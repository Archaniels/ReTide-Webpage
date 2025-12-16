<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MarketplaceProduct;

class MarketplaceProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = MarketplaceProduct::orderBy('created_at', 'desc')->get();
        return view('marketplace.index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('marketplace.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:5|max:100',
            'description' => 'required|min:5|max:3000',
            'price' => 'required|numeric|min:0',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $request->file('image_path')->store('marketplace_products');

        MarketplaceProduct::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('marketplace.index')->with('success', 'Product berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $product = MarketplaceProduct::findOrFail($id);
        // return view('marketplace.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = MarketplaceProduct::findOrFail($id);
        return view('marketplace.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'image_path' => 'nullable|',
        ]);

        $product = MarketplaceProduct::findOrFail($id);
        $product->update($request->all());

        return redirect()->route('marketplace.index')->with('success', 'Product berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = MarketplaceProduct::findOrFail($id);
        $product->delete();

        return redirect()->route('marketplace.index')->with('success', 'Product berhasil dihapus!');
    }
}
