<?php
declare(strict_types = 1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'nickname',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role()
    {
         return $this->belongsToMany(Role::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function ratings():HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function review():HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    
    public function hasAnyRole($role):bool
    {
        return null !== $this->role()->where('role', $role)->first();
    }

    public function hasAnyRoles(array $role):bool
    {
        return null !== $this->role()->whereIn('role', $role)->first();
    }

    public function plug()
    {
        return $this->hasOne(Plug::class);
    }
    
    public function va()
    {
        return $this->hasOne(VirtualAccount::class);
    }

    public function beneficiary()
    {
        return $this->hasOne(Beneficiary::class);
    }

    public function attendance()
    {
        // return $this->hasManyTh
    }

    public function notification()
    {
        return $this->hasOne(Notification::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
