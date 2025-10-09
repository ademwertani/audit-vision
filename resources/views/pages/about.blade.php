@extends('layouts.app')

@section('title', $about->heading ?? 'À propos de nous')

@section('content')
<style>
/* =========================================================
   Aisla Nova – Page shell (same skin as Contact page)
   Scoped so it won't leak elsewhere.
   ========================================================= */
.page-about{
  --navy:#242958;
  --navyDark:#1d2760;
  --sky:#31b4eb;
  --accent:#7CAE2A;
  --ink:#0f172a;
  --muted:#6b7280;
  --field:#f5f7fb;
  --ring:#dbe6ff;
  --card:#ffffff;
  --shadow:0 20px 40px rgba(16,24,40,.08);
}
.page-about *{box-sizing:border-box}

/* ---------- HERO (identical to contact page) ---------- */

.pa-hero .pa-hgroup{max-width:1100px;margin:0 auto;padding:0 12px}
.pa-title{font-size:80px;line-height:2.05;font-weight:800;margin:0 0 10px}
.pa-hero h1,.pa-hero .pa-title,.pa-hero p,.pa-hero .pa-sub{color:#ffffff !important}
.pa-sub{max-width:620px;font-size:15px;line-height:1.7;margin:0;opacity:.95}
@media (max-width:768px){.pa-title{font-size:40px}}

/* breadcrumb pill */
.pa-bread-wrap{position:absolute;left:0;right:0;bottom:-28px;display:flex;justify-content:center}
.pa-bread{
  width:min(1180px, calc(100% - 48px));
  background:var(--sky);
  height:46px;border-radius:9999px;display:flex;align-items:center;gap:18px;
  padding:0 22px;font-weight:700;box-shadow:0 10px 18px rgba(3,102,140,.12);
  color:#fff !important;
}
.pa-bread a,.pa-bread span{color:#fff !important}
.pa-bread .sep{color:rgba(255,255,255,.85) !important}
.pa-bread .home-ico{display:inline-grid;place-items:center;width:26px;height:26px;border-radius:50%;
  background:rgba(255,255,255,.22);color:#fff !important;font-size:12px}

/* ---------- HEADINGS + buttons ---------- */
.pa-kicker{color:var(--sky);font-weight:800;text-transform:uppercase;letter-spacing:.12em;font-size:.85rem}
.pa-h1{color:var(--ink);font-weight:800;line-height:1.14;margin:8px 0 0}
.btn-accent{background:var(--accent);border:none;color:#fff;font-weight:800;padding:14px 22px;border-radius:14px;
  ;transition:.2s}
.btn-accent:hover{transform:translateY(-1px);filter:brightness(.98)}

/* ---------- Metrics (replaces bg-secondary strip) ---------- */
.metrics{padding:64px 0 48px}
.metric-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:18px}
@media (max-width:991.98px){.metric-grid{grid-template-columns:repeat(2,1fr)}}
@media (max-width:575.98px){.metric-grid{grid-template-columns:1fr}}
.metric-card{background:var(--card);border:1px solid #eef2f6;border-radius:18px;box-shadow:0 10px 18px rgba(0,0,0,.04);
  padding:22px;display:flex;align-items:center;gap:14px}
.metric-num{font-size:36px;font-weight:800;color:var(--sky);margin:0}
.metric-label{margin:0;color:#334155;font-weight:700}

/* ---------- About section ---------- */
.about-wrap{padding:56px 0}
.about-imgs{position:relative;height:100%}
.about-imgs .img-a{width:75%;border-radius:16px;box-shadow:var(--shadow);margin-bottom:25%}
.about-imgs .img-b{position:absolute;top:25%;left:25%;width:75%;border-radius:16px;box-shadow:var(--shadow)}
.about-text p{color:#475569}
.about-text h1{font-weight:800}
/* ---------- VALUES (Our Values) ---------- */
.values-wrap{ padding: 42px 0 64px; background:#fbfbfb; }
.values-head .kicker{
  color:#7CAE2A; font-weight:800; letter-spacing:.12em; text-transform:uppercase; font-size:.9rem;
}
.values-title{
  margin: 6px 0 20px; line-height:1.05; font-weight:800;
  font-size: clamp(32px, 4.2vw, 64px);
  color:#0f172a;
}
.values-title .accent{ color:#7CAE2A; display:block; }
.values-img{
  width:100%; border-radius:28px; box-shadow:0 20px 40px rgba(16,24,40,.08);
  display:block; margin-top:20px;
  object-fit:cover; max-height:520px;
}

/* liste de 3 valeurs à droite */
.value-list{ display:flex; flex-direction:column; gap:46px; }
.value-item{ display:grid; grid-template-columns:92px 1fr; align-items:center; column-gap:18px; }

.value-ico{
  width:92px; height:92px; border-radius:50%;
  display:grid; place-items:center;
  background:#ffffff; border:1px solid #e8eef6; box-shadow:0 12px 24px rgba(0,0,0,.05);
  position:relative; isolation:isolate;
}
.value-ico::after{               /* pastille verte derrière l’icône */
  content:""; position:absolute; inset:10px;
  background:#7CAE2A; border-radius:50%; z-index:-1; opacity:.15;
}
.value-ico i{ font-size:34px; color:#1f2a5a; }   /* icône FA */

.value-title{ margin:0 0 6px; font-weight:800; letter-spacing:.02em;
  text-transform:uppercase; color:#7CAE2A; font-size:1.05rem;
}
.value-text{ margin:0; color:#475569; line-height:1.7; }
/* Décale la colonne des valeurs un peu vers le bas (desktop only) */
@media (min-width: 992px){
  .values-col{ margin-top: 32px; }     /* ~32px */
}
@media (min-width: 1400px){
  .values-col{ margin-top: 56px; }     /* un peu plus sur très grands écrans */
}

/* Option : si tu préfères un décalage léger aussi sur tablette large */
@media (min-width: 768px) and (max-width: 991.98px){
  .values-col{ margin-top: 16px; }
}

/* responsive */
@media (max-width: 991.98px){
  .value-item{ grid-template-columns:78px 1fr; }
  .value-ico{ width:78px; height:78px; }
  .value-ico i{ font-size:28px; }
}
@media (max-width: 575.98px){
  .values-img{ max-height:360px; }
}

/* ---------- Team ---------- */
.team-wrap{padding:10px 0 70px}
.team-head{text-align:center;margin-bottom:26px}
.team-card{background:#f8fafc;border:1px solid #eef2f6;border-radius:18px;box-shadow:0 10px 18px rgba(0,0,0,.04);overflow:hidden}
.team-card .team-img{width:140px;height:140px;margin:22px auto 0;border-radius:50%;overflow:hidden}
.team-card .team-img img{width:100%;height:100%;object-fit:cover}
.team-card .team-name{padding:14px 12px;text-align:center}
.team-card .team-name h4{margin:0 0 6px;font-weight:800}
.team-card .team-name p{margin:0;color:#64748b}
.team-card .team-icon{display:flex;justify-content:center;gap:8px;padding:0 0 18px;}
.team-card .btn{width:36px;height:36px;border-radius:50%}
/* ===== HERO About : bande bleue + image qui dépasse vers le bas ===== */


/* Décrochage vertical + espace sous le hero pour laisser respirer l'image */
.pa-hero--split{
  --pa-img-drop: 108px;     /* ↓ augmente/diminue la descente de l’image (ex: 80–140px) */
  margin-bottom: var(--pa-img-drop);
}

/* Texte au-dessus du bleu */
.pa-hero__inner{ position: relative; z-index: 3; }

/* Couche bleue (derrière le texte, devant l’image) */


/* Image : à droite, dépasse vers le bas, sous la couche bleue */
.pa-hero__media{
  position: absolute;
  right: clamp(16px, 3vw, 40px);
  bottom: calc(-1 * var(--pa-img-drop));  /* la fait “sortir” sous la bande bleue */
  width: min(520px, 50vw);
  z-index: 1;                             /* sous la couche bleue, mais visible en dessous */
}
.pa-hero__media img{
  display: block; width: 100%; height: auto;
  border-radius: 18px;        /* coins arrondis */
  border: 0; box-shadow: none; filter: none; transform: none;
}

/* Responsive */
@media (max-width: 992px){
  .pa-hero--split{ --pa-img-drop: 48px; }
  .pa-hero__media{ width: min(640px, 88vw); right: 12px; }
}

/* --- Epilogue --- */
@import url('https://fonts.googleapis.com/css2?family=Epilogue:wght@400;600;800;900&display=swap');

/* ===== HERO About (split + image fixe arrondie) ===== */
.pa-hero{
  position: relative;
  background: var(--navy, #242958);
  color:#fff;
  padding: var(--pa-hero-pad, 160px) 0;  /* hauteur bandeau */
  overflow: visible;                      /* laisse dépasser l’image */
  z-index: 5;
}
/* voile bleu au-dessus de l’image, sous le texte */
.pa-hero::after{
  content:""; position:absolute; inset:0;
  background: var(--navy, #242958);
  z-index: 2; pointer-events:none;
}
/* espace sous le hero pour loger l’image qui déborde */
.pa-hero--split{
  --pa-img-drop: 200px;       /* ↓ descend, ↑ remonte */
  margin-bottom: var(--pa-img-drop);
}

/* texte (déplacement fin via variables) */
.pa-hero__inner{ position: relative; z-index: 3; }
.pa-hero__copy{
  position: relative;
  transform: translate(var(--pa-copy-x, 8px), var(--pa-copy-y, -8px));
  will-change: transform;
}

/* typo + tailles + blanc */
.page-about .pa-title,
.page-about .pa-sub{
  font-family: "Epilogue", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif !important;
  color:#fff !important;
}
.page-about .pa-title{
  font-size: clamp(44px, 6.5vw, 80px) !important;
  line-height: 1.05 !important;
  font-weight: 900 !important;
  margin: 0 0 10px;
}
.page-about .pa-sub{
  font-size: clamp(18px, 1.8vw, 24px) !important;
  line-height: 1.7 !important;
  opacity: .98 !important;
  margin: 0;
}

/* CADRE IMAGE: taille/position figées + 4 coins arrondis */
.pa-hero__media{
  position: absolute;
  right: var(--pa-img-right, 24px);
  bottom: calc(-1 * var(--pa-img-drop, 200px));
  width: var(--pa-img-w, 600px);     /* largeur du cadre */
  height: var(--pa-img-h, 370px);    /* hauteur du cadre */
  border-radius: var(--pa-img-radius, 22px);
  overflow: hidden;                   /* masque les coins */
  background: transparent;
  z-index: 1;                         /* sous le voile */
}
/* l’image remplit le cadre (peu importe sa taille d’origine) */
.pa-hero__media img{
  width: 100%; height: 100%;
  object-fit: cover; display:block; border:0;
  box-shadow:none !important; filter:none !important; transform:none !important;
}

/* Mobile: image sous le texte avec hauteur fixe */
@media (max-width: 992px){
  .pa-hero--split{ --pa-img-drop: 40px; }
  .pa-hero__media{
    position: static; right:auto; bottom:auto;
    width: 100%;
    height: var(--pa-img-h-mobile, 280px);
    margin-top: 18px;
  }
}
/* --- HERO About: cadre image FIXE et plus grand --- */
.page-about .pa-hero--split{
  --pa-img-drop: 260px; /* descend l’image sous la bande bleue */
}

.page-about .pa-hero__media{
  position: absolute;
  right: var(--pa-img-right, 32px);
  bottom: calc(-1 * var(--pa-img-drop, 260px));
  width: var(--pa-img-w, 720px);     /* LARGEUR FIXE du cadre */
  height: var(--pa-img-h, 460px);    /* HAUTEUR FIXE du cadre */
  border-radius: var(--pa-img-radius, 22px);
  overflow: hidden;
  background: transparent;
  z-index: 1;
}

.page-about .pa-hero__media img{
  width: 100%;
  height: 100%;
  object-fit: cover;           /* remplit le cadre, peu importe la photo */
  object-position: center;     /* centre la zone visible */
  display: block;
  border: 0;
  box-shadow: none !important;
  filter: none !important;
  transform: none !important;
}

/* Desktop XL: encore un peu plus grand si tu veux */
@media (min-width: 1400px){
  .page-about .pa-hero__media{
    width: var(--pa-img-w-xl, 780px);
    height: var(--pa-img-h-xl, 500px);
    right: var(--pa-img-right-xl, 40px);
  }
}

/* Mobile: cadre fixe mais plus bas et en plein flux */
@media (max-width: 992px){
  .page-about .pa-hero--split{ --pa-img-drop: 56px; }
  .page-about .pa-hero__media{
    position: static;
    right: auto; bottom: auto;
    width: 100%;
    height: var(--pa-img-h-mobile, 320px); /* hauteur fixe mobile */
    margin-top: 18px;
  }
}
.page-about .pa-hero--compact{
  --pa-img-w: 52px !important;
  --pa-img-h: 32px !important;
  --pa-img-drop: 20px !important;
}
/* FORCE la taille du cadre image du hero About */
.page-about header.pa-hero .pa-hero__media{
  width: var(--pa-img-w, 600px) !important;
  height: var(--pa-img-h, 370px) !important;
  right: var(--pa-img-right, 24px) !important;
  bottom: calc(-1 * var(--pa-img-drop, 200px)) !important;
  border-radius: var(--pa-img-radius, 22px) !important;
  overflow: hidden !important;
}
.page-about header.pa-hero .pa-hero__media img{
  width: 100% !important;
  height: 100% !important;
  object-fit: cover !important;
  object-position: center !important;
}

</style>



<section class="page-about">

{{-- HERO (split : texte à gauche, image à droite) --}}
@php
  $heroBannerImg = $heroBannerImg
      ?? (isset($banners) && $banners->count()
            ? asset('storage/'.ltrim($banners->first()->image,'/'))
            : asset('img/default-banner.jpg'));
@endphp

<header class="pa-hero pa-hero--split"
        style="
          /* 1) Hauteur bandeau bleu */
          --pa-hero-pad: 117px;

          /* 2) Image : position verticale (plus grand = plus bas) */
          --pa-img-drop: 170px;

          /* 3) Image : décalage horizontal (plus petit = plus à droite) */
          --pa-img-right: 16px;

          /* 4) Image : taille du cadre (peu importe la photo) */
          --pa-img-w: 600px;
          --pa-img-h: 380px;
          --pa-img-radius: 22px;

          /* 5) Texte : micro-décalage */
          --pa-copy-x: 8px;
          --pa-copy-y: -8px;

          /* 6) Mobile + XL (optionnel) */
          --pa-img-h-mobile: 280px;
          --pa-img-w-xl: 720px;
          --pa-img-h-xl: 440px;
          --pa-img-right-xl: 40px;
        ">
  <div class="container pa-hero__inner">
    <div class="pa-hero__copy">
      <h1 class="pa-title">{{ trim($about->heading ?? '') ?: 'À propos de nous' }}</h1>
      <p class="pa-sub">{{ trim($about->summary ?? '') ?: 'Nous créons du confort durable grâce à des solutions sur-mesure.' }}</p>
    </div>
    <figure class="pa-hero__media">
      <img src="{{ $heroBannerImg }}" alt="Hero banner">
    </figure>
  </div>
</header>




  <section class="metrics">
    <div class="container">
      <div class="metric-grid">
        
      </div>
    </div>
  </section>

  {{-- ABOUT SECTION --}}
  <section class="about-wrap">
    <div class="container">
      <div class="row g-5 align-items-center">
        <div class="col-lg-5 col-md-6">
          <div class="about-imgs">
            <img src="{{ asset('img/rect2.png') }}" alt="EcoCall" class="img-a">
            <img src="{{ asset('img/rect.png') }}" alt="Formation" class="img-b">
          </div>
        </div>
        <div class="col-lg-7 col-md-6">
          <div class="pa-kicker"><span style="color: #7CAE2A;">Qui sommes-nous ?</span></h2></div>
          <h1 class="pa-h1">France Expert Isolation, votre partenaire en formation et relation client</h1>
          <p class="mt-3">France Expert Isolation est un centre de formation et de services dédié à l'excellence dans le domaine du call center. Nous accompagnons les entreprises et les particuliers dans le développement de leurs compétences en relation client, gestion des appels, communication commerciale et outils CRM.</p>
          <p class="mb-4">Grâce à des formateurs expérimentés et des modules adaptés aux exigences du marché, nous garantissons une montée en compétence rapide et efficace. Notre objectif est de professionnaliser les métiers de la relation client à travers une pédagogie moderne et des cas pratiques réels.</p>
          <a href="{{ url('/formation') }}" class="btn btn-accent">Voir nos formations</a>
        </div>
      </div>
    </div>
  </section>
{{-- OUR VALUES section (placer AVANT .team-wrap) --}}
<section class="values-wrap">
  <div class="container">
    <div class="row g-5 align-items-center">
      {{-- Colonne gauche : titre + grande image --}}
      <div class="col-lg-7">
        <div class="values-head">
          <div class="kicker">ABOUT</div>
          <h2 class="values-title">
            We stand by<br>
            <span class="accent">Our Values</span>
          </h2>
        </div>

        {{-- Image grande avec coins arrondis --}}
        <img
          src="{{ asset('img/ta.png') }}"
          alt="Solar values"
          class="values-img">
      </div>

      {{-- Colonne droite : 3 valeurs --}}
      <div class="col-lg-3 values-col">
        <div class="value-list">
          {{-- Valeur 1 --}}
          <div class="value-item">
            <div class="value-ico">
              <i class="fa-solid fa-seedling"></i>
            </div>
            <div>
              <h4 class="value-title">Integrity</h4>
              <p class="value-text">
                Nous opérons avec transparence et responsabilité à chaque étape.
              </p>
            </div>
          </div>

          {{-- Valeur 2 --}}
          <div class="value-item">
            <div class="value-ico">
              <i class="fa-solid fa-dollar-sign"></i>
            </div>
            <div>
              <h4 class="value-title">Quality</h4>
              <p class="value-text">
                Des matériaux certifiés et une exécution maîtrisée pour durer.
              </p>
            </div>
          </div>

          {{-- Valeur 3 --}}
          <div class="value-item">
            <div class="value-ico">
              <i class="fa-solid fa-bolt"></i>
            </div>
            <div>
              <h4 class="value-title">Commitment</h4>
              <p class="value-text">
                Engagement total envers la performance, la sécurité et l’environnement.
              </p>
            </div>
          </div>
        </div>
      </div>
      {{-- /col droite --}}
    </div>
  </div>
</section>


</section>
@endsection
