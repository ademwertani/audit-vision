@extends('layouts.app')

@section('title', $blog->title)

@section('content')
@php
  use Illuminate\Support\Str;
  use Illuminate\Support\Carbon;

  // Dates & reading time
  $publishedAt    = $blog->published_at ? Carbon::parse($blog->published_at) : null;
  $readingMinutes = max(1, (int)ceil(str_word_count(strip_tags($blog->content)) / 200));

  // Share links
  $canonicalUrl = route('blog.show', $blog->slug);
  $encodedUrl   = urlencode($canonicalUrl);
  $encodedTitle = urlencode($blog->title);
@endphp

<style>
/* =========================================================
   Aisla Nova – Blog Post (same skin as Contact/About/Blog)
   Styles scoped to this page only.
   ========================================================= */
.page-post{
  --navy:#2f3582;
  --navyDark:#1d2760;
  --sky:#7CAE2A;
  --accent:#ff6b35;
  --ink:#0f172a;
  --muted:#6b7280;
  --card:#ffffff;
  --ring:#dbe6ff;
  --shadow-lg:0 24px 48px rgba(16,24,40,.12);
  --shadow:0 10px 18px rgba(0,0,0,.08);
}
.page-post *{box-sizing:border-box}

/* ---------- HERO (left-aligned + long pill breadcrumb) ---------- */
.pp-hero{
  background:var(--navy); color:#fff; padding:78px 0 92px; position:relative;
}
.pp-hero .pp-hgroup{max-width:1100px;margin:0 auto;padding:0 12px}
.pp-title{font-size:48px;line-height:1.08;font-weight:800;margin:0 0 10px}
@media (min-width:992px){ .pp-title{font-size:56px} }
.pp-hero h1,.pp-hero .pp-title,.pp-hero p,.pp-hero .pp-sub{color:#fff !important}
.pp-sub{max-width:680px;font-size:15px;line-height:1.7;margin:0;opacity:.95}

/* breadcrumb pill (identical behavior) */
.pp-bread-wrap{position:absolute;left:0;right:0;bottom:-28px;display:flex;justify-content:center}
.pp-bread{
  width:min(1180px, calc(100% - 48px));
  background:var(--sky); height:46px; border-radius:9999px;
  display:flex; align-items:center; gap:18px; padding:0 22px;
  font-weight:700; box-shadow:0 10px 18px rgba(3,102,140,.12);
  color:#fff !important;
}
.pp-bread a,.pp-bread span{color:#fff !important}
.pp-bread .sep{color:rgba(255,255,255,.85) !important}
.pp-bread .home-ico{display:inline-grid;place-items:center;width:26px;height:26px;border-radius:50%;
  background:rgba(255,255,255,.22);color:#fff !important;font-size:12px}

/* ---------- Article ---------- */
.pp-wrap{padding:70px 0 40px}
.article-wrap{max-width:980px;margin:0 auto}
.article-card{
  background:var(--card); border:1px solid #eef2f6; border-radius:18px;
  box-shadow:var(--shadow); overflow:hidden;
}
.article-hero{position:relative; aspect-ratio: 16/9; background:#f3f5f7}
.article-hero img{width:100%;height:100%;object-fit:cover;display:block}
.badge-state{
  position:absolute; top:12px; left:12px; padding:.35rem .6rem; border-radius:10px;
  font-size:.8rem; background:rgba(0,0,0,.65); color:#fff; backdrop-filter: blur(4px);
}
.badge-draft{ background:#ffe08a; color:#222 }
.article-body{ padding:1.5rem 1.25rem 1.75rem }
@media (min-width:992px){ .article-body{ padding:2rem } }

/* Typography */
.prose{ color:#1f2937; line-height:1.75; font-size:1.05rem }
.prose p{ margin-bottom:1rem }
.prose h2, .prose h3{ margin-top:1.6rem; margin-bottom:.8rem; font-weight:700 }
.prose h2{ font-size:1.5rem }
.prose h3{ font-size:1.25rem }
.prose ul, .prose ol{ padding-left:1.15rem; margin-bottom:1rem }
.prose blockquote{
  margin:1.25rem 0; padding:.9rem 1rem; background:#f8fafc;
  border-left:4px solid var(--sky); border-radius:8px;
}

.meta{display:flex; flex-wrap:wrap; gap:.75rem 1.25rem; color:#6b7280; font-size:.95rem; margin-bottom:1rem}
.divider{height:1px;background:#eef2f6;margin:1.25rem 0}

/* Share + nav */
.share-list{ display:flex; gap:.5rem; flex-wrap:wrap }
.share-list .btn{ border-radius:12px }
.nav-article a{
  display:flex; gap:.75rem; align-items:center; padding:1rem; border-radius:14px;
  border:1px solid #eef2f6; background:#fff; text-decoration:none;
  transition: transform .2s ease, box-shadow .2s ease;
}
.nav-article a:hover{ transform: translateY(-2px); box-shadow:0 10px 22px rgba(0,0,0,.08) }

/* Accent button (if you need on this page later) */
.btn-accent{
  background:var(--accent); color:#fff; border:none; font-weight:800;
  padding:10px 16px; border-radius:14px; box-shadow:0 10px 18px rgba(255,107,53,.2);
}
.btn-accent:hover{ filter:brightness(.98) }
/* HERO Post : bleu en haut, image dessous, pas d'effet */
.pp-hero{
  --navy:#242958;
  position: relative;
  background: var(--navy);
  color: #fff;
  padding: 78px 0 92px;     /* hauteur de la bande bleue */
  overflow: visible;        /* pour laisser dépasser l'image */
  z-index: 5;
}

/* Décrochage de l'image sous le bleu */
.pp-hero--split{
  --pp-img-drop: 160px;      /* ⇦ ajuste +/– pour monter/descendre l'image */
  margin-bottom: var(--pp-img-drop);
}

.pp-hero__inner{ position: relative; z-index: 3; } /* texte au-dessus */
.pp-title{ margin: 0 0 6px; font-weight: 800; font-size: clamp(32px,5vw,56px); }
.pp-sub{ max-width: 720px; opacity: .95; }

/* Couche bleue au-dessus de l'image mais sous le texte (pour un “cut” net) */
.pp-hero::after{
  content: "";
  position: absolute; inset: 0;
  background: var(--navy);
  z-index: 2;
  pointer-events: none;
}
/* Coins arrondis pour l'image du hero (post) */
.pp-hero__media img{
  border-radius: 18px !important; /* ajuste: 12px, 18px, 24px... */
  box-shadow: none !important;    /* pas d'ombre, comme demandé */
  filter: none !important;        /* aucun effet */
  transform: none !important;
}
.pa-hero__media img,
.sv-hero__media img,
.pb-hero__media img,
.pp-hero__media img{
  border-radius: 18px !important;
  box-shadow: none !important;
  filter: none !important;
  transform: none !important;
}


/* IMAGE : sous la couche bleue, dépasse vers le bas, SANS effets */
.pp-hero__media{
  position: absolute;
  right: clamp(16px, 3vw, 40px);
  bottom: calc(-1 * var(--pp-img-drop)); /* fait dépasser l'image sous le bleu */
  width: min(360px, 52vw);
  z-index: 1;                             /* sous la couche bleue */
}
.pp-hero__media img{
  display: block;
  width: 100%; height: auto;
  border: 0; border-radius: 0 !important;
  box-shadow: none !important;
  filter: none !important;
  transform: none !important;            /* ZERO effet sur l'image */
}

/* Responsive */
@media (max-width: 992px){
  .pp-hero--split{ --pp-img-drop: 44px; }
  .pp-hero__media{ width: min(640px, 88vw); right: 12px; }
}

</style>

<section class="page-post">

@php
  // Image héro = image de l'article, sinon fallback
  $postHeroImg = !empty($blog->image)
      ? asset('storage/' . ltrim($blog->image, '/'))
      : asset('img/blog-post-hero.png'); // fallback
@endphp

{{-- HERO (left-aligned) --}}
<header class="pp-hero pp-hero--split"
        style="
          --pp-hero-offset: 902px;  /* ↓ Descend la bande bleue de 32px */
          --pp-img-drop: 200px;    /* ↓ Descend l’image sous la bande bleue */
        ">
  <div class="pp-hgroup container pp-hero__inner">
    <div class="pp-hero__copy">
      <h1 class="pp-title">{{ $blog->title }}</h1>

      @if($publishedAt)
        <p class="pp-sub">
          Publié le
          <time datetime="{{ $publishedAt->toDateString() }}">{{ $publishedAt->isoFormat('DD/MM/YYYY') }}</time>
          • {{ $readingMinutes }} min de lecture
          @isset($blog->author) • Par <strong>{{ e($blog->author) }}</strong> @endisset
        </p>
      @else
        <p class="pp-sub text-warning">Brouillon • {{ $readingMinutes }} min de lecture</p>
      @endif
    </div>

    {{-- IMAGE sous la bande bleue (PAS d’effet) --}}
    <figure class="pp-hero__media">
      <img src="{{ $postHeroImg }}" alt="{{ $blog->title }}">
    </figure>
  </div>
</header>


  {{-- ARTICLE --}}
  <div class="pp-wrap">
    <div class="container">
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

            {{-- Contenu (sécurisé). Si vous stockez du HTML validé, remplacez par: {!! $blog->content !!} --}}
            <div class="prose">
              {!! nl2br(e($blog->content)) !!}
            </div>

            <div class="divider"></div>

            {{-- Partage --}}
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

        {{-- Navigation entre articles (facultatif : $prev / $next depuis le contrôleur) --}}
        @if(!empty($prev) || !empty($next))
          <div class="row g-3 mt-4 nav-article">
            <div class="col-md-6">
              @if(!empty($prev))
                <a href="{{ route('blog.show', $prev->slug) }}" aria-label="Article précédent : {{ $prev->title }}">
                  <span class="badge bg-light text-dark">← Précédent</span>
                  <span class="fw-semibold">{{ Str::limit($prev->title, 60) }}</span>
                </a>
              @endif
            </div>
            <div class="col-md-6 text-md-end">
              @if(!empty($next))
                <a href="{{ route('blog.show', $next->slug) }}" aria-label="Article suivant : {{ $next->title }}" class="ms-md-auto">
                  <span class="badge bg-light text-dark">Suivant →</span>
                  <span class="fw-semibold">{{ Str::limit($next->title, 60) }}</span>
                </a>
              @endif
            </div>
          </div>
        @endif

      </article>
    </div>
  </div>

</section>
@endsection
