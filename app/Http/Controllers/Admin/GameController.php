<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;

class GameController extends Controller
{
    public function index()
    {
    	$user = \App\Models\User::with('role', 'va')->where('id', auth()->id())->first();
    	$games = Game::latest()->orderBy('id')->cursorPaginate(12);
    	return view("dashboard.admin.game.index", [
    		'user' => $user,
    		'games' => $games]);
    }

    public function paginateGames(Request $request)
    {
    	$events = Game::latest()->orderBy('id')->cursorPaginate(12);
    	return response()->json($events);
    }

    public function create()
    {
        $user = \App\Models\User::with('role', 'va')->where('id', auth()->id())->first();
        return view("dashboard.admin.game.create", ['user' => $user]);
    }

    public function search(Request $request)
    {
    	$games = Search::add(Game::class, ['name', 'summary', 'stepByStep', 'minimum_player'])
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

    public function store(\App\Http\Requests\Game\CreateGameRequest $game)
    {
    	try {
            $event = ( new \App\Actions\Game\CreateGame() )( $game);
            return response()->json([
                'error' => false,
                'message' => "Game successfully created"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }
}
