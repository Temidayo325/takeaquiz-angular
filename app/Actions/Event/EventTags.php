<?php 
declare(strict_types = 1);
namespace App\Actions\Event;
use Illuminate\Database\Eloquent\Model;

use Spatie\Tags\Tag;
/**
 * 
 */
class EventTags
{
	
	public function add(string $tags, Model $event)
	{
		$tagsArray = $this->cleanTags($tags);
		$tagWithType = Tag::findOrCreate($tagsArray, strtolower(class_basename($event)));
		// Attach the tags
		$event->attachTags($tagWithType);
	}

	public function edit(string $tags, Model $event)
	{
		$tagsArray = $this->cleanTags($tags);
		$event->syncTags($tagsArray);
	}

	protected function cleanTags(string $tags):array
	{
		$tagArray = explode(',', $tags);
		$newCleanedTagArray = [];
		if ( count($tagArray) > 1 ) {
			foreach ($tagArray as $tag) {
				# code...
				array_push($newCleanedTagArray, preg_replace('/[^a-zA-Z0-9-]/', '', strip_tags(trim($tag))));
			}
		}
		$newCleanedTagArray[] = $tags;
		return $newCleanedTagArray;
	}
}