<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()
            ->paginate(5);

        $trashCategories = Category::onlyTrashed()
            ->latest()
            ->paginate(3);

        return view('admin.categories.index', compact('categories', 'trashCategories'));
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

    public function delete(Category $category)
    {
        $category->delete();

        return redirect()
            ->back()
            ->with('success', 'Category deleted successfully');
    }

    public function restore($id)
    {
        $category = Category::withTrashed()->find($id)->restore();

        return redirect()
            ->back()
            ->with('success', 'Category restore successfully');
    }

    public function destroy($id)
    {
        Category::onlyTrashed()->find($id)->forceDelete();

        return redirect()
            ->back()
            ->with('success', 'Category permanently deleted');
    }
}
