<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;

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
            'title' => 'required',
            'content' => 'required',
            'image_path' => 'nullable|image',
        ]);

        $imagePath = null;
        if ($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->store('blog_images');
        }

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
        $blog = BlogPost::findOrFail($id);
        return view('blog.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $blog = BlogPost::findOrFail($id);
        $blog->update($request->all());
        return redirect('/blog/' . $id . '/edit')->with('success', 'Blog berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = BlogPost::findOrFail($id);
        $blog->delete();
        return redirect('/blog/')->with('success', 'Blog berhasil dihapus!');
    }
}
