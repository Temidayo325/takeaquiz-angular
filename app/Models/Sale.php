<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
    	'user_id',
    	'event_id',
    	'ticket_id',
    	'purchased_tickets',
    	'amount_paid',
    	'status'
    ];

    public function event()
    {
    	return $this->belongsTo(Event::class);
    }

    public function tickets()
    {
        return $this->belongsTo(Sale::class);
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
