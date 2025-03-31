<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GameIdea;
use App\Models\Game;


class GameIdeaController extends Controller
{
    public function index()
    {
        $user = \App\Models\User::with('role', 'va')->where('id', auth()->id())->first();
    	$games = Game::with('ideas')->latest()->cursorPaginate(12);
    	return view("dashboard.admin.game.gameidea-index", [
    		'user' => $user,
    		'games' => $games]);
    }

    public function store(\App\Http\Requests\Game\CreateGameIdeaRequest $request)
    {
        $idea = ( new \App\Actions\Game\CreateGameQuestion() )($request);
        return response()->json([
            'idea' => $idea,
            'error' => false
        ]);
    }

    public function delete(Request $request)
    {
        $deleted_idea = \App\Models\GameIdea::where('id', $request->idea_id)->delete();
        return response()->json([
            'error' => false
        ]);
    }
}
