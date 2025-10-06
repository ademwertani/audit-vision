<?php

namespace App\Http\Controllers;
use App\Models\Banner;
use App\Models\Blog;

class BlogController extends Controller
{
    public function index()
    {$banner = \App\Models\Banner::latest()->first();
    $heroBannerImg = $banner && $banner->image
        ? asset('storage/'.ltrim($banner->image,'/'))
        : asset('img/default-banner.jpg');
        $blogs = Blog::latest('published_at')->paginate(10);
        return view('pages.blog', compact('blogs','heroBannerImg'));
    }

    public function show(Blog $blog)
    {$banner = \App\Models\Banner::latest()->first();
    $heroBannerImg = $banner && $banner->image
        ? asset('storage/'.ltrim($banner->image,'/'))
        : asset('img/default-banner.jpg');
         return view('pages.blog-show', compact('blog','heroBannerImg'));
    }
}

