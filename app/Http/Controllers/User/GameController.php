<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;

class GameController extends Controller
{
    public function index()
    {
    	$games = Game::latest()->orderBy('id')->cursorPaginate(12);
    	return view("dashboard.user.game.index", [
    		'user' => \App\Models\User::with('va')->where('id', auth()->id())->first(),
    		'games' => $games,
            'tags' => $this->gameTags()
        ]);
    }

    public function paginateGames(Request $request)
    {
    	$events = Game::latest()->orderBy('id')->cursorPaginate(12);
    	return response()->json($events);
    }

    public function search(Request $request)
    {
    	$games = Search::add(Game::class, ['name', 'summary', 'how-to', 'minimum_player'])
			              ->beginWithWildcard() 
			              ->endWithWildcard(true)
			              ->orderByRelevance()
			              ->search($request->searchTerm)
			              ->take(12);
    	return response()->json([
    		'error' => false,
    		'message' => "Games returned",
    		'games' => [
    			'data' => $games
    		]
    	]);
    }
    protected function gameTags():array
    {
        $games = Game::select('tags')->get()->toArray();
        if(count($games) <= 0)
        {
            return [];
        }
        $merged = [];
        foreach($games as $game)
        {
          $merged = array_merge($merged, ...array_values($game));
        }
        $unique_tags = array_unique($merged, SORT_STRING);
        return $unique_tags;
    }
}
