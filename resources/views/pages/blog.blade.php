@extends('layouts.app')
@php use Illuminate\Support\Str; @endphp

@section('title', 'Notre blog')

@section('content')
<style>
/* =========================================================
   Aisla Nova – Blog (same skin as Contact/About)
   Scoped to this page only.
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

/* ---------- HERO (identical pattern) ---------- */
.pb-hero{
  background:var(--navy); color:#fff; padding:78px 0 92px; position:relative;
}
.pb-hero .pb-hgroup{max-width:1100px;margin:0 auto;padding:0 12px}
.pb-title{font-size:56px;line-height:1.05;font-weight:800;margin:0 0 10px}
.pb-hero h1,.pb-hero .pb-title,.pb-hero p,.pb-hero .pb-sub{color:#fff !important}
.pb-sub{max-width:620px;font-size:15px;line-height:1.7;margin:0;opacity:.95}
@media (max-width:768px){.pb-title{font-size:40px}}

/* breadcrumb pill */
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
.pb-bread .home-ico{display:inline-grid;place-items:center;width:26px;height:26px;border-radius:50%;
  background:rgba(255,255,255,.22);color:#fff !important;font-size:12px}

/* ---------- Section head ---------- */
.pb-wrap{padding:70px 0 40px}
.pb-head{text-align:center;max-width:820px;margin:0 auto 26px}
.pb-kicker{color:var(--sky);font-weight:800;text-transform:uppercase;letter-spacing:.12em;font-size:.85rem}
.pb-h1{color:var(--ink);font-weight:800;line-height:1.14;margin:8px 0 0}

/* ---------- Blog grid ---------- */
.blog-grid{display:grid;grid-template-columns:repeat(12,1fr);gap:24px}
.blog-col{grid-column:span 4}
@media (max-width: 991.98px){.blog-col{grid-column:span 6}}
@media (max-width: 575.98px){.blog-col{grid-column:span 12}}

.card-blog{
  background:var(--card); border:1px solid #eef2f6; border-radius:18px; overflow:hidden;
  box-shadow:var(--shadow); height:100%; display:flex; flex-direction:column;
}
.card-blog .thumb{aspect-ratio: 16/10; background:#f2f4f8; overflow:hidden}
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
/* HERO Blog : bande bleue, image dessous, pas d'effet */
.pb-hero{
  position: relative;
  background: var(--navy, #242958);
  color: #fff;
  padding: 78px 0 92px;   /* hauteur du bandeau bleu */
  overflow: visible;      /* IMPORTANT : ne pas couper l'image qui déborde */
  z-index: 5;
}

/* Contrôle le “décrochage” de l’image sous le bleu */
.pb-hero--split{
  --pb-img-drop: 108px;              /* ajuste 40–100px selon ton rendu */
  margin-bottom: var(--pb-img-drop);/* évite que la section suivante chevauche l’image */
}

/* Texte au-dessus du bleu */
.pb-hero__inner{ position: relative; z-index: 3; }
.pb-hero .pb-title{ margin:0 0 6px; font-weight:800; font-size: clamp(34px, 5vw, 64px); }
.pb-hero .pb-sub{ max-width: 720px; opacity:.95; }

/* Couche bleue par-dessus l'image mais sous le texte */
.pb-hero::after{
  content:"";
  position:absolute; inset:0;
  background: var(--navy, #242958);
  z-index: 2;
  pointer-events:none;
}
/* Coins arrondis pour l'image du hero (Blog) */
.page-blog .pb-hero__media img{
  border-radius: 18px !important;  /* ajuste 12px, 18px, 24px... */
  box-shadow: none !important;     /* pas d’ombre */
  filter: none !important;
  transform: none !important;
}

/* L’image : sous la couche bleue, dépasse vers le bas, SANS effets */
.pb-hero__media{
  position: absolute;
  right: clamp(16px, 3vw, 40px);
  bottom: calc(-1 * var(--pb-img-drop));  /* la fait descendre sous la bande bleue */
  width: min(520px, 50vw);
  z-index: 1;                             /* sous la couche bleue */
}
.pb-hero__media img{
  display:block; width:100%; height:auto;
  border:0; border-radius:0 !important;
  box-shadow:none !important;
  filter:none !important;
  transform:none !important;              /* aucun effet */
}

/* Responsive */
@media (max-width: 992px){
  .pb-hero--split{ --pb-img-drop: 40px; }
  .pb-hero__media{ width: min(640px, 88vw); right: 12px; }
}

</style>

<section class="page-blog">

@php
  // Utilise $blogHeroImg si passé depuis le contrôleur, sinon un fallback
  $blogHeroImg = $blogHeroImg
      ?? (isset($banners) && $banners->count()
            ? (!empty($banners[0]->image) ? asset('storage/' . ltrim($banners[0]->image,'/')) : null)
            : null)
      ?? asset('img/ima.png'); // image par défaut
@endphp

{{-- HERO --}}
<header class="pb-hero pb-hero--split">
  <div class="container pb-hero__inner">
    <div class="pb-hero__copy">
      <h1 class="pb-title">Notre blog</h1>
      <p class="pb-sub">
        Derniers articles, conseils et actualités autour de la relation client et de l’efficacité opérationnelle.
      </p>
    </div>

    {{-- Image sous la zone bleue, qui peut dépasser en bas --}}
    <figure class="pb-hero__media">
      <img src="{{ $blogHeroImg }}" alt="Blog hero">
    </figure>
  </div>
</header>


  {{-- LIST --}}
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
