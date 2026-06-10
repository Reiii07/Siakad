<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAllAsRead(Request $request): RedirectResponse
    {
        $readNotifications = $request->session()->get('admin_read_notifications', []);
        $notificationKeys = collect($request->input('notifications', []))
            ->filter()
            ->values()
            ->all();

        $request->session()->put(
            'admin_read_notifications',
            array_values(array_unique(array_merge($readNotifications, $notificationKeys)))
        );

        return back();
    }
}
