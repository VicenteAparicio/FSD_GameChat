<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    // USER IS ON MANY PARTIES THROUGH MEMBERSHIP TABLE
    public function membership(){
        return $this->hasMany(Membership::class);
    }

    // USER HAS MANY MESSAGES
    public function message(){
        return $this->hasMany(Message::class);
    }

    // USER OWNS MANY PARTIES
    public function parties(){
        return $this->hasMany(Party::class);
    }
    

    protected $fillable = [
        'username',
        'email',
        'steamId',
        'password',
    ];


    protected $hidden = [
        'password',
        'remember_token',
        'isAdmin',
        'isActive'
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
