<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRemoveTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'total_quantity',
        'description',
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
