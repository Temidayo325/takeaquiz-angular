<?php 
declare(strict_types = 1);
namespace App\Services;

/**
 * 
 */
class TurningStringToArray
{
	public static function convert(string $string):Array
     {
        $tagArray = explode(',', $string);
		$newCleanedTagArray = [];
		if ( count($tagArray) > 1 ) {
			foreach ($tagArray as $tag) {
				# code...
				array_push($newCleanedTagArray, preg_replace('/[^a-zA-Z0-9- ]/', '', strip_tags(trim($tag))));
			}
		}
		return $newCleanedTagArray;
     }
}