<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    // GAME has many Party relations
    public function party(){
        return $this->hasMany(Party::class);
    }
    use HasFactory;

    protected $fillable = [
        'title',
        'thumbnail_url',
        'url',
    ];

    protected $hidden = [
        'isActive'
    ];


}
