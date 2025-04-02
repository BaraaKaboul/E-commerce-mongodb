<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'image',
        'brand_id'
    ];

    public function brand(){
        return $this->belongsTo(Brand::class);
    }
}
