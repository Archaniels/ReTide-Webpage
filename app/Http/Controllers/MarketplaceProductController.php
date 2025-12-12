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
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'image_path' => 'nullable|max:255',
        ]);

        MarketplaceProduct::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image_path' => $request->image_path,
        ]);

        return redirect()->route('marketplace.index')->with('success', 'Product berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = MarketplaceProduct::findOrFail($id);
        return view('marketplace.show', compact('product'));
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
            'image_path' => 'nullable|max:255',
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
