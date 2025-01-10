<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function image(){
        return $this->hasOne(Image::class);
    }

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
