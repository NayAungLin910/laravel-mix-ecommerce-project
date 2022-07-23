<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductAddTransaction;
use App\Models\ProductRemoveTransaction;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest()->select('slug', 'name', 'image', 'total_quantity')->paginate(10);
        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $supplier = Supplier::all();
        $color = Color::all();
        $brand = Brand::all();
        $category = Category::all();
        return view('admin.product.create', compact('supplier', 'color', 'brand', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => "required|string",
            'description' => "required|string",
            "total_quantity" => "required|integer",
            "buy_price" => "required|integer",
            "sale_price" => "required|integer",
            "discount_price" => "required|integer",
            "supplier_id" => "required|string",
            "category_slug" => "required|string",
            "brand_slug" => "required|string",
            "color_slug.*" => "required|string",
            "image" => "required|mimes:jpg,png,jpeg,webp|max:2048",
        ]);

        // image upload
        $image = $request->file("image");
        $image_name = uniqid() . $image->getClientOriginalName();
        $image_path = "/images/" . $image_name;
        $image->move(public_path('/images'), $image_name);

        // product store
        $category = Category::where('slug', $request->category_slug)->first();
        if (!$category) {
            return redirect()->back()->with("error", "Category not found!");
        }
        $brand = Brand::where('slug', $request->brand_slug)->first();
        if (!$brand) {
            return redirect()->back()->with("error", "Brand not found!");
        }
        $supplier = Supplier::where('id', $request->supplier_id)->first();
        if (!$supplier) {
            return redirect()->back()->with("error", "Supplier not found!");
        }

        $colors = [];
        foreach ($request->color_slug as $c) {
            $color = Color::where('slug', $c)->first();
            if (!$color) {
                return redirect()->back()->with("error", "Color not found!");
            }
            $colors[] = $color->id;
        }

        $product = Product::create([
            "category_id" => $category->id,
            "supplier_id" => $supplier->id,
            "brand_id" => $brand->id,
            "slug" => uniqid() . Str::slug($request->name),
            "name" => $request->name,
            "image" => $image_path,
            "discount_price" => $request->discount_price,
            "sale_price" => $request->sale_price,
            "buy_price" => $request->buy_price,
            "total_quantity" => $request->total_quantity,
            "view_count" => 0,
            "like_count" => 0,
            "description" => $request->description,
        ]);
        // add to transaction
        ProductAddTransaction::create([
            'product_id' => $product->id,
            'supplier_id' => $supplier->id,
            'total_quantity' => $request->total_quantity,

        ]);
        // store to product_color
        $p = Product::find($product->id);
        $p->color()->sync($colors);

        return redirect()->back()->with('success', "Product Created!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $supplier = Supplier::all();
        $color = Color::all();
        $brand = Brand::all();
        $category = Category::all();
        $product = Product::where('slug', $slug)
            ->with('supplier', 'color', 'brand', 'category')
            ->first();
        if (!$product) {
            return redirect()->back()->with("error", "Product not found!");
        }
        return view('admin.product.edit', compact('supplier', 'color', 'brand', 'category', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $request->validate([
            'name' => "required|string",
            'description' => "required|string",
            "total_quantity" => "required|integer",
            "buy_price" => "required|integer",
            "sale_price" => "required|integer",
            "discount_price" => "required|integer",
            "supplier_id" => "required|string",
            "category_slug" => "required|string",
            "brand_slug" => "required|string",
            "color_slug.*" => "required|string",
            "image" => "mimes:jpg,png,jpeg,webp|max:2048",
        ]);

        $product = Product::where('slug', $slug)->first();
        if (!$product) {
            return redirect()->back()->with("error", "Product not found!");
        }

        if ($request->file('image')) {
            if (File::exists(public_path($product->image))) {
                File::delete(public_path($product->image));
            }
            $image = $request->file("image");
            $image_name = uniqid() . $image->getClientOriginalName();
            $image_path = "/images/" . $image_name;
            $image->move(public_path('/images'), $image_name);
        } else {
            $image_path = $product->image;
        }

        // update product
        $category = Category::where('slug', $request->category_slug)->first();
        if (!$category) {
            return redirect()->back()->with("error", "Category not found!");
        }
        $brand = Brand::where('slug', $request->brand_slug)->first();
        if (!$brand) {
            return redirect()->back()->with("error", "Brand not found!");
        }
        $supplier = Supplier::where('id', $request->supplier_id)->first();
        if (!$supplier) {
            return redirect()->back()->with("error", "Supplier not found!");
        }

        $colors = [];
        foreach ($request->color_slug as $c) {
            $color = Color::where('slug', $c)->first();
            if (!$color) {
                return redirect()->back()->with("error", "Color not found!");
            }
            $colors[] = $color->id;
        }

        $slug_new = uniqid() . Str::slug($request->name);

        $product->update([
            "category_id" => $category->id,
            "supplier_id" => $supplier->id,
            "brand_id" => $brand->id,
            "slug" => $slug_new,
            "name" => $request->name,
            "image" => $image_path,
            "discount_price" => $request->discount_price,
            "sale_price" => $request->sale_price,
            "buy_price" => $request->buy_price,
            "total_quantity" => $request->total_quantity,
            "description" => $request->description,
        ]);

        // store to product_color
        $p = Product::find($product->id);
        $p->color()->sync($colors);

        return redirect()->route('product.edit', ['product' => $slug_new])->with('success', "Product updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        // find product
        $product = Product::where('slug', $slug)->first();
        if (!$product) {
            return redirect()->back()->with("error", "Product not found!");
        }
        // remove image
        if (File::exists(public_path($product->image))) {
            File::delete(public_path($product->image));
        }
        // delete product_color
        Product::find($product->id)->color()->sync([]);
        // delete product 
        $product->delete();
        return redirect()->back()->with("info", "Product Deleted!");
    }

    public function imageUpload()
    {
        $file = request()->file('image');
        $file_name = uniqid() . $file->getClientOriginalName();
        $file->move(public_path('/images'), $file_name);
        return asset('/images/' . $file_name);
    }

    public function createProductAdd($slug)
    {
        $product = Product::where('slug', $slug)->first();
        if (!$product) {
            return redirect()->back()->with('error', "Product not found!");
        }
        $supplier = Supplier::all();
        return view('admin.product.create-product-add', compact('product', 'supplier'));
    }

    public function createProductRemove($slug)
    {
        $product = Product::where('slug', $slug)->first();
        if (!$product) {
            return redirect()->back()->with('error', "Product not found!");
        }
        $supplier = Supplier::all();
        return view('admin.product.create-product-remove', compact('product', 'supplier'));
    }

    public function storeProductAdd(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->first();
        if (!$product) {
            return redirect()->back()->with('error', "Product not found!");
        }
        // store to transaction
        ProductAddTransaction::create([
            'product_id' => $product->id,
            'supplier_id' => $request->supplier_id,
            'total_quantity' => $request->total_quantity,
            "description" => $request->description,
        ]);
        // update product
        $product->update([
            "total_quantity" => DB::raw('total_quantity + ' . $request->total_quantity)
        ]);
        return redirect()->back()->with('success', $request->total_quantity . " added to " . $product->name);
    }

    public function storeProductRemove(Request $request, $slug)
    {
        $request->validate([
            "total_quantity" => "required"
        ]);

        $product = Product::where('slug', $slug)->first();
        if (!$product) {
            return redirect()->back()->with('error', "Product not found!");
        }

        if ($product->total_quantity < $request->total_quantity) {
            return redirect()->back()->with('error', "Not enough quantity to substitute!");
        }

        ProductRemoveTransaction::create([
            'product_id' => $product->id,
            'total_quantity' => $request->total_quantity,
            "description" => $request->description,
        ]);

        $product->update([
            "total_quantity" => DB::raw('total_quantity - ' . $request->total_quantity)
        ]);
        return redirect()->back()->with('success', $request->total_quantity . " removed from " . $product->name);
    }

    // show the record of product add transaction
    public function productAddTransaction()
    {
        $transactions = ProductAddTransaction::with('product')->paginate('10');
        return view('admin.product.add-transaction', compact('transactions'));
    }

    // show the records of product remove transaction
    public function productRemoveTransaction()
    {
        $transactions = ProductRemoveTransaction::with('product')->paginate('10');
        return view('admin.product.remove-transaction', compact('transactions'));
    }
}
