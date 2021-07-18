<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    // RELATION TO GAME
    public function game(){
        return $this->belongsTo(Game::class);
    }

    // RELATION TO USER
    public function user(){
        return $this->belongsTo(User::class);
    }

    // PARTY HAS MANY MEMBERSHIP RELATIONS
    public function membership(){
        return $this->hasMany(Membership::class);
    }

    // PARTY HAS MANY MESSAGE RELATIONS
    public function message(){
        return $this->hasMany(Message::class);
    }

    use HasFactory;

    protected $fillable = [
        'partyName',
        'description',
        'game_id',
        'owner_id',
    ];

    protected $hidden = [
        'isActive',
    ];

}
