<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    use HasFactory;

    protected $fillable = [
        'partyName',
        'description',
        'game_id',
        'owner_id',
        // 'user_id'=>'103',
    ];


    public function game(){
        return $this->belongsTo(Game::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function membership(){
        return $this->hasMany(Membership::class);
    }
    public function message(){
        return $this->hasMany(Message::class);
    }
}
