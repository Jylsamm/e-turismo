<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * List all notifications for the authenticated user.
     */
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'all');
        $query = Notification::where('recipient_id', auth()->id());

        if ($filter === 'unread') {
            $query->where('is_read', false);
        }

        $notifications = $query->latest()->paginate(20)->withQueryString();
        $unreadCount = Notification::where('recipient_id', auth()->id())->where('is_read', false)->count();
        $totalCount = Notification::where('recipient_id', auth()->id())->count();

        return view('notifications.index', compact('notifications', 'unreadCount', 'totalCount', 'filter'));
    }

    /**
     * Mark a single notification as read.
     */
    public function markRead(Request $request, Notification $notification)
    {
        if ($notification->recipient_id !== auth()->id()) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
            abort(403);
        }

        $notification->update(['is_read' => true]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Notification marked as read.']);
        }

        return back()->with('success', 'Notification marked as read.');
    }

    /**
     * Mark all notifications as read for the current user.
     */
    public function markAllRead(Request $request)
    {
        $updated = Notification::where('recipient_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'All notifications marked as read.',
                'updated_count' => $updated,
            ]);
        }

        return back()->with('success', 'All notifications marked as read.');
    }

    /**
     * Get the latest unread broadcast alert for polling.
     */
    public function getLatestAlert()
    {
        $notification = Notification::where('recipient_id', auth()->id())
            ->where('is_read', false)
            ->where('type', 'broadcast_alert')
            ->latest()
            ->first();

        if ($notification) {
            return response()->json([
                'has_alert' => true,
                'id' => $notification->id,
                'message' => $notification->message,
            ]);
        }

        return response()->json(['has_alert' => false]);
    }

    /**
     * Dismiss an active broadcast alert.
     */
    public function dismissAlert(Notification $notification)
    {
        if ($notification->recipient_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $notification->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * Stream unread notifications and emergency alerts in real-time using Server-Sent Events (SSE).
     */
    public function streamRealtimeUpdates()
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        return response()->stream(function () use ($user) {
            $lastSignature = null;
            
            // Set max execution time per stream window
            @set_time_limit(45);

            // Prevent session locking which blocks other requests
            if (session_status() === PHP_SESSION_ACTIVE) {
                session_write_close();
            }

            // Flush and disable all output buffering levels
            while (ob_get_level() > 0) {
                ob_end_flush();
            }

            // Stream in bounded cycles (~30 seconds) so Apache/PHP workers cycle safely.
            // The browser's native EventSource automatically reconnects immediately.
            $maxCycles = 15; // 15 cycles * 2s = 30s
            for ($cycle = 0; $cycle < $maxCycles; $cycle++) {
                if (connection_aborted()) {
                    break;
                }

                // Send silent heartbeat comment to maintain connection state
                echo ": heartbeat\n\n";
                if (ob_get_level() > 0) {
                    ob_flush();
                }
                flush();

                // Fetch latest state
                $unreadCount = Notification::where('recipient_id', $user->id)
                    ->where('is_read', false)
                    ->count();

                $latestNotification = Notification::where('recipient_id', $user->id)
                    ->where('is_read', false)
                    ->latest()
                    ->first();

                $latestAlert = Notification::where('recipient_id', $user->id)
                    ->where('is_read', false)
                    ->where('type', 'broadcast_alert')
                    ->latest()
                    ->first();

                // Compute composite signature to detect any new/updated/dismissed notifications
                $currentSignature = md5(
                    $unreadCount . '_' .
                    ($latestAlert ? $latestAlert->id . '-' . $latestAlert->updated_at : 'no-alert') . '_' .
                    ($latestNotification ? $latestNotification->id . '-' . $latestNotification->updated_at : 'no-notif')
                );

                if ($currentSignature !== $lastSignature) {
                    $recent = Notification::where('recipient_id', $user->id)
                        ->where('is_read', false)
                        ->latest()
                        ->take(5)
                        ->get()
                        ->map(function ($n) {
                            return [
                                'id' => $n->id,
                                'type' => $n->type,
                                'message' => $n->message,
                                'created_at' => $n->created_at ? $n->created_at->diffForHumans() : '',
                            ];
                        });

                    $data = json_encode([
                        'unread_count' => $unreadCount,
                        'recent' => $recent,
                        'has_alert' => $latestAlert ? true : false,
                        'alert_id' => $latestAlert ? $latestAlert->id : null,
                        'alert_message' => $latestAlert ? $latestAlert->message : null,
                    ]);

                    echo "data: {$data}\n\n";
                    if (ob_get_level() > 0) {
                        ob_flush();
                    }
                    flush();

                    $lastSignature = $currentSignature;
                }

                sleep(2); // Check for updates every 2 seconds
            }
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Connection' => 'keep-alive',
            'X-Accel-Buffering' => 'no', // Disable output buffering for Nginx
        ]);
    }
}
