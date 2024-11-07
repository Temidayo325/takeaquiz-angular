<?php 
declare(strict_types = 1);

namespace App\Actions\Event;

/**
 * 
 */
class CreateEvent
{
	
	function __invoke(object $eventToBeCreated)
	{
		$event = \App\Models\User::where('id', auth()->id())->first()->events()->create([
			'name' => $eventToBeCreated->name, 
	    	'event_date' => $eventToBeCreated->event_date,
	    	'starting_time' => $eventToBeCreated->starting_time,
	    	'state' => $eventToBeCreated->state,
	    	'coordinate' => $eventToBeCreated->coordinate,
	    	'promotional_copy' => $eventToBeCreated->promotional_copy
		]);
		// $event->isPremium = false;
		// $event->save();
		return $event;
	}
}