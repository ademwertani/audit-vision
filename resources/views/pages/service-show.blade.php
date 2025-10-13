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
/* ↑ Agrandir le titre et le sous-titre du hero (page service) */
.page-service .sv-title{
  font-size: clamp(40px, 6.5vw, 72px); /* max 72px sur desktop */
  line-height: 1.06;
  font-weight: 800;
}

.page-service .sv-sub{
  font-size: clamp(16px, 1.6vw, 20px); /* monte à ~20px sur desktop */
  line-height: 1.8;
  opacity: .98; /* un poil plus lisible */
}

/* Optionnel : encore plus gros sur très grands écrans */
@media (min-width: 1400px){
  .page-service .sv-title{ font-size: 78px; }
  .page-service .sv-sub{ font-size: 22px; }
}


/* “Split” : espace sous le hero pour loger l’image qui déborde */
.sv-hero--split{
  --sv-img-drop: 160px;          /* ↓ descend plus  ↑ remonte */
  margin-bottom: var(--sv-img-drop);
}

/* Texte au-dessus */
.sv-hero__inner{ position: relative; z-index: 3; }

/* Couche verte “au-dessus” de l’image */
.sv-hero::after{
  content:"";
  position:absolute; inset:0;
  background: var(--navy);
  z-index: 2;  /* au-dessus de l’image, sous le texte */
  pointer-events:none;
}

/* === HERO image: taille/position figées + 4 coins arrondis === */
.sv-hero__media{
  position: absolute;
  right: var(--sv-img-right, 24px);
  bottom: calc(-1 * var(--sv-img-drop, 160px));
  width: var(--sv-img-w, 560px);     /* ← largeur fixe (ou responsive via min()/clamp()) */
  height: var(--sv-img-h, 380px);    /* ← hauteur fixe */
  border-radius: var(--sv-img-radius, 22px); /* ← coins arrondis */
  overflow: hidden;                  /* ← masque dans les coins */
  background: transparent;           /* pas de fond */
  z-index: 1;                        /* sous le voile du hero (qui est en ::after z-index:2) */
}

/* L’image remplit le cadre, sans dépendre de sa taille d’origine */
.sv-hero__media img{
  width: 100%;
  height: 100%;
  display: block;
  object-fit: cover;                 /* plein cadre */
  border: 0;
  box-shadow: none !important;
  filter: none !important;
  transform: none !important;
}

/* Mobile : si tu veux la faire passer sous le texte */
@media (max-width: 992px){
  .sv-hero__media{
    position: static;
    width: 100%;
    height: var(--sv-img-h-mobile, 280px);
    right: auto;
    bottom: auto;
    margin-top: 18px;
  }
}

/* ---------- Breadcrumb pill (si tu l’utilises) ---------- */
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
  transform: translate(-52px, -11px) !important; /* +x = droite, -y = haut */
  will-change: transform;
}
/* --- FINAL OVERRIDES (place at the end) --- */

/* Use the variables you set on <header> to move the text */
.page-service .sv-hero__copy{
  position: relative;
  transform: translate(var(--sv-copy-x, 0), var(--sv-copy-y, 0)); /* x=right/left, y=up/down */
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
  font-size: clamp(44px, 6.5vw, 80px) !important;  /* increase max if needed */
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
  font-size: clamp(40px, 6.5vw, 58px) !important; /* ← augmente surtout la 1re (mobile) et la 3e (desktop) */
  line-height: 1.05 !important;
}

/* Sous-titre (summary) */
.page-service .sv-sub{
  font-size: clamp(18px, 1.8vw, 26px) !important; /* ← pareil : 18px (mobile), 26px (desktop) */
  line-height: 1.7 !important;
}


</style>

<section class="page-service">

@php
  $serviceHeroImg = !empty($service->image)
      ? asset('storage/' . ltrim($service->image, '/'))
      : asset('img/placeholder-hero.png'); // fallback si besoin
@endphp

