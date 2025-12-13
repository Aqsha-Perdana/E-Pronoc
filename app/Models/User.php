<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'notelp',
        'institution',
        'photo',
<<<<<<< HEAD
        'user_group', // GANTI 'role' JADI 'user_group'
=======

>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
<<<<<<< HEAD
    
    // Relasi ke Member (Profil)
    public function member()
    {
        return $this->hasOne(Member::class);
    }
}
=======
    public function skills()
{
    return $this->hasMany(Skill::class);
}
}

>>>>>>> e68c7900a429ca0a02a86e7a4345c04cba74b760
