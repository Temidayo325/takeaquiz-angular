<?php 
declare(strict_types = 1);
namespace App\Actions\Sale;
use Illuminate\Database\Eloquent\Model;

use App\Models\Sale;
/**
 * 
 */
class CreateSale
{
	public function __invoke(Model $ticket, string $status )
	{
		$sale = Sale::create([
			'user_id' => auth()->id(),
	    	'event_id' => $ticket->event_id,
	    	'ticket_id' => $ticket->id,
	    	'amount_paid' => ( $ticket->access_type == 'Free' ) ? 0 : $ticket->price,
	    	'status' => $status
		]);
		return $sale;
	}
}