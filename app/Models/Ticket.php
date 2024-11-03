<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
    	'event_id',
    	'price',
    	'total_seat',
    	'available_seat',
    	'type',
    	'type_copy'
    ];

    public function event()
    {
    	$this->belongsTo(Event::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
