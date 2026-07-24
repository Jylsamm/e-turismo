<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class IdentityVerificationService
{
    private string $apiKey;

    public function __construct()
    {
        $key = config('services.ocr.key');

        if (empty($key)) {
            throw new \RuntimeException(
                'OCR_SPACE_API_KEY is not set in your .env file. ' .
                'Obtain a free key at https://ocr.space/ocrapi/freekey and add it to .env.'
            );
        }

        $this->apiKey = $key;
    }

    /**
     * Run the full verification pipeline for a user.
     * Returns: ['status', 'score', 'notes']
     */
    public function verify(User $user): array
    {
        if ($user->is_manually_verified) {
            return [
                'status' => $user->id_verification_status,
                'score'  => $user->id_verification_score,
                'notes'  => $user->id_verification_notes ?? 'Manually verified by Admin.',
            ];
        }

        if (!$user->id_photo) {
            return ['status' => 'rejected', 'score' => 0, 'notes' => 'No ID photo was uploaded.'];
        }

        $photoPath = Storage::disk('public')->path($user->id_photo);

        if (!file_exists($photoPath)) {
            return ['status' => 'rejected', 'score' => 0, 'notes' => 'Uploaded ID photo file could not be found.'];
        }

        // Call OCR.space API to read the actual text from the uploaded photo
        $ocrResult = $this->extractTextViaOCR($photoPath);

        if ($ocrResult['is_errored'] || $ocrResult['exit_code'] === 4 || empty($ocrResult['text'])) {
            $errorMsg = $ocrResult['error_message'] ?: 'Photo is too blurry, dark, or unsupported format.';
            return [
                'status' => 'rejected',
                'score' => 0,
                'notes' => 'OCR_READ_ERROR: ' . $errorMsg
            ];
        }

        // Compare extracted text against registered details
        $result = $this->matchData($user, $ocrResult['text']);

        if ($ocrResult['exit_code'] === 2 || $ocrResult['exit_code'] === 3) {
            $status = 'pending';
            $notes = 'PENDING_REVIEW: Exit code ' . $ocrResult['exit_code'] . ' (partial success). Confidence shaky. | ' . $result['notes'];
        } else {
            if ($result['score'] >= 90) {
                $status = 'verified';
            } elseif ($result['score'] >= 60) {
                $status = 'pending';
            } else {
                $status = 'rejected';
            }
            $notes = $result['notes'];
        }

        return [
            'status' => $status,
            'score'  => round($result['score'], 2),
            'notes'  => $notes,
        ];
    }

    /**
     * Send image to OCR.space API and return the extracted text and metadata.
     */
    private function extractTextViaOCR(string $photoPath): array
    {
        $defaultResult = [
            'text' => '',
            'is_errored' => true,
            'error_message' => 'API Unreachable',
            'exit_code' => 4,
        ];

        if (!function_exists('curl_init')) {
            return $defaultResult;
        }

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => 'https://api.ocr.space/parse/image',
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => [
                'apikey'            => $this->apiKey,  // Fix 1: no helloworld fallback
                'language'          => 'eng',
                'isOverlayRequired' => 'false',
                'OCREngine'         => '2',
                'file'              => new \CURLFile($photoPath),
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT        => 30,
        ]);

        $response = curl_exec($ch);
        $err      = curl_errno($ch);
        curl_close($ch);

        if ($err || !$response) {
            Log::warning('OCR.space API unreachable.');
            return $defaultResult;
        }

        $json = json_decode($response, true);
        
        $isErrored = !empty($json['IsErroredOnProcessing']) && $json['IsErroredOnProcessing'] === true;
        $exitCode = isset($json['OCRExitCode']) ? intval($json['OCRExitCode']) : 4;
        
        $errorMessage = '';
        if (!empty($json['ErrorMessage'])) {
            $errorMessage = is_array($json['ErrorMessage']) ? implode(' ', $json['ErrorMessage']) : (string)$json['ErrorMessage'];
            Log::warning('OCR.space error: ' . $errorMessage);
        }

        $text = '';
        if (!empty($json['ParsedResults'][0]['ParsedText'])) {
            $text = strtolower(trim($json['ParsedResults'][0]['ParsedText']));
            Log::info('OCR extracted: ' . $text);
        }

        return [
            'text' => $text,
            'is_errored' => $isErrored,
            'error_message' => $errorMessage,
            'exit_code' => $exitCode,
        ];
    }

    /**
     * Compare the OCR-extracted text against the user's registered details.
     */
    private function matchData(User $user, string $extractedText): array
    {
        $notes      = [];
        $totalScore = 0;

        // Fix 3: Use $user->name directly — it already contains the full composed name
        // ("FIRST [M.I.] LAST") built in RegisteredUserController. Do NOT append
        // middle_initial / last_name again or the OCR string will be doubled.
        $registeredName = strtolower(trim($user->name));
        $nameScore = $this->similarityScore($registeredName, $extractedText);
        $totalScore += $nameScore * 0.40;

        if ($nameScore >= 70)      $notes[] = "Name match: {$nameScore}% (found)";
        elseif ($nameScore >= 40)  $notes[] = "Name match: {$nameScore}% (partial)";
        else                       $notes[] = "Name match: {$nameScore}% (not found)";

        // ID Number matching (weight: 40%)
        $idScore = 0;
        if ($user->id_number) {
            $idClean   = preg_replace('/[^a-z0-9]/i', '', strtolower($user->id_number));
            $textClean = preg_replace('/[^a-z0-9]/', '', $extractedText);

            if (str_contains($textClean, $idClean)) {
                $idScore = 100;
            } elseif (strlen($idClean) >= 6 && str_contains($textClean, substr($idClean, -6))) {
                $idScore = 60;
            } elseif (strlen($idClean) >= 6 && str_contains($textClean, substr($idClean, 0, 6))) {
                $idScore = 55;
            }
        } else {
            $idScore = 50;
            $notes[] = 'ID Number: not provided';
        }
        $totalScore += $idScore * 0.40;

        if ($idScore >= 70)     $notes[] = "ID Number: {$idScore}% (found)";
        elseif ($idScore >= 40) $notes[] = "ID Number: {$idScore}% (partial)";
        else                    $notes[] = "ID Number: {$idScore}% (not found)";

        // DOB matching — only for ID types that actually print a date of birth on the card.
        // Scoring weights:
        //   With DOB:    Name 40% + ID 40% + DOB 15% + Type 5%  = 100%
        //   Without DOB: Name 55% + ID 45%                       = 100%
        $idType      = strtolower(trim($user->id_type ?? ''));
        $hasDobField = $this->idHasDob($idType);

        if (!$hasDobField) {
            // Redistribute DOB weight into Name and ID Number
            $totalScore = ($nameScore * 0.55) + ($idScore * 0.45);
            $notes[]    = 'DOB: Skipped — this ID type does not print a date of birth';
        } else {
            $dobScore = 0;

            if ($user->dob) {
                $dobFormats = [
                    $user->dob->format('Y-m-d'),                  // 2004-12-10
                    $user->dob->format('d-m-Y'),                  // 10-12-2004
                    $user->dob->format('m-d-Y'),                  // 12-10-2004
                    $user->dob->format('Y/m/d'),                  // 2004/12/10
                    $user->dob->format('d/m/Y'),                  // 10/12/2004
                    $user->dob->format('m/d/Y'),                  // 12/10/2004
                    strtolower($user->dob->format('F d, Y')),     // december 10, 2004
                    strtolower($user->dob->format('M d, Y')),     // dec 10, 2004
                    strtolower($user->dob->format('d F Y')),      // 10 december 2004
                    strtolower($user->dob->format('d M Y')),      // 10 dec 2004
                ];

                foreach ($dobFormats as $fmt) {
                    if (str_contains($extractedText, $fmt)) {
                        $dobScore = 100;
                        break;
                    }
                }
            }

            $totalScore += $dobScore * 0.15;
            $notes[]     = 'DOB: ' . ($dobScore === 100 ? 'Found' : 'Not Found');

            // ID Type keyword (weight: 5%) — only counted when DOB is also in play
            $typeScore = 0;
            if ($user->id_type) {
                foreach ($this->idTypeKeywords($idType) as $kw) {
                    if (str_contains($extractedText, strtolower($kw))) {
                        $typeScore = 100;
                        break;
                    }
                }
            }
            $totalScore += $typeScore * 0.05;
        }

        return [
            'score' => min(100, $totalScore),
            'notes' => implode(' | ', $notes),
        ];
    }

    /**
     * Determine whether a given ID type is known to print a date of birth on the card.
     *
     *   true  → DOB is included in verification scoring (weights: Name 40%, ID 40%, DOB 15%, Type 5%)
     *   false → DOB is skipped; weights redistributed  (weights: Name 55%, ID 45%)
     */
    private function idHasDob(string $idType): bool
    {
        // IDs confirmed to print date of birth on the physical card
        $withDob = [
            'passport',
            'national id',
            "driver's license",
            'sss id',
            'gsis id',
            'philhealth id',
            'pag-ibig id',
            'voter id',
            'postal id',
        ];

        // IDs that do NOT print DOB (school id, barangay id, company id)
        // fall through to the default return false.
        foreach ($withDob as $type) {
            if (str_contains($idType, $type) || $idType === $type) {
                return true;
            }
        }

        return false; // unknown / no-DOB types treated conservatively
    }

    /**
     * Calculate string similarity between name words and OCR-extracted text.
     */
    private function similarityScore(string $needle, string $haystack): float
    {
        if (empty($needle) || empty($haystack)) return 0;

        $words = array_filter(preg_split('/\s+/', str_replace('.', '', $needle)));
        $total = count($words);
        if ($total === 0) return 0;

        $found = 0;
        foreach ($words as $word) {
            $word = trim($word);
            if (strlen($word) < 2) { $total--; continue; }

            if (str_contains($haystack, $word)) {
                $found++;
            } else {
                $threshold = max(1, (int) floor(strlen($word) / 4));
                foreach (preg_split('/\s+/', $haystack) as $hw) {
                    if (levenshtein($word, $hw) <= $threshold) {
                        $found += 0.7;
                        break;
                    }
                }
            }
        }

        return $total > 0 ? min(100, ($found / $total) * 100) : 0;
    }

    /**
     * Return known keywords printed on each ID type.
     */
    private function idTypeKeywords(string $idType): array
    {
        $map = [
            'passport'             => ['passport', 'republic of the philippines', 'pasaporte'],
            'national id'          => ['philsys', 'national id', 'pambansang pagkakakilanlan', 'phl', 'philippine identification'],
            "driver's license"     => ["driver's license", 'land transportation', 'lto'],
            'sss id'               => ['social security', 'sss'],
            'gsis id'              => ['government service insurance', 'gsis'],
            'philhealth id'        => ['philhealth', 'philippine health'],
            'pag-ibig id'          => ['pag-ibig', 'home development'],
            'voter id'             => ['comelec', 'commission on elections'],
            'postal id'            => ['philippine postal', 'postal'],
            'school id'            => ['student', 'school', 'university', 'college', 'institute', 'bsit', 'bachelor'],
            'barangay id'          => ['barangay', 'punong barangay'],
            'company id'           => ['company', 'employee'],
        ];

        foreach ($map as $key => $keywords) {
            if (str_contains($idType, $key) || $idType === $key) return $keywords;
        }

        return [strtolower($idType)];
    }
}
