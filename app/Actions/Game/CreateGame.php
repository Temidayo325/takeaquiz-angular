<?php 
declare(strict_types = 1);

namespace App\Actions\Game;

use App\Actions\Event\EventTags;

/**
 * 
 */
class CreateGame extends EventTags
{
	
	function __invoke($gameToBeCreated)
	{
        $image_path = ( $gameToBeCreated->has('picture') ) ? $gameToBeCreated->picture->store('games') : null;
		$game = \App\Models\Game::create([
			'name' => $gameToBeCreated->name, 
	    	'summary' => $gameToBeCreated->summary,
	    	'stepByStep' => json_decode( $gameToBeCreated->stepByStepJson ),
	    	'minimum_player' => $gameToBeCreated->minimum_player,
	    	'maximum_player' => $gameToBeCreated->maximum_player,
	    	'tags' => $this->turnStringTagsToArray( $gameToBeCreated->tags ),
	    	'image' => $image_path,
	    	'materials' => $this->turnStringTagsToArray( $gameToBeCreated->materials ), 
	    	'play_time' => $gameToBeCreated->play_time, 
	    	'difficulty_level' => $gameToBeCreated->difficulty_level, 
	    	'category' => $gameToBeCreated->category, 
	    	'ideal_setting' => $gameToBeCreated->ideal_setting, 
	    	'objective' => $gameToBeCreated->objective, 
	    	'tips' => $gameToBeCreated->tips
		]);
		// $tag = new EventTags();
		// $tag->add($gameToBeCreated->tags, $game);
		// return $game;
		// 
	}

	private function turnStringTagsToArray(string $tags):Array
	{
		$tagArray = explode(',', $tags);
		$newCleanedTagArray = [];
		if ( count($tagArray) > 1 ) {
			foreach ($tagArray as $tag) {
				# code...
				array_push($newCleanedTagArray, preg_replace('/[^a-zA-Z0-9- ]/', '', strip_tags(trim($tag))));
			}
		}
		return $newCleanedTagArray;
	}
}