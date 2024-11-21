<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
    	'ticket_id', 'user_id', 'present'
    ];

    public function ticket()
    {
    	return $this->belongsTo(Ticket::class);
    }
}
