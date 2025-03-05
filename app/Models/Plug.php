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
    
    protected $appends = ['links'];

    public function getLinksAttribute()
    {
        $url = secure_url('/plugs/') . '/'.$this->slug;
        return \Share::page($url, "Here's my plug card")    
                ->facebook()
                ->twitter()
                ->whatsapp()
                ->linkedin()
                ->getRawLinks();
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
