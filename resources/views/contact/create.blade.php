@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<style>
/* =========================================================
   Aisla Nova – Contact (matches the provided mock)
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
.cp-hero .cp-hgroup{max-width:1100px;margin:0 auto;padding:0 12px}
.cp-title{
  font-size:56px; line-height:1.05; font-weight:800; margin:0 0 10px;
}
.cp-hero h1,
.cp-hero .cp-title,
.cp-hero p,
.cp-hero .cp-sub{ color:#fff !important; }  /* force white in hero */
@media (max-width:768px){ .cp-title{font-size:40px} }
.cp-sub{
  max-width:560px; font-size:15px; line-height:1.7; margin:0; opacity:.95;
}

/* Long rounded breadcrumb bar (sits at hero bottom like the mock) */
.cp-bread-wrap{position:absolute; left:0; right:0; bottom:-28px; display:flex; justify-content:center}
.cp-bread{
  width:min(1180px, calc(100% - 48px));
  background:var(--sky);
  height:46px; border-radius:9999px;
  display:flex; align-items:center; gap:18px;
  padding:0 22px; font-weight:700; box-shadow:0 10px 18px rgba(3,102,140,.12);
  color:#fff !important;              /* base text color white */
}
.cp-bread a,
.cp-bread span{ color:#fff !important; }  /* make “Home” + “Contact Us” white */
.cp-bread .sep{ color:rgba(255,255,255,.85) !important; }
.cp-bread .home-ico{
  display:inline-grid; place-items:center; width:26px; height:26px; border-radius:50%;
  background:rgba(255,255,255,.22); color:#fff !important; font-size:12px;
}

/* ---------- SECTION HEAD ---------- */
.cp-wrap{padding:70px 0 40px}
.cp-head{max-width:820px;margin:0 auto 8px;text-align:center}
.cp-kicker{color:var(--sky);font-weight:800;text-transform:uppercase;letter-spacing:.12em;font-size:.85rem}
.cp-h1{color:var(--ink);font-weight:800;line-height:1.14;margin:8px 0 0}

/* ---------- GRID ---------- */
.cp-grid{display:grid;grid-template-columns:1.35fr .9fr;gap:28px;align-items:start;margin-top:26px}
@media (max-width: 991.98px){.cp-grid{grid-template-columns:1fr}}

/* ---------- FORM CARD ---------- */
.cp-card{background:var(--card);border-radius:20px;box-shadow:var(--shadow);padding:28px}
.cp-form .form-control{
  background:var(--field)!important; border:1px solid #e6e9f5!important; border-radius:12px!important;
  padding:14px 16px!important; font-size:1rem;
}
.cp-form .form-control:focus{background:#fff!important;border-color:var(--ring)!important;box-shadow:none!important}
.cp-form textarea.form-control{min-height:160px;resize:vertical}
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
  width:56px; height:56px; border-radius:50%; display:grid; place-items:center;
  background:var(--accent); color:#fff; font-size:22px; flex-shrink:0;
}
.cp-info h5{ margin:0 0 6px; font-weight:800; font-size:1rem; color:#fff !important; }  /* force white */
.cp-info a{ color:#d8e6ff; text-decoration:none; font-weight:600 }
.cp-info a:hover{ text-decoration:underline }

/* ---------- MAP ---------- */
.cp-map{margin-top:34px;background:#f4f7ff;border-radius:20px;box-shadow:0 8px 18px rgba(0,0,0,.06);padding:10px}
.cp-map iframe{width:100%;height:440px;border:0;border-radius:12px}
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
  margin-bottom: var(--cp-img-drop);
}

.cp-hero__inner{ position: relative; z-index: 3; }
.cp-hero .cp-title{ margin:0 0 6px; font-weight:800; font-size: clamp(34px, 5vw, 64px); }
.cp-hero .cp-sub{ max-width: 720px; opacity:.95; }

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
  right: clamp(16px, 3vw, 40px);
  bottom: calc(-1 * var(--cp-img-drop));
  width: min(520px, 50vw);   /* largeur de l’image */
  z-index: 1;                /* sous la couche bleue */
}
.cp-hero__media img{
  display:block; width:100%; height:auto;
  border: 0;
  border-radius: 0;          /* laisse droit (mets 18px si tu veux arrondi) */
  box-shadow: none; filter:none; transform:none;
}

/* Responsive */
@media (max-width: 992px){
  .cp-hero--split{ --cp-img-drop: 48px; }
  .cp-hero__media{ width: min(640px, 88vw); right: 12px; }
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
  margin-bottom: var(--cp-img-drop);
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
  right: clamp(16px, 3vw, 40px);
  bottom: calc(-1 * var(--cp-img-drop)); /* fait dépasser vers le bas */
  width: min(520px, 50vw);
  z-index: 4;                                  /* > au bleu, < au texte */
}
.cp-hero__media img{
  display:block; width:100%; height:auto;
  border: 0;
  border-radius: 18px !important;              /* coins arrondis */
  box-shadow: none !important;
  filter: none !important;
  transform: none !important;
}

/* Responsive */
@media (max-width: 992px){
  .cp-hero--split{ --cp-img-drop: 48px; }
  .cp-hero__media{ width: min(640px, 88vw); right: 12px; }
}

</style>

<section class="contact-page">

{{-- HERO --}}
<header class="cp-hero cp-hero--split">
  <div class="cp-hgroup container cp-hero__inner">
    <h1 class="cp-title">Contact Us</h1>
    <p class="cp-sub">
      Practical renewable energy technology that reduces costs and helps the environment
    </p>
  </div>

  {{-- Image statique, même style/placement --}}
  <figure class="cp-hero__media">
    <img src="{{ asset('img/ima.png') }}" alt="Contact hero">
    {{-- mets ici ton image statique (ex: public/img/contact-hero.png) --}}
  </figure>
</header>


  {{-- CONTENT --}}
  <div class="cp-wrap">
    <div class="container">

      <div class="cp-head">
        <div class="cp-kicker">Request a quote</div>
        <h2 class="cp-h1">
          Talk About How We Can Help<br>
          You 
        </h2>

        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif
      </div>

      <div class="cp-grid">

        {{-- LEFT: FORM (keep backend fields only) --}}
        <div class="cp-card">
          <form method="POST" action="{{ route('contact.store') }}" class="cp-form">
            @csrf
            <div class="mb-3">
              <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Complete Name" required>
              @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
              <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Email Address" required>
              @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
              <input type="text" name="subject" value="{{ old('subject') }}" class="form-control @error('subject') is-invalid @enderror" placeholder="Subject" required>
              @error('subject') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-4">
              <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="6" placeholder="Your Message" required>{{ old('message') }}</textarea>
              @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <button type="submit" class="cp-btn">
              <i class="fas fa-paper-plane me-2"></i> Send Message
            </button>
          </form>
        </div>

        {{-- RIGHT: INFO CARDS --}}
        <aside class="cp-aside">
          <div class="cp-info">
            <div class="cp-ico"><i class="fa fa-phone"></i></div>
            <div>
              <h5>Phone No:</h5>
              <a href="tel:+330948160487">+33 09 48 16 04 87</a>
            </div>
          </div>

          <div class="cp-info">
            <div class="cp-ico"><i class="fas fa-map-marker-alt"></i></div>
            <div>
              <h5>Location:</h5>
              <a href="https://goo.gl/maps/Zd4BCynmTb98ivUJ6" target="_blank" rel="noopener">
                171 route de Bezons, 78420 Carrières-sur-Seine, France
              </a>
            </div>
          </div>

          <div class="cp-info">
            <div class="cp-ico"><i class="fa fa-envelope"></i></div>
            <div>
              <h5>Email Address:</h5>
              <a href="mailto:commercial@eco-call.fr">commercial@eco-call.fr</a>
            </div>
          </div>
        </aside>
      </div>

      {{-- MAP --}}
      <div class="cp-map">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2622.102419139038!2d2.1990053!3d48.9134409!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xa5cd521a7a2aeb3%3A0x53a81c81da566b1a!2sEco%20Call!5e0!3m2!1sfr!2stn!4v1753705033700!5m2!1sfr!2stn"
          loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen>
        </iframe>
      </div>

    </div>
  </div>

</section>
@endsection
