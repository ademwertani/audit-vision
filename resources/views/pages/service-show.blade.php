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
   France Isolation – Service Details (same skin as Contact/About/Blog/Projects)
   Styles scoped to this page only.
   ========================================================= */
.page-service{
  --navy:#7CAE2A;
  --navyDark:#7CAE2A;
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

/* ---------- HERO (split : texte + image qui dépasse) ---------- */
.sv-hero{
  position: relative;
  background: var(--navy);
  color:#fff;
  padding: var(--sv-hero-pad, 140px) 0;  /* hauteur bande verte */
  overflow: visible;                     /* ne pas couper l’image */
  z-index: 5;
}
/* ↑ Titre & sous-titre */
.page-service .sv-title{
  font-size: clamp(40px, 6.5vw, 72px);
  line-height: 1.06;
  font-weight: 800;
}
.page-service .sv-sub{
  font-size: clamp(16px, 1.6vw, 20px);
  line-height: 1.8;
  opacity: .98;
}

/* XXL */
@media (min-width: 1400px){
  .page-service .sv-title{ font-size: 78px; }
  .page-service .sv-sub{ font-size: 22px; }
}

/* “Split” : espace sous le hero pour loger l’image qui déborde */
.sv-hero--split{
  --sv-img-drop: 160px;
  margin-bottom: var(--sv-img-drop);
}

/* Texte au-dessus */
.sv-hero__inner{ position: relative; z-index: 3; }

/* Couche verte au-dessus de l’image (sous le texte) */
.sv-hero::after{
  content:"";
  position:absolute; inset:0;
  background: var(--navy);
  z-index: 2;
  pointer-events:none;
}

/* === HERO image === */
.sv-hero__media{
  position: absolute;
  right: var(--sv-img-right, 24px);
  bottom: calc(-1 * var(--sv-img-drop, 160px));
  width: var(--sv-img-w, 560px);
  height: var(--sv-img-h, 380px);
  border-radius: var(--sv-img-radius, 22px);
  overflow: hidden;
  background: transparent;
  z-index: 1;
}
.sv-hero__media img{
  width: 100%;
  height: 100%;
  display: block;
  object-fit: cover;
  border: 0;
  box-shadow: none !important;
  filter: none !important;
  transform: none !important;
}

/* ---------- CORRECTIONS MOBILE: supprimer le vide après header ---------- */
@media (max-width: 992px){
  /* 1) supprimer l’espace réservé du split */
  .sv-hero--split{ margin-bottom: 0 !important; }

  /* 2) compacter le hero */
  .sv-hero{ padding: 96px 0 24px !important; }

  /* 3) neutraliser les variables inline qui créent du vide */
  header.sv-hero{
    --sv-img-drop: 0 !important;
    --sv-img-right: 0 !important;
    --sv-hero-pad: 110px !important;
  }

  /* 4) l’image passe sous le texte, donc plus de décalage négatif */
  .sv-hero__media{
    position: static;
    width: 100%;
    height: var(--sv-img-h-mobile, 240px);
    right: auto;
    bottom: auto;
    margin-top: 12px;
  }
}

/* ---------- Breadcrumb pill ---------- */
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
.zoom-btn:hover{ filter:brightness(1.05) }
.lb-backdrop{position:fixed; inset:0; background:rgba(0,0,0,.75); display:none;
  z-index:1050; align-items:center; justify-content:center; padding:2rem}
.lb-backdrop.is-open{display:flex}
.lb-img{max-width:min(1200px,96vw); max-height:86vh; border-radius:14px; box-shadow:0 20px 60px rgba(0,0,0,.35)}
.lb-close{
  position:absolute; top:14px; right:16px; background:#fff; border:0; border-radius:999px;
  padding:.35rem .6rem; cursor:pointer; font-weight:700; color:#111;
}

/* --- Grande bannière en bas + bouton image --- */
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
  bottom:48px;
  transform:translateX(-50%);
  z-index:2;
  display:inline-block;
}
.sv-banner-cta img{
  display:block;
  width:clamp(120px, 22vw, 280px);
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
/* Police Epilogue */
@import url('https://fonts.googleapis.com/css2?family=Epilogue:wght@400;600;800&display=swap');

/* Appliquer Epilogue et garder le blanc */
.page-service .sv-title,
.page-service .sv-sub{
  font-family: "Epilogue", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
  color:#fff !important;
}

/* Décaler le bloc texte (un peu à droite et un peu vers le haut) */
.page-service .sv-hero__copy{
  position: relative;
  transform: translate(-52px, -11px) !important;
  will-change: transform;
}

/* Use variables on <header> */
.page-service .sv-hero__copy{
  position: relative;
  transform: translate(var(--sv-copy-x, 0), var(--sv-copy-y, 0));
  will-change: transform;
}

/* Force Epilogue + keep white */
@import url('https://fonts.googleapis.com/css2?family=Epilogue:wght@400;600;800&display=swap');
.page-service .sv-title,
.page-service .sv-sub{
  font-family: "Epilogue", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif !important;
  color:#fff !important;
}

/* Bigger sizes with high specificity */
.page-service .sv-title{
  font-size: clamp(44px, 6.5vw, 80px) !important;
  line-height: 1.05 !important;
  font-weight: 900 !important;
}
.page-service .sv-sub{
  font-size: clamp(18px, 1.8vw, 24px) !important;
  line-height: 1.7 !important;
  opacity: .98 !important;
}
/* Titre (h1) */
.page-service .sv-title{
  font-size: clamp(40px, 6.5vw, 58px) !important;
  line-height: 1.05 !important;
}
/* Sous-titre (summary) */
.page-service .sv-sub{
  font-size: clamp(18px, 1.8vw, 26px) !important;
  line-height: 1.7 !important;
}
/* Ajustement page-project si réutilisé */
.page-project .sv-title{
  font-size:clamp(24px,4.5vw,60px)!important; line-height:1.05!important; font-weight:900!important; margin:0 0 10px;
}
/* Variante sub */
.page-service .sv-sub{
  font-size: clamp(16px, 1.5vw, 22px) !important;
  line-height: 1.7 !important;
  opacity: .98 !important;
}

/* Assure que les variables de décalage s'appliquent */
.page-service .sv-hero__copy{
  position: relative;
  transform: translate(var(--sv-copy-x, 0), var(--sv-copy-y, 0)) !important;
  will-change: transform;
}

/* Bannière bas – texte */
.sv-banner-copy{ transform: translateY(6px); }
.sv-banner-subb{
  color:#fff !important;
  opacity: .95;
  transform: translateX(-14px);
  max-width: 40ch;
}

/* OVERRIDES bannière bas */
.sv-bottom-banner .sv-banner-subb{
  color: #192646 !important;
  transform: translateX(13px);
}
/* Bouton un peu plus à droite */
.sv-bottom-banner .sv-banner-ctaa img{
  transform: translateX(-150px);
}

/* Réserve "light" à droite pour éviter l’image */
.page-service .sv-hero--split .sv-hero__copy{
  position: relative;
  z-index: 3;
  --_rightPad: clamp(
    12px,
    calc(0.5 * var(--sv-img-w, 560px) + max(0px, var(--sv-img-right, 24px))),
    420px
  );
  padding-right: var(--_rightPad);
  max-width: calc(100% - var(--_rightPad));
  overflow-wrap: anywhere;
  word-break: break-word;
  hyphens: auto;
}
/* Sur mobile, on ne réserve rien */
@media (max-width: 992px){
  .page-service .sv-hero--split .sv-hero__copy{
    padding-right: 0;
    max-width: 100%;
  }
}
</style>

<section class="page-service">


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

{{-- Grande image en bas (avec vidéo ou image à gauche) --}}
<div class="container-fluid px-0 sv-bottom-banner">
  <img class="banner-bg" src="{{ asset('img/Group.png') }}" alt="" loading="lazy">

  @php
    $embed = method_exists($service,'getYoutubeEmbedAttribute') ? $service->youtube_embed : null;
    $slotImg = !empty($service->image) ? asset('storage/' . ltrim($service->image, '/')) : null;
  @endphp

  {{-- Slot gauche : vidéo si dispo, sinon image du service --}}
  @if($embed || $slotImg)
    <div class="sv-banner-slot-left">
      @if($embed)
        <div class="ratio-16x9">
          <iframe
            src="{{ $embed }}"
            title="Vidéo du service"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            allowfullscreen></iframe>
        </div>
      @else
        <div class="ratio-16x9 sv-slot-img">
          <img src="{{ $slotImg }}" alt="{{ $service->name }}">
        </div>
      @endif
    </div>
  @endif

  <!-- Bloc texte + bouton à droite (inchangé) -->
  <div class="sv-banner-right">
    <div class="sv-banner-copy">
      <h6 class="sv-banner-titlee">Prêt à démarrer ?</h6>
      <p class="sv-banner-subb">
        Dites-nous en plus sur votre projet d’isolation et vos objectifs :
        confort thermique, économies d’énergie, conformité ou rénovation globale.
        Nos experts vous orientent vers la solution la plus pertinente.
      </p>
    </div>

    <a href="{{ url('/contact') }}" class="sv-banner-ctaa" aria-label="Contactez-nous">
      <img src="{{ asset('img/cont.png') }}" alt="Contactez-nous">
    </a>
  </div>
</div>

<style>
/* Contexte bannière bas */
.sv-bottom-banner{ position: relative; overflow: hidden; }
.sv-bottom-banner .banner-bg{
  width: 100%; height: auto; display: block; object-fit: cover;
}

/* Wrapper à droite (texte au-dessus du bouton) */
.sv-banner-right{
  position: absolute;
  right: min(40vw, 200px);
  bottom: min(30vw, 208px);
  display: flex;
  flex-direction: column;
  align-items: stretch;
  gap: 10px;
  max-width: min(408ch, 420vw);
  z-index: 20;
  --sv-space: 210px;
  gap: var(--sv-space);
}

/* Texte */
.sv-banner-copy{
  text-align: right;
  transform: translateY(122px) !important; 
}
.sv-banner-titlee{
  margin: 0;
  font-weight: 800;
  font-size: clamp(60px, 2.2vw, 28px);
  line-height: 1.15;
  color: #ffffff;
  text-align: right;
}
.sv-banner-subb{
  margin: 2px 0 0 0;
  font-size: clamp(13px, 1.3vw, 16px);
  line-height: 1.4;
  color: #334155;
  text-align: right;
}

/* Bouton */
.sv-banner-ctaa{
  display: flex;
  justify-content: flex-end;
  align-self: stretch;
  transform: translateY(0);
  transition: transform .15s ease, filter .15s ease;
}
.sv-banner-ctaa:hover{ transform: translateY(-2px); filter: brightness(1.02); }
.sv-banner-ctaa img{
  display: block;
  height: auto;
  max-width: clamp(140px, 18vw, 220px);
  transform: translateX(-270px);
}

/* Mobile bannière: centrer */
@media (max-width: 575.98px){
  .sv-banner-right{
    right: 50%;
    transform: translateX(50%);
    bottom: 16px;
    align-items: center;
    text-align: center;
    max-width: 88%;
  }
  .sv-banner-titlee, .sv-banner-subb{ text-align: center; }
  .sv-banner-ctaa{
    align-self: auto;
    justify-content: center;
    padding-right: var(--cta-shift);
  }
}
</style>

@endsection
