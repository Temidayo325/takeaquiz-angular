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
        'slug',
        'travel',
        'flier',
        'service',
    	'service_summary',
        'usp',
        'social_media_links',
        'status',
        'location_based',
        'physical_address',
        'contact_email',
        'contact_portfolio',
        'contact_whatsapp'
    ];

    protected $casts = [
        'tags' => 'array'
    ];

    protected $appends = ['slug'];

    public function getSlugAttribute()
    {
        return \Illuminate\Support\Str::slug($this->name);
    }
    
    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    
}
