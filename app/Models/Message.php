<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    // RELATION TO USER
    public function user(){
        return $this->belongsTo(User::class);
    }

    // RELATION TO PARTY
    public function party(){
        return $this->belongsTo(Party::class);
    }


    protected $fillable = [
        'message',
        'date',
        'party_id',
        'user_id'
    ];

    protected $hidden = [
        'isActive',
    ];
}
