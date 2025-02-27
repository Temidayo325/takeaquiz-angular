<?php

namespace App\Http\Controllers\Promoter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Event\CreateEventRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
    	$events = Event::with('tickets.attendance', 'user')->where('user_id', auth()->id())->latest()->orderBy('id')->cursorPaginate(5);
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

    public function add_promotional_media(\App\Http\Requests\Event\PromotionalRequest $request)
    {
        try {
            $path = $request->video->store('promotional_materials');
            $event_media = \App\Models\EventMedia::create([
                'user_id' => auth()->id(),
                'event_id' => $request->event_id,
                'video_gallery' => $path,
                'image_gallery' => 'Wahala pro max and it does not exist',
                'flier' => 'Again the same thing'
            ]);
            $event = Event::with('eventmedia')->where('id', $request->event_id)->first();
            return response()->json([
                'error' => false,
                'message' => "Event promotional video added",
                'event' => $event
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
    	$events = Event::with('tickets', 'user')->where('user_id', auth()->id())->latest()->orderBy('id')->cursorPaginate(5);
    	return response()->json($events);
    }

    public function create()
    {
        $user = \App\Models\User::with('role')->where('id', auth()->id())->first();
        return view("dashboard.promoter.event.create", ['user' => $user]);
    }

    public function updateStatus(\App\Http\Requests\Event\EventIdRequest $request)
    {
        $event = Event::find($request->id);
        $event->status = ( $event->status == 'Draft' ) ? 'Published' : 'Draft';
        $event->save();
        return response()->json([
            'error' => false,
            'message' => "Event status updated successfully"
        ]);
    }
}
