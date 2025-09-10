@extends('layouts.app')
@php use Illuminate\Support\Str; @endphp

@section('title', 'Notre blog')

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5">
        <div class="container text-center py-5">
            <h1 class="display-2 text-white mb-4 animated slideInDown">Notre blog</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Accueil</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Blog</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Blog Section -->
    <div class="container-fluid blog py-5 my-5">
        <div class="container py-5">
            <div class="text-center mx-auto pb-5 wow fadeIn" data-wow-delay=".3s" style="max-width: 600px;">
                <h5 class="text-primary">Notre blog</h5>
                <h1>Derniers articles et actualités</h1>
            </div>
            <div class="row g-5">
                @foreach($blogs as $blog)
                    <div class="col-lg-6 col-xl-4">
                        <div class="blog-item bg-light rounded">
                            @if($blog->image)
                                <img src="{{ asset('storage/' . $blog->image) }}" class="img-fluid w-100 rounded-top" alt="{{ $blog->title }}">
                            @endif
                            <div class="blog-content text-center">
                                <h5>{{ $blog->title }}</h5>
                                <p>
                                    {{ $blog->published_at 
                                        ? \Carbon\Carbon::parse($blog->published_at)->format('Y-m-d') 
                                        : '' }}
                                </p>
                                <p>{{ Str::limit($blog->content, 120) }}</p>
                                <a href="{{ route('blog.show', $blog->slug) }}" class="btn btn-primary mt-2">Lire la suite</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4 d-flex justify-content-center">
                {{ $blogs->links() }}
            </div>
        </div>
    </div>
@endsection
