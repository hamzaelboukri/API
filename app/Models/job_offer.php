<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class job_offer extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'description',
        'category_id',
        'user_id',
        'location',
        'salary',
        'start_date',
        'expiration_date',
        'is_active',
        
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
        
    }
}
