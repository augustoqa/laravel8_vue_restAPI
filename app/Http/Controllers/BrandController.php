<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::latest()->paginate(5);

        return view('admin.brands.index', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:brands|min:4',
            'image' => 'required|mimes:jpg,jpeg,png',
        ]);

        $path = $request->file('image')->store('images/brand', 'public');

        Brand::create([
            'name' => $request->name,
            'image' => $path,
        ]);

        return back()->with('success', 'Brand inserted successfully');
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|min:4',
        ]);

        if ($request->file('image')) {
            Storage::disk('public')->delete($brand->image);

            $path = $request->file('image')->store('images/brand', 'public');
            $brand->image = $path;
        }


        $brand->name = $request->name;
        $brand->save();

        return back()->with('success', 'Brand updated successfully');
    }
}
