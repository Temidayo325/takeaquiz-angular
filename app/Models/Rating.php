<?php
declare(strict_types = 1);
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Rating extends Model
{
    use HasFactory;
    protected $fillable = [
    	'rating',
    	'user_id',
    	'event_id'
    ];

    public function events()
    {
    	return $this->belongsTo(Event::class);
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
