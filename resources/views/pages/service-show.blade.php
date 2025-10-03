@extends('layouts.app')

@section('title', $service->name . ' | Nos services')

@section('content')
@php
  // Resolve image source robustly
  $img = $service->image ?? null;
  if ($img) {
      $src = \Illuminate\Support\Str::startsWith($img, ['http://','https://','/','storage/'])
            ? $img
            : 'storage/'.$img;
  } else {
      $src = null;
  }
@endphp

<style>
/* =========================================================
   Aisla Nova – Service Details (same skin as Contact/About/Blog/Projects)
   Styles scoped to this page only.
   ========================================================= */
.page-service{
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
.page-service *{box-sizing:border-box}

/* ---------- HERO (left-aligned + long pill breadcrumb) ---------- */
.sv-hero{
  background:var(--navy); color:#fff; padding:78px 0 92px; position:relative;
}
.sv-hero .sv-hgroup{max-width:1100px;margin:0 auto;padding:0 12px}
.sv-title{font-size:48px;line-height:1.08;font-weight:800;margin:0 0 10px}
@media (min-width:992px){ .sv-title{font-size:56px} }
.sv-hero h1,.sv-hero .sv-title,.sv-hero p,.sv-hero .sv-sub{color:#fff !important}
.sv-sub{max-width:680px;font-size:15px;line-height:1.7;margin:0;opacity:.95}

/* breadcrumb pill */
.sv-bread-wrap{position:absolute;left:0;right:0;bottom:-28px;display:flex;justify-content:center}
.sv-bread{
  width:min(1180px, calc(100% - 48px));
  background:var(--sky); height:46px; border-radius:9999px;
  display:flex; align-items:center; gap:18px; padding:0 22px;
  font-weight:700; box-shadow:0 10px 18px rgba(3,102,140,.12);
  color:#fff !important;
}
.sv-bread a,.sv-bread span{color:#fff !important}
.sv-bread .sep{color:rgba(255,255,255,.85) !important}
.sv-bread .home-ico{display:inline-grid;place-items:center;width:26px;height:26px;border-radius:50%;
  background:rgba(255,255,255,.22);color:#fff !important;font-size:12px}

/* ---------- Content ---------- */
.sv-wrap{padding:70px 0 60px}
.sv-grid{display:grid;grid-template-columns:1.05fr .95fr;gap:28px;align-items:start}
@media (max-width: 991.98px){ .sv-grid{grid-template-columns:1fr} }

/* Media card + lightbox */
.media-card{
  background:var(--card); border:1px solid #eef2f6; border-radius:18px; overflow:hidden;
  box-shadow:var(--shadow); position:relative;
}
.media-thumb{aspect-ratio: 4/3; background:#f2f4f8}
.media-thumb img{width:100%;height:100%;object-fit:cover;display:block}
.media-placeholder{display:grid;place-items:center;aspect-ratio:4/3;background:#f8fafc;color:#94a3b8}
.zoom-btn{
  position:absolute; right:12px; bottom:12px;
  background:rgba(13,42,134,.9); color:#fff; border:0; border-radius:999px;
  padding:.5rem .7rem; line-height:1; display:flex; align-items:center; gap:6px; cursor:pointer;
}
/* --- Bottom full-bleed banner --- */
.sv-bottom-banner{ margin: 40px 0 0; }
.sv-bottom-banner img{
  width:100%;
  height:clamp(220px, 45vw, 560px); /* responsive */
  object-fit:cover;
  display:block;
}

.zoom-btn:hover{ filter:brightness(1.05) }
.lb-backdrop{position:fixed; inset:0; background:rgba(0,0,0,.75); display:none;
  z-index:1050; align-items:center; justify-content:center; padding:2rem}
.lb-backdrop.is-open{display:flex}
.lb-img{max-width:min(1200px,96vw); max-height:86vh; border-radius:14px; box-shadow:0 20px 60px rgba(0,0,0,.35)}
.lb-close{
  position:absolute; top:14px; right:16px; background:#fff; border:0; border-radius:999px;
  padding:.35rem .6rem; cursor:pointer; font-weight:700; color:#111;
}
/* --- Bouton image centré en bas sur la grande image --- */
.sv-bottom-banner{ position: relative; margin: 40px 0 0; }
.sv-bottom-banner .banner-bg{
  width:100%;
  height:clamp(220px, 45vw, 560px);
  object-fit:cover;
  display:block;
}
.sv-banner-cta{
  position:absolute;
  left:50%;
  bottom:48px;                 /* distance du bas */
  transform:translateX(-50%);
  z-index:2;
  display:inline-block;
}
.sv-banner-cta img{
  display:block;
  width:clamp(120px, 22vw, 280px);   /* taille responsive du bouton */
  height:auto;
  filter: drop-shadow(0 8px 22px rgba(0,0,0,.25));
}
.sv-banner-cta:hover img{ transform:scale(1.02); }

/* Text card */
.sv-body-card{
  background:var(--card); border:1px solid #eef2f6; border-radius:18px;
  box-shadow:var(--shadow); padding:22px;
}
@media (min-width:992px){ .sv-body-card{ padding:28px } }
.sv-h2{font-weight:800;color:#0f172a;margin:0 0 8px}
.sv-lead{color:#0ea5e9;margin:0 0 12px;font-weight:700}
.prose{ color:#1f2937; line-height:1.75; font-size:1.05rem }
.prose p{ margin-bottom:1rem }
.meta{ font-size:.95rem; color:#6b7280; }

/* Buttons (consistent with site) */
.btn-accent{
  background:var(--accent); color:#fff; border:none; font-weight:800;
  padding:12px 18px; border-radius:14px; 
}
.btn-accent:hover{ filter:brightness(0.98) }
.btn-outline-accent{
  background:#fff; color:#0f1e3d; border:1px solid #dbe4f0; font-weight:700;
  padding:12px 18px; border-radius:14px;
}
.btn-outline-accent:hover{ background:#f8fafc }
</style>

<section class="page-service">

  {{-- HERO --}}
  <header class="sv-hero">
    <div class="sv-hgroup container">
      <h1 class="sv-title">{{ $service->name }}</h1>
      @if(!empty($service->summary))
        <p class="sv-sub">{{ $service->summary }}</p>
      @endif
    </div>

    {{-- Long rounded breadcrumb pill --}}
    <div class="sv-bread-wrap">
      <div class="sv-bread">
        <span class="home-ico"><i class="fa fa-home"></i></span>
        <a href="{{ url('/') }}">Accueil</a>
        <span class="sep">|</span>
        <a href="{{ route('services.index') }}">Services</a>
        <span class="sep">|</span>
        <span>{{ \Illuminate\Support\Str::limit($service->name, 60) }}</span>
      </div>
    </div>
  </header>

  {{-- DETAILS --}}
  <section class="sv-wrap">
    <div class="container">
      <div class="sv-grid">

        {{-- LEFT: Media --}}
        <div>
          <div class="media-card">
            @if($src)
              <figure class="media-thumb">
                <img src="{{ asset($src) }}" alt="{{ $service->name }}" loading="lazy">
              </figure>
              <button class="zoom-btn" type="button" id="openLightbox" aria-label="Agrandir l’image">
                <i class="fa fa-search-plus"></i><span>Zoom</span>
              </button>
            @else
              <div class="media-placeholder">
                <i class="fa fa-image fa-3x"></i>
                <span class="visually-hidden">Aucune image disponible</span>
              </div>
            @endif
          </div>

          @if(!empty($service->updated_at))
            <div class="meta mt-2">
              Mis à jour le {{ $service->updated_at->format('d/m/Y') }}
            </div>
          @endif
        </div>

        {{-- RIGHT: Content --}}
        <div class="sv-body-card">
          <h2 class="sv-h2">{{ $service->name }}</h2>
          @if(!empty($service->summary))
            <h5 class="sv-lead">{{ $service->summary }}</h5>
          @endif

          @if(!empty($service->description))
            <div class="prose mb-3">
              {!! nl2br(e($service->description)) !!}
            </div>
          @endif

          <div class="d-flex flex-wrap align-items-center gap-2 pt-2">
            <a href="{{ url('/contact') }}" class="btn btn-accent">
              <i class="fas fa-phone-alt me-2"></i> Contactez-nous
            </a>
            <a href="{{ route('services.index') }}" class="btn btn-outline-accent">
              <i class="fas fa-arrow-left me-2"></i> Retour aux services
            </a>
          </div>
        </div>

      </div>
    </div>
  </section>

  {{-- Lightbox --}}
  @if($src)
    <div class="lb-backdrop" id="lightbox" aria-modal="true" role="dialog">
      <button class="lb-close" id="closeLightbox" aria-label="Fermer">×</button>
      <img src="{{ asset($src) }}" alt="{{ $service->name }}" class="lb-img">
    </div>
  @endif

</section>

{{-- Minimal JS for the lightbox (only if image exists) --}}
@if($src)
<script>
  (function(){
    const open = document.getElementById('openLightbox');
    const lb   = document.getElementById('lightbox');
    const close= document.getElementById('closeLightbox');
    if(!open || !lb || !close) return;
    open.addEventListener('click', ()=> lb.classList.add('is-open'));
    close.addEventListener('click', ()=> lb.classList.remove('is-open'));
    lb.addEventListener('click', (e)=>{ if(e.target === lb) lb.classList.remove('is-open'); });
    document.addEventListener('keydown', (e)=>{ if(e.key === 'Escape') lb.classList.remove('is-open'); });
  })();
</script>
@endif
{{-- Grande image en bas (depuis /public/img) --}}
<div class="container-fluid px-0 sv-bottom-banner">
  <img class="banner-bg" src="{{ asset('img/greenn.png') }}" alt="" loading="lazy">

  {{-- Bouton sous forme d'image, centré en bas (cliquable) --}}
  <a href="{{ url('/contact') }}" class="sv-banner-cta" aria-label="Contactez-nous">
    <img src="{{ asset('img/btn-cta.png') }}" alt="Contactez-nous">
  </a>
</div>


@endsection
