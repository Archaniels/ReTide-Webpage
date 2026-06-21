<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = BlogPost::orderBy('created_at', 'desc')->get();

        return view('admin.blog.index', compact('blogs'));
    }
}
