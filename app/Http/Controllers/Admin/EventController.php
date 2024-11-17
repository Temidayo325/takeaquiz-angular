<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
    	$events = \App\Models\Event::with('tickets')->latest()->orderBy('id')->cursorPaginate(5);
    	$user = \App\Models\User::with('role')->where('id', auth()->id())->first();
    	return view("dashboard.admin.event.index", ['events' => $events, 'user' => $user]);
    }

    public function paginateEvents(Request $request)
    {
    	$events = \App\Models\Event::with('tickets')->latest()->orderBy('id')->cursorPaginate(5);
    	return response()->json($events);
    }

    public function togglePremium(\App\Http\Requests\Event\EventIdRequest $request)
    {
    	$event = \App\Models\Event::find($request->id);
    	$event->isPremium = ! $event->isPremium;
    	$event->save();
    	$events = \App\Models\Event::with('tickets')->latest()->orderBy('id')->cursorPaginate(5);
    	return response()->json([
    		'error' => false,
    		'errorMessage' => 'Event premium status successfully updated',
    		'events' => $events
    	]);
    }

    public function delete(\App\Http\Requests\Event\EventIdRequest $request)
    {
    	$event = \App\Models\Event::find($request->id);
    	$event->delete();
    	$events = \App\Models\Event::with('tickets')->latest()->orderBy('id')->cursorPaginate(5);
    	return response()->json([
    		'error' => false,
    		'errorMessage' => 'Ticket succesfully deleted',
    		'events' => $events
    	]);
    }
}
