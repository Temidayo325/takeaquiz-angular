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
    	$events = Event::with('tickets', 'user', 'eventmedia')->where('status', 'Published')->whereBetween('event_date', [Carbon::today(), Carbon::parse('+30 day')])->orderBy('event_date', 'ASC')->get();
      
    	$premium_events = $events->filter( function($event){
    		return $event->isPremium == true;
    	})->toArray();
      $premium_events = array_values($premium_events);
    	$events_today = Event::with('tickets', 'user', 'eventmedia')->where('status', 'Published')->where('event_date', '=', Carbon::today())->orderBy('event_date', 'ASC')->get();
    	
      return view("dashboard.user.event.index", [
          'events' => $events, 
          'user' => \App\Models\User::with('va')->where('id', auth()->id())->first(), 
          'premium_events' => $premium_events, 
          'events_today' => $events_today,
          // 'tags' => $this->eventTags()
      ]);
    }

    public function homepage()
    {
    	$now = \Carbon\Carbon::now()->format('Y-m-d');
    	$events = Event::with('tickets', 'user', 'eventmedia')->where('status', 'Published')->whereBetween('event_date', [$now, Carbon::parse('+30 days')])->orderBy('event_date', 'ASC')->get();
    	$premium_events = $events->filter( function($event){
    		return $event->isPremium == true;
    	})->toArray();
      $premium_events = array_values($premium_events);
    	$events_today = Event::with('tickets', 'user', 'eventmedia')->where('status', 'Published')->where('event_date', '=', Carbon::today())->orderBy('event_date', 'ASC')->get();
    	
      return view("welcome", [
  			'events' => $events, 
  			'premium_events' => $premium_events,
  			'events_today' => $events_today,
        // 'tags' => $this->eventTags()
  		]);
    }

    public function searchByState(Request $request)
    {
    	$now = \Carbon\Carbon::now()->format('Y-m-d');
    	$events = ($request->state === 'all') ? Event::with('tickets', 'user', 'eventmedia')->where('status', 'Published')->whereBetween('event_date', [$now, Carbon::parse('+30 days')])->orderBy('event_date', 'ASC')->get(): Event::with('tickets', 'user', 'eventmedia')->where('state', strtolower($request->state))->where('status', 'Published')->whereBetween('event_date', [$now, Carbon::parse('+30 days')])->orderBy('event_date', 'ASC')->get();
    	$premium_events = $events->filter( function($event){
    		return $event->isPremium == true;
    	})->toArray();
      $premium_events = array_values($premium_events);
    	$events_today = ($request->state !== 'all') ? Event::with('tickets', 'user', 'eventmedia')->where('state', strtolower($request->state))->where('status', 'Published')->where('event_date', '=', Carbon::today())->orderBy('event_date', 'ASC')->get() : Event::with('tickets', 'user', 'eventmedia')->where('status', 'Published')->where('event_date', '=', Carbon::today())->orderBy('event_date', 'ASC')->get();
    	return response()->json([
    		'events' => $events, 
			  'premium_events' => $premium_events,
			  'events_today' => $events_today
    	]);
    }

    public function searchByTags(Request $request)
    {
      
    }

    // protected function eventTags():array
    // {
    //     $games = Event::select('tags')->get()->toArray();
    //     $merged = [];
    //     foreach($games as $game)
    //     {
    //       $merged = array_merge($merged, ...array_values($game));
    //     }
    //     $unique_tags = array_unique($merged, SORT_STRING);
    //     return $unique_tags;
    // }
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