{{-- HERO --}}
<header class="sv-hero sv-hero--split"
        style="
          /* ⇩⇩ Tu ajustes ici selon la page ⇩⇩ */
          --sv-img-drop: 280px;
          --sv-img-right: 24px;
          --sv-img-w: 660px;
          --sv-hero-pad: 190px;
        ">
  <div class="container sv-hero__inner">
    <div class="sv-hero__copy">
      <h1 class="sv-title">{{ $service->name }}</h1>
      @if(!empty($service->summary))
        <p class="sv-sub">{{ $service->summary }}</p>
      @endif
    </div>

    {{-- Image sous la zone verte, qui peut déborder en bas --}}
    <figure class="sv-hero__media">
      <img src="{{ $serviceHeroImg }}" alt="{{ $service->name }}">
    </figure>
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
  <img class="banner-bg" src="{{ asset('img/Group.png') }}" alt="" loading="lazy">

  <!-- Bloc texte + bouton alignés à droite -->
  <div class="sv-banner-right">
    <div class="sv-banner-copy">
      <h6 class="sv-banner-titlee">Prêt à démarrer ?</h6>
      <p class="sv-banner-subb">Parlez-nous de votre projet énergétique.</p>
    </div>

    <a href="{{ url('/contact') }}" class="sv-banner-ctaa" aria-label="Contactez-nous">
      <img src="{{ asset('img/btn-cta.png') }}" alt="Contactez-nous">
    </a>
  </div>
</div>

<style>
/* Contexte */
.sv-bottom-banner{ position: relative; overflow: hidden; }
.sv-bottom-banner .banner-bg{
  width: 100%; height: auto; display: block; object-fit: cover;
}

/* Wrapper à droite (texte au-dessus du bouton) */
.sv-banner-right{
  position: absolute;
  right: min(40vw, 200px);     /* ajustable */
  bottom: min(30vw, 208px);    /* position du bloc global */
  display: flex;
  flex-direction: column;      /* texte au-dessus du bouton */

  /* === MODIF: étirer pour que le bouton ait la même largeur que le texte === */
  align-items: stretch;

  gap: 10px;
  max-width: min(408ch, 420vw);/* évite un texte trop large */
  z-index: 20;
  --sv-space: 210px;           /* espace entre texte et bouton */
  gap: var(--sv-space);
}

/* === MODIF: le texte reste aligné à droite === */
.sv-banner-copy{
  text-align: right;
}

/* Texte */
.sv-banner-titlee{
  margin: 0;
  font-weight: 800;
  font-size: clamp(60px, 2.2vw, 28px);
  line-height: 1.15;
  color: #0f172a;
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
/* === MODIF: le bouton prend la même largeur que le texte, image collée à droite === */
.sv-banner-ctaa{
  display: flex;
  justify-content: flex-end;   /* pousse l'image à droite */
  align-self: stretch;         /* même largeur que le bloc texte */
  transform: translateY(0);
  transition: transform .15s ease, filter .15s ease;
}
.sv-banner-ctaa:hover{ transform: translateY(-2px); filter: brightness(1.02); }
.sv-banner-ctaa img{
  display: block;
  height: auto;
  max-width: clamp(140px, 18vw, 220px); /* taille responsive du bouton image */
  transform: translateX(-270px);
  
}

/* Mobile: centrer et remonter un peu */
@media (max-width: 575.98px){
  .sv-banner-right{
    right: 50%;
    transform: translateX(50%); /* centre horizontal */
    bottom: 16px;

    /* === MODIF: recentrer sur mobile === */
    align-items: center;

    text-align: center;
    max-width: 88%;
  }
  /* === MODIF: cibler les bonnes classes === */
  .sv-banner-titlee, .sv-banner-subb{ text-align: center; }

  /* === MODIF: sur mobile, bouton centré === */
  .sv-banner-ctaa{
    align-self: auto;
    justify-content: center;
      padding-right: var(--cta-shift);
  }
}

</style>


@endsection
