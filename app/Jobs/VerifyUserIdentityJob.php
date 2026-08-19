<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\IdentityVerificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class VerifyUserIdentityJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     * If OCR.space is unreachable, we retry once after 30s before marking as pending.
     */
    public int $tries = 2;

    /**
     * Number of seconds to wait before retrying a failed attempt.
     */
    public int $backoff = 30;

    /**
     * Maximum number of seconds the job may run before being killed.
     * Covers two OCR engine attempts (4s connect + 8s request) × 2 + image optimisation overhead.
     */
    public int $timeout = 120;

    public function __construct(public readonly User $user)
    {
    }

    /**
     * Execute the job.
     * NOTE: User::create() always happens in RegisteredUserController BEFORE this job is
     * dispatched. This job only runs OCR and updates the existing user row.
     */
    public function handle(IdentityVerificationService $verifier): void
    {
        // Idempotency guard: skip if already verified to prevent wasted OCR calls
        // when the job is accidentally dispatched more than once for the same user.
        $freshUser = User::find($this->user->id);
        if (!$freshUser) {
            Log::warning("[VerifyUserIdentityJob] User #{$this->user->id} no longer exists — skipping.");
            return;
        }

        if ($freshUser->id_verification_status === 'verified') {
            Log::info("[VerifyUserIdentityJob] User #{$freshUser->id} is already verified — skipping duplicate job.");
            return;
        }

        Log::info("[VerifyUserIdentityJob] Starting OCR verification for user #{$freshUser->id} ({$freshUser->email})");

        try {
            $result = $verifier->verify($freshUser);

            $freshUser->update([
                'id_verification_status' => $result['status'],
                'id_verification_score'  => $result['score'],
                'id_verification_notes'  => $result['notes'],
                'id_verified_at'         => $result['status'] === 'verified' ? now() : null,
                'ocr_raw_text'           => $result['raw_text'] ?? null,
                'ocr_extracted_fields'   => $result['extracted_fields'] ?? null,
                'ocr_processing_ms'      => $result['processing_ms'] ?? null,
                'ocr_image_hash'         => $result['image_hash'] ?? null,
                'ocr_provider'           => 'ocr.space',
            ]);

            Log::info("[VerifyUserIdentityJob] Completed for user #{$freshUser->id}: status={$result['status']}, score={$result['score']}, duration={$result['processing_ms']}ms");
        } catch (\Throwable $e) {
            Log::error("[VerifyUserIdentityJob] Failed for user #{$freshUser->id}: " . $e->getMessage(), [
                'exception' => $e,
            ]);

            // On final failure, mark as pending so an admin can manually review
            // instead of leaving the user stuck in 'processing' forever.
            if ($this->attempts() >= $this->tries) {
                $freshUser->update([
                    'id_verification_status' => 'pending',
                    'id_verification_notes'  => 'OCR_JOB_FAILED: ' . $e->getMessage(),
                ]);
            }

            throw $e; // Re-throw so the queue marks this attempt as failed
        }
    }
}
