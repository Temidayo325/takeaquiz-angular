<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\User\EditRoleRequest;

class RoleController extends Controller
{
    
    public function AddRoleToUser(EditRoleRequest $request)
    {
    	$user = \App\Models\User::with('role')->where('id', $request->user_id)->first();
    	if ($user->hasAnyRole($request->role)) {
    		# code...
    		return response()->json([
	    		'error' => false,
		    	'message' => "User role successfully adjusted",
		    	'user' => $user
	    	]);
    	}
    	if ($request->role == 'admin' && $user->hasAnyRole('promoter') === false) {
			$promoter_role = \App\Models\Role::whereRole('promoter')->first();
			$user->role()->attach($promoter_role);
    	}
		$desired_role = \App\Models\Role::whereRole($request->role)->first();
		$user->role()->attach($desired_role);
    	$user = \App\Models\User::with('role')->where('id', $request->user_id)->first();
    	return response()->json([
    		'error' => false,
	    	'message' => "User role successfully adjusted",
	    	'user' => $user
    	]);
    }

    public function RemoveRoleFromUser(EditRoleRequest $request)
    {
    	$user = \App\Models\User::with('role')->where('id', $request->user_id)->first();
    	if ($request->role == 'promoter' && $user->hasAnyRole('admin')) {
    		# remove both the promoter and the admin role
			$promoter_role = \App\Models\Role::whereRole($request->role)->first();
    		$admin_role = \App\Models\Role::whereRole('admin')->first();
    		$user->role()->detach($promoter_role);
    		$user->role()->detach($admin_role);
    	}
    	
		$desired_role = \App\Models\Role::whereRole($request->role)->first();
		$user->role()->detach($desired_role);
    	$user = \App\Models\User::with('role')->where('id', $request->user_id)->first();
    	return response()->json([
    		'error' => false,
	    	'message' => "User role adjusted as required",
	    	'user' => $user 
    	]);
    }
}
