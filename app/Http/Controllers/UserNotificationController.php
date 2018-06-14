<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserNotificationController extends Controller
{
    public function destroy(User $user, $notificationId)
    {
    	$user->notifications()->find($notificationId)->markAsRead();
    }

    public function index()
    {
    	return auth()->user()->unreadNotifications;
    }
}
