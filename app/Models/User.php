<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;

use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name', 
        'last_name', 
        'email', 
        'password', 
        'image', 
        'username', 
        'user_ref', 
        'phone', 
        'address', 
        'is_active', 
        'email_verified_at', 
        'force_password_reset', 
        'last_login_at', 
        'temporary_password_expires_at', 
        'first_login_at', 
        'profile_completed',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'force_password_reset' => 'boolean',
            'profile_completed' => 'boolean',
            'is_active' => 'boolean',
            'temporary_password_expires_at' => 'datetime',
            'first_login_at' => 'datetime',
            'last_login_at' => 'datetime',
            'last_seen_at' => 'datetime', 
        ];
    }

    public function getImageUrlAttribute(): string
    {
     
        $filename = basename($this->image); // récupère uniquement le nom du fichier

        return $this->image
            ? asset('storage/profile-images/' . $filename)
            : asset('assets/images/placeholder.jpg'); // crée ce fichier si besoin
    }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function getNameAttribute(): string
    {
        return $this->full_name;
    }

    public function isOnline()
    {
        return $this->last_seen_at && $this->last_seen_at->gt(now()->subMinutes(5));
    }


}
