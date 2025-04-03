<?php

namespace App\Http\Controllers\Promoter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class DashboardController extends Controller
{
    public function index()
    {
    	$recent_events = Event::with(['tickets.sales', 'tickets.attendance'])->where('user_id', auth()->id())->latest()->limit(3)->get();
    	$upcoming_events = Event::with(['tickets.sales', 'tickets.attendance'])->where('event_date', '>', now())->latest()->where('user_id', auth()->id())->limit(3)->get();
    	return view("dashboard.promoter.index", 
				[	'user' => \App\Models\User::with('va')->where('id', auth()->id())->first(),
					'recent_events' => ( $recent_events != null && count($recent_events) > 0) ? $recent_events : [],
					'upcoming_events' => $upcoming_events
				]);
    }
}
