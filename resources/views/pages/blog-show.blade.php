@extends('layouts.app')

@section('title', $blog->title)

@section('content')
    <!-- ======= Hero ======= -->
    <div class="container-fluid page-header py-5">
        <div class="container text-center py-5">
            <h1 class="display-5 text-white mb-3 animated slideInDown">{{ $blog->title }}</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Accueil</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">Blog</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ \Illuminate\Support\Str::limit($blog->title, 40) }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- ======= Styles locaux (déplace-les dans ton CSS si tu veux) ======= -->
    <style>
        .article-wrap { max-width: 900px; margin: 0 auto; }
        .article-card{
            background:#fff; border:1px solid rgba(0,0,0,.06); border-radius:16px;
            box-shadow: 0 10px 30px rgba(0,0,0,.06); overflow:hidden;
        }
        .article-hero{ position:relative; aspect-ratio: 16/9; background:#f3f5f7; }
        .article-hero img{ width:100%; height:100%; object-fit:cover; }
        .badge-state{
            position:absolute; top:12px; left:12px; padding:.35rem .6rem; border-radius:10px;
            font-size:.8rem; background:rgba(0,0,0,.7); color:#fff; backdrop-filter: blur(4px);
        }
        .badge-draft{ background:#ffe08a; color:#222; }
        .article-body{ padding: 1.5rem 1.25rem 1.75rem; }
        @media (min-width: 992px){ .article-body{ padding: 2rem; } }

        /* Typo “prose” lisible */
        .prose{ color:#1f2937; line-height:1.75; font-size:1.05rem; }
        .prose p{ margin-bottom:1rem; }
        .prose h2, .prose h3{ margin-top:1.6rem; margin-bottom:.8rem; font-weight:700; }
        .prose h2{ font-size:1.5rem; }
        .prose h3{ font-size:1.25rem; }
        .prose ul, .prose ol{ padding-left:1.15rem; margin-bottom:1rem; }
        .prose blockquote{
            margin:1.25rem 0; padding:.9rem 1rem; background:#f8fafc; border-left:4px solid #0d6efd; border-radius:8px;
        }
        .meta{
            display:flex; flex-wrap:wrap; gap:.75rem 1.25rem; color:#6b7280; font-size:.95rem; margin-bottom:1rem;
        }
        .share-list{ display:flex; gap:.5rem; flex-wrap:wrap; }
        .share-list .btn{ border-radius:10px; }
        .nav-article a{
            display:flex; gap:.75rem; align-items:center; padding:1rem; border-radius:12px;
            border:1px solid rgba(0,0,0,.06); background:#fff; text-decoration:none;
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .nav-article a:hover{ transform: translateY(-2px); box-shadow:0 10px 22px rgba(0,0,0,.08); }
        .divider{ height:1px; background:rgba(0,0,0,.06); margin:1.25rem 0; }
    </style>

    @php
        // Sécurise la date & calcule le temps de lecture
        // (si tu castes published_at => 'datetime' dans le modèle, utilise directement $blog->published_at)
        $publishedAt = $blog->published_at ? \Illuminate\Support\Carbon::parse($blog->published_at) : null;
        $readingMinutes = max(1, (int)ceil(str_word_count(strip_tags($blog->content)) / 200));
        $canonicalUrl = route('blog.show', $blog->slug);
        $encodedUrl = urlencode($canonicalUrl);
        $encodedTitle = urlencode($blog->title);
    @endphp

    <!-- ======= Article ======= -->
    <div class="container py-5">
        <article class="article-wrap">
            <div class="article-card">
                @if($blog->image)
                    <figure class="article-hero">
                        <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ e($blog->title) }}" loading="lazy">
                        <figcaption class="visually-hidden">{{ e($blog->title) }}</figcaption>
                        <span class="badge-state {{ $publishedAt ? '' : 'badge-draft' }}">
                            {{ $publishedAt ? $publishedAt->translatedFormat('d MMM yyyy') : 'Brouillon' }}
                        </span>
                    </figure>
                @endif

                <div class="article-body">
                    <header class="mb-2">
                        <h1 class="h2 mb-3">{{ $blog->title }}</h1>
                        <div class="meta">
                            <div>
                                @if($publishedAt)
                                    <span class="me-2">Publié le</span>
                                    <time datetime="{{ $publishedAt->toDateString() }}">{{ $publishedAt->isoFormat('DD/MM/YYYY') }}</time>
                                @else
                                    <span class="text-warning">Non publié</span>
                                @endif
                            </div>
                            <div>•</div>
                            <div>{{ $readingMinutes }} min de lecture</div>

                            @isset($blog->author)
                                <div>•</div>
                                <div>Par <strong>{{ e($blog->author) }}</strong></div>
                            @endisset
                        </div>
                    </header>

                    <div class="divider"></div>

                    <!-- Contenu -->
                    <div class="prose">
                        {!! nl2br(e($blog->content)) !!}
                    </div>

                    <div class="divider"></div>

                    <!-- Partage -->
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                        <div class="share-list">
                            <a class="btn btn-outline-primary btn-sm"
                               href="https://www.facebook.com/sharer/sharer.php?u={{ $encodedUrl }}"
                               target="_blank" rel="noopener">Facebook</a>
                            <a class="btn btn-outline-primary btn-sm"
                               href="https://twitter.com/intent/tweet?url={{ $encodedUrl }}&text={{ $encodedTitle }}"
                               target="_blank" rel="noopener">X / Twitter</a>
                            <a class="btn btn-outline-primary btn-sm"
                               href="https://www.linkedin.com/sharing/share-offsite/?url={{ $encodedUrl }}"
                               target="_blank" rel="noopener">LinkedIn</a>
                            <a class="btn btn-outline-primary btn-sm"
                               href="https://api.whatsapp.com/send?text={{ $encodedTitle }}%20{{ $encodedUrl }}"
                               target="_blank" rel="noopener">WhatsApp</a>
                        </div>

                        <div class="text-muted small">
                            <span class="me-1">Lien :</span>
                            <a href="{{ $canonicalUrl }}">{{ $canonicalUrl }}</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation articles -->
            @php
                // Optionnel : passe $prev et $next depuis le contrôleur (articles adjacents)
                // $prev: article plus récent; $next: article plus ancien (ou inverse selon ton tri)
            @endphp
            @if(!empty($prev) || !empty($next))
                <div class="row g-3 mt-4 nav-article">
                    <div class="col-md-6">
                        @if(!empty($prev))
                            <a href="{{ route('blog.show', $prev->slug) }}" aria-label="Article précédent : {{ $prev->title }}">
                                <span class="badge bg-light text-dark">← Précédent</span>
                                <span class="fw-semibold">{{ \Illuminate\Support\Str::limit($prev->title, 60) }}</span>
                            </a>
                        @endif
                    </div>
                    <div class="col-md-6 text-md-end">
                        @if(!empty($next))
                            <a href="{{ route('blog.show', $next->slug) }}" aria-label="Article suivant : {{ $next->title }}" class="ms-md-auto">
                                <span class="badge bg-light text-dark">Suivant →</span>
                                <span class="fw-semibold">{{ \Illuminate\Support\Str::limit($next->title, 60) }}</span>
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </article>
    </div>
@endsection