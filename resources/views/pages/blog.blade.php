@extends('layouts.app')
@php use Illuminate\Support\Str; @endphp

@section('title', 'Notre blog')

@section('content')
<style>
/* =========================================================
   France Isolation – Blog (même skin Contact/About)
   Styles SCOPÉS à .page-blog
   ========================================================= */
.page-blog{
  --navy:#242958;
  --navyDark:#1d2760;
  --sky:#7CAE2A;
  --accent:#7CAE2A;
  --ink:#0f172a;
  --muted:#6b7280;
  --card:#ffffff;
  --ring:#dbe6ff;
  --shadow-lg:0 24px 48px rgba(16,24,40,.12);
  --shadow:0 10px 18px rgba(0,0,0,.08);
}
.page-blog *{box-sizing:border-box}

/* ---------- TYPO (Epilogue pour le hero) ---------- */
@import url('https://fonts.googleapis.com/css2?family=Epilogue:wght@400;600;800;900&display=swap');
.page-blog .pb-title,
.page-blog .pb-sub{
  font-family: "Epilogue", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif !important;
  color:#fff !important;
}

/* =========================================================
   HERO Blog : bande bleue + image en cadre fixe (split)
   ========================================================= */
.pb-hero{
  position: relative;
  background: var(--navy, #242958);
  color:#fff;
  padding: var(--pb-hero-pad, 180px) 0;   /* ← hauteur du bandeau bleu (modifiable) */
  overflow: visible;                      /* laisse dépasser l’image */
  z-index: 5;
}
/* voile bleu au-dessus de l’image, sous le texte */
.pb-hero::after{
  content:""; position:absolute; inset:0;
  background: var(--navy, #242958);
  z-index: 2; pointer-events:none;
}

/* décrochage vertical de l'image (descente sous le bleu) */
.pb-hero--split{
  --pb-img-drop: 260px;        /* ← descend l’image (modifiable) */
  margin-bottom: var(--pb-img-drop);
}

/* contenu texte au-dessus du bleu */
.pb-hero__inner{ position: relative; z-index: 3; }
.pb-hero__copy{
  position: relative;
  transform: translate(var(--pb-copy-x, 8px), var(--pb-copy-y, -8px)); /* micro-ajustements */
  will-change: transform;
}

/* tailles de titre/sous-titre */
.pb-title{
  font-size: clamp(44px, 6.5vw, 80px);
  line-height: 1.05;
  font-weight: 900;
  margin: 0 0 10px;
}
.pb-sub{
  font-size: clamp(18px, 1.8vw, 24px);
  line-height: 1.7;
  opacity: .98;
  margin: 0;
}

/* IMAGE : cadre fixe + coins arrondis + cover */
.pb-hero__media{
  position: absolute;
  right: var(--pb-img-right, 24px);
  bottom: calc(-1 * var(--pb-img-drop, 260px));
  width: var(--pb-img-w, 620px);     /* ← largeur du cadre (modifiable) */
  height: var(--pb-img-h, 390px);    /* ← hauteur du cadre (modifiable) */
  border-radius: var(--pb-img-radius, 22px);
  overflow: hidden;
  background: transparent;
  z-index: 1; /* sous le voile */
}
.pb-hero__media img{
  width: 100%; height: 100%;
  object-fit: cover; object-position: center;
  display:block; border:0;
  box-shadow:none !important; filter:none !important; transform:none !important;
}

/* Breadcrumb pilule (comme Projets/About/Contact) */
.pb-bread-wrap{position:absolute;left:0;right:0;bottom:-28px;display:flex;justify-content:center}
.pb-bread{
  width:min(1180px, calc(100% - 48px));
  background:var(--sky); height:46px; border-radius:9999px;
  display:flex; align-items:center; gap:18px; padding:0 22px;
  font-weight:700; box-shadow:0 10px 18px rgba(3,102,140,.12);
  color:#fff !important;
}
.pb-bread a,.pb-bread span{color:#fff !important}
.pb-bread .sep{color:rgba(255,255,255,.85) !important}
.pb-bread .home-ico{
  display:inline-grid; place-items:center; width:26px; height:26px; border-radius:50%;
  background:rgba(255,255,255,.22); color:#fff !important; font-size:12px;
}

/* Responsive hero */
@media (min-width: 1400px){
  .pb-hero__media{
    width: var(--pb-img-w-xl, 680px);
    height: var(--pb-img-h-xl, 440px);
    right: var(--pb-img-right-xl, 40px);
  }
}
@media (max-width: 992px){
  .pb-hero--split{ --pb-img-drop: 40px; }
  .pb-hero__media{
    position: static; right:auto; bottom:auto;
    width: 100%;
    height: var(--pb-img-h-mobile, 280px); /* hauteur fixe mobile */
    margin-top: 18px;
  }
}

/* =========================================================
   Section head + grille des cartes
   ========================================================= */
.pb-wrap{padding:70px 0 40px}
.pb-head{text-align:center;max-width:820px;margin:0 auto 26px}
.pb-kicker{color:var(--sky);font-weight:800;text-transform:uppercase;letter-spacing:.12em;font-size:.85rem}
.pb-h1{color:var(--ink);font-weight:800;line-height:1.14;margin:8px 0 0}

.blog-grid{display:grid;grid-template-columns:repeat(12,1fr);gap:24px}
.blog-col{grid-column:span 4}
@media (max-width: 991.98px){.blog-col{grid-column:span 6}}
@media (max-width: 575.98px){.blog-col{grid-column:span 12}}

.card-blog{
  background:var(--card); border:1px solid #eef2f6; border-radius:18px; overflow:hidden;
  box-shadow:var(--shadow); height:100%; display:flex; flex-direction:column;
}
.card-blog .thumb{aspect-ratio:16/10; background:#f2f4f8; overflow:hidden}
.card-blog .thumb img{width:100%;height:100%;object-fit:cover;display:block}
.card-body{padding:18px 18px 14px}
.card-title{font-size:1.125rem;font-weight:800;color:#0f172a;margin:0 0 8px}
.card-meta{font-size:.9rem;color:#64748b;margin-bottom:8px}
.card-excerpt{color:#475569;margin:0}
.card-footer{display:flex;align-items:center;justify-content:flex-start;padding:0 18px 18px}
.btn-accent{
  background:var(--accent); color:#fff; border:none; font-weight:800;
  padding:10px 16px; border-radius:14px;
}
.btn-accent:hover{filter:brightness(.98)}
/* FORCE OVERRIDE : taille/position de l'image du hero */
.page-blog header.pb-hero .pb-hero__media{
  width: var(--pb-img-w, 620px) !important;
  height: var(--pb-img-h, 390px) !important;
  right: var(--pb-img-right, 24px) !important;
  bottom: calc(-1 * var(--pb-img-drop, 260px)) !important;
}

.page-blog header.pb-hero .pb-hero__media img{
  width: 100% !important;
  height: 100% !important;
  object-fit: cover !important;
  object-position: center !important;
}
/* =====================================================
   📱 MOBILE — Réduire et déplacer l'image du hero blog
   ===================================================== */
@media (max-width: 575.98px) {

    /* Réduire la taille de l'image */
    .pb-hero__media img {
        width: 70% !important;    /* ⇦ diminue la taille de l'image */
        max-width: 70% !important;
    }

    /* Décaler l'image vers la gauche */
    .pb-hero__media {
        transform: translateX(-20px) !important; /* ⇦ valeur à modifier si tu veux plus gauche */
    }
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
<header class="pb-hero pb-hero--split"
        style="
          --pb-hero-pad: 180px;
          --pb-img-drop: 240px;  /* plus bas si tu veux 260–300 */

          /* ↓ PLUS PETITE */
          --pb-img-w: 600px;
          --pb-img-h: 380px;

          /* ↓ PLUS À DROITE (proche du bord) */
          --pb-img-right: 7px;

          --pb-img-radius: 22px;
          --pb-copy-x: 8px;
          --pb-copy-y: -8px;
        ">

  <div class="container pb-hero__inner">
    <div class="pb-hero__copy">
      <h1 class="pb-title">Notre blog</h1>
      <p class="pb-sub">Derniers articles, conseils et actualités <br>autour de la relation client et de l’efficacité opérationnelle.</p>
    </div>

    <figure class="pb-hero__media">
      <img src="{{ $heroBannerImg }}" alt="Blog hero">
    </figure>
  </div>
</header>

{{-- LISTE DES ARTICLES --}}
<div class="pb-wrap">
  <div class="container">

    <div class="pb-head">
      <div class="pb-kicker">Notre blog</div>
      <h2 class="pb-h1">Derniers articles et actualités</h2>
    </div>

    <div class="blog-grid">
      @foreach($blogs as $blog)
        <article class="blog-col">
          <div class="card-blog">
            @if($blog->image)
              <div class="thumb">
                <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}">
              </div>
            @endif

            <div class="card-body">
              <h3 class="card-title">{{ $blog->title }}</h3>
              <div class="card-meta">
                {{ $blog->published_at ? \Carbon\Carbon::parse($blog->published_at)->format('Y-m-d') : '' }}
              </div>
              <p class="card-excerpt">{{ Str::limit(strip_tags($blog->content), 140) }}</p>
            </div>

            <div class="card-footer">
              <a href="{{ route('blog.show', $blog->slug) }}" class="btn btn-accent">Lire la suite</a>
            </div>
          </div>
        </article>
      @endforeach
    </div>

    <div class="mt-4 d-flex justify-content-center">
      {{ $blogs->links() }}
    </div>

  </div>
</div>

</section>
@endsection
