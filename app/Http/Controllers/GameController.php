<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class GameController extends Controller
{
     public function index()
    {
    	$games = Game::latest()->orderBy('id')->cursorPaginate(12);
    	return view("games", [
    		'user' => auth()->user(),
    		'games' => $games]);
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
}
