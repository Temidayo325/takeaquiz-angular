<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Share;

// use Spatie\Tags\HasTags;

class Event extends Model
{
    use HasFactory ; 
    // HasTags;
    protected $fillable = [
    	'name', 
    	'event_date',
    	'starting_time',
    	'state',
        'tags',
    	'coordinate',
        'user_id',
        'location',
        'flier',
        'promotional_copy',
    	'social_media_handle',
        'ticket_information',
        'duration',
        'audience',
        'dress_code',
        'contact_information',
        'coordinate'
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

    public function ratings()
    {
    	return $this->hasMany(Rating::class);
    }

    public function reviews()
    {
    	return $this->hasMany(Review::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function eventmedia()
    {
        return $this->hasOne(EventMedia::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
