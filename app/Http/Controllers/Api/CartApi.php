<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCart;
use App\Models\ProductOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CartApi extends Controller
{
    public function addToCart(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->first();
        if (!$product) {
            return response()->json([
                'message' => false,
                'data' => 'Product not found!',
            ]);
        }

        $findInCart = ProductCart::where('user_id', $request->user_id)->where('product_id', $product->id)->first();
        if ($findInCart) {
            $total_quantity = $findInCart->total_quantity + 1;
            $findInCart->update([
                "total_quantity" => $total_quantity,
            ]);
        } else {
            ProductCart::create([
                "product_id" => $product->id,
                "user_id" => $request->user_id,
                "total_quantity" => 1,
            ]);
        }

        $cart_count = ProductCart::where('user_id', $request->user_id)->count();
        return response()->json([
            'message' => true,
            'data' => $cart_count,
        ]);
    }

    public function getCart(Request $request)
    {
        $user_id = $request->user_id;
        $cart = ProductCart::where('user_id', $user_id)->with('product')->get();

        return response()->json([
            "message" => true,
            "data" => $cart,
        ]);
    }

    public function updateQty(Request $request)
    {
        $cart_id = $request->cart_id;
        $qty = $request->total_quantity;

        ProductCart::where('id', $cart_id)->update([
            'total_quantity' => $qty,
        ]);

        return response()->json([
            "message" => true,
            "data" => null,
        ]);
    }

    public function removeCart(Request $request)
    {
        $cart_id = $request->cart_id;

        ProductCart::where('id', $cart_id)->delete();

        return response()->json([
            "message" => true,
            "data" => null,
        ]);
    }

    public function checkout(Request $request)
    {
        $user_id = $request->user_id;
        $cart = ProductCart::where('user_id', $user_id)->get();

        foreach ($cart as $c) {
            ProductOrder::create([
                'user_id' => $c->user_id,
                'product_id' => $c->product_id,
                'total_quantity' => $c->total_quantity,
            ]);
        }

        ProductCart::where('user_id', $user_id)->delete();

        return response()->json([
            "message" => true,
            "data" => null,
        ]);
    }

    public function order()
    {
        $user_id = request()->user_id;
        $order = ProductOrder::where('user_id', $user_id)
            ->with('product')
            ->paginate(2);
        return response()->json([
            "message" => true,
            "data" => $order,
        ]);
    }
}
