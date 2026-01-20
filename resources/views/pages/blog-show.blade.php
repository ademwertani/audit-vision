@extends('layouts.app')

@section('title', $blog->title)

@section('content')
@php
  use Illuminate\Support\Str;
  use Illuminate\Support\Carbon;

  // Dates & reading time
  $publishedAt    = $blog->published_at ? Carbon::parse($blog->published_at) : null;

  // Share links
  $canonicalUrl = route('blog.show', $blog->slug);
  $encodedUrl   = urlencode($canonicalUrl);
  $encodedTitle = urlencode($blog->title);

  // Image hero (même image que l’article)
  $postHeroImg = !empty($blog->image)
      ? asset('storage/' . ltrim($blog->image, '/'))
      : asset('img/blog-placeholder.jpg');
@endphp
<style>
/* =========================================================
   PAGE ARTICLE – France Isolation (version animée)
   ========================================================= */
.page-post{
  --navy:#111827;
  --navySoft:#1f2937;
  --accent:#7CAE2A;
  --accentSoft:#bbf7d0;
  --muted:#6b7280;
  --border:#e5e7eb;
  --bg:#f3f4f6;
  --card:#ffffff;
  --shadow-card:0 18px 40px rgba(15,23,42,0.10);
  padding: 40px 0 80px;
  background: radial-gradient(circle at top left, #e5f0ff 0, #f9fafb 42%, #eef2ff 100%);
}
.page-post *{box-sizing:border-box}

/* ================== ANIMATIONS GLOBALES ================== */
@keyframes fadeSlideUp {
  from {
    opacity:0;
    transform:translateY(18px);
  }
  to {
    opacity:1;
    transform:translateY(0);
  }
}

@keyframes fadeSlideUpSoft {
  from {
    opacity:0;
    transform:translateY(10px);
  }
  to {
    opacity:1;
    transform:translateY(0);
  }
}

@keyframes glowPulse {
  0% {
    opacity:.55;
    transform:scale(1);
  }
  50% {
    opacity:.95;
    transform:scale(1.04);
  }
  100% {
    opacity:.55;
    transform:scale(1);
  }
}

/* Layout global */
.pp-shell{
  padding-top: 10px;
}
.pp-grid{
  /* une seule colonne pour que la carte prenne toute la largeur */
  display:block;
}

/* =========================================================
   COVER ARTICLE
   ========================================================= */
.pp-cover{
  position:relative;
  margin-bottom:28px;
  border-radius:26px;
  overflow:hidden;
  background:#020617;
  box-shadow:var(--shadow-card);
  isolation:isolate;

  /* animation d’entrée */
  animation: fadeSlideUp 0.75s cubic-bezier(0.21,0.79,0.29,0.99) forwards;
}
.pp-cover-media{
  position:relative;
  min-height:260px;
  max-height:420px;
  overflow:hidden;
}
.pp-cover-media img{
  width:100%;
  height:100%;
  object-fit:cover;
  display:block;
  transform:scale(1.02);
  transition:transform .9s ease-out, filter .9s ease-out;
}

/* halo + glow animé */
.pp-cover::before{
  content:"";
  position:absolute;
  inset:0;
  background:
    linear-gradient(135deg,
      rgba(15,23,42,0.96) 0%,
      rgba(15,23,42,0.86) 32%,
      rgba(15,23,42,0.40) 65%,
      rgba(15,23,42,0.10) 100%);
  z-index:1;
}
.pp-cover::after{
  content:"";
  position:absolute;
  inset:-20%;
  background:
    radial-gradient(140% 160% at -6% 0%,
      rgba(59,130,246,0.48) 0%,
      transparent 60%),
    radial-gradient(120% 140% at 115% 15%,
      rgba(124,174,42,0.55) 0%,
      transparent 55%);
  mix-blend-mode:soft-light;
  opacity:.9;
  z-index:1;
  pointer-events:none;

  /* lueur douce qui flotte en continu */
  animation: glowPulse 7s ease-in-out infinite alternate;
}

/* léger zoom/preview au survol */
.pp-cover:hover .pp-cover-media img{
  transform:scale(1.06) translateY(-4px);
  filter:brightness(1.07);
}

.pp-cover-inner{
  position:absolute;
  inset:0;
  z-index:2;
  display:flex;
  align-items:center;
  padding:26px 30px;
}
.pp-cover-panel{
  position:relative;
  max-width:650px;
  transform:translate(10px, -8px);
}
.pp-cover-panel::before{
  content:"";
  position:absolute;
  inset:-22px -34px -24px -34px;
  background:
    linear-gradient(135deg,
      rgba(15,23,42,0.96),
      rgba(15,23,42,0.86));
  border-radius:28px;
  backdrop-filter:blur(10px);
  -webkit-backdrop-filter:blur(10px);
  box-shadow:0 32px 90px rgba(15,23,42,0.80);
  z-index:-1;
}

/* Tag / meta sur la cover */
.pp-cover-kicker{
  letter-spacing:.18em;
  text-transform:uppercase;
  font-size:.75rem;
  font-weight:700;
  color:#bfdbfe;
  margin-bottom:8px;
}
.pp-cover-title{
  font-family:"Epilogue",system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;
  font-size: clamp(30px, 4.2vw, 52px);
  line-height:1.05;
  font-weight:900;
  color:#fff;
  margin:0 0 14px;
}
.pp-cover-sub{
  font-family:"Epilogue",system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;
  font-size:clamp(15px,1.4vw,19px);
  line-height:1.7;
  color:#e5e7eb;
  margin:0 0 10px;
}
.pp-cover-meta{
  display:flex;
  flex-wrap:wrap;
  gap:10px;
  align-items:center;
  font-size:.82rem;
  color:#cbd5f5;
  margin-top:6px;
}
.pp-cover-meta .dot::before{
  content:"•";
  opacity:.6;
  margin:0 6px;
}

/* =========================================================
   ARTICLE (full width)
   ========================================================= */
.pp-article{
  background:var(--card);
  border-radius:22px;
  padding:24px 26px 28px;
  box-shadow:0 14px 38px rgba(15,23,42,0.09);
  border:1px solid rgba(148,163,184,0.20);
  width:100%;

  /* animation d’entrée, légère */
  animation: fadeSlideUpSoft 0.7s ease-out 0.1s both;
}

/* en-tête dans la carte */
.pp-article-header h1{
  font-size:1.65rem;
  line-height:1.3;
  font-weight:800;
  color:var(--navy);
  margin:0 0 6px;
}
.pp-article-meta{
  display:flex;
  flex-wrap:wrap;
  gap:10px;
  align-items:center;
  font-size:.85rem;
  color:var(--muted);
}
.pp-article-meta .dot::before{
  content:"•";
  opacity:.6;
  margin:0 6px;
}

/* séparateurs */
.pp-divider{
  height:1px;
  background:linear-gradient(90deg,
    rgba(148,163,184,0.00) 0%,
    rgba(148,163,184,0.70) 25%,
    rgba(148,163,184,0.70) 75%,
    rgba(148,163,184,0.00) 100%);
  margin:18px 0 18px;
}

/* corps de l’article */
.pp-prose{
  font-size:1rem;
  line-height:1.8;
  color:#111827;
}
.pp-prose p{
  margin-bottom:1.15em;
}
.pp-prose h2,
.pp-prose h3{
  margin-top:1.7em;
  margin-bottom:.6em;
  font-weight:700;
  color:#0f172a;
}
.pp-prose ul,
.pp-prose ol{
  padding-left:1.2em;
  margin-bottom:1.15em;
}
.pp-prose li{
  margin-bottom:.35em;
}

/* =========================================================
   FOOTER ARTICLE – partage + lien
   ========================================================= */
.pp-article-footer{
  display:flex;
  flex-wrap:wrap;
  gap:16px;
  align-items:center;
  justify-content:space-between;
}
.pp-share-list{
  display:flex;
  flex-wrap:wrap;
  gap:8px;
}
.pp-share-btn{
  display:inline-flex;
  align-items:center;
  justify-content:center;
  padding:7px 12px;
  border-radius:999px;
  border:1px solid rgba(148,163,184,0.6);
  background:#f9fafb;
  font-size:.8rem;
  font-weight:500;
  color:#111827;
  text-decoration:none;
  transition:all .18s ease;
}
.pp-share-btn:hover{
  background:#111827;
  color:#f9fafb;
  border-color:#111827;
  transform:translateY(-2px) scale(1.02);
  box-shadow:0 10px 22px rgba(15,23,42,0.18);
}
.pp-link-small{
  font-size:.8rem;
  color:var(--muted);
}
.pp-link-small a{
  color:#1d4ed8;
  text-decoration:none;
  word-break:break-all;
}
.pp-link-small a:hover{
  text-decoration:underline;
}

/* =========================================================
   SIDEBAR (en dessous, animée aussi)
   ========================================================= */
.pp-sidebar{
  position:relative;
  margin-top:24px;
}
.pp-sidebar-inner{
  animation: fadeSlideUpSoft 0.7s ease-out 0.2s both;
}
.pp-card,
.pp-nav-card{
  background:var(--card);
  border-radius:20px;
  padding:18px 18px 16px;
  border:1px solid rgba(148,163,184,0.28);
  box-shadow:0 12px 32px rgba(15,23,42,0.06);
  margin-bottom:18px;
  transition:transform .18s ease, box-shadow .18s ease, border-color .18s ease;
}
.pp-card:hover,
.pp-nav-card:hover{
  transform:translateY(-2px);
  box-shadow:0 18px 38px rgba(15,23,42,0.12);
  border-color:rgba(129,140,248,0.85);
}
.pp-card-title,
.pp-nav-card-title{
  font-size:.95rem;
  font-weight:700;
  letter-spacing:.08em;
  text-transform:uppercase;
  color:#6b7280;
  margin-bottom:10px;
}
.pp-card-line{
  font-size:.9rem;
  color:#111827;
  margin-bottom:8px;
}
.pp-card-line span{
  font-size:.8rem;
  color:#6b7280;
}

/* navigation précédent / suivant */
.pp-nav-list{
  display:flex;
  flex-direction:column;
  gap:10px;
}
.pp-nav-link{
  display:flex;
  flex-direction:column;
  gap:4px;
  padding:10px 12px;
  border-radius:14px;
  background:#f9fafb;
  border:1px solid transparent;
  text-decoration:none;
  transition:all .18s ease;
}
.pp-nav-link span:last-child{
  font-size:.9rem;
  color:#111827;
}
.badge-dir{
  display:inline-flex;
  padding:3px 9px;
  border-radius:999px;
  font-size:.7rem;
  text-transform:uppercase;
  letter-spacing:.12em;
  background:#e5f2ff;
  color:#1e3a8a;
}
.pp-nav-link:hover{
  border-color:#93c5fd;
  background:#eff6ff;
  transform:translateY(-2px);
}

/* Responsif */
@media (max-width: 575.98px){
  .page-post{
    padding:24px 0 48px;
  }
  .pp-article{
    padding:18px 16px 22px;
  }
  .pp-cover-inner{
    padding:20px 18px;
  }
  .pp-cover-panel::before{
    inset:-16px -16px -16px -16px;
  }
}
</style>


<section class="page-post">

  {{-- COVER AVEC L’IMAGE DE L’ARTICLE --}}
  <div class="container">
    <div class="pp-cover">
      <div class="pp-cover-media">
        <img src="{{ $postHeroImg }}" alt="{{ $blog->title }}">
      </div>
      <div class="pp-cover-inner">
        <div class="pp-cover-panel">
          <div class="pp-cover-kicker">Article de blog</div>
          <h1 class="pp-cover-title">{{ $blog->title }}</h1>

          @if($blog->excerpt ?? false)
            <p class="pp-cover-sub">{{ $blog->excerpt }}</p>
          @else
            <p class="pp-cover-sub">
              Derniers articles, conseils et actualités autour de la relation client
              et de l’efficacité opérationnelle.
            </p>
          @endif

          
        </div>
      </div>
    </div>
  </div>

  {{-- CONTENU + SIDEBAR --}}
  <div class="pp-shell">
    <div class="container">
      <div class="pp-grid">

        {{-- Colonne article --}}
        <article class="pp-article">

          {{-- petit header dans la carte (facultatif mais cohérent) --}}
          <header class="pp-article-header">
            <h1>{{ $blog->title }}</h1>

            
          </header>

          <div class="pp-divider"></div>

          {{-- Contenu de l’article 
               ⚠️ Si ton contenu contient déjà du HTML, remplace par: {!! $blog->content !!} --}}
          <div class="pp-prose">
            {!! nl2br(e($blog->content)) !!}
          </div>

          <div class="pp-divider"></div>

          {{-- Footer article : partage + lien canonique --}}
          <div class="pp-article-footer">
            <div class="pp-share-list">
              <a class="pp-share-btn"
                 href="https://www.facebook.com/sharer/sharer.php?u={{ $encodedUrl }}"
                 target="_blank" rel="noopener">
                <span>Facebook</span>
              </a>
              <a class="pp-share-btn"
                 href="https://twitter.com/intent/tweet?url={{ $encodedUrl }}&text={{ $encodedTitle }}"
                 target="_blank" rel="noopener">
                <span>X / Twitter</span>
              </a>
              <a class="pp-share-btn"
                 href="https://www.linkedin.com/sharing/share-offsite/?url={{ $encodedUrl }}"
                 target="_blank" rel="noopener">
                <span>LinkedIn</span>
              </a>
              <a class="pp-share-btn"
                 href="https://api.whatsapp.com/send?text={{ $encodedTitle }}%20{{ $encodedUrl }}"
                 target="_blank" rel="noopener">
                <span>WhatsApp</span>
              </a>
            </div>

           
          </div>
        </article>

        {{-- SIDEBAR --}}
        <aside class="pp-sidebar">
          <div class="pp-sidebar-inner">

           

            {{-- Carte navigation précédent / suivant --}}
            @if(!empty($prev) || !empty($next))
              <div class="pp-nav-card">
                <div class="pp-nav-card-title">Navigation</div>
                <div class="pp-nav-list">
                  @if(!empty($prev))
                    <a href="{{ route('blog.show', $prev->slug) }}" class="pp-nav-link">
                      <span class="badge-dir">Précédent</span>
                      <span>{{ Str::limit($prev->title, 70) }}</span>
                    </a>
                  @endif

                  @if(!empty($next))
                    <a href="{{ route('blog.show', $next->slug) }}" class="pp-nav-link">
                      <span class="badge-dir">Suivant</span>
                      <span>{{ Str::limit($next->title, 70) }}</span>
                    </a>
                  @endif
                </div>
              </div>
            @endif

          </div>
        </aside>

      </div>
    </div>
  </div>

</section>
@endsection
