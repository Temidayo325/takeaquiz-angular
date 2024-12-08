<?php 
declare(strict_types = 1);

namespace App\Actions\Event;

/**
 * 
 */
class StoreEvent
{
	
	function __invoke($editedEvent)
	{
		$event = \App\Models\Event::find($editedEvent->id);
		$event->save((array) $editedEvent->validated());
		$tag = new EventTags();
		$tag->edit($editedEvent->tags, $event);
		return $event;
	}
}