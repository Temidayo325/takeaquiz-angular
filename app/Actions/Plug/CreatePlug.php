<?php 
declare(strict_types = 1);
namespace App\Actions\Plug;

use App\Http\Requests\Plug\CreatePlugRequest;
use App\Models\Plug;
use App\Services\TurningStringToArray;
use Illuminate\Support\Str;
/**
 * 
 */
class CreatePlug
{
	
	public function __invoke(CreatePlugRequest $plug):Plug
	{
        try {
            $path = $plug->flier->store('plugs');
            $logo = $plug->logo->store('logo');
            $newPlug = Plug::create([
                'user_id' => auth()->id(), 
                'state' => ucfirst($plug->state),
                'tags' => TurningStringToArray::convert( $plug->tags ),
                'address' => $plug->address,
                'travel' => ( $plug->has('travel') != null && $plug->travel == 'on' ) ? 1 : 0,
                'flier' => $path,
                'logo' => $logo,
                'service' => $plug->service,
                'service_summary' => $plug->service_summary,
                'usp' => $plug->usp ,
                'social_media_links' => $plug->social_media_links,
                'slug' => Str::slug(auth()->user()->name),
                'location_based' => $plug->location_based,
                'physical_address' => $plug->physical_address,
                'contact_email' => $plug->contact_email,
                'contact_portfolio' => $plug->contact_portfolio,
                'contact_whatsapp' => $plug->contact_whatsapp 
            ]);
            return $newPlug;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
	}
}