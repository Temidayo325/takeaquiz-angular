<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameIdea extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'question',
        'tags'
    ];

    protected $casts = [
        'tags' => 'array'
    ];
    
    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
