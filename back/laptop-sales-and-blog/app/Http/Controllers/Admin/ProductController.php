<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop\Brand;
use App\Models\Shop\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::when(request('search'), function ($query) {
            $query->where('name', 'like', '%' . request('search') . '%')
                ->orWhere('description', 'like', '%' . request('search') . '%');
        })
            ->orderBy('id', 'desc')->paginate(6);

        $products->appends(request()->all());

        return view('admin.shop.products.index', compact('products'));
    }

    public function create()
    {
        $brands = Brand::all();

        return view('admin.shop.products.create', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand_id' => 'required',
            'name' => 'required|max:100',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,jpg,png,webp,svg',
            'price' => 'required|numeric|min:0|max:5000',
            'discount' => 'required|numeric|min:0|max:1',
            'condition' => 'required',
        ]);

        $imageName = uniqid() . '_' . $request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('public/product_images', $imageName);

        if ($request->status) {
            $status = 'yes';
        } else {
            $status = 'no';
        }

        Product::create([
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imageName,
            'price' => $request->price,
            'discount' => $request->discount,
            'discount_price' => $request->price * (1 - $request->discount),
            'condition' => $request->condition,
            'status' => $status,
        ]);

        return redirect()->route('products.index')->with('success', 'Product created!');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $brands = Brand::all();

        return view('admin.shop.products.edit', compact('product', 'brands'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'brand_id' => 'required',
            'name' => 'required|max:100',
            'description' => 'required',
            'image' => 'image|mimes:jpeg,jpg,png,webp,svg',
            'price' => 'required|numeric|min:0|max:5000',
            'discount' => 'required|numeric|min:0|max:1',
            'condition' => 'required',
        ]);

        if ($request->status) {
            $status = 'yes';
        } else {
            $status = 'no';
        }

        $product = Product::find($id);
        if ($request->hasFile('image')) {
            Storage::delete('public/product_images/' . $product->image);
            $imageName = uniqid() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/product_images', $imageName);
        } else {
            $imageName = $product->image;
        }

        $product->update([
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imageName,
            'price' => $request->price,
            'discount' => $request->discount,
            'discount_price' => $request->price * (1 - $request->discount),
            'condition' => $request->condition,
            'status' => $status,
        ]);

        return redirect()->route('products.index')->with('warning', 'Product updated!');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        Storage::delete('public/product_images/' . $product->image);
        $product->delete();

        return back()->with('danger', 'Product deleted!');
    }
}
