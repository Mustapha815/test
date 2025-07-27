<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getAllProducts()
    {
        $products = Product::with(['category'])->get();
        return response()->json($products);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:png,jpg,jpeg,webp|max:2048',
            'isShow' => 'sometimes|boolean',
            'category_id' => 'required|exists:categories,id',
            'sizes' => 'json|nullable',
            'colors' => 'json|nullable',
            'isOffred' => 'sometimes|boolean',
            'offredPrice' => 'sometimes|nullable|numeric|min:0',
            'startOffreDay' => 'sometimes|nullable|date',
            'endOffreDay' => 'sometimes|nullable|date|after_or_equal:startOffreDay',
        ]);
        $image = null;
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'image|mimes:png,jpg,jpeg,webp|max:2048',
            ]);
            $image = $request->file('image')->store('products', 'public');
            $image = "storage/{$image}";
        } else {
            $image = $request->image; // string (URL or path)
        }
        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'sizes' => json_decode($request->sizes),
            'colors' => json_decode($request->colors),
            'isShow' =>  true,
            'image' => $image,
            'category_id' => $request->category_id,
            'isOffred' => false,
            'offredPrice' => null,
            'startOffreDay' => null,
            'endOffreDay' => null,
        ]);

        return response()->json(['message' => 'product added successfully', 'product' => $product]);
            }

    public function offer(Request $request, $id)
    {
        $request->validate([
            'isOffred' => 'required|boolean',
            'offredPrice' => 'nullable|numeric|min:0',
            'startOffreDay' => 'nullable|date',
            'endOffreDay' => 'nullable|date|after_or_equal:startOffreDay',
        ]);
        $product = Product::findOrFail($id);
        $product->isOffred = $request->isOffred;
        $product->offredPrice = $request->offredPrice;
        $product->startOffreDay = $request->startOffreDay;
        $product->endOffreDay = $request->endOffreDay;
        $product->save();
        return response()->json(['message' => 'Offer updated successfully', 'product' => $product]);
    }

    // Add a new offer to a product
    public function addOffer(Request $request, $id)
    {
        $request->validate([
            'offredPrice' => 'required|numeric|min:0',
            'startOffreDay' => 'required|date',
            'endOffreDay' => 'required|date|after_or_equal:startOffreDay',
        ]);
        $product = Product::findOrFail($id);
        $product->isOffred = true;
        $product->offredPrice = $request->offredPrice;
        $product->startOffreDay = $request->startOffreDay;
        $product->endOffreDay = $request->endOffreDay;
        $product->save();
        return response()->json(['message' => 'Offer added successfully', 'product' => $product]);
    }

    // Edit an existing offer for a product
    public function editOffer(Request $request, $id)
    {
        $request->validate([
            'offredPrice' => 'sometimes|required|numeric|min:0',
            'startOffreDay' => 'sometimes|required|date',
            'endOffreDay' => 'sometimes|required|date|after_or_equal:startOffreDay',
        ]);
        $product = Product::findOrFail($id);
        if ($request->has('offredPrice')) $product->offredPrice = $request->offredPrice;
        if ($request->has('startOffreDay')) $product->startOffreDay = $request->startOffreDay;
        if ($request->has('endOffreDay')) $product->endOffreDay = $request->endOffreDay;
        $product->save();
        return response()->json(['message' => 'Offer updated successfully', 'product' => $product]);
    }

    // Delete an offer from a product
    public function deleteOffer($id)
    {
        $product = Product::findOrFail($id);
        $product->isOffred = false;
        $product->offredPrice = null;
        $product->startOffreDay = null;
        $product->endOffreDay = null;
        $product->save();
        return response()->json(['message' => 'Offer deleted successfully', 'product' => $product]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric|min:0',
            'image' => 'nullable|image|file|max:2048',
            'sizes' => 'nullable|json',
            'colors' => 'nullable|json',
        ]);
        $product = Product::findOrFail($id);
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'image|file|max:2048',
            ]);
            $image = $request->file('image')->store('products', 'public');
            $product->image = "storage/{$image}";
        } elseif ($request->has('image')) {
            $product->image = $request->image; // string (URL or path)
        }
        if ($request->has('name')) $product->name = $request->name;
        if ($request->has('price')) $product->price = $request->price;
        if ($request->has('sizes')) $product->sizes = json_decode($request->sizes);
        if ($request->has('colors')) $product->colors = json_decode($request->colors);
        $product->save();
        return response()->json(['message' => 'Product updated successfully', 'product' => $product]);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
