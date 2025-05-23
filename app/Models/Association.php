<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Association extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function president()
    {
        return $this->belongsTo(User::class, 'president_id');
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }
}
