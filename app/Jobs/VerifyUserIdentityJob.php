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
        Log::info("[VerifyUserIdentityJob] Starting OCR verification for user #{$this->user->id} ({$this->user->email})");

        try {
            $result = $verifier->verify($this->user);

            $this->user->update([
                'id_verification_status' => $result['status'],
                'id_verification_score'  => $result['score'],
                'id_verification_notes'  => $result['notes'],
                'id_verified_at'         => $result['status'] === 'verified' ? now() : null,
            ]);

            Log::info("[VerifyUserIdentityJob] Completed for user #{$this->user->id}: status={$result['status']}, score={$result['score']}");
        } catch (\Throwable $e) {
            Log::error("[VerifyUserIdentityJob] Failed for user #{$this->user->id}: " . $e->getMessage(), [
                'exception' => $e,
            ]);

            // On final failure, mark as pending so an admin can manually review
            // instead of leaving the user stuck in 'processing' forever.
            if ($this->attempts() >= $this->tries) {
                $this->user->update([
                    'id_verification_status' => 'pending',
                    'id_verification_notes'  => 'OCR_JOB_FAILED: ' . $e->getMessage(),
                ]);
            }

            throw $e; // Re-throw so the queue marks this attempt as failed
        }
    }
}
