<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'boardgame_id',
        'association_id',
    ];

    public function boardgame()
    {
        return $this->belongsTo(Boardgame::class);
    }

    public function association()
    {
        return $this->belongsTo(Association::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'game_user');
    }

//    protected function playersCount(): Attribute
//    {
//        return Attribute::make(
//            get: fn($value, $attributes) => $this->users()->count(),
//        );
//    }
}
