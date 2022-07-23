<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function detail($slug)
    {
        $product = Product::where('slug', $slug)->first();
        if (!$product) {
            return redirect("/")->with("error", "Product not found!");
        }
        $category = Category::withCount('product')->get();
        return view('product-detail', compact('category', 'slug'));
    }
}
