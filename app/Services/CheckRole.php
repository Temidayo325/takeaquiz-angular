<?php 
declare(strict_types = 1);
namespace App\Services;

/**
 * 
 */
class CheckRole
{
	public static function check(string $email):bool
     {
        
      	// $admins = explode(',', config('role.admin'));env('ADMINS')
      	$admins = explode(',', env('ADMINS'));
	    if (in_array($email, $admins)) {
	        return true;
	    }
	    return false;
     }
}