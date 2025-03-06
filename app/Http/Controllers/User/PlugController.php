<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlugController extends Controller
{
    public function index()
    {
        $notification = \App\Models\Notification::query()->where('role', 'plug')->where('user_id', auth()->id())->first();
        return view("dashboard.user.plug.create", ['user' => auth()->user(), 'notification' => $notification]);
    }

    public function create(\App\Http\Requests\Plug\RequestPlugAccessRequest $request)
    {
        $notification_exists = \App\Models\Notification::query()->where('role', 'plug')->where('user_id', auth()->id())->first();
        if($notification_exists != null)
        {
            return response()->json([
                'message' => 'You notification has been previously received and work is been done concerning it',
                'error' => true
            ]);
        }

        \App\Models\Notification::create([
            'summary' => "Service provided: " .$request->service ."Service summary: ".$request->service_summary,
            'user_id' => auth()->id(),
            'role' => 'plug'
        ]); 

        return response()->json([
            'error' => false,
            'message' => 'notification succesfully created'
        ]);
    }
}
