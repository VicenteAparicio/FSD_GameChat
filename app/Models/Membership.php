<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    // RELATION TO USER
    public function user(){
        return $this->belongsTo(User::class);
    }

    // RELATION TO PARTY
    public function parties(){
        return $this->belongsTo(Party::class);
    }

    protected $fillable = [
        'party_id',
        'user_id',
        
    ];

    protected $hidden = [
        'isActive'
        
    ];
}
