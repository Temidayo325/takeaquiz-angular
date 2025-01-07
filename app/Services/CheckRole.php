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
        // $emails = config('role.admins');
      	$admins = explode(',', config('role.role'));
      	// $admins = explode(',', env('ADMINS'));
	    if (in_array($email, $admins)) {
	        return true;
	    }
	    return false;
     }
}