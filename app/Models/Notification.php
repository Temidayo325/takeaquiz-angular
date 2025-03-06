<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    public $fillable = [
        'user_id', 'summary', 'status', 'role'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
