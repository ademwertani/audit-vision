<?php

namespace App\Http\Controllers;

use App\Models\Blog;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest('published_at')->paginate(10);
        return view('pages.blog', compact('blogs'));
    }

    public function show(Blog $blog)
    {
        return view('pages.blog-show', compact('blog'));
    }
}

