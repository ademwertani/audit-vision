<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Blog;

class BlogController extends Controller
{
    public function index()
    {
        // جلب أول 3 صور من banners بالترتيب من الأحدث
        $heroBannerImages = Banner::orderByDesc('created_at')
            ->take(3)
            ->pluck('image')                      // نأخذ مسار الصورة فقط
            ->filter()                            // نشيل null والفراغ
            ->map(fn ($img) => asset('storage/' . ltrim($img, '/')));

        // لو بناكودك يحتاج صورة واحدة (كما هو سابقاً)
        $heroBannerImg = $heroBannerImages->first();

        $blogs = Blog::latest('published_at')->paginate(10);

        return view('pages.blog', [
            'blogs'            => $blogs,
            'heroBannerImg'    => $heroBannerImg,     // صورة واحدة (قد تكون null)
            'heroBannerImages' => $heroBannerImages,  // مجموعة (قد تكون فارغة)
        ]);
    }

    public function show(Blog $blog)
{
    // Récupérer jusqu'à 3 bannières avec image
    $heroBannerImages = \App\Models\Banner::orderByDesc('created_at')
        ->take(3)
        ->pluck('image')
        ->filter()
        ->map(fn ($img) => asset('storage/' . ltrim($img, '/')));

    // Image de fallback = image de l’article
    $postHeroImg = !empty($blog->image)
        ? asset('storage/' . ltrim($blog->image, '/'))
        : null;

    return view('pages.blog-show', [
        'blog'             => $blog,
        'heroBannerImages' => $heroBannerImages,
        'postHeroImg'      => $postHeroImg,
    ]);
}
}
