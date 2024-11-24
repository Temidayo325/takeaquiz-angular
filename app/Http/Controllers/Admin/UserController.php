<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Models\User;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;

class UserController extends Controller
{
    public function index()
    {
    	$user = User::with('role')->where('id', auth()->id())->first();
    	$users = User::with('role', 'sales')->latest()->orderBy('id')->cursorPaginate(10);
    	return view("dashboard.admin.user.index", ['user' => $user, 'users' => $users]);
    }

    public function paginateUsers(Request $request)
    {
    	$users = User::with('role', 'sales')->latest()->orderBy('id')->cursorPaginate(10);
    	return response()->json($users);
    }

    public function AddRoleToUser(Request $request)
    {
    	
    }
    
    public function search(Request $request)
    {
    	$users = Search::add(User::class, ['name', 'nickname', 'email'])
					    ->beginWithWildcard()
					    ->endWithWildcard(true)
					    ->orderByRelevance()
					    ->paginate(5)
					    ->search($request->searchTerm);
    	return response()->json([
    		'error' => false,
    		'errorMessage' => 'Search results returned successfully',
    		'data' => $users
    	]);
    }
}
