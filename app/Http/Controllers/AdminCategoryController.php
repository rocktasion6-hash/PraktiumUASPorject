<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories.index', ['categories' => Category::latest()->get()]);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255', 'color' => 'nullable|string|max:50']);
        Category::create($request->only('name', 'color'));
        return back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate(['name' => 'required|string|max:255', 'color' => 'nullable|string|max:50']);
        $category->update($request->only('name', 'color'));
        return back()->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}
