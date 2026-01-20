@extends('layouts.app')

@section('title', 'Contactez-nous')

@section('content')
<style>
/* =========================================================
   Audit Vision – Contact
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

/* ---------- HERO ---------- */
.cp-hero{
  background:var(--navy);
  color:#fff;
  padding:78px 0 92px;
  position:relative;
  overflow:visible;
  z-index:5;
}
.cp-hero .cp-hgroup{max-inline-size:1100px;margin:0 auto;padding:0 12px}
.cp-title{
  font-size:56px; line-height:1.05; font-weight:800; margin:0 0 10px;
}
.cp-hero h1,
.cp-hero .cp-title,
.cp-hero p,
.cp-hero .cp-sub{ color:#fff !important; }
@media (max-width:768px){ .cp-title{font-size:40px} }
.cp-sub{
  max-inline-size:560px; font-size:15px; line-height:1.7; margin:0; opacity:.95;
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
.cp-form .form-control,
.cp-form .form-select{
  background:var(--field)!important; border:1px solid #e6e9f5!important; border-radius:12px!important;
  padding:14px 16px!important; font-size:1rem;
}
.cp-form .form-control:focus,
.cp-form .form-select:focus{
  background:#fff!important;border-color:var(--ring)!important;box-shadow:none!important
}
.cp-form textarea.form-control{min-block-size:160px;resize:vertical}
.cp-btn{
  background:var(--accent); border:none; color:#fff; font-weight:800;
  padding:14px 22px; border-radius:14px; transition:.2s;
}
.cp-btn:hover{transform:translateY(-1px);filter:brightness(.98)}
.contact-page .alert-success{border-radius:12px}

/* ---------- INFO CARDS ---------- */
.cp-aside{display:flex;flex-direction:column;gap:18px}
.cp-info{
  background:#242e77; color:#fff; border-radius:18px; box-shadow:0 8px 18px rgba(0,0,0,.08);
  padding:22px; display:flex; gap:16px; align-items:flex-start;
}
.cp-ico{
  inline-size:56px; block-size:56px; border-radius:50%; display:grid; place-items:center;
  background:var(--accent); color:#fff; font-size:22px; flex-shrink:0;
}
.cp-info h5{ margin:0 0 6px; font-weight:800; font-size:1rem; color:#fff !important; }
.cp-info a{ color:#d8e6ff; text-decoration:none; font-weight:600 }
.cp-info a:hover{ text-decoration:underline }

/* ---------- MAP ---------- */
.cp-map{margin-block-start:34px;background:#f4f7ff;border-radius:20px;box-shadow:0 8px 18px rgba(0,0,0,.06);padding:10px}
.cp-map iframe{inline-size:100%;block-size:440px;border:0;border-radius:12px}

/* ---------- HERO IMAGE SPLIT (overrides) ---------- */
.contact-page header.cp-hero{
  padding: var(--cp-hero-pad, 190px) 0 !important;
  margin-block-start: var(--cp-hero-offset, 24px) !important;
}
.contact-page header.cp-hero.cp-hero--split{
  margin-block-end: var(--cp-img-drop, 60px) !important;
}
.contact-page header.cp-hero .cp-hero__inner{
  position: relative;
  transform: translateX(var(--cp-copy-x, -48px));
}
@media (max-width: 992px){
  .contact-page header.cp-hero .cp-hero__inner{ transform: none; }
}
.contact-page header.cp-hero .cp-hero__media{
  position: absolute !important;
  inset-inline-end: var(--cp-img-right, 77px) !important;
  inset-block-end: calc(-1 * var(--cp-img-drop, 60px)) !important;
  inline-size: var(--cp-img-w, 600px) !important;
  block-size: var(--cp-img-h, 380px) !important;
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

/* Mobile tweaks */
@media (max-width: 575.98px){
  .cp-hero__media{
    position: relative !important;
    inset-block-start: 115px !important;
    inset-inline-start: -10px !important;
  }
  .cp-hero__media img{
    display:block !important;
    inline-size:auto !important;
    max-inline-size:90% !important;
  }

  .cp-aside{
    transform: translateX(-15px) !important;
    font-size: .85rem !important;
  }
  .cp-info{
    padding:6px 0 !important;
  }
  .cp-info .cp-ico i{
    font-size:1rem !important;
    inline-size:28px !important;
    block-size:28px !important;
    display:flex !important;
    align-items:center !important;
    justify-content:center !important;
  }
  .cp-info h5{font-size:.85rem !important;margin-block-end:2px !important;}
  .cp-info a{font-size:.82rem !important;line-height:1.2 !important;}
}
</style>

<section class="contact-page">

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

        {{-- FORMULAIRE : champs alignés avec la table contacts (first_name, last_name, etc.) --}}
        <div class="cp-card">
          <form method="POST" action="{{ route('contact.store') }}" class="cp-form">
            @csrf

            <div class="row g-3">
              <div class="col-md-6">
                <input type="text"
                       name="first_name"
                       value="{{ old('first_name') }}"
                       class="form-control @error('first_name') is-invalid @enderror"
                       placeholder="Prénom"
                       required>
                @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-md-6">
                <input type="text"
                       name="last_name"
                       value="{{ old('last_name') }}"
                       class="form-control @error('last_name') is-invalid @enderror"
                       placeholder="Nom"
                       required>
                @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-md-6">
                <input type="email"
                       name="email"
                       value="{{ old('email') }}"
                       class="form-control @error('email') is-invalid @enderror"
                       placeholder="Adresse e-mail"
                       required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-md-6">
                <input type="text"
                       name="phone"
                       value="{{ old('phone') }}"
                       class="form-control @error('phone') is-invalid @enderror"
                       placeholder="Téléphone (facultatif)">
                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-md-6">
                <input type="text"
                       name="company"
                       value="{{ old('company') }}"
                       class="form-control @error('company') is-invalid @enderror"
                       placeholder="Société (facultatif)">
                @error('company') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-md-6">
                <input type="text"
                       name="city"
                       value="{{ old('city') }}"
                       class="form-control @error('city') is-invalid @enderror"
                       placeholder="Ville (facultatif)">
                @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-12">
                <input type="text"
                       name="subject"
                       value="{{ old('subject') }}"
                       class="form-control @error('subject') is-invalid @enderror"
                       placeholder="Objet de votre demande">
                @error('subject') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-12">
                <textarea name="message"
                          class="form-control @error('message') is-invalid @enderror"
                          rows="6"
                          placeholder="Votre message"
                          required>{{ old('message') }}</textarea>
                @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-12 mt-2">
                <button type="submit" class="cp-btn">
                  <i class="fas fa-paper-plane me-2"></i> Envoyer le message
                </button>
              </div>
            </div>
          </form>
        </div>

        {{-- INFO CONTACT Audit Vision --}}
        <aside class="cp-aside">
          <div class="cp-info">
            <div class="cp-ico"><i class="fa fa-phone"></i></div>
            <div>
              <h5>Téléphone&nbsp;:</h5>
              {{-- remplace par le vrai numéro si tu l'as --}}
              <a href="tel:+33123456789">+33 1 23 45 67 89</a>
            </div>
          </div>

          <div class="cp-info">
            <div class="cp-ico"><i class="fas fa-map-marker-alt"></i></div>
            <div>
              <h5>Adresse&nbsp;:</h5>
              <a href="https://www.google.com/maps/search/?api=1&query=38+Avenue+Villemain+75014+Paris"
                 target="_blank" rel="noopener">
                AUDIT VISION – Bureau d’Études Énergétiques<br>
                38 Avenue Villemain – 75014 Paris
              </a>
            </div>
          </div>

          <div class="cp-info">
            <div class="cp-ico"><i class="fa fa-envelope"></i></div>
            <div>
              <h5>E-mail&nbsp;:</h5>
              {{-- remplace par le vrai mail si besoin --}}
              <a href="mailto:contact@auditvision.fr">contact@auditvision.fr</a>
            </div>
          </div>
        </aside>
      </div>

      {{-- MAP Audit Vision --}}
      <div class="cp-map">
        <h5 class="mb-2 fw-bold">Audit Vision</h5>
        <p class="text-muted mb-3">
          38 Avenue Villemain, 75014 Paris, France<br>
          SIREN : 982 511 644 – Assurance RC Pro : Markel Insurance SE
        </p>

        <a class="btn btn-outline-primary mb-3"
           target="_blank"
           rel="noopener"
           href="https://www.google.com/maps?q=38%20Avenue%20Villemain%2075014%20Paris&output=embed">
           Ouvrir dans Google Maps
        </a>

        <iframe
          src="https://www.google.com/maps?q=38%20Avenue%20Villemain%2075014%20Paris&output=embed"
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"
          allowfullscreen>
        </iframe>
      </div>

    </div>
  </div>

</section>
@endsection
