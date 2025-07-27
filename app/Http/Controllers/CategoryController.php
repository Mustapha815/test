<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getAllCategories()
    {
        $categories = Category::with(['products'])->get();
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:png,jpg,jpeg,webp|max:2048',
            'sizes' => 'json|nullable',
        ]);
        $image = null;
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'image|mimes:png,jpg,jpeg,webp|max:2048',
            ]);
            $image = $request->file('image')->store('categories', 'public');
            $image = "storage/{$image}";
        } else {
            $image = $request->image; // string (URL or path)
        }
        $category = Category::create([
            'name' => $request->name,
            'image' => $image,
            'sizes' => json_decode($request->sizes),

        ]);

        return response()->json(['message' => 'Category created successfully', 'category' => $category]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable', // accept string or file
            
        ]);

        $category = Category::findOrFail($id);
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'image|file|max:2048',
            ]);
            $image = $request->file('image')->store('categories', 'public');
            $category->image = "storage/{$image}";
        } elseif ($request->has('image')) {
            $category->image = $request->image; // string (URL or path)
        }
        $category->update([
            'name' => $request->name,
            'image' => $category->image,
        ]);

        return response()->json(['message' => 'Category updated successfully', 'category' => $category]);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }

}