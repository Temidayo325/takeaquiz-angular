<?php 
declare(strict_types = 1);

namespace App\Actions\Game;

/**
 * 
 */
class CreateGameQuestion
{
	
	function __invoke(object $question)
	{
		$idea = \App\Models\Game::where('id', $question->game_id)->first()->ideas()->create([
			'question' => $question->idea, 
	    	'tags' => $this->turnStringTagsToArray($question->tags)
		]);
		return $idea;
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