<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Spatie\Tags\HasTags;

class Game extends Model
{
    use HasFactory;
    // HasTags;

    protected $fillable = [
    	'name', 'summary', 'stepByStep', 'minimum_player', 'maximum_player', 'image', 'tags',
    	'materials', 'play_time', 'difficulty_level', 'category', 'ideal_setting', 'objective', 'tips', 'video'
    ];

    protected $casts = [
    	'tags' => 'array',
    	'materials' => 'array',
    	'stepByStep' => 'array'
    ];
}
