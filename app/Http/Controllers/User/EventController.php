<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
    	$events = Event::with('tickets', 'user')->whereBetween('event_date', [\Carbon\Carbon::now(), \Carbon\Carbon::parse('+30 day')])->orderBy('event_date', 'ASC')->get();
    	$premium_events = $events->filter( function($event){
    		return $event->isPremium === true;
    	});
    	return view("dashboard.user.event.index", ['events' => $events, 'user' => auth()->user(), 'premium_events' => $premium_events]);
    }
}
