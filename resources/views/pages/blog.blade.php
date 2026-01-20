@extends('layouts.app')
@php use Illuminate\Support\Str; @endphp

@section('title', 'Notre blog')

@section('content')
<style>
/* =========================================================
   France Isolation – Blog
   ========================================================= */
.page-blog{
  --navy:#242958;
  --navyDark:#1d2760;
  --sky:#7CAE2A;
  --accent:#7CAE2A;
  --ink:#020617;
  --muted:#6b7280;
  --card:#ffffff;
  --ring:#dbe6ff;
  --shadow-lg:0 24px 48px rgba(15,23,42,.18);
  --shadow:0 10px 18px rgba(15,23,42,.10);
}
.page-blog *{box-sizing:border-box}

/* ---------- TYPO (Epilogue pour le hero) ---------- */
@import url('https://fonts.googleapis.com/css2?family=Epilogue:wght@400;600;800;900&display=swap');
.page-blog .OO-title,
.page-blog .OO-sub{
  font-family: "Epilogue", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif !important;
  color:#fff !important;
}

/* =========================================================
   HERO façon “Audit énergétique”
   ========================================================= */


/* --- halo global qui dépasse le cadre --- */


/* --- vague du bas : خفيفة جدا، بدون أخضر قوي --- */

/* contenu texte */


/* panneau “verre” derrière le texte */


/* tailles de titre/sous-titre */
.OO-title{
  font-size: clamp(44px, 6.5vw, 80px);
  line-height: 1.05;
  font-weight: 900;
  margin: 0 0 10px;
}
.OO-sub{
  font-size: clamp(18px, 1.8vw, 24px);
  line-height: 1.7;
  opacity: .98;
  margin: 0;
}


/* =========================================================
   SECTION LISTE BLOG – modèle amélioré
   ========================================================= */
.OO-wrap{
  padding:70px 0 50px;
}
.OO-head{
  text-align:center;
  max-width:820px;
  margin:0 auto 36px;
}
.OO-kicker{
  color:var(--sky);
  font-weight:800;
  text-transform:uppercase;
  letter-spacing:.12em;
  font-size:.85rem;
}
.OO-h1{
  color:var(--ink);
  font-weight:800;
  line-height:1.14;
  margin:8px 0 0;
}

/* Layout global */
.blog-layout{
  display:flex;
  flex-direction:column;
  gap:40px;
}

