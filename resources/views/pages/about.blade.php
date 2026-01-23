@extends('layouts.app')

@section('title', $about->heading ?? 'À propos de nous')

@section('content')
  <style>
    /* =========================================================
     France Isolation – Page shell (same skin as Contact page)
     Scoped so it won't leak elsewhere.
     ========================================================= */
    .page-about {
      --navy: #242958;
      --navyDark: #1d2760;
      --sky: #31b4eb;
      --accent: #7CAE2A;
      --ink: #0f172a;
      --muted: #6b7280;
      --field: #f5f7fb;
      --ring: #dbe6ff;
      --card: #ffffff;
      --shadow: 0 20px 40px rgba(16, 24, 40, .08);
    }

    .page-about * {
      box-sizing: border-box
    }

    /* ---------- HERO (identical to contact page) ---------- */

    .pa-hero .pa-hgroup {
      max-inline-size: 1100px;
      margin: 0 auto;
      padding: 0 12px
    }

    .pa-title {
      font-size: 80px;
      line-height: 2.05;
      font-weight: 800;
      margin: 0 0 10px
    }

    .pa-hero h1,
    .pa-hero .pa-title,
    .pa-hero p,
    .pa-hero .pa-sub {
      color: #ffffff !important
    }

    .pa-sub {
      max-inline-size: 620px;
      font-size: 15px;
      line-height: 1.7;
      margin: 0;
      opacity: .95
    }

    @media (max-inline-size:768px) {
      .pa-title {
        font-size: 40px
      }
    }

    /* breadcrumb pill */
    .pa-bread-wrap {
      position: absolute;
      inset-inline-start: 0;
      inset-inline-end: 0;
      inset-block-end: -28px;
      display: flex;
      justify-content: center
    }

    .pa-bread {
      inline-size: min(1180px, calc(100% - 48px));
      background: var(--sky);
      block-size: 46px;
      border-radius: 9999px;
      display: flex;
      align-items: center;
      gap: 18px;
      padding: 0 22px;
      font-weight: 700;
      box-shadow: 0 10px 18px rgba(3, 102, 140, .12);
      color: #fff !important;
    }

    .pa-bread a,
    .pa-bread span {
      color: #fff !important
    }

    .pa-bread .sep {
      color: rgba(255, 255, 255, .85) !important
    }

    .pa-bread .home-ico {
      display: inline-grid;
      place-items: center;
      inline-size: 26px;
      block-size: 26px;
      border-radius: 50%;
      background: rgba(255, 255, 255, .22);
      color: #fff !important;
      font-size: 12px
    }

    /* ---------- HEADINGS + buttons ---------- */
    .pa-kicker {
      color: var(--sky);
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: .12em;
      font-size: .85rem
    }

    .pa-h1 {
      color: var(--ink);
      font-weight: 800;
      line-height: 1.14;
      margin: 8px 0 0
    }

    .btn-accent {
      background: var(--accent);
      border: none;
      color: #fff;
      font-weight: 800;
      padding: 14px 22px;
      border-radius: 14px;
      ;
      transition: .2s
    }

    .btn-accent:hover {
      transform: translateY(-1px);
      filter: brightness(.98)
    }

    /* ---------- Metrics (replaces bg-secondary strip) ---------- */
    .metrics {
      padding: 64px 0 48px
    }

    .metric-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 18px
    }

    @media (max-inline-size:991.98px) {
      .metric-grid {
        grid-template-columns: repeat(2, 1fr)
      }
    }

    @media (max-inline-size:575.98px) {
      .metric-grid {
        grid-template-columns: 1fr
      }
    }

    .metric-card {
      background: var(--card);
      border: 1px solid #eef2f6;
      border-radius: 18px;
      box-shadow: 0 10px 18px rgba(0, 0, 0, .04);
      padding: 22px;
      display: flex;
      align-items: center;
      gap: 14px
    }

    .metric-num {
      font-size: 36px;
      font-weight: 800;
      color: var(--sky);
      margin: 0
    }

    .metric-label {
      margin: 0;
      color: #334155;
      font-weight: 700
    }

    /* ---------- About section ---------- */
    .about-wrap {
      padding: 56px 0
    }

    .about-imgs {
      position: relative;
      block-size: 100%
    }

    .about-imgs .img-a {
      inline-size: 75%;
      border-radius: 16px;
      box-shadow: var(--shadow);
      margin-block-end: 25%
    }

    .about-imgs .img-b {
      position: absolute;
      inset-block-start: 25%;
      inset-inline-start: 25%;
      inline-size: 75%;
      border-radius: 16px;
      box-shadow: var(--shadow)
    }

    .about-text p {
      color: #475569
    }

    .about-text h1 {
      font-weight: 800
    }

    /* ---------- VALUES (Our Values) ---------- */
    .values-wrap {
      padding: 42px 0 64px;
      background: #fbfbfb;
    }

    .values-head .kicker {
      color: #7CAE2A;
      font-weight: 800;
      letter-spacing: .12em;
      text-transform: uppercase;
      font-size: .9rem;
    }

    .values-title {
      margin: 6px 0 20px;
      line-height: 1.05;
      font-weight: 800;
      font-size: clamp(32px, 4.2vw, 64px);
      color: #0f172a;
    }

    .values-title .accent {
      color: #7CAE2A;
      display: block;
    }

    .values-img {
      inline-size: 100%;
      border-radius: 28px;
      box-shadow: 0 20px 40px rgba(16, 24, 40, .08);
      display: block;
      margin-block-start: 20px;
      object-fit: cover;
      max-block-size: 520px;
    }

    /* liste de 3 valeurs à droite */
    .value-list {
      display: flex;
      flex-direction: column;
      gap: 46px;
    }

    .value-item {
      display: grid;
      grid-template-columns: 92px 1fr;
      align-items: center;
      column-gap: 18px;
    }

    .value-ico {
      inline-size: 92px;
      block-size: 92px;
      border-radius: 50%;
      display: grid;
      place-items: center;
      background: #ffffff;
      border: 1px solid #e8eef6;
      box-shadow: 0 12px 24px rgba(0, 0, 0, .05);
      position: relative;
      isolation: isolate;
    }

    .value-ico::after {
      /* pastille verte derrière l’icône */
      content: "";
      position: absolute;
      inset: 10px;
      background: #7CAE2A;
      border-radius: 50%;
      z-index: -1;
      opacity: .15;
    }

    .value-ico i {
      font-size: 34px;
      color: #1f2a5a;
    }

    /* icône FA */

    .value-title {
      margin: 0 0 6px;
      font-weight: 800;
      letter-spacing: .02em;
      text-transform: uppercase;
      color: #7CAE2A;
      font-size: 1.05rem;
    }

    .value-text {
      margin: 0;
      color: #475569;
      line-height: 1.7;
    }

    /* Décale la colonne des valeurs un peu vers le bas (desktop only) */
    @media (min-inline-size: 992px) {
      .values-col {
        margin-block-start: 32px;
      }

      /* ~32px */
    }

    @media (min-inline-size: 1400px) {
      .values-col {
        margin-block-start: 56px;
      }

      /* un peu plus sur très grands écrans */
    }

    /* Option : si tu préfères un décalage léger aussi sur tablette large */
    @media (min-inline-size: 768px) and (max-inline-size: 991.98px) {
      .values-col {
        margin-block-start: 16px;
      }
    }

    /* responsive */
    @media (max-inline-size: 991.98px) {
      .value-item {
        grid-template-columns: 78px 1fr;
      }

      .value-ico {
        inline-size: 78px;
        block-size: 78px;
      }

      .value-ico i {
        font-size: 28px;
      }
    }

    @media (max-inline-size: 575.98px) {
      .values-img {
        max-block-size: 360px;
      }
    }

    /* ---------- Team ---------- */
    .team-wrap {
      padding: 10px 0 70px
    }

    .team-head {
      text-align: center;
      margin-block-end: 26px
    }

    .team-card {
      background: #f8fafc;
      border: 1px solid #eef2f6;
      border-radius: 18px;
      box-shadow: 0 10px 18px rgba(0, 0, 0, .04);
      overflow: hidden
    }

    .team-card .team-img {
      inline-size: 140px;
      block-size: 140px;
      margin: 22px auto 0;
      border-radius: 50%;
      overflow: hidden
    }

    .team-card .team-img img {
      inline-size: 100%;
      block-size: 100%;
      object-fit: cover
    }

    .team-card .team-name {
      padding: 14px 12px;
      text-align: center
    }

    .team-card .team-name h4 {
      margin: 0 0 6px;
      font-weight: 800
    }

    .team-card .team-name p {
      margin: 0;
      color: #64748b
    }

    .team-card .team-icon {
      display: flex;
      justify-content: center;
      gap: 8px;
      padding: 0 0 18px;
    }

    .team-card .btn {
      inline-size: 36px;
      block-size: 36px;
      border-radius: 50%
    }

    /* ===== HERO About : bande bleue + image qui dépasse vers le bas ===== */


    /* Décrochage vertical + espace sous le hero pour laisser respirer l'image */
    .pa-hero--split {
      --pa-img-drop: 108px;
      /* ↓ augmente/diminue la descente de l’image (ex: 80–140px) */
      margin-block-end: var(--pa-img-drop);
    }

    /* Texte au-dessus du bleu */
    .pa-hero__inner {
      position: relative;
      z-index: 3;
    }

    /* Couche bleue (derrière le texte, devant l’image) */


    /* Image : à droite, dépasse vers le bas, sous la couche bleue */
    .pa-hero__media {
      position: absolute;
      inset-inline-end: clamp(16px, 3vw, 40px);
      inset-block-end: calc(-1 * var(--pa-img-drop));
      /* la fait “sortir” sous la bande bleue */
      inline-size: min(520px, 50vw);
      z-index: 1;
      /* sous la couche bleue, mais visible en dessous */
    }

    .pa-hero__media img {
      display: block;
      inline-size: 100%;
      block-size: auto;
      border-radius: 18px;
      /* coins arrondis */
      border: 0;
      box-shadow: none;
      filter: none;
      transform: none;
    }

    /* Responsive */
    @media (max-inline-size: 992px) {
      .pa-hero--split {
        --pa-img-drop: 48px;
      }

      .pa-hero__media {
        inline-size: min(640px, 88vw);
        inset-inline-end: 12px;
      }
    }

    /* --- Epilogue --- */
    @import url('https://fonts.googleapis.com/css2?family=Epilogue:wght@400;600;800;900&display=swap');

    /* ===== HERO About (split + image fixe arrondie) ===== */
    .pa-hero {
      position: relative;
      background: var(--navy, #242958);
      color: #fff;
      padding: var(--pa-hero-pad, 160px) 0;
      /* hauteur bandeau */
      overflow: visible;
      /* laisse dépasser l’image */
      z-index: 5;
    }

    /* voile bleu au-dessus de l’image, sous le texte */
    .pa-hero::after {
      content: "";
      position: absolute;
      inset: 0;
      background: var(--navy, #242958);
      z-index: 2;
      pointer-events: none;
    }

    /* espace sous le hero pour loger l’image qui déborde */
    .pa-hero--split {
      --pa-img-drop: 200px;
      /* ↓ descend, ↑ remonte */
      margin-block-end: var(--pa-img-drop);
    }

    /* texte (déplacement fin via variables) */
    .pa-hero__inner {
      position: relative;
      z-index: 3;
    }

    .pa-hero__copy {
      position: relative;
      transform: translate(var(--pa-copy-x, 8px), var(--pa-copy-y, -8px));
      will-change: transform;
    }

    /* typo + tailles + blanc */
    .page-about .pa-title,
    .page-about .pa-sub {
      font-family: "Epilogue", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif !important;
      color: #fff !important;
    }

    .page-about .pa-title {
      font-size: clamp(44px, 6.5vw, 80px) !important;
      line-height: 1.05 !important;
      font-weight: 900 !important;
      margin: 0 0 10px;
    }

    .page-about .pa-sub {
      font-size: clamp(18px, 1.8vw, 24px) !important;
      line-height: 1.7 !important;
      opacity: .98 !important;
      margin: 0;
    }

    /* CADRE IMAGE: taille/position figées + 4 coins arrondis */
    .pa-hero__media {
      position: absolute;
      inset-inline-end: var(--pa-img-right, 24px);
      inset-block-end: calc(-1 * var(--pa-img-drop, 200px));
      inline-size: var(--pa-img-w, 600px);
      /* largeur du cadre */
      block-size: var(--pa-img-h, 370px);
      /* hauteur du cadre */
      border-radius: var(--pa-img-radius, 22px);
      overflow: hidden;
      /* masque les coins */
      background: transparent;
      z-index: 1;
      /* sous le voile */
    }

    /* l’image remplit le cadre (peu importe sa taille d’origine) */
    .pa-hero__media img {
      inline-size: 100%;
      block-size: 100%;
      object-fit: cover;
      display: block;
      border: 0;
      box-shadow: none !important;
      filter: none !important;
      transform: none !important;
    }

    /* Mobile: image sous le texte avec hauteur fixe */
    @media (max-inline-size: 992px) {
      .pa-hero--split {
        --pa-img-drop: 40px;
      }

      .pa-hero__media {
        position: static;
        inset-inline-end: auto;
        inset-block-end: auto;
        inline-size: 100%;
        block-size: var(--pa-img-h-mobile, 280px);
        margin-block-start: 18px;
      }
    }

    /* --- HERO About: cadre image FIXE et plus grand --- */
    .page-about .pa-hero--split {
      --pa-img-drop: 260px;
      /* descend l’image sous la bande bleue */
    }

    .page-about .pa-hero__media {
      position: absolute;
      inset-inline-end: var(--pa-img-right, 32px);
      inset-block-end: calc(-1 * var(--pa-img-drop, 260px));
      inline-size: var(--pa-img-w, 720px);
      /* LARGEUR FIXE du cadre */
      block-size: var(--pa-img-h, 460px);
      /* HAUTEUR FIXE du cadre */
      border-radius: var(--pa-img-radius, 22px);
      overflow: hidden;
      background: transparent;
      z-index: 1;
    }

    .page-about .pa-hero__media img {
      inline-size: 100%;
      block-size: 100%;
      object-fit: cover;
      /* remplit le cadre, peu importe la photo */
      object-position: center;
      /* centre la zone visible */
      display: block;
      border: 0;
      box-shadow: none !important;
      filter: none !important;
      transform: none !important;
    }

    /* Desktop XL: encore un peu plus grand si tu veux */
    @media (min-inline-size: 1400px) {
      .page-about .pa-hero__media {
        inline-size: var(--pa-img-w-xl, 780px);
        block-size: var(--pa-img-h-xl, 500px);
        inset-inline-end: var(--pa-img-right-xl, 40px);
      }
    }

    /* Mobile: cadre fixe mais plus bas et en plein flux */
    @media (max-inline-size: 992px) {
      .page-about .pa-hero--split {
        --pa-img-drop: 56px;
      }

      .page-about .pa-hero__media {
        position: static;
        inset-inline-end: auto;
        inset-block-end: auto;
        inline-size: 100%;
        block-size: var(--pa-img-h-mobile, 320px);
        /* hauteur fixe mobile */
        margin-block-start: 18px;
      }
    }

    .page-about .pa-hero--compact {
      --pa-img-w: 52px !important;
      --pa-img-h: 32px !important;
      --pa-img-drop: 20px !important;
    }

    /* FORCE la taille du cadre image du hero About */
    .page-about header.pa-hero .pa-hero__media {
      inline-size: var(--pa-img-w, 600px) !important;
      block-size: var(--pa-img-h, 370px) !important;
      inset-inline-end: var(--pa-img-right, 24px) !important;
      inset-block-end: calc(-1 * var(--pa-img-drop, 200px)) !important;
      border-radius: var(--pa-img-radius, 22px) !important;
      overflow: hidden !important;
    }

    .page-about header.pa-hero .pa-hero__media img {
      inline-size: 100% !important;
      block-size: 100% !important;
      object-fit: cover !important;
      object-position: center !important;
    }
    /* === FIX: espace blanc sous le header (About) === */
@media (max-width: 991.98px) {
  /* 1) Annuler l'espace réservé au débordement de l'image quand elle devient "statique" */
  header.pa-hero.pa-hero--split {
    margin-block-end: 0 !important;
  }

  /* 2) On garde l'image visible après le texte (déjà statique chez toi) */
  .page-about .pa-hero__media {
    position: static !important;
    inset-inline-end: auto !important;
    inset-block-end: auto !important;
    inline-size: 100% !important;
    block-size: var(--pa-img-h-mobile, 320px) !important;
    margin-block-start: 18px !important;
  }

  /* 3) Rapprocher la section suivante si besoin */
  .page-about .metrics {
    padding-block-start: 24px !important;   /* était 64px */
  }
}

/* (Optionnel) Si tu vois encore un léger blanc sur tablettes */
@media (min-width: 992px) and (max-width: 1199.98px) {
  header.pa-hero.pa-hero--split {
    margin-block-end: 40px !important; /* petit coussin au lieu d’un grand trou */
  }
}
/* ===== VALUES – Layout horizontal ===== */

.values-image-wrap {
  margin: 30px 0 60px;
}

.values-img--large {
  inline-size: 100%;
  max-block-size: 620px;
  object-fit: cover;
  border-radius: 32px;
  box-shadow: 0 24px 48px rgba(16,24,40,.12);
}

/* Valeurs horizontales */
.values-horizontal {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 36px;
}

/* Carte valeur */
.value-card {
  background: #ffffff;
  border-radius: 26px;
  padding: 42px 32px;
  text-align: center;
  box-shadow: 0 18px 36px rgba(0,0,0,.06);
  transition: transform .25s ease, box-shadow .25s ease;
}

.value-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 26px 48px rgba(0,0,0,.12);
}

.value-card .value-ico {
  margin: 0 auto 18px;
}

.value-card .value-title {
  margin: 12px 0 10px;
  font-size: 1.15rem;
}

.value-card .value-text {
  font-size: .98rem;
  line-height: 1.7;
}

/* Responsive */
@media (max-width: 991.98px) {
  .values-horizontal {
    grid-template-columns: 1fr;
    gap: 24px;
  }

  .values-img--large {
    max-block-size: 380px;
  }
}

  </style>



  <section class="page-about">

 



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
              <img src="{{ asset('img/etude.jpeg') }}" alt="EcoCall" class="img-a">
              <img src="{{ asset('img/man.jpeg') }}" alt="Formation" class="img-b">
            </div>
          </div>
          <div class="col-lg-7 col-md-6">
  <div class="pa-kicker">
      <span style="color: #7CAE2A;">Qui sommes‑nous&nbsp;?</span>
  </div>

  <h1 class="pa-h1">AuditVision, Bureau d’études en génie énergétique et stratégie bas-carbone</h1>

  <p class="mt-3">
      AuditVision est un bureau d’études indépendant en génie énergétique, implanté en France, dédié à l’accompagnement des acteurs du tertiaire, de l’habitat collectif, des collectivités territoriales et du secteur industriel.
      Le cabinet intervient à chaque étape des projets d’amélioration de la performance énergétique, environnementale et économique des bâtiments et des procédés, en intégrant pleinement les exigences réglementaires, les contraintes techniques et les enjeux stratégiques liés à la transition énergétique et à la décarbonation.
  </p>

  <p class="mb-4">
      L’approche d’AuditVision s’appuie sur :
      <ul>
          <li>Une expertise technique approfondie en génie énergétique,</li>
          <li>Une parfaite maîtrise des cadres réglementaires français et européens,</li>
          <li>Une vision globale orientée performance énergétique durable et réduction de l’empreinte carbone.</li>
      </ul>
  </p>

  <p class="mb-4">
      AuditVision se positionne comme un partenaire de confiance, capable de transformer les obligations réglementaires et énergétiques en véritables leviers de performance, de compétitivité et de durabilité pour ses clients.
  </p>

  <h2 class="pa-h1">Nos missions</h2>
  <p class="mb-4">
      AuditVision intervient sur l’ensemble du cycle de la performance énergétique et environnementale, depuis le diagnostic jusqu’à la définition de stratégies d’amélioration durable.
      Voici quelques-unes de nos principales missions :
  </p>

  <ul class="mb-4">
      <li>La réalisation d’audits énergétiques des bâtiments d’habitat collectif,</li>
      <li>La réalisation d’audits énergétiques des bâtiments tertiaires,</li>
      <li>La conduite d’études thermiques spécialisées, en particulier sur les installations de chambres froides en secteurs tertiaire et industriel,</li>
      <li>Le dimensionnement technique et le calepinage de systèmes de destratification d’air,</li>
      <li>L’élaboration de bilans carbone,</li>
      <li>La définition de plans d’actions visant à la réduction des émissions de CO₂,</li>
      <li>La réalisation d’études d’éclairage intérieur et de dimensionnement des installations d’éclairage.</li>
  </ul>

  <a href="{{ url('/services') }}" class="btn btn-accent">Découvrir nos solutions</a>
</div>



        </div>
      </div>
    </section>
    {{-- OUR VALUES section (placer AVANT .team-wrap) --}}
    <section class="values-wrap">
  <div class="container">

    {{-- Titre + image --}}
    <div class="values-head text-center">
      <div class="kicker" style="color: #000331;">À PROPOS</div>

      <h2 class="values-title">
        <span class="accent">Nos valeurs</span>
      </h2>
    </div>

    {{-- Image plus grande --}}
    <div class="values-image-wrap">
      <img src="{{ asset('img/taa.jpeg') }}" alt="Nos valeurs" class="values-img values-img--large">
    </div>

    {{-- Valeurs horizontales --}}
<div class="values-horizontal">
  {{-- Valeur 1 --}}
  <div class="value-card">
    <div class="value-ico">
      <i class="fa-solid fa-handshake"></i>
    </div>
    <h4 class="value-title">Transparence</h4>
    <p class="value-text">
      Nous priorisons la transparence dans toutes nos interactions, en fournissant à nos clients des informations claires, précises et accessibles à chaque étape de notre collaboration.
    </p>
  </div>

  {{-- Valeur 2 --}}
  <div class="value-card">
    <div class="value-ico">
      <i class="fa-solid fa-cogs"></i>
    </div>
    <h4 class="value-title">Innovation</h4>
    <p class="value-text">
      Nous nous engageons à utiliser des solutions innovantes et des technologies de pointe pour offrir des services qui respectent les normes les plus élevées de l'industrie.
    </p>
  </div>

  {{-- Valeur 3 --}}
  <div class="value-card">
    <div class="value-ico">
      <i class="fa-solid fa-leaf"></i>
    </div>
    <h4 class="value-title">Durabilité</h4>
    <p class="value-text">
      Nous nous engageons à promouvoir des pratiques durables en intégrant des solutions respectueuses de l'environnement dans tous nos projets et en réduisant constamment notre empreinte carbone.
    </p>
  </div>

  {{-- Valeur 4 --}}
  <div class="value-card">
    <div class="value-ico">
      <i class="fa-solid fa-users"></i>
    </div>
    <h4 class="value-title">Collaboration</h4>
    <p class="value-text">
      Nous croyons en la force de la collaboration et du travail d'équipe pour trouver les meilleures solutions, en impliquant toutes les parties prenantes dans chaque étape de nos projets.
    </p>
  </div>
</div>

<style>
  .values-horizontal {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 24px;
    padding: 40px 0;
  }

  .value-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 28px;
    text-align: center;
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.05);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .value-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 32px rgba(0, 0, 0, 0.1);
  }

  .value-ico {
    background: #f0f9ff;
    padding: 20px;
    border-radius: 50%;
    color: #31b4eb;
    font-size: 36px;
    margin-bottom: 20px;
    display: inline-block;
  }

  .value-title {
    font-size: 1.2rem;
    color: #333333;
    font-weight: 700;
    margin-bottom: 12px;
    text-transform: uppercase;
  }

  .value-text {
    color: #555555;
    font-size: 1rem;
    line-height: 1.6;
    margin-bottom: 20px;
    font-weight: 400;
  }

  /* Responsive */
  @media (max-width: 991px) {
    .values-horizontal {
      grid-template-columns: repeat(2, 1fr);
      gap: 18px;
    }
  }

  @media (max-width: 575px) {
    .values-horizontal {
      grid-template-columns: 1fr;
      gap: 16px;
    }
  }
</style>

  </div>
</section>



  </section>
@endsection