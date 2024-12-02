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
    	'type_copy',
        'access_type'
    ];

    public function event()
    {
    	return $this->belongsTo(Event::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }
}
