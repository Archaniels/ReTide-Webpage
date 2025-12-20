<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MarketplaceProduct;
use Illuminate\Support\Facades\Http;

class MarketplaceProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Old Code: using Laravel Eloquent
        // $products = MarketplaceProduct::orderBy('created_at', 'desc')->get();
        // return view('marketplace.index', ['products' => $products]);

        // New: using NodeJS
        $response = Http::get("http://localhost:3000/products");
        $products = [];

        if ($response->successful()) {
            $data = $response->json();
            $products = collect($data)->map(function ($item) {
                $object = (object) $item;
                // Carbon for date formatting
                $object->created_at = \Carbon\Carbon::parse($item['created_at'] ?? now());
                $object->updated_at = \Carbon\Carbon::parse($item['updated_at'] ?? now());
                $object->image = $item['image_path'] ?? null;
                return $object;
            });
        }

        return view("marketplace.index", compact("products"));
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

        // Old Code: using Laravel Eloquent
        // MarketplaceProduct::create([
        //     'name' => $request->name,
        //     'description' => $request->description,
        //     'price' => $request->price,
        //     'image_path' => $imagePath,
        // ]);

        // New Code: using NodeJS
        Http::post("http://localhost:3000/products", [
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
        // Old Code: using Laravel Eloquent
        // $product = MarketplaceProduct::findOrFail($id);

        // New Code: using NodeJS
        $response = Http::get("http://localhost:3000/products/$id");
        if ($response->successful()) {
            $productData = $response->json();
            $product = (object) $productData;
            $product->image = $productData['image_path'] ?? null;
            return view("marketplace.edit", compact("product"));
        }

        return redirect()->route('marketplace.index')->with('error', 'Product not found');
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

        // Old Code: using Laravel Eloquent
        // $product = MarketplaceProduct::findOrFail($id);
        // $product->update($request->all());

        // New Code: using NodeJS
        Http::put("http://localhost:3000/products/$id", [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image_path' => $request->image_path,
        ]);

        return redirect()->route('marketplace.index')->with('success', 'Product berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Old Code: using Laravel Eloquent
        // $product = MarketplaceProduct::findOrFail($id);
        // $product->delete();

        // New Code: using NodeJS
        Http::delete("http://localhost:3000/products/$id");

        return redirect()->route('marketplace.index')->with('success', 'Product berhasil dihapus!');
    }
}
