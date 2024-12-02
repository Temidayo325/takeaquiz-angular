<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
    	$events = Event::with('tickets', 'user')->latest()->orderBy('id')->cursorPaginate(5);
    	$user = \App\Models\User::with('role')->where('id', auth()->id())->first();
    	return view("dashboard.admin.event.index", ['events' => $events, 'user' => $user]);
    }

    public function paginateEvents(Request $request)
    {
    	$events = Event::with('tickets', 'user')->latest()->orderBy('id')->cursorPaginate(5);
    	return response()->json($events);
    }

    public function togglePremium(\App\Http\Requests\Event\EventIdRequest $request)
    {
    	$event = Event::find($request->id);
    	$event->isPremium = ! $event->isPremium;
    	$event->save();
    	$events = Event::with('tickets', 'user')->latest()->orderBy('id')->cursorPaginate(5);
    	return response()->json([
    		'error' => false,
    		'errorMessage' => 'Event premium status successfully updated',
    		'events' => $events
    	]);
    }

    public function search(Request $request)
    {
    	$events = Search::add(Event::class, 'name')
					    ->add(\App\Models\Ticket::class, 'type')
					    ->beginWithWildcard()
					    ->endWithWildcard(false)
					    ->search($request->searchTerm);
    	return response()->json([
    		'error' => false,
    		'errorMessage' => 'Search results returned successfully',
    		'events' => $events
    	]);
    }

    public function delete(\App\Http\Requests\Event\EventIdRequest $request)
    {
    	$event = Event::find($request->id);
    	$event->delete();
    	$events = Event::with('tickets', 'user')->latest()->orderBy('id')->cursorPaginate(5);
    	return response()->json([
    		'error' => false,
    		'errorMessage' => 'Ticket succesfully deleted',
    		'events' => $events
    	]);
    }
}
