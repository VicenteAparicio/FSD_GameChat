<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    use HasFactory;

    protected $fillable = [
        'partyName', 'description'
    ];


    public function game(){
        return $this->belongsTo(Game::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function userparty(){
        return $this->hasMany(UserParty::class);
    }
    public function message(){
        return $this->hasMany(Message::class);
    }
}
