<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competence extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'category',
    ];

    /**
     * Relation many-to-many avec les utilisateurs.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'competence_user');
    }
}