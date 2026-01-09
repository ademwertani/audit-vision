@extends('layouts.app')

@section('title', 'Contactez-nous')

@section('content')
<style>
/* =========================================================
   France Isolation – Contact (matches the provided mock)
   All styles are scoped to avoid leaking to other pages.
   ========================================================= */
.contact-page{
  --navy:#242958;
  --navyDark:#1d2760;
  --sky:#7CAE2A;
  --accent:#7CAE2A;
  --ink:#0f172a;
  --muted:#6b7280;
  --field:#f5f7fb;
  --ring:#dbe6ff;
  --card:#ffffff;
  --shadow:0 20px 40px rgba(16,24,40,.08);
}
.contact-page *{box-sizing:border-box}

/* ---------- HERO (left-aligned text + big pill breadcrumb) ---------- */
.cp-hero{
  background:var(--navy);
  color:#fff;
  padding:78px 0 92px;
  position:relative;
}
.cp-hero .cp-hgroup{max-inline-size:1100px;margin:0 auto;padding:0 12px}
.cp-title{
  font-size:56px; line-height:1.05; font-weight:800; margin:0 0 10px;
}
.cp-hero h1,
.cp-hero .cp-title,
.cp-hero p,
.cp-hero .cp-sub{ color:#fff !important; }  /* force white in hero */
@media (max-width:768px){ .cp-title{font-size:40px} }
.cp-sub{
  max-inline-size:560px; font-size:15px; line-height:1.7; margin:0; opacity:.95;
}

/* Long rounded breadcrumb bar (sits at hero bottom like the mock) */
.cp-bread-wrap{position:absolute; inset-inline-start:0; inset-inline-end:0; inset-block-end:-28px; display:flex; justify-content:center}
.cp-bread{
  inline-size:min(1180px, calc(100% - 48px));
  background:var(--sky);
  block-size:46px; border-radius:9999px;
  display:flex; align-items:center; gap:18px;
  padding:0 22px; font-weight:700; box-shadow:0 10px 18px rgba(3,102,140,.12);
  color:#fff !important;              /* base text color white */
}
.cp-bread a,
.cp-bread span{ color:#fff !important; }  /* make “Home” + “Contact Us” white */
.cp-bread .sep{ color:rgba(255,255,255,.85) !important; }
.cp-bread .home-ico{
  display:inline-grid; place-items:center; inline-size:26px; block-size:26px; border-radius:50%;
  background:rgba(255,255,255,.22); color:#fff !important; font-size:12px;
}

/* ---------- SECTION HEAD ---------- */
.cp-wrap{padding:70px 0 40px}
.cp-head{max-inline-size:820px;margin:0 auto 8px;text-align:center}
.cp-kicker{color:var(--sky);font-weight:800;text-transform:uppercase;letter-spacing:.12em;font-size:.85rem}
.cp-h1{color:var(--ink);font-weight:800;line-height:1.14;margin:8px 0 0}

/* ---------- GRID ---------- */
.cp-grid{display:grid;grid-template-columns:1.35fr .9fr;gap:28px;align-items:start;margin-block-start:26px}
@media (max-width: 991.98px){.cp-grid{grid-template-columns:1fr}}

/* ---------- FORM CARD ---------- */
.cp-card{background:var(--card);border-radius:20px;box-shadow:var(--shadow);padding:28px}
.cp-form .form-control{
  background:var(--field)!important; border:1px solid #e6e9f5!important; border-radius:12px!important;
  padding:14px 16px!important; font-size:1rem;
}
.cp-form .form-control:focus{background:#fff!important;border-color:var(--ring)!important;box-shadow:none!important}
.cp-form textarea.form-control{min-block-size:160px;resize:vertical}
.cp-btn{
  background:var(--accent); border:none; color:#fff; font-weight:800;
  padding:14px 22px; border-radius:14px; transition:.2s;
}
.cp-btn:hover{transform:translateY(-1px);filter:brightness(.98)}
.contact-page .alert-success{border-radius:12px}

/* ---------- INFO CARDS (right column) ---------- */
.cp-aside{display:flex;flex-direction:column;gap:18px}
.cp-info{
  background:#242e77; color:#fff; border-radius:18px; box-shadow:0 8px 18px rgba(0,0,0,.08);
  padding:22px; display:flex; gap:16px; align-items:flex-start;
}
.cp-ico{
  inline-size:56px; block-size:56px; border-radius:50%; display:grid; place-items:center;
  background:var(--accent); color:#fff; font-size:22px; flex-shrink:0;
}
.cp-info h5{ margin:0 0 6px; font-weight:800; font-size:1rem; color:#fff !important; }  /* force white */
.cp-info a{ color:#d8e6ff; text-decoration:none; font-weight:600 }
.cp-info a:hover{ text-decoration:underline }

/* ---------- MAP ---------- */
.cp-map{margin-block-start:34px;background:#f4f7ff;border-radius:20px;box-shadow:0 8px 18px rgba(0,0,0,.06);padding:10px}
.cp-map iframe{inline-size:100%;block-size:440px;border:0;border-radius:12px}
/* ---------- HERO Contact : bande bleue + image qui dépasse ---------- */
.cp-hero{
  position: relative;
  background: #242958;      /* bleu */
  color: #fff;
  padding: 78px 0 92px;     /* hauteur du bandeau bleu */
  overflow: visible;         /* IMPORTANT : ne pas couper l'image qui déborde */
  z-index: 5;
}

/* Contrôle le “décrochage” de l’image sous le bleu */
.cp-hero--split{
  --cp-img-drop: 108px;      /* ajuste 60–140px selon le rendu */
  margin-block-end: var(--cp-img-drop);
}

.cp-hero__inner{ position: relative; z-index: 3; }
.cp-hero .cp-title{ margin:0 0 6px; font-weight:800; font-size: clamp(34px, 5vw, 64px); }
.cp-hero .cp-sub{ max-inline-size: 720px; opacity:.95; }

/* Couche bleue (sous le texte, au-dessus de l’image) */
.cp-hero::after{
  content:"";
  position:absolute; inset:0;
  background:#242958;
  z-index: 2;
  pointer-events:none;
}

/* L’image : à droite, dépasse vers le bas, SANS effets */
.cp-hero__media{
  position: absolute;
  inset-inline-end: clamp(16px, 3vw, 40px);
  inset-block-end: calc(-1 * var(--cp-img-drop));
  inline-size: min(520px, 50vw);   /* largeur de l’image */
  z-index: 1;                /* sous la couche bleue */
}
.cp-hero__media img{
  display:block; inline-size:100%; block-size:auto;
  border: 0;
  border-radius: 0;          /* laisse droit (mets 18px si tu veux arrondi) */
  box-shadow: none; filter:none; transform:none;
}

/* Responsive */
@media (max-width: 992px){
  .cp-hero--split{ --cp-img-drop: 48px; }
  .cp-hero__media{ inline-size: min(640px, 88vw); inset-inline-end: 12px; }
}
/* ---------- HERO Contact : image AU-DESSUS + coins arrondis ---------- */
.cp-hero{
  position: relative;
  background: #242958;         /* bleu */
  color: #fff;
  padding: 78px 0 92px;        /* hauteur du bandeau bleu */
  overflow: visible;           /* ne pas couper l'image qui dépasse */
  z-index: 5;
}

/* Décrochage vertical de l'image */
.cp-hero--split{
  --cp-img-drop: 17px;        /* ↑ baisse l’image ; 60–140px selon ton rendu */
  margin-block-end: var(--cp-img-drop);
}

/* Calques : texte tout en haut, image devant le bleu, bleu derrière tout */
.cp-hero__inner{ position: relative; z-index: 5; }  /* texte */
.cp-hero::after{
  content:"";
  position:absolute; inset:0;
  background:#242958;          /* bande bleue */
  z-index: 2;                  /* derrière l'image */
  pointer-events:none;
}

/* Image : à droite, dépasse vers le bas, AU-DESSUS de la bande bleue */
.cp-hero__media{
  position: absolute;
  inset-inline-end: clamp(16px, 3vw, 40px);
  inset-block-end: calc(-1 * var(--cp-img-drop)); /* fait dépasser vers le bas */
  inline-size: min(520px, 50vw);
  z-index: 4;                                  /* > au bleu, < au texte */
}
.cp-hero__media img{
  display:block; inline-size:100%; block-size:auto;
  border: 0;
  border-radius: 18px !important;              /* coins arrondis */
  box-shadow: none !important;
  filter: none !important;
  transform: none !important;
}

/* Responsive */
@media (max-width: 992px){
  .cp-hero--split{ --cp-img-drop: 48px; }
  .cp-hero__media{ inline-size: min(640px, 88vw); inset-inline-end: 12px; }
}
/* === HERO Contact : cadre image FIXE + position stable === */
.contact-page .cp-hero--split{
  --cp-img-drop: 240px; /* descend l’image sous la bande bleue */
}

.contact-page .cp-hero__media{
  position: absolute;
  inset-inline-end: var(--cp-img-right, 32px);
  inset-block-end: calc(-1 * var(--cp-img-drop, 240px));
  inline-size: var(--cp-img-w, 720px);     /* LARGEUR FIXE */
  block-size: var(--cp-img-h, 460px);    /* HAUTEUR FIXE */
  border-radius: var(--cp-img-radius, 22px);
  overflow: hidden;
  z-index: 4; /* au-dessus du bleu, sous le texte */
}

.contact-page .cp-hero__media img{
  inline-size: 100%;
  block-size: 100%;
  object-fit: cover;       /* remplit le cadre proprement */
  object-position: center; /* centre le cadrage */
  display: block;
  border: 0;
  box-shadow: none !important;
  filter: none !important;
  transform: none !important;
}

/* XL : un peu plus grand si tu veux */
@media (min-width: 1400px){
  .contact-page .cp-hero__media{
    inline-size: var(--cp-img-w-xl, 780px);
    block-size: var(--cp-img-h-xl, 500px);
    inset-inline-end: var(--cp-img-right-xl, 40px);
  }
}

/* Mobile : cadre fixe plus raisonnable, en flux sous le texte */
@media (max-width: 992px){
  .contact-page .cp-hero--split{ --cp-img-drop: 56px; }
  .contact-page .cp-hero__media{
    position: static;
    inset-inline-end: auto; inset-block-end: auto;
    inline-size: 100%;
    block-size: var(--cp-img-h-mobile, 320px);
    margin-block-start: 18px;
  }
}
/* === OVERRIDES SIMPLES (Contact) === */
.contact-page header.cp-hero{
  /* hauteur de la bande bleue + décalage vers le bas */
  padding: var(--cp-hero-pad, 180px) 0 !important;
  margin-block-start: var(--cp-hero-offset, 0) !important;   /* ↑ pousse TOUT le header vers le bas */
}

/* laisse la place sous le hero pour l'image qui déborde */
.contact-page header.cp-hero.cp-hero--split{
  margin-block-end: var(--cp-img-drop, 240px) !important;
}

/* TAILLE + POSITION de l'image du header (cadre fixe) */
.contact-page header.cp-hero .cp-hero__media{
  position: absolute !important;
  inset-inline-end: var(--cp-img-right, 24px) !important;        /* + grand = plus à gauche ; + petit = plus à droite */
  inset-block-end: calc(-1 * var(--cp-img-drop, 240px)) !important;  /* ↑ augmente pour descendre l’image */
  inline-size: var(--cp-img-w, 520px) !important;           /* largeur image */
  block-size: var(--cp-img-h, 320px) !important;          /* hauteur image */
  border-radius: var(--cp-img-radius, 18px) !important;
  overflow: hidden !important;
  z-index: 4 !important;
}
.contact-page header.cp-hero .cp-hero__media img{
  inline-size: 100% !important;
  block-size: 100% !important;
  object-fit: cover !important;
  object-position: center !important;
}
/* === Contact hero: décalage fin du texte === */
.contact-page .cp-hero__inner{
  position: relative;
  transform: translateX(var(--cp-copy-x, 0));
}
@media (max-width: 992px){
  .contact-page .cp-hero__inner{ transform: none; } /* pas de décalage en mobile */
}
/* =====================================================
   📱 MOBILE — Déplacer l'image du hero contact
   ===================================================== */
@media (max-width: 575.98px) {

    .cp-hero__media {
        position: relative !important;
        inset-block-start: 115px !important;     /* ⇦ monte l’image */
        inset-inline-start: -10px !important;     /* ⇦ pousse l’image à droite */
    }

    .cp-hero__media img {
        display: block !important;
        inline-size: auto !important;
        max-inline-size: 90% !important; /* optionnel si تريد أصغر */
    }
}
/* =====================================================
   📱 MOBILE — Réduire cp-aside + décaler à gauche
   ===================================================== */
@media (max-width: 575.98px) {

    /* 🔵 rendre tout l'aside plus petit + à gauche */
    .cp-aside {
        transform: translateX(-15px) !important;  /* ⇦ vers la gauche */
        font-size: 0.85rem !important;            /* ⇦ texte plus petit */
    }

    /* 🔵 réduire l’espace entre les cartes */
    .cp-info {
        padding: 6px 0 !important;                
    }

    /* 🔵 réduire les icônes */
    .cp-info .cp-ico i {
        font-size: 1rem !important;               /* ⇦ icônes plus petites */
        inline-size: 28px !important;
        block-size: 28px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    /* 🔵 réduire les titres */
    .cp-info h5 {
        font-size: 0.85rem !important;            /* ⇦ plus petit */
        margin-block-end: 2px !important;
    }

    /* 🔵 réduire les liens */
    .cp-info a {
        font-size: 0.82rem !important;            /* ⇦ plus petit */
        line-height: 1.2 !important;
    }
}

</style>

<section class="contact-page">
@php
  // Image héro = image de l'article, sinon fallback
  $postHeroImg = !empty($blog->image)
      ? asset('storage/' . ltrim($blog->image, '/'))
      : asset('img/blog-post-hero.png'); // fallback
@endphp
<header class="cp-hero cp-hero--split"
  style="
    /* bande bleue */
    --cp-hero-offset: 24px;
    --cp-hero-pad: 190px;

    /* image */
    --cp-img-drop: 60px;
    --cp-img-right: 77px;
    --cp-img-w: 600px;
    --cp-img-h: 380px;
    --cp-img-radius: 18px;

    /* ↓↓ décale le texte du header un peu à GAUCHE */
    --cp-copy-x: -48px; /* essaie -16 | -24 | -32 selon ton goût */
  ">

  <div class="cp-hgroup container cp-hero__inner">
    <h1 class="cp-title">Contactez-nous</h1>
    <p class="cp-sub">
      Des technologies d’énergies renouvelables pratiques qui réduisent les coûts et protègent l’environnement.
    </p>
  </div>


<figure class="cp-hero__media">
  <img src="{{ $heroBannerImg }}" alt="Contact hero">
</figure>



</header>



  {{-- CONTENT --}}
  <div class="cp-wrap">
    <div class="container">

      <div class="cp-head">
        <div class="cp-kicker">Demande de devis</div>
        <h2 class="cp-h1">
          Parlons de la façon dont nous pouvons vous aider
        </h2>

        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
          </div>
        @endif
      </div>

      <div class="cp-grid">

        {{-- inset-inline-start: FORM (keep backend fields only) --}}
        <div class="cp-card">
          <form method="POST" action="{{ route('contact.store') }}" class="cp-form">
            @csrf
            <div class="mb-3">
              <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Nom complet" required>
              @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
              <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Adresse e-mail" required>
              @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
              <input type="text" name="subject" value="{{ old('subject') }}" class="form-control @error('subject') is-invalid @enderror" placeholder="Objet" required>
              @error('subject') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-4">
              <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="6" placeholder="Votre message" required>{{ old('message') }}</textarea>
              @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <button type="submit" class="cp-btn">
              <i class="fas fa-paper-plane me-2"></i> Envoyer le message
            </button>
          </form>
        </div>

        {{-- inset-inline-end: INFO CARDS --}}
        <aside class="cp-aside">
          <div class="cp-info">
            <div class="cp-ico"><i class="fa fa-phone"></i></div>
            <div>
              <h5>Téléphone&nbsp;:</h5>
              <a href="tel:01 84 80 81 24">01 84 80 81 24</a>
            </div>
          </div>

          <div class="cp-info">
            <div class="cp-ico"><i class="fas fa-map-marker-alt"></i></div>
            <div>
              <h5>Adresse&nbsp;:</h5>
              <a href="https://goo.gl/maps/Zd4BCynmTb98ivUJ6" target="_blank" rel="noopener">
                171 route de Bezons, 78420 Carrières-sur-Seine, France
              </a>
            </div>
          </div>

          <div class="cp-info">
            <div class="cp-ico"><i class="fa fa-envelope"></i></div>
            <div>
              <h5>Adresse e-mail&nbsp;:</h5>
              <a href="mailto:commercial@franceexpertisolation.fr">commercial@franceexpertisolation.fr</a>
            </div>
          </div>
        </aside>
      </div>

      {{-- MAP --}}
<div class="cp-map">

  {{-- Branding au-dessus de la map --}}
  <h5 class="mb-2 fw-bold">France Expert Isolation</h5>
  <p class="text-muted mb-3">
    171 route de Bezons, 78420 Carrières-sur-Seine, France
  </p>

  <a class="btn btn-outline-primary mb-3"
     target="_blank"
     rel="noopener"
     href="https://www.google.com/maps?q=France%20Expert%20Isolation%20171%20route%20de%20Bezons%2078420%20Carri%C3%A8res-sur-Seine">
     Ouvrir dans Google Maps
  </a>

  {{-- Google Map --}}
  <iframe
    src="https://www.google.com/maps?q=171%20route%20de%20Bezons%2C%2078420%20Carri%C3%A8res-sur-Seine%2C%20France&output=embed"
    loading="lazy"
    referrerpolicy="no-referrer-when-downgrade"
    allowfullscreen>
  </iframe>

</div>


    </div>
  </div>

</section>
@endsection
