<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlugController extends Controller
{
    public function index()
    {
        $notification = \App\Models\Notification::with('user')->where('role', 'plug')->where('status', false)->get();
        return view("dashboard.admin.plug.notification", [
            'user' => \App\Models\User::with('va')->where('id', auth()->id())->first(), 
            'notification' => $notification]);
    }

    public function approve(Request $request)
    {
        $notification = \App\Models\Notification::find($request->notification_id);
        $plug_role = \App\Models\Role::query()->where("role", "plug")->first();
        $user = \App\Models\User::find($notification->user_id);
        $user->role()->attach($plug_role);
       
        $notification->status = true;
        $notification->save();
        return response()->json([
            'error' => false,
            'message' => 'request approved succesfully'
        ]);
    }
}
