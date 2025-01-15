<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;

class GameController extends Controller
{
     public function index()
    {
    	$games = Game::latest()->orderBy('id')->cursorPaginate(12);
        $tags = $this->gameTags();
    	return view("games", [
    		'user' => auth()->user(),
    		'games' => $games,
            'tags' => $tags
        ]);
    }

    public function paginateGames(Request $request)
    {
    	$events = Game::latest()->orderBy('id')->cursorPaginate(12);
    	return response()->json($events);
    }

    public function search(Request $request)
    {
    	$games = Search::add(Game::class, ['name', 'summary', 'stepByStep', 'materials'])
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

    public function searchByTags(Request $request)
    {
        $games = Search::add(Game::class, ['tags'])
                          ->beginWithWildcard() 
                          ->endWithWildcard(true)
                          ->orderByRelevance()
                          ->search($request->tag)
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
        $merged = [];
        foreach($games as $game)
        {
          $merged = array_merge($merged, ...array_values($game));
        }
        $unique_tags = array_unique($merged, SORT_STRING);
        return $unique_tags;
    }
}
