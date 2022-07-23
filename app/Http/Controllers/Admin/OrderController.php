<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function all()
    {
        $order = ProductOrder::with('user', 'product');

        if (request()->status) {
            $status = request()->status;
            $order->where('status', $status);
        }

        $order = $order->latest()->paginate(10);
        return view('admin.order.all', compact('order'));
    }

    public function changeOrderStatus(Request $request)
    {
        $id = $request->id;
        $status = $request->status;
        $product_order = ProductOrder::where('id', $id);

        if ($status !== 'success' && $status !== 'cancel') {
            return redirect('/admin/order')->with("error", "Status update failed!");
        }

        $order_qty = $product_order->first()->total_quantity;

        if ($status == "success") {
            if ($product_order->first()->status == "success") {
                return redirect('/admin/order')->with("error", "Status is already success!");
            }
            $product_order->update([
                "status" => $status,
            ]);
            Product::where('id', $product_order->first()->product_id)->update([
                'total_quantity' => DB::raw('total_quantity - ' . $order_qty)
            ]);
        }

        if ($status == "cancel") {
            if ($product_order->first()->status == "cancel") {
                return redirect('/admin/order')->with("error", "Status is already canceled!");
            }
            $product_order->update([
                "status" => $status,
            ]);
            Product::where('id', $product_order->first()->product_id)->update([
                'total_quantity' => DB::raw('total_quantity + ' . $order_qty)
            ]);
        }

        return redirect('/admin/order')->with("success", "Order status changed!");
    }
}
