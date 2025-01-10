<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function images()
    {
        return $this->hasManyThrough(Image::class, ProductImage::class, 'product_id', 'id', 'id', 'image_id');
    }

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
