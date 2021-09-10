<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

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
}
