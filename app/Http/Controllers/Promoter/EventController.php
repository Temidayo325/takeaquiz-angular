<?php

namespace App\Http\Controllers\Promoter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Event\CreateEventRequest;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
    	$events = \App\Models\Event::with('tickets.attendance')->where('user_id', auth()->id())->latest()->orderBy('id')->cursorPaginate(5);
        $user = \App\Models\User::with('role')->where('id', auth()->id())->first();
    	return view("dashboard.promoter.event.index", ['events' => $events, 'user' => $user]);
    }

    public function store(CreateEventRequest $event)
    {
    	if ($event->has('id') && $event->id != null) {
    		try {
    			$event = ( new \App\Actions\Event\StoreEvent() )((object) $event);
	    		return response()->json([
	    			'error' => false,
	    			'message' => "Event successfully edited"
	    		]);
    		} catch (\Exception $e) {
    			return response()->json([
	    			'error' => true,
	    			'message' => $e->getMessage()
	    		]);
    		}
    	}
        try {
            // $file = $event->file('flier');
            // // Store the file in the desired storage location
            // if (Storage::size($file) > 2048) {
            //     return response()->json([
            //         'error' => true,
            //         'message' => "Filesize cannot exceed 2MB"
            //     ]);
            // }
            $event = ( new \App\Actions\Event\CreateEvent() )((object) $event);
            return response()->json([
                'error' => false,
                'message' => "Event successfully created"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function paginateEvents(Request $request)
    {
    	$events = \App\Models\Event::with('tickets')->where('user_id', auth()->id())->latest()->orderBy('id')->cursorPaginate(5);
    	return response()->json($events);
    }

    public function create()
    {
        $user = \App\Models\User::with('role')->where('id', auth()->id())->first();
        return view("dashboard.promoter.event.create", ['user' => $user]);
    }
}
