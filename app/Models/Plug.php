<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plug extends Model
{
    use HasFactory;

    protected $fillable = [
    	'user_id', 
    	'state',
        'tags',
    	'address',
        'travel',
        'flier',
        'service',
    	'service_summary',
        'usp',
        'social_media_links',
        'status'
    ];

    protected $casts = [
        'tags' => 'array'
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
