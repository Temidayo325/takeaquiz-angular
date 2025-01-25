<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;

class UserController extends Controller
{
    public function index()
    {
    	$events = Sale::with('ticket', 'event')->where('user_id', auth()->id())->latest()->limit(5)->get();
    	$upcoming_events = Sale::with('ticket', 'event')->whereHas('event', function ($query) {
		    $query->where('event_date', '>', now())->where('status', 'Published')->latest();
		})->where('user_id', auth()->id())->limit(5)->get();
        $user = \App\Models\User::with('role')->where('id', auth()->id())->first();
    	return view("dashboard.user.index", ['events' => $events, 'user' => $user, 'upcoming_events' => $upcoming_events]);
    }

    public function edit()
    {
    	
    }
}