/* -------- FEATURED POST -------- */
.blog-feature{
  display:grid;
  grid-template-columns:minmax(0,1.45fr) minmax(0,1fr);
  gap:0;
  align-items:stretch;
  border-radius:26px;
  overflow:hidden;
  background:
    linear-gradient(135deg,
      #020617 0%,
      #020617 34%,
      #0b1120 60%,
      #0b2a16 100%);
  box-shadow:var(--shadow-lg);
  position:relative;
  isolation:isolate;
}

/* ligne verte/bleue très fine autour */
.blog-feature::before{
  content:"";
  position:absolute;
  inset:0;
  border-radius:inherit;
  padding:1px;
  background:linear-gradient(135deg,
      rgba(124,174,42,0.80),
      rgba(37,99,235,0.75),
      rgba(15,23,42,0.0));
  -webkit-mask:
    linear-gradient(#000 0 0) content-box,
    linear-gradient(#000 0 0);
  -webkit-mask-composite:xor;
  mask-composite:exclude;
  opacity:.75;
  pointer-events:none;
}

/* image */
.blog-feature-thumb{
  position:relative;
  overflow:hidden;
}
.blog-feature-thumb img{
  width:100%;
  height:100%;
  min-height:260px;
  object-fit:cover;
  display:block;
  transform:scale(1.03);
  transition:transform .7s ease-out, filter .7s ease-out;
}
.blog-feature:hover .blog-feature-thumb img{
  transform:scale(1.07);
  filter:brightness(1.07);
}

/* badge */
.blog-feature-badge{
  position:absolute;
  left:20px;
  top:20px;
  padding:6px 12px;
  background:rgba(15,23,42,0.92);
  border-radius:999px;
  font-size:.78rem;
  letter-spacing:.12em;
  text-transform:uppercase;
  color:#e5f4ff;
}

/* contenu */
.blog-feature-body{
  padding:24px 26px 24px 26px;
  display:flex;
  flex-direction:column;
  justify-content:space-between;
  color:#e5e7eb;
}
.blog-feature-meta{
  font-size:.85rem;
  color:#9ca3af;
  margin-bottom:6px;
}
.blog-feature-title{
  font-size: clamp(1.7rem, 2.1vw, 2rem);
  font-weight:800;
  margin-bottom:10px;
  color:#f9fafb;
}
.blog-feature-title a{
  color:inherit;
  text-decoration:none;
}
.blog-feature-title a:hover{
  text-decoration:underline;
}
.blog-feature-excerpt{
  font-size:.97rem;
  line-height:1.7;
  color:#d1d5db;
  margin-bottom:18px;
}

/* footer dans le feature */
.blog-feature-footer{
  display:flex;
  flex-wrap:wrap;
  align-items:center;
  gap:16px;
  margin-top:6px;
}
.btn-accent{
  background:var(--accent);
  color:#fff;
  border:none;
  font-weight:800;
  padding:10px 18px;
  border-radius:999px;
  font-size:.95rem;
  display:inline-flex;
  align-items:center;
  gap:6px;
  text-decoration:none;
  box-shadow:0 12px 30px rgba(15,118,110,0.40);
  transition:transform .18s ease, box-shadow .18s ease, filter .18s ease;
}
.btn-accent:hover{
  filter:brightness(1.03);
  transform:translateY(-1px);
  box-shadow:0 16px 40px rgba(15,118,110,0.55);
}
.blog-feature-link{
  font-size:.9rem;
  color:#a5b4fc;
  text-decoration:none;
}
.blog-feature-link:hover{
  text-decoration:underline;
}

/* -------- LISTE des autres posts -------- */
.blog-list{
  display:grid;
  grid-template-columns:repeat(12,1fr);
  gap:26px;
}
.blog-item{
  grid-column:span 4;
  display:flex;
}

@media (max-width: 991.98px){
  .blog-feature{
    grid-template-columns:1fr;
  }
  .blog-feature-body{
    padding:20px 20px 22px 20px;
  }
  .blog-list{
    grid-template-columns:repeat(2,1fr);
  }
  .blog-item{
    grid-column:span 1;
  }
}
@media (max-width: 575.98px){
  .blog-list{
    grid-template-columns:1fr;
  }
}

/* Carte “secondaire” */
.blog-card{
  background:var(--card);
  border-radius:22px;
  overflow:hidden;
  box-shadow:0 10px 28px rgba(15,23,42,0.08);
  border:1px solid rgba(148,163,184,0.26);
  display:flex;
  flex-direction:column;
  width:100%;
  position:relative;
  transition:
    box-shadow .23s ease,
    transform .23s ease,
    border-color .23s ease;
}

/* bande dégradé en haut من الكارت */
.blog-card::before{
  content:"";
  position:absolute;
  left:0;right:0;top:0;
  height:3px;
  background:linear-gradient(90deg,
      rgba(124,174,42,0.0) 0%,
      rgba(124,174,42,0.70) 12%,
      rgba(37,99,235,0.70) 60%,
      rgba(37,99,235,0.0) 100%);
  opacity:.65;
}
.blog-card:hover{
  transform:translateY(-4px);
  box-shadow:0 20px 55px rgba(15,23,42,0.16);
  border-color:rgba(129,140,248,0.85);
}

/* image */
.blog-card-thumb{
  position:relative;
  overflow:hidden;
  background:#020617;
}
.blog-card-thumb img{
  width:100%;
  height:215px;
  object-fit:cover;
  display:block;
  transform:scale(1.01);
  transition:transform .55s ease-out, filter .55s ease-out;
}
.blog-card:hover .blog-card-thumb img{
  transform:scale(1.05);
  filter:brightness(1.05);
}

/* petit tag */
.blog-card-tag{
  position:absolute;
  left:14px;
  top:14px;
  padding:5px 11px;
  background:rgba(15,23,42,0.88);
  border-radius:999px;
  font-size:.72rem;
  letter-spacing:.14em;
  text-transform:uppercase;
  color:#e5f4ff;
}

/* corps */
.blog-card-body{
  padding:16px 18px 14px;
}
.blog-card-title{
  font-size:1.03rem;
  font-weight:800;
  margin:0 0 6px;
  color:#0f172a;
}
.blog-card-title a{
  color:inherit;
  text-decoration:none;
}
.blog-card-title a:hover{
  text-decoration:underline;
}
.blog-card-meta{
  display:flex;
  flex-wrap:wrap;
  gap:10px;
  align-items:center;
  font-size:.8rem;
  color:#6b7280;
  margin-bottom:6px;
}
.blog-card-meta-dot::before{
  content:"•";
  margin:0 6px;
  opacity:.55;
}
.blog-card-excerpt{
  font-size:.9rem;
  line-height:1.6;
  color:#4b5563;
  margin:0 0 12px;
}

/* footer carte */
.blog-card-footer{
  display:flex;
  align-items:center;
  justify-content:space-between;
  padding:0 18px 14px 18px;
}
.blog-card-more{
  font-size:.85rem;
  color:var(--navyDark);
  font-weight:600;
  text-decoration:none;
}
.blog-card-more span{
  display:inline-block;
  transition:transform .2s ease;
}
.blog-card:hover .blog-card-more span{
  transform:translateX(3px);
}

.badge-pill{
  display:inline-flex;
  align-items:center;
  padding:4px 9px;
  border-radius:999px;
  font-size:.75rem;
  background:#e5f2ff;
  color:#1e3a8a;
}
</style>

<section class="page-blog">

@php
  // Image du hero (fournie depuis le contrôleur ou fallback)
  $heroBannerImg = isset($heroBannerImg)
      ? $heroBannerImg
      : asset('img/placeholder-hero.png');
@endphp

{{-- HERO --}}

{{-- LISTE DES ARTICLES --}}
<div class="OO-wrap">
  <div class="container">

    <div class="OO-head">
      <div class="OO-kicker">Notre blog</div>
      <h2 class="OO-h1">Derniers articles et actualités</h2>
    </div>

    <div class="blog-layout">

      @if($blogs->count())
        {{-- ARTICLE MIS EN AVANT --}}
        @php $first = $blogs->first(); @endphp
        <article class="blog-feature">
          <div class="blog-feature-thumb">
            @if($first->image)
              <img src="{{ asset('storage/' . $first->image) }}" alt="{{ $first->title }}">
            @else
              <img src="{{ asset('img/blog-placeholder.jpg') }}" alt="{{ $first->title }}">
            @endif
            <div class="blog-feature-badge">Article à la une</div>
          </div>
          <div class="blog-feature-body">
            <div>
              <div class="blog-feature-meta">
                {{ $first->published_at ? \Carbon\Carbon::parse($first->published_at)->format('Y-m-d') : '—' }}
              </div>
              <h2 class="blog-feature-title">
                <a href="{{ route('blog.show', $first->slug) }}">
                  {{ $first->title }}
                </a>
              </h2>
              <p class="blog-feature-excerpt">
                {{ Str::limit(strip_tags($first->content), 230) }}
              </p>
            </div>
            <div class="blog-feature-footer">
              <a href="{{ route('blog.show', $first->slug) }}" class="btn-accent">
                Lire l’article
                <span>→</span>
              </a>
              <a href="{{ route('blog.show', $first->slug) }}" class="blog-feature-link">
                Voir les détails de l’article
              </a>
            </div>
          </div>
        </article>
      @endif

      {{-- LISTE DES AUTRES ARTICLES --}}
      @if($blogs->count() > 1)
        <div class="blog-list">
          @foreach($blogs as $blog)
            @if($loop->first)
              @continue
            @endif

            <article class="blog-item">
              <div class="blog-card">
                <div class="blog-card-thumb">
                  @if($blog->image)
                    <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}">
                  @else
                    <img src="{{ asset('img/blog-placeholder.jpg') }}" alt="{{ $blog->title }}">
                  @endif
                  <div class="blog-card-tag">Blog</div>
                </div>

                <div class="blog-card-body">
                  <h3 class="blog-card-title">
                    <a href="{{ route('blog.show', $blog->slug) }}">
                      {{ $blog->title }}
                    </a>
                  </h3>

                  <div class="blog-card-meta">
                    <span>{{ $blog->published_at ? \Carbon\Carbon::parse($blog->published_at)->format('Y-m-d') : '—' }}</span>
                    <span class="blog-card-meta-dot"></span>
                    <span>Lecture {{ max(2, ceil(str_word_count(strip_tags($blog->content)) / 200)) }} min</span>
                  </div>

                  <p class="blog-card-excerpt">
                    {{ Str::limit(strip_tags($blog->content), 130) }}
                  </p>
                </div>

                <div class="blog-card-footer">
                  <a href="{{ route('blog.show', $blog->slug) }}" class="blog-card-more">
                    Lire la suite <span>→</span>
                  </a>
                  <span class="badge-pill">Article</span>
                </div>
              </div>
            </article>
          @endforeach
        </div>
      @endif

    </div>

    <div class="mt-4 d-flex justify-content-center">
      {{ $blogs->links() }}
    </div>

  </div>
</div>

</section>
@endsection
