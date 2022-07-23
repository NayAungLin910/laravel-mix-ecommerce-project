<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
    ];

    public function transaction()
    {
        return $this->hasMany(ProductAddTransaction::class);
    }

    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
