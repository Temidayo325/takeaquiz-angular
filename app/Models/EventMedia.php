<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventMedia extends Model
{
    use HasFactory;

    protected $fillable = [
    	'user_id',
    	'event_id',
    	'video_gallery',
    	'image_gallery',
    	'flier'
    ];

    public function event()
    {
    	return $this->belongsTo(Event::class);
    }
}
