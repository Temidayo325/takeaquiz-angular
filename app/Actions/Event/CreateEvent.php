<?php 
declare(strict_types = 1);

namespace App\Actions\Event;

/**
 * 
 */
class CreateEvent extends EventTags
{
	
	function __invoke(object $eventToBeCreated)
	{
        $path = $eventToBeCreated->event_flier->store('/');
		$event = \App\Models\User::where('id', auth()->id())->first()->events()->create([
			'name' => $eventToBeCreated->name, 
	    	'event_date' => $eventToBeCreated->event_date,
	    	'starting_time' => $eventToBeCreated->starting_time,
	    	'state' => $eventToBeCreated->state,
	    	'coordinate' => $eventToBeCreated->coordinate,
	    	'flier' => $path,
	    	'location' => $eventToBeCreated->location,
	    	'promotional_copy' => $eventToBeCreated->promotional_copy
		]);
		$tag = new EventTags();
		$tag->add($eventToBeCreated->event_tags, $event);
		return $event;
	}
}