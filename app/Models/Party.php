<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    public function game(){
        return $this->belongsTo(Game::class);
    }
    public function userparty(){
        return $this->hasMany(UserParty::class);
    }
    public function message(){
        return $this->hasMany(Message::class);
    }
}
