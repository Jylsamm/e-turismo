<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\CheckIn;
use App\Models\Destination;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        } elseif ($user->isStaff()) {
            return $this->staffDashboard();
        } else {
            return $this->touristDashboard();
        }
    }

    private function adminDashboard()
    {
        $stats = [
            'total_tourists' => User::where('role', 'tourist')->count(),
            'total_destinations' => Destination::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'total_checkins' => CheckIn::count(),
            'today_visitors' => CheckIn::whereDate('arrival_time', today())->count(),
            'confirmed_bookings' => Booking::where('status', 'confirmed')->count(),
        ];

        $recentBookings = Booking::with(['tourist', 'destination'])
            ->latest()->limit(10)->get();

        $topDestinations = Destination::withCount(['bookings' => fn($q) => $q->whereIn('status', ['confirmed', 'completed'])])
            ->orderByDesc('bookings_count')->limit(5)->get();

        $notifications = Notification::where('recipient_id', auth()->id())
            ->where('is_read', false)->latest()->limit(5)->get();

        return view('dashboard.admin', compact('stats', 'recentBookings', 'topDestinations', 'notifications'));
    }

    private function staffDashboard()
    {
        $user = auth()->user();
        $destinationId = $user->assigned_destination_id;

        $stats = [
            'pending_bookings' => Booking::where('destination_id', $destinationId)->where('status', 'pending')->count(),
            'confirmed_bookings' => Booking::where('destination_id', $destinationId)->where('status', 'confirmed')->count(),
            'today_checkins' => CheckIn::whereHas('booking', fn($q) => $q->where('destination_id', $destinationId))
                ->whereDate('arrival_time', today())->count(),
        ];

        $pendingBookings = Booking::with('tourist')
            ->where('destination_id', $destinationId)
            ->where('status', 'pending')
            ->latest()->get();

        $notifications = Notification::where('recipient_id', auth()->id())
            ->where('is_read', false)->latest()->limit(5)->get();

        return view('dashboard.staff', compact('stats', 'pendingBookings', 'notifications'));
    }

    private function touristDashboard()
    {
        $myBookings = Booking::with(['destination', 'ticket'])
            ->where('tourist_id', auth()->id())
            ->latest()->limit(5)->get();

        $notifications = Notification::where('recipient_id', auth()->id())
            ->where('is_read', false)->latest()->limit(5)->get();

        $destinations = Destination::limit(6)->get();

        return view('dashboard.tourist', compact('myBookings', 'notifications', 'destinations'));
    }
}
