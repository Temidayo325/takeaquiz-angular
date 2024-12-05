<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index()
    {
    	$events = Event::with('tickets', 'user')->whereBetween('event_date', [Carbon::today(), Carbon::parse('+30 day')])->orderBy('event_date', 'ASC')->get();
    	$premium_events = $events->filter( function($event){
    		return $event->isPremium === true;
    	});
    	$events_today = Event::with('tickets', 'user')->where('event_date', '=', Carbon::today())->orderBy('event_date', 'ASC')->get();
    	return view("dashboard.user.event.index", ['events' => $events, 'user' => auth()->user(), 'premium_events' => $premium_events, 'events_today' => $events_today]);
    }

    public function homepage()
    {
    	$now = \Carbon\Carbon::now()->format('Y-m-d');
    	$events = Event::with('tickets', 'user')->whereBetween('event_date', [$now, Carbon::parse('+30 days')])->orderBy('event_date', 'ASC')->get();
    	$premium_events = $events->filter( function($event){
    		return $event->isPremium === true;
    	});
    	$events_today = Event::with('tickets', 'user')->where('event_date', '=', Carbon::today())->orderBy('event_date', 'ASC')->get();
    	return view("welcome", [
			'events' => $events, 
			'premium_events' => $premium_events,
			'events_today' => $events_today
		]);
    }

    public function searchByState(Request $request)
    {
    	$now = \Carbon\Carbon::now()->format('Y-m-d');
    	$events = ($request->state === 'all') ? Event::with('tickets', 'user')->whereBetween('event_date', [$now, Carbon::parse('+30 days')])->orderBy('event_date', 'ASC')->get(): Event::with('tickets', 'user')->where('state', strtolower($request->state))->whereBetween('event_date', [$now, Carbon::parse('+30 days')])->orderBy('event_date', 'ASC')->get();
    	$premium_events = $events->filter( function($event){
    		return $event->isPremium === true;
    	});
    	$events_today = ($request->state !== 'all') ? Event::with('tickets', 'user')->where('state', strtolower($request->state))->where('event_date', '=', Carbon::today())->orderBy('event_date', 'ASC')->get() : Event::with('tickets', 'user')->where('event_date', '=', Carbon::today())->orderBy('event_date', 'ASC')->get();
    	return response()->json([
    		'events' => $events, 
			'premium_events' => $premium_events,
			'events_today' => $events_today
    	]);
    }

    public function searchByTags(Request $request)
    {
      
    }
   //  public function searchByEventName()
   //  {
   //  	$now = \Carbon\Carbon::now()->format('Y-m-d');
   //  	$events = Event::with('tickets', 'user')->where('state', strtolower($request->state))->whereBetween('event_date', [$now, Carbon::parse('+30 days')])->orderBy('event_date', 'ASC')->get();
   //  	$premium_events = $events->filter( function($event){
   //  		return $event->isPremium === true;
   //  	});
   //  	$events_today = Event::with('tickets', 'user')->where('state', strtolower($request->state))->where('event_date', '=', Carbon::today())->orderBy('event_date', 'ASC')->get();
   //  	return response()->json([
   //  		'events' => $events, 
			// 'premium_events' => $premium_events,
			// 'events_today' => $events_today
   //  	]);
   //  }
}
