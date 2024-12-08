<?php 
declare(strict_types = 1);

namespace App\Actions\Game;

use App\Actions\Event\EventTags;

/**
 * 
 */
class CreateGame extends EventTags
{
	
	function __invoke(object $gameToBeCreated)
	{
        $image_path = $gameToBeCreated->image->store('/games');
		$game = \App\Models\Game::create([
			'name' => $gameToBeCreated->name, 
	    	'summary' => $gameToBeCreated->summary,
	    	'stepByStep' => $gameToBeCreated->stepByStep,
	    	'minimum_player' => $gameToBeCreated->minimum_player,
	    	'maximum_player' => $gameToBeCreated->maximum_player,
	    	'tags' => $gameToBeCreated->tags,
	    	'image' => $image_path
		]);
		$tag = new EventTags();
		$tag->add($gameToBeCreated->tags, $game);
		return $game;
	}
}