<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brand = Brand::latest()->paginate(2);

        return view('admin.brand.index', compact('brand'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.brand.create');
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
        ]);
        Brand::create([
            "slug" => Str::slug($request->name .  uniqid()),
            "name" => $request->name,
        ]);
        return redirect()->back()->with('success', "Brand created!");
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
        $brand = Brand::where('slug', $slug)->first();
        if(!$brand){
            return redirect()->back()->with('error', 'Brand not found!');
        }
        return view('admin.brand.edit', compact('brand'));
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
        ]);

        $brand = Brand::where('slug', $slug)->first();
        if(!$brand){
            return redirect()->back()->with('error', 'Failed to update!');
        }

        Brand::where('slug', $slug)->update([
            "name" => $request->name,
        ]);

        return redirect()->back()->with("success", "Brand updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $brand = Brand::where('slug', $slug)->first();
        if(!$brand){
            return redirect()->back()->with('error', 'Failed to delete!');
        }

        $brand->delete();
        return redirect()->back()->with('info', 'Brand deleted!');
    }
}
