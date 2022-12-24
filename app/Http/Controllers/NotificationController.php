<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Get all notifications for the logged-in user, paginated.
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        // TODO: load related model e.g. following user
        return $user->notifications()->paginate();
    }

    /**
     * Mark all unread notifications as read
     */
    public function markAllRead()
    {
        /** @var User $user */
        $user = Auth::user();
        return $user->notifications()->update(['read_at' => now()]);
    }

    /**
     * Mark a single notification as read
     */
    public function markRead(DatabaseNotification $notification)
    {
        $notification->markAsRead();
        return $notification;
    }
}
