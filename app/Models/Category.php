<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'mm_name',
        'image',
    ];

    // // Appending  the image url
    // protected $appends = ['image_url'];
    // public function getImageUrlAttribute(){
    //     return asset('/images' . $this->image);    
    // } // but you don't need it since you save the path already

    public function product()
    {
        return $this->hasMany(Product::class);
    }
    use HasFactory;
}
