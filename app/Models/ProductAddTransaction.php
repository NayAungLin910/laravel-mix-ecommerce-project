<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAddTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'product_id',
        'total_quantity',
        'description',
    ];

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
