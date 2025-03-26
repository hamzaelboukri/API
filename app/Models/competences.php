<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competence extends Model
{
    protected $fillable = [
        'name', 'description', 'category',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
