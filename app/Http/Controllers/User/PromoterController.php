<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PromoterController extends Controller
{
    public function index()
    {
        $notification = \App\Models\Notification::query()->where('user_id', auth()->id())->first();
        return view("dashboard.user.promoter.create", ['user' => auth()->user(), 'notification' => $notification]);
    }

    public function create(Request $request)
    {
        $notification_exists = \App\Models\Notification::where('user_id', auth()->id())->first();
        if($notification_exists != null)
        {
            return response()->json([
                'message' => 'You notification has been previously received and work is been done concerning it',
                'error' => true
            ]);
        }

        $new_promoter_notification = \App\Models\Notification::create([
            'summary' => $request->summary,
            'user_id' => auth()->id()
        ]); 

        return response()->json([
            'error' => false,
            'message' => 'notification succesfully created'
        ]);
    }
}
