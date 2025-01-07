<?php 
declare(strict_types = 1);
namespace App\Actions\Plug;

use App\Http\Requests\Plug\CreatePlugRequest;
use App\Models\Plug;
use App\Services\TurningStringToArray;

/**
 * 
 */
class CreatePlug
{
	
	public function __invoke(CreatePlugRequest $plug):Plug
	{
        $path = $plug->flier->store('plugs');
		$newPlug = Plug::create([
            'user_id' => auth()->id(), 
            'state' => $plug->state,
            'tags' => TurningStringToArray::convert( $plug->tags ),
            'address' => $plug->address,
            'travel' => ( $plug->travel == 'on') ? 1 : 0,
            'flier' => $path,
            'service' => $plug->service,
            'service_summary' => $plug->service_summary,
            'usp' => $plug->usp,
            'social_media_links' => $plug->social_media_links
        ]);

        return $newPlug;
	}
}