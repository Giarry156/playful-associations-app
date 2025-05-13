<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Boardgame extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function games()
    {
        return $this->hasMany(Game::class);
    }
}
