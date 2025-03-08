<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
    	$user = User::with('role', 'va')->where('id', auth()->id())->first();
    	$users = User::with('role', 'sales', 'va')->latest()->orderBy('id')->cursorPaginate(5);
    	return view("dashboard.admin.index", [
    		'user' => $user, 
    		'users' => $users
    	]);
    }
}
