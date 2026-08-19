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
        $key = config('services.ocr.key') ?: env('OCR_SPACE_API_KEY');

        if (empty($key)) {
            Log::warning('OCR_SPACE_API_KEY is not set in your .env file.');
        }

        $this->apiKey = $key ?? '';
    }

    /**
     * Run the full verification pipeline for a user.
     * Returns: ['status', 'score', 'notes', 'raw_text', 'extracted_fields', 'processing_ms', 'image_hash']
     */
    public function verify(User $user): array
    {
        $totalStartTime = microtime(true);
        $timings = [
            'image_optimization_ms' => 0,
            'ocr_api_ms'            => 0,
            'comparison_ms'         => 0,
            'total_ms'              => 0,
        ];

        if ($user->is_manually_verified) {
            return [
                'status'           => $user->id_verification_status ?: 'verified',
                'score'            => $user->id_verification_score ?? 100,
                'notes'            => $user->id_verification_notes ?? 'Manually verified by Admin.',
                'raw_text'         => $user->ocr_raw_text,
                'extracted_fields' => $user->ocr_extracted_fields,
                'processing_ms'    => 0,
                'image_hash'       => $user->ocr_image_hash,
            ];
        }

        if (!$user->id_photo) {
<<<<<<< Updated upstream
            return ['status' => 'rejected', 'score' => 0, 'notes' => 'No ID photo was uploaded.'];
=======
            return [
                'status'           => 'pending',
                'score'            => 0,
                'notes'            => 'No ID photo uploaded yet.',
                'raw_text'         => null,
                'extracted_fields' => null,
                'processing_ms'    => 0,
                'image_hash'       => null,
            ];
>>>>>>> Stashed changes
        }

        $photoPath = Storage::disk('public')->path($user->id_photo);

        if (!file_exists($photoPath)) {
<<<<<<< Updated upstream
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
=======
            return [
                'status'           => 'pending',
                'score'            => 0,
                'notes'            => 'Uploaded ID photo file could not be found.',
                'raw_text'         => null,
                'extracted_fields' => null,
                'processing_ms'    => 0,
                'image_hash'       => null,
>>>>>>> Stashed changes
            ];
        }

        // 1. Calculate Image SHA-256 Checksum for duplicate prevention & caching
        $imageHash = hash_file('sha256', $photoPath);

<<<<<<< Updated upstream
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
=======
        // Check if an existing user record with the same ID hash already has completed OCR text
        $existingOcr = User::where('ocr_image_hash', $imageHash)
            ->whereNotNull('ocr_raw_text')
            ->where('ocr_raw_text', '!=', '')
            ->first();

        $ocrText = '';
        $ocrExitCode = 1;
        $isDuplicateCached = false;

        if ($existingOcr) {
            $ocrText = $existingOcr->ocr_raw_text;
            $isDuplicateCached = true;
            Log::info("[OCR_CACHE_HIT] Reusing cached OCR result from user #{$existingOcr->id} for image hash: {$imageHash}");
        } else {
            // 2. Pre-process and optimize image for fast OCR transmission
            $optStart = microtime(true);
            $optimizedPath = $this->optimizeImageForOcr($photoPath);
            $fileToScan = $optimizedPath ?: $photoPath;
            $timings['image_optimization_ms'] = round((microtime(true) - $optStart) * 1000);

            // 3. Execute OCR with circuit breaker & strict timeout
            $apiStart = microtime(true);
            try {
                $ocrResult = $this->extractTextViaOCR($fileToScan);
                $ocrText = $ocrResult['text'];
                $ocrExitCode = $ocrResult['exit_code'];
            } finally {
                // Clean up temporary optimized image file if created
                if ($optimizedPath && file_exists($optimizedPath) && $optimizedPath !== $photoPath) {
                    @unlink($optimizedPath);
                }
            }
            $timings['ocr_api_ms'] = round((microtime(true) - $apiStart) * 1000);

            if ($ocrResult['is_errored'] || $ocrResult['exit_code'] === 4 || empty($ocrResult['text'])) {
                $errorMsg = $ocrResult['error_message'] ?: 'Photo is blurry or unreadable.';
                $notes = ($errorMsg === 'API Unreachable')
                    ? 'OCR service temporarily unreachable. Submitted for manual admin review.'
                    : 'OCR_READ_ERROR: ' . $errorMsg;

                $timings['total_ms'] = round((microtime(true) - $totalStartTime) * 1000);
                $this->logPerformanceMetrics($user, $timings, 0, 'pending', 'OCR_FAILED: ' . $errorMsg);

                return [
                    'status'           => 'pending',
                    'score'            => 0,
                    'notes'            => $notes,
                    'raw_text'         => null,
                    'extracted_fields' => null,
                    'processing_ms'    => $timings['total_ms'],
                    'image_hash'       => $imageHash,
                ];
>>>>>>> Stashed changes
            }
        }

        // 4. Compare extracted text against registered tourist details
        $compStart = microtime(true);
        $matchResult = $this->matchData($user, $ocrText);
        $timings['comparison_ms'] = round((microtime(true) - $compStart) * 1000);

        // --- Field-Specific Verification Gate ---
        //
        // Auto-verified requires ALL three gates:
        //   Gate 1: ID number must match (optical-confusion-corrected) ≥ 80%
        //   Gate 2: Name must match ≥ 70%
        //   Gate 3: Overall weighted score ≥ 80%
        //
        // This prevents a case where Name + DOB + Type all match but ID is wrong
        // from reaching the 'verified' state automatically.

        $idGatePassed   = $matchResult['id_score'] >= 80;
        $nameGatePassed = $matchResult['name_score'] >= 70;
        $overallPasses  = $matchResult['score'] >= 80;

        $autoVerified = $idGatePassed && $nameGatePassed && $overallPasses;

        // Needs human review: at least one gate passes but not all three,
        // or score is in 60–79% partial-match zone
        $needsReview = !$autoVerified && (
            $idGatePassed || $nameGatePassed || $matchResult['score'] >= 60
        );

        if ($autoVerified && $ocrExitCode === 1) {
            $status = 'verified';
            $notes  = 'Auto-Verified: ' . $matchResult['notes'];
        } elseif ($needsReview || $ocrExitCode === 2 || $ocrExitCode === 3) {
            $status = 'pending';
            // Prefix distinguishes "partial match needing review" from a clean pending state
            if (!$idGatePassed && $matchResult['id_score'] < 80) {
                $notes = 'NEEDS_REVIEW: ID number could not be confirmed. ' . $matchResult['notes'];
            } elseif (!$nameGatePassed && $matchResult['name_score'] < 70) {
                $notes = 'NEEDS_REVIEW: Name could not be confirmed. ' . $matchResult['notes'];
            } else {
                $notes = 'NEEDS_REVIEW: Partial OCR match. ' . $matchResult['notes'];
            }
        } else {
            $status = 'pending';
            $notes  = 'MISMATCH: ' . $matchResult['notes'];
        }

        if ($isDuplicateCached) {
            $notes .= ' [Cached Document]';
        }

        $timings['total_ms'] = round((microtime(true) - $totalStartTime) * 1000);

        $extractedFields = [
            'name_score'      => $matchResult['name_score'],
            'id_score'        => $matchResult['id_score'],
            'dob_found'       => $matchResult['dob_found'] ?? false,
            'id_type_matched' => $matchResult['id_type_matched'] ?? false,
            'cached'          => $isDuplicateCached,
            'verified_at'     => now()->toIso8601String(),
        ];

        $this->logPerformanceMetrics($user, $timings, $matchResult['score'], $status, $notes);

        return [
            'status'           => $status,
            'score'            => round($matchResult['score'], 2),
            'notes'            => $notes,
            'raw_text'         => $ocrText,
            'extracted_fields' => $extractedFields,
            'processing_ms'    => $timings['total_ms'],
            'image_hash'       => $imageHash,
        ];
    }

    /**
     * Pre-process, auto-orient, and downscale oversized ID photos to eliminate OCR latency.
     */
    private function optimizeImageForOcr(string $sourcePath): ?string
    {
        if (!extension_loaded('gd') || !file_exists($sourcePath)) {
            return null;
        }

        try {
            $imageInfo = @getimagesize($sourcePath);
            if (!$imageInfo) {
                return null;
            }

            [$origWidth, $origHeight, $imageType] = $imageInfo;

            // Load source image resource based on image type
            $srcImage = match ($imageType) {
                IMAGETYPE_JPEG => @imagecreatefromjpeg($sourcePath),
                IMAGETYPE_PNG  => @imagecreatefrompng($sourcePath),
                IMAGETYPE_WEBP => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($sourcePath) : null,
                IMAGETYPE_BMP  => function_exists('imagecreatefrombmp') ? @imagecreatefrombmp($sourcePath) : null,
                default        => null,
            };

            if (!$srcImage) {
                return null;
            }

            // Correct EXIF orientation for mobile camera uploads
            if ($imageType === IMAGETYPE_JPEG && function_exists('exif_read_data')) {
                try {
                    $exif = @exif_read_data($sourcePath);
                    if (!empty($exif['Orientation'])) {
                        switch ($exif['Orientation']) {
                            case 3:
                                $srcImage = imagerotate($srcImage, 180, 0);
                                break;
                            case 6:
                                $srcImage = imagerotate($srcImage, -90, 0);
                                $tmp = $origWidth;
                                $origWidth = $origHeight;
                                $origHeight = $tmp;
                                break;
                            case 8:
                                $srcImage = imagerotate($srcImage, 90, 0);
                                $tmp = $origWidth;
                                $origWidth = $origHeight;
                                $origHeight = $tmp;
                                break;
                        }
                    }
                } catch (\Throwable $e) {
                    // Non-fatal
                }
            }

            // Downscale to max 1600px on longest edge for optimal OCR reading under 500KB
            $maxDimension = 1600;
            $scale = min(1.0, $maxDimension / max($origWidth, $origHeight));
            $newWidth  = max(1, (int) round($origWidth * $scale));
            $newHeight = max(1, (int) round($origHeight * $scale));

            $dstImage = imagecreatetruecolor($newWidth, $newHeight);

            // Handle transparency by filling with clean white background
            $white = imagecolorallocate($dstImage, 255, 255, 255);
            imagefilledrectangle($dstImage, 0, 0, $newWidth, $newHeight, $white);

            imagecopyresampled($dstImage, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

            // Light contrast enhancement for crisp character edges
            if (function_exists('imagefilter')) {
                @imagefilter($dstImage, IMG_FILTER_CONTRAST, -8);
            }

            // Save to temporary high-contrast JPEG
            $tempOptimizedPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'ocr_opt_' . uniqid() . '.jpg';
            imagejpeg($dstImage, $tempOptimizedPath, 85);

            imagedestroy($srcImage);
            imagedestroy($dstImage);

            return file_exists($tempOptimizedPath) ? $tempOptimizedPath : null;
        } catch (\Throwable $e) {
            Log::warning('Image optimization for OCR skipped: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Send image to OCR.space API with circuit breaker and fallback.
     */
    private function extractTextViaOCR(string $photoPath): array
    {
        $defaultResult = [
            'text'          => '',
            'is_errored'    => true,
            'error_message' => 'API Unreachable',
            'exit_code'     => 4,
        ];

        if (!function_exists('curl_init') || empty($this->apiKey)) {
            return $defaultResult;
        }

        // Strategy 1: Try OCR Engine 2 (optimized for ID cards & alphanumeric tokens)
        $res = $this->callOcrEndpoint($photoPath, '2');

        // Strategy 2: If Engine 2 produced no text and wasn't a network timeout, try Engine 1
        if (($res['is_errored'] || empty($res['text'])) && $res['error_message'] !== 'API Unreachable') {
            Log::info('OCR Engine 2 yielded no text. Retrying with OCR Engine 1...');
            $res1 = $this->callOcrEndpoint($photoPath, '1');
            if (!empty($res1['text'])) {
                return $res1;
            }
        }

        return $res;
    }

    /**
     * Execute HTTP request to OCR.space gateway with tight timeout.
     */
    private function callOcrEndpoint(string $photoPath, string $engine = '2'): array
    {
        $endpoint = config('services.ocr.endpoint', 'https://api.ocr.space/parse/image');

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $endpoint,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => [
                'apikey'            => $this->apiKey,
                'language'          => 'eng',
                'isOverlayRequired' => 'false',
                'OCREngine'         => $engine,
                'file'              => new \CURLFile($photoPath),
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4,
            CURLOPT_CONNECTTIMEOUT => 4,
            CURLOPT_TIMEOUT        => 8,
        ]);

        $response = curl_exec($ch);
        $err      = curl_errno($ch);
        $errMsg   = curl_error($ch);
        curl_close($ch);

        if ($err || !$response) {
            Log::warning("OCR.space API call failed (engine {$engine}): " . ($errMsg ?: 'Empty response'));
            return [
                'text'          => '',
                'is_errored'    => true,
                'error_message' => 'API Unreachable',
                'exit_code'     => 4,
            ];
        }

        $json = json_decode($response, true);

        $isErrored = !empty($json['IsErroredOnProcessing']) && $json['IsErroredOnProcessing'] === true;
        $exitCode  = isset($json['OCRExitCode']) ? intval($json['OCRExitCode']) : 4;

        $errorMessage = '';
        if (!empty($json['ErrorMessage'])) {
            $errorMessage = is_array($json['ErrorMessage']) ? implode(' ', $json['ErrorMessage']) : (string)$json['ErrorMessage'];
        }

        $text = '';
        if (!empty($json['ParsedResults'][0]['ParsedText'])) {
            $text = strtolower(trim($json['ParsedResults'][0]['ParsedText']));
        }

        return [
            'text'          => $text,
            'is_errored'    => $isErrored,
            'error_message' => $errorMessage,
            'exit_code'     => $exitCode,
        ];
    }

    /**
     * Compare the OCR-extracted text against the user's registered details.
     */
    public function matchData(User $user, string $extractedText): array
    {
        $notes      = [];
        $totalScore = 0;
        $extractedText = strtolower($extractedText);

        // 1. Name Matching (with permutation & fuzzy tolerance)
        $nameScore = $this->evaluateNameMatch($user, $extractedText);
        $totalScore += $nameScore * 0.40;

        if ($nameScore >= 80)      $notes[] = "Name match: {$nameScore}% (found)";
        elseif ($nameScore >= 45)  $notes[] = "Name match: {$nameScore}% (partial)";
        else                       $notes[] = "Name match: {$nameScore}% (not found)";

        // 2. ID Number Matching (with alphanumeric optical correction)
        $idScore = $this->evaluateIdNumberMatch($user, $extractedText);
        $totalScore += $idScore * 0.40;

        if ($idScore >= 80)        $notes[] = "ID Number: {$idScore}% (found)";
        elseif ($idScore >= 45)    $notes[] = "ID Number: {$idScore}% (partial)";
        else                       $notes[] = "ID Number: {$idScore}% (not found)";

        // 3. DOB & ID Type Matching
        $idType      = strtolower(trim($user->id_type ?? ''));
        $hasDobField = $this->idHasDob($idType);
        $dobFound    = false;
        $typeScore   = 0;

        if (!$hasDobField) {
            // Re-weight to Name (55%) + ID Number (45%)
            $totalScore = ($nameScore * 0.55) + ($idScore * 0.45);
            $notes[]    = 'DOB: Skipped (no DOB on ID type)';
        } else {
            $dobScore = $this->evaluateDobMatch($user, $extractedText);
            $dobFound = $dobScore >= 80;
            $totalScore += $dobScore * 0.15;
            $notes[]     = 'DOB: ' . ($dobFound ? 'Found' : 'Not Found');

            // ID Type keyword match (weight: 5%)
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
            'score'           => min(100, $totalScore),
            'name_score'      => $nameScore,
            'id_score'        => $idScore,
            'dob_found'       => $dobFound,
            'id_type_matched' => $typeScore >= 80,
            'notes'           => implode(' | ', $notes),
        ];
    }

    /**
     * Evaluate name match against various permutations and fuzzy token distances.
     */
    private function evaluateNameMatch(User $user, string $extractedText): float
    {
        $fullName = strtolower(trim(preg_replace('/\b(n\/a|na|none)\b/i', '', $user->name)));
        $fullName = preg_replace('/\s+/', ' ', $fullName);
        $lastName = strtolower(trim(preg_replace('/\b(n\/a|na|none)\b/i', '', $user->last_name ?? '')));
        $middle   = strtolower(trim(str_replace('.', '', preg_replace('/\b(n\/a|na|none)\b/i', '', $user->middle_initial ?? ''))));

        if (empty($fullName)) {
            return 0;
        }

        // Direct full string check
        if (str_contains($extractedText, $fullName)) {
            return 100;
        }

        // Permutations (e.g. "LAST, FIRST" or "FIRST LAST")
        if (!empty($lastName)) {
            $firstName = trim(str_ireplace([$lastName, $middle, '.'], '', $fullName));
            if (!empty($firstName)) {
                $perm1 = "{$lastName} {$firstName}";
                $perm2 = "{$lastName}, {$firstName}";
                $perm3 = "{$firstName} {$lastName}";
                if (str_contains($extractedText, $perm1) || str_contains($extractedText, $perm2) || str_contains($extractedText, $perm3)) {
                    return 100;
                }
            }
        }

        // Token-based fuzzy matching
        return $this->similarityScore($fullName, $extractedText);
    }

    /**
     * Evaluate ID Number with optical character confusion correction (0/O, 1/I, 5/S, 8/B).
     */
    private function evaluateIdNumberMatch(User $user, string $extractedText): float
    {
        if (empty($user->id_number)) {
            return 50; // baseline for optional ID numbers
        }

        $idClean   = preg_replace('/[^a-z0-9]/i', '', strtolower($user->id_number));
        $textClean = preg_replace('/[^a-z0-9]/', '', $extractedText);

        if (empty($idClean)) {
            return 0;
        }

        // Direct exact match
        if (str_contains($textClean, $idClean)) {
            return 100;
        }

        // Normalized match with optical confusion mapping (O->0, I->1, L->1, S->5, B->8)
        $confMap = ['o' => '0', 'i' => '1', 'l' => '1', 's' => '5', 'b' => '8'];
        $idNorm   = strtr($idClean, $confMap);
        $textNorm = strtr($textClean, $confMap);

        if (str_contains($textNorm, $idNorm)) {
            return 95;
        }

        // Substring / suffix matches (e.g. last 6 digits)
        if (strlen($idNorm) >= 6) {
            $suffix = substr($idNorm, -6);
            $prefix = substr($idNorm, 0, 6);
            if (str_contains($textNorm, $suffix) || str_contains($textNorm, $prefix)) {
                return 80;
            }
        }

        return 0;
    }

    /**
     * Evaluate Date of Birth against various date formats.
     */
    private function evaluateDobMatch(User $user, string $extractedText): float
    {
        if (!$user->dob) {
            return 0;
        }

        $dob = $user->dob;
        $dobFormats = [
            $dob->format('Y-m-d'),
            $dob->format('d-m-Y'),
            $dob->format('m-d-Y'),
            $dob->format('Y/m/d'),
            $dob->format('d/m/Y'),
            $dob->format('m/d/Y'),
            $dob->format('d.m.Y'),
            $dob->format('Y.m.d'),
            strtolower($dob->format('F d, Y')),
            strtolower($dob->format('M d, Y')),
            strtolower($dob->format('d F Y')),
            strtolower($dob->format('d M Y')),
            strtolower($dob->format('d-M-Y')),
            strtolower($dob->format('M-d-Y')),
        ];

        foreach ($dobFormats as $fmt) {
            if (str_contains($extractedText, $fmt)) {
                return 100;
            }
        }

        return 0;
    }

    /**
     * Determine whether an ID type is known to print a date of birth.
     */
    private function idHasDob(string $idType): bool
    {
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

        foreach ($withDob as $type) {
            if (str_contains($idType, $type) || $idType === $type) {
                return true;
            }
        }

        return false;
    }

    /**
     * Calculate token-based similarity score with Levenshtein typo allowance.
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
                        $found += 0.8;
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
            'school id'            => ['student', 'school', 'university', 'college', 'institute', 'bachelor'],
            'barangay id'          => ['barangay', 'punong barangay'],
            'company id'           => ['company', 'employee'],
        ];

        return $map[$idType] ?? [];
    }

    /**
     * Record structured timing and audit logs for OCR operations.
     */
    private function logPerformanceMetrics(User $user, array $timings, float $score, string $status, string $notes): void
    {
        Log::info('[OCR_PERFORMANCE_METRICS]', [
            'user_id'    => $user->id,
            'email'      => $user->email,
            'timings_ms' => $timings,
            'score'      => $score,
            'status'     => $status,
            'notes'      => $notes,
        ]);
    }
}
