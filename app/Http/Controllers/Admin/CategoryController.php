<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::latest()->paginate(5);

        return view('admin.category.index', compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
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
            "name" => "required",
            "mm_name" => "required",
            "image" => "required|mimes:jpg,png,jpeg,webp|max:2048"
        ]);

        // upload image
        $image = $request->file("image");
        $image_name = uniqid() . $image->getClientOriginalName();
        $image_path = "/images/" . $image_name;
        $image->move(public_path('/images'), $image_name);

        Category::create([
            "slug" => Str::slug($request->name .  uniqid()),
            "mm_name" => $request->mm_name,
            "name" => $request->name,
            "image" => $image_path,
        ]);
        return redirect()->back()->with('success', "Category created!");
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
        $category = Category::where('slug', $slug)->first();
        if (!$category) {
            return redirect()->back()->with('error', 'Category not found!');
        }
        return view('admin.category.edit', compact('category'));
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
            "name" => "required",
            "mm_name" => "required",
            "image" => "mimes:jpg,png,jpeg,webp|max:2048"
        ]);

        $category = Category::where('slug', $slug)->first();
        if (!$category) {
            return redirect()->back()->with('error', 'Failed to update!');
        }

        if ($request->file("image")) {
            // delete previous category image
            if (File::exists(public_path($category->image))) {
                if ($category->image !== '/images/category.webp') {
                    File::delete(public_path($category->image));
                }
            }
            $image = $request->file("image");
            $image_name = uniqid() . $image->getClientOriginalName();
            $image_path = "/images/" . $image_name;
            $image->move(public_path('/images'), $image_name);
        } else {
            $image_path = $category->image;
        }

        Category::where('slug', $slug)->update([
            "name" => $request->name,
            "mm_name" => $request->mm_name,
            "image" => $image_path,
        ]);

        return redirect()->back()->with("success", "Category updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $category = Category::where('slug', $slug)->first();
        if (!$category) {
            return redirect()->back()->with('error', 'Failed to delete!');
        }

        // delete category image
        if (File::exists(public_path($category->image))) {
            if ($category->image !== '/images/category.webp') {
                File::delete(public_path($category->image));
            }
        }

        $category->delete();
        return redirect()->back()->with('info', 'Category deleted!');
    }
}
