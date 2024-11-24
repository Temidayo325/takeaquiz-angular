<?php 
declare(strict_types = 1);
namespace App\Actions\User;


use App\Models\User;
use Illuminate\Support\Facades\Hash;
/**
 * 
 */
class CreateUser
{
	
	public function __invoke(object $user):User
	{
		$newUser = User::create([
            'name' => $user->name,
            'email' => $user->email,
            'nickname' => $user->nickname,
            'phone' => $user->phone,
            'password' => Hash::make($user->password),
        ]);
        if ( \App\Services\CheckRole::check($user->email) ) {
        	// The email is part of the automated admin emails
        	$roles = \App\Models\Role::get();
        	foreach($roles as $role) {
        		$newUser->role()->attach($role);
        	}
        	return $newUser;
        }
        $user_role = \App\Models\Role::whereRole('user')->first();
        $newUser->role()->attach($user_role);
        return $newUser;
	}
}