<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model; // لازم عدل هاد السطر مشان يتعرف على mongodb

class Brand extends Model
{
    protected $connection = 'mongodb';
    protected $fillable = [
        'name',
        'slug',
        'image'
    ];

    public function category(){
        return $this->hasManyThrough(Product::class,Category::class);
    }
}
