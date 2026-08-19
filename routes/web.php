<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\CheckInController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\IdentityVerificationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\Auth\RegistrationOtpController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::post('/check-email', function (\Illuminate\Http\Request $request) {
    $email = strtolower(trim($request->email));
    
    if (empty($email)) {
        return response()->json(['valid' => false, 'available' => false, 'message' => 'Email is required.']);
    }
    
    $isGmail = (bool) preg_match('/^[a-z0-9._%+-]+@gmail\.com$/i', $email);
    if (!$isGmail) {
        return response()->json(['valid' => false, 'available' => false, 'message' => 'Must be a valid @gmail.com address.']);
    }
    
    $exists = \App\Models\User::where('email', $email)->exists();
    if ($exists) {
        return response()->json(['valid' => true, 'available' => false, 'message' => 'This Gmail is already registered.']);
    }
    
    return response()->json(['valid' => true, 'available' => true, 'message' => 'Gmail is available.']);
})->name('email.check');

Route::post('/register/send-code', [RegistrationOtpController::class, 'sendCode'])
    ->name('register.send_code');

Route::post('/register/verify-code', [RegistrationOtpController::class, 'verifyCode'])
    ->name('register.verify_code');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    // ── Identity Verification (always accessible after email verification) ──
    Route::get('/verification/status', [IdentityVerificationController::class, 'getStatus'])->name('verification.status');
    Route::post('/verification/resubmit', [IdentityVerificationController::class, 'resubmit'])->name('verification.resubmit');
    Route::post('/verification/update-details', [IdentityVerificationController::class, 'updateDetails'])->name('verification.update_details');

    // ── Routes requiring identity verification ──────────────────────────────
    Route::middleware('identity.verified')->group(function () {

    // Dashboard (role-aware)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/latest-alert', [NotificationController::class, 'getLatestAlert'])->name('notifications.latest-alert');
    Route::post('/notifications/{notification}/dismiss', [NotificationController::class, 'dismissAlert'])->name('notifications.dismiss-alert');
    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.read-all');

    // Tickets
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');

    /*
    |----------------------------------------------------------------------
    | Tourist Routes
    |----------------------------------------------------------------------
    */

    // Browse destinations
    Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations.index');
    Route::get('/destinations/{destination}', [DestinationController::class, 'show'])->name('destinations.show');
    Route::get('/destinations/{destination}/availability', [DestinationController::class, 'checkAvailability'])->name('destinations.availability');
    Route::get('/destinations/{destination}/availability/range', [DestinationController::class, 'checkRangeAvailability'])->name('destinations.availability.range');

    // Bookings — Tourist books, Staff manages; Admin is excluded
    // Tourist: book a destination
    Route::get('/destinations/{destination}/book', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/destinations/{destination}/book', [BookingController::class, 'store'])->middleware('check.booking.status')->name('bookings.store');

    // Bookings list + management (Tourist sees own; Staff sees assigned spot; Admin blocked)
    Route::middleware('can:not-admin')->group(function () {
        Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
        Route::post('/bookings/{booking}/submit-payment', [BookingController::class, 'submitPayment'])->name('bookings.submit-payment');
        Route::get('/my-tickets', [BookingController::class, 'myTickets'])->name('bookings.my-tickets');
    });

    /*
    |----------------------------------------------------------------------
    | Staff Routes  (staff-or-admin gate now means staff-only)
    |----------------------------------------------------------------------
    */

    Route::middleware('can:staff-or-admin')->group(function () {
        // Check-in scanner
        Route::get('/checkin', [CheckInController::class, 'create'])->name('checkins.create');
        Route::get('/checkin/stats', [CheckInController::class, 'stats'])->name('checkins.stats');
        Route::post('/checkin', [CheckInController::class, 'store'])->name('checkins.store');

        // Booking management (confirm/decline) — Staff-scoped to their destination
        Route::post('/bookings/{booking}/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');
        Route::post('/bookings/{booking}/decline', [BookingController::class, 'decline'])->name('bookings.decline');

        // Payment approval/rejection and camera scanning
        Route::post('/bookings/{booking}/approve-payment', [BookingController::class, 'approvePayment'])->name('bookings.approve-payment');
        Route::post('/bookings/{booking}/reject-payment', [BookingController::class, 'rejectPayment'])->name('bookings.reject-payment');
        Route::post('/staff/preview-ticket', [BookingController::class, 'previewTicket'])->name('staff.preview-ticket');
        Route::post('/staff/verify-ticket', [BookingController::class, 'verifyTicket'])->name('staff.verify-ticket');

        // New Staff Refactored Routes
        Route::get('/staff/bookings', [\App\Http\Controllers\StaffBookingController::class, 'index'])->name('staff.bookings.index');
        Route::get('/staff/bookings/{booking}', [\App\Http\Controllers\StaffBookingController::class, 'show'])->name('staff.bookings.show');

        // Walk-in Registration Routes
        Route::get('/staff/walkins/create', [\App\Http\Controllers\WalkInController::class, 'create'])->name('staff.walkins.create');
        Route::post('/staff/walkins', [\App\Http\Controllers\WalkInController::class, 'store'])->name('staff.walkins.store');

        // Spots routes — spots.index auto-redirects to the correct spot
        Route::get('/spots', [\App\Http\Controllers\SpotController::class, 'redirect'])->name('spots.index');
        Route::get('/spots/{destination}', [\App\Http\Controllers\SpotController::class, 'dashboard'])->name('spots.dashboard');
        Route::get('/spots/{destination}/status',  [\App\Http\Controllers\SpotController::class, 'status'])->name('spots.status');
        Route::get('/spots/{destination}/edit',    [\App\Http\Controllers\SpotController::class, 'edit'])->name('spots.edit');
        Route::get('/spots/{destination}/gallery', [\App\Http\Controllers\SpotController::class, 'gallery'])->name('spots.gallery');
        Route::patch('/spots/{destination}', [\App\Http\Controllers\SpotController::class, 'update'])->name('spots.update');
        Route::post('/spots/{destination}/images', [\App\Http\Controllers\SpotController::class, 'uploadImage'])->name('spots.images.upload');
        Route::delete('/spots/images/{image}', [\App\Http\Controllers\SpotController::class, 'deleteImage'])->name('spots.images.delete');
        Route::post('/spots/images/{image}/primary', [\App\Http\Controllers\SpotController::class, 'setPrimary'])->name('spots.images.primary');
    });

    /*
    |----------------------------------------------------------------------
    | Admin Routes
    |----------------------------------------------------------------------
    */

    Route::middleware('can:admin-only')->group(function () {
        // Destination management
        Route::get('/admin/destinations/create', [DestinationController::class, 'create'])->name('destinations.create');
        Route::post('/admin/destinations', [DestinationController::class, 'store'])->name('destinations.store');
        Route::get('/admin/destinations/{destination}/edit', [DestinationController::class, 'edit'])->name('destinations.edit');
        Route::patch('/admin/destinations/{destination}', [DestinationController::class, 'update'])->name('destinations.update');
        Route::delete('/admin/destinations/{destination}', [DestinationController::class, 'destroy'])->name('destinations.destroy');

        // Reports
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/generate-visitor-record', [ReportController::class, 'generateVisitorRecord'])->name('reports.generate-visitor-record');
        Route::get('/reports/export-visitor-record', [ReportController::class, 'exportVisitorRecord'])->name('reports.export-visitor-record');
        Route::get('/reports/export-docx', [ReportController::class, 'exportDocx'])->name('reports.export-docx');
        Route::get('/reports/{report}', [ReportController::class, 'show'])->name('reports.show');

        // Identity Verification admin review
        Route::get('/admin/verifications/reviews', [IdentityVerificationController::class, 'adminReviews'])->name('verification.reviews');
        Route::get('/admin/verifications/accounts', [IdentityVerificationController::class, 'adminAccounts'])->name('verification.accounts');
        Route::get('/admin/verifications/staff', [IdentityVerificationController::class, 'adminStaff'])->name('verification.staff');
        Route::post('/admin/verifications/staff/{user}/reassign', [IdentityVerificationController::class, 'reassignStaff'])->name('verification.staff.reassign');
        Route::delete('/admin/verifications/staff/{user}', [IdentityVerificationController::class, 'deleteStaff'])->name('verification.staff.delete');
        Route::patch('/admin/verifications/staff/{user}', [IdentityVerificationController::class, 'updateStaff'])->name('verification.staff.update');
        Route::get('/admin/verifications/add-account', [IdentityVerificationController::class, 'adminAddAccount'])->name('verification.add_account');
        
        Route::post('/admin/verifications/{user}/decide', [IdentityVerificationController::class, 'adminDecide'])->name('verification.decide');
        Route::post('/admin/accounts/create', [IdentityVerificationController::class, 'adminStoreAccount'])->name('admin.accounts.store');
        Route::post('/admin/accounts/{user}/status', [IdentityVerificationController::class, 'adminUpdateStatus'])->name('admin.accounts.update_status');
        Route::post('/admin/accounts/{user}/auto-verify', [IdentityVerificationController::class, 'autoVerify'])->name('admin.accounts.auto_verify');
        Route::post('/admin/accounts/batch-auto-verify', [IdentityVerificationController::class, 'batchAutoVerify'])->name('admin.accounts.batch_auto_verify');

        // Analytics
        Route::get('/admin/analytics/kpis', [AnalyticsController::class, 'getKpis'])->name('admin.analytics.kpis');
        Route::get('/admin/analytics/trends', [AnalyticsController::class, 'getTrendData'])->name('admin.analytics.trends');
        Route::get('/admin/analytics/destinations', [AnalyticsController::class, 'getDestinations'])->name('admin.analytics.destinations');
        Route::get('/admin/analytics/advanced', [AnalyticsController::class, 'getAdvancedData'])->name('admin.analytics.advanced');
        Route::post('/admin/analytics/broadcast-alert', [AnalyticsController::class, 'broadcastAlert'])->name('admin.analytics.broadcast-alert');
        Route::post('/admin/analytics/toggle-halt', [AnalyticsController::class, 'toggleHaltBookings'])->name('admin.analytics.toggle-halt');
        Route::post('/admin/analytics/export-pipeline', [AnalyticsController::class, 'exportPipeline'])->name('admin.analytics.export-pipeline');
    });

    }); // end identity.verified middleware group
});

// Public polling endpoint — visitor map fetches this every 30 s to stay in sync
Route::get('/spots/{destination}/checkin-coords', [\App\Http\Controllers\SpotController::class, 'checkinCoords'])->name('spots.checkin-coords');

require __DIR__ . '/auth.php';
