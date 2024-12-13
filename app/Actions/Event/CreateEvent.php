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
        $path = $eventToBeCreated->flier->store('fliers');
		$event = \App\Models\User::where('id', auth()->id())->first()->events()->create([
			'name' => $eventToBeCreated->name, 
	    	'event_date' => $eventToBeCreated->event_date,
	    	'starting_time' => $eventToBeCreated->starting_time,
	    	'state' => $eventToBeCreated->state,
	    	'coordinate' => $eventToBeCreated->coordinate,
	    	'tags' => json_encode($this->turnStringTagsToArray($eventToBeCreated->tags)),
	    	'flier' => $path,
	    	'location' => $eventToBeCreated->location,
	    	'promotional_copy' => $eventToBeCreated->promotional_copy
		]);
		// $tag = new EventTags();
		// $tag->add($eventToBeCreated->tags, $event);
		return $event;
	}

	private function turnStringTagsToArray(string $tags):Array
	{
		$tagArray = explode(',', $tags);
		$newCleanedTagArray = [];
		if ( count($tagArray) > 1 ) {
			foreach ($tagArray as $tag) {
				# code...
				array_push($newCleanedTagArray, preg_replace('/[^a-zA-Z0-9-]/', '', strip_tags(trim($tag))));
			}
		}
		return $newCleanedTagArray;
	}
}