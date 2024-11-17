<?php

namespace App\Http\Controllers\Promoter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
    	$user = \App\Models\User::with('role')->where('id', auth()->id())->first();
    	return view("dashboard.promoter.index", ['user' => $user]);
    }
}
