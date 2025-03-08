<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PromoterController extends Controller
{
    public function index()
    {
        $notification = \App\Models\Notification::with('user')->where('role', 'promoter')->where('status', false)->get();
        return view("dashboard.admin.promoter.notification", [
            'user' => \App\Models\User::with('va')->where('id', auth()->id())->first(), 
            'notification' => $notification
        ]);
    }

    public function approve(Request $request)
    {
        $notification = \App\Models\Notification::find($request->notification_id);
        $promoter_role = \App\Models\Role::find(3);
        $user = \App\Models\User::find($notification->user_id);
        $user->role()->attach($promoter_role);
       
        $notification->status = true;
        $notification->save();
        return response()->json([
            'error' => false,
            'message' => 'request approved succesfully'
        ]);
    }
}
