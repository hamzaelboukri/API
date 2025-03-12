<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;
    
    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
    ];
    
    /**
     * Obtenir les offres d'emploi associées à cette catégorie.
     */
    public function jobOffers(): HasMany
    {
        return $this->hasMany(job_offer::class);
    }
    

}