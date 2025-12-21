<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Http;

class BlogPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blog = BlogPost::all();
        return view('blog.index', ['blog' => $blog]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:5|max:100',
            'content' => 'required|min:5|max:3000',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $request->file('image_path')->store('blog_images');

        BlogPost::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'image_path' => $imagePath,
        ]);
        return redirect('/blog/create')->with('success', 'Blog berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Old Code: using Laravel Eloquent
        // $blog = BlogPost::findOrFail($id);
        // return view('blog.edit', compact('blog'));

        // New Code: using NodeJS
        $response = Http::get("http://localhost:3000/blogs/$id");
        if ($response->successful()) {
            $blogData = $response->json();
            $blog = (object) $blogData;
            $blog->image = $blogData['image_path'] ?? null;
            return view("blog.edit", compact("blog"));
        }

        return redirect()->route('blog.index')->with('error', 'Blog not found');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Old Code: using Laravel Eloquent
        // $blog = BlogPost::findOrFail($id);
        $request->all();
        // return redirect('/blog/' . $id . '/edit')->with('success', 'Blog berhasil diperbarui!');

        // New Code: using NodeJS
        Http::put("http://localhost:3000/blogs/$id", [
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'image_path' => $request->input('image_path'),
        ]);

        return redirect()->route('blog.index')->with('success', 'Blog berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // $blog = BlogPost::findOrFail($id);
        // $blog->delete();
        // return redirect('/blog/')->with('success', 'Blog berhasil dihapus!');

        // New Code: using NodeJS
        Http::delete("http://localhost:3000/blogs/$id");

        return redirect()->route('blog.index')->with('success', 'Blog berhasil dihapus!');
    }
}
