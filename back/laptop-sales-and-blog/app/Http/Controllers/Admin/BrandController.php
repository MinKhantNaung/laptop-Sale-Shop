<?php

namespace App\Http\Controllers\Admin;

use App\Models\Shop\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::when(request('search'), function ($query) {
            $query->where('name', 'like', '%' . request('search') . '%');
        })
            ->orderBy('id', 'desc')->paginate(6);

        $brands->appends(request()->all());

        return view('admin.shop.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.shop.brands.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:15|unique:brands,name',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp,svg',
        ]);

        $imageName = uniqid() . '_' . $request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('public/brand_images', $imageName);

        Brand::create([
            'name' => $request->name,
            'image' => $imageName,
        ]);

        return redirect()->route('brands.index')->with('success', 'Brand created!');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $brand = Brand::find($id);

        return view('admin.shop.brands.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:15|unique:brands,name,' . $id,
            'image' => 'image|mimes:jpg,jpeg,png,webp,svg',
        ]);

        $brand = Brand::find($id);
        if ($request->hasFile('image')) {
            Storage::delete('public/brand_images/' . $brand->image);

            $imageName = uniqid() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/brand_images', $imageName);
        } else {
            $imageName = $brand->image;
        }

        $brand->update([
            'name' => $request->name,
            'image' => $imageName,
        ]);

        return redirect()->route('brands.index')->with('warning', 'Brand updated!');
    }

    public function destroy($id)
    {
        $brand = Brand::find($id);

        // Delete the images of related products
        foreach($brand->products as $product) {
            Storage::delete('public/product_images/' . $product->image);
        }

        // Delete related products
        $brand->products()->delete();

        // finally delete brand
        Storage::delete('public/brand_images/' . $brand->image);
        $brand->delete();

        return back()->with('danger', 'Brand deleted!');
    }
}
