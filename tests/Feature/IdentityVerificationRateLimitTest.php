<?php

namespace Tests\Feature;

use App\Http\Controllers\IdentityVerificationController;
use App\Models\User;
use App\Services\IdentityVerificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class IdentityVerificationRateLimitTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_only_resubmit_three_times_per_day(): void
    {
        $user = User::factory()->create([
            'role' => 'tourist',
            'id_verification_status' => 'rejected',
            'email_verified_at' => now(),
        ]);

        RateLimiter::clear('id-verify:' . $user->id);

        $service = $this->createMock(IdentityVerificationService::class);
        $this->app->instance(IdentityVerificationService::class, $service);

        $this->actingAs($user);

        for ($i = 0; $i < 3; $i++) {
            RateLimiter::hit('id-verify:' . $user->id, 86400);
        }

        $controller = new IdentityVerificationController($this->app->make(IdentityVerificationService::class));
        $request = Request::create('/verification/resubmit', 'POST', [], [], [
            'id_photo' => UploadedFile::fake()->image('id-photo-4.jpg'),
        ]);

        $response = $controller->resubmit($request);

        $this->assertSame('Too many verification attempts today. Try again tomorrow.', $response->getSession()->get('error'));
    }
}
