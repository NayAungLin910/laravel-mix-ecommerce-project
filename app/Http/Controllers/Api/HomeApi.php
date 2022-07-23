<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class HomeApi extends Controller
{
    public function home()
    {
        $category = Category::withCount('product')->get();
        try {
            $featureProduct = Product::all()->random(2);
        } catch (Exception $e) {
            $featureProduct = [];
        }

        $productByCategory = Category::has('product')->take(2)->get();
        foreach ($productByCategory as $k => $v) {
            $productByCategory[$k]->product = Product::where('category_id', $v->id)->latest()->take(6)->get();
        }

        return response()->json([
            'success' => true,
            'data' => [
                'category' => $category,
                'featureProduct' => $featureProduct,
                'productByCategory' => $productByCategory,
            ],
            'status' => 200,
        ]);
    }
}
