<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Notification;
use App\Order;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function adminDashboard(){
        $check = 'dashboard';
        $notifications = Notification::where('receiver', 'admin')->get()->all();
        $new_requests = Order::where('status', 'requested')->get()->all();
        $in_progress = Order::where('status', 'onWorking')->get()->all();
        $completed = Order::where('status', 'completed')->get()->all();
        $for_revision = Order::where('status', 'revisionFromBuyer')->get()->all();
        $approved = Order::where('status', 'approved')->get()->all();
        $accepted = Order::where('status', 'accepted')->get()->all();
        return view('admin.adminDashboard')
            ->with('notifications', array_reverse($notifications))
            ->with('user_name', 'admin')
            ->with('user_type', 'admin')
            ->with('new_requests', $new_requests)
            ->with('in_progress', $in_progress)
            ->with('completed', $completed)
            ->with('for_revision', $for_revision)
            ->with('approved', $approved)
            ->with('accepted', $accepted)
            ->with('check', $check)
            ->with('user_id', 1)
            ->with('user_picture', "https://firebasestorage.googleapis.com/v0/b/freelanceplus-9aa42.appspot.com/o/images%2Fadmin.jpg?alt=media&token=a68bb735-2cc9-4970-9d6b-b806adc699fb");
    }
}
