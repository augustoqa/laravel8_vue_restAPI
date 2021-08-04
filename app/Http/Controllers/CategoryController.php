<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories.index')
            ->with('categories', Category::latest()->paginate(5));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:3|max:255|unique:categories',
        ]);

        $category = Category::create([
            'name' => $request->name,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category inserted successfully.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|min:3|max:255|unique:categories',
        ]);

        $category->name = $data['name'];
        $category->save();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category updated successfully');
    }
}
