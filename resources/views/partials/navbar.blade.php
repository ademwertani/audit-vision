{{-- ================== UNIFIED HEADER ================== --}}
@php
  $about = $about ?? (object) [];
  $social = $social ?? (object) [];
@endphp

<header class="header-aisla bg-white shadow-sm sticky-top">
  <div class="container-fluid">
    <nav class="navbar navbar-expand-lg navbar-light py-1">

      {{-- LOGO PLUS GRAND --}}
      <a href="{{ url('/') }}" class="navbar-brand me-auto d-flex align-items-center gap-2">
        @if(!empty($about->logo))
          <img src="{{ asset('storage/' . ltrim($about->logo, '/')) }}" 
               alt="Audit Vision" 
               class="logo-navbar">
        @else
          <img src="{{ asset('/img/logo.png') }}" 
               alt="Audit Vision" 
               class="logo-navbar">
        @endif
      </a>

      {{-- Toggler mobile --}}
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapseNew"
        aria-controls="navbarCollapseNew" aria-expanded="false" aria-label="Basculer la navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      {{-- Liens --}}
      <div class="collapse navbar-collapse" id="navbarCollapseNew">

        <ul class="navbar-nav mx-auto align-items-lg-center gap-3">

          <li class="nav-item">
            <a href="{{ url('/') }}" class="nav-link {{ Request::is('/') ? 'active' : '' }}">Accueil</a>
          </li>

          {{-- 🔽 NOUVEAU : MENU DÉROULANT STRATÉGIE BAS-CARBONE --}}
          <li class="nav-item dropdown">
            <a href="#"
               class="nav-link dropdown-toggle {{ Request::is('bilan-carbone') || Request::is('plan-reduction') ? 'active' : '' }}"
               data-bs-toggle="dropdown">
              Audit Energetique
            </a>
            <ul class="dropdown-menu">
              <li>
                <a class="dropdown-item {{ Request::is('audit-tertiaire.blade') ? 'active' : '' }}"
                   href="{{ route('audit-tertiaire') }}">
                  Audit énergétique des bâtiments tertiaires
                </a>
              </li>
              <li>
                <a class="dropdown-item {{ Request::is('audit-habitat-collectif') ? 'active' : '' }}"
                   href="{{ route('audit-habitat-collectif') }}">
                  Audit énergétique des bâtiments habitations collectives
                </a>
              </li>
            </ul>
          </li>

          {{-- 🔽 NOUVEAU : MENU DÉROULANT STRATÉGIE BAS-CARBONE --}}
          <li class="nav-item dropdown">
            <a href="#"
               class="nav-link dropdown-toggle {{ Request::is('bilan-carbone') || Request::is('plan-reduction') ? 'active' : '' }}"
               data-bs-toggle="dropdown">
              Etude Thermique
            </a>
            <ul class="dropdown-menu">
              <li>
                <a class="dropdown-item {{ Request::is('etude-thermique') ? 'active' : '' }}"
                   href="{{ route('etude-thermique') }}">
                  Etude thermique des chambres froides
                </a>
              </li>
              <li>
                <a class="dropdown-item {{ Request::is('dimensionnement-destratificateurs') ? 'active' : '' }}"
                   href="{{ route('dimensionnement-destratificateurs') }}">
                  Dimensionnement et calepinage de destratificateur
                </a>
              </li>
            </ul>
          </li>

          {{-- 🔽 NOUVEAU : MENU DÉROULANT STRATÉGIE BAS-CARBONE --}}
          <li class="nav-item dropdown">
            <a href="#"
               class="nav-link dropdown-toggle {{ Request::is('bilan-carbone') || Request::is('plan-reduction') ? 'active' : '' }}"
               data-bs-toggle="dropdown">
              Stratégie Bas-Carbone
            </a>
            <ul class="dropdown-menu">
              <li>
                <a class="dropdown-item {{ Request::is('bilan-carbone') ? 'active' : '' }}"
                   href="{{ route('bilan-carbone') }}">
                  Bilan Carbone
                </a>
              </li>
              <li>
                <a class="dropdown-item {{ Request::is('plan-reduction') ? 'active' : '' }}"
                   href="{{ route('plan-reduction') }}">
                  Étude de plan d’action de réduction
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="{{ url('/etude-eclairage') }}" 
               class="nav-link {{ Request::is('etude-eclairage') ? 'active' : '' }}">Etude Eclairage</a>
          </li>

          <li class="nav-item">
            <a href="{{ url('/blog') }}" 
               class="nav-link {{ Request::is('blog') ? 'active' : '' }}">Blog</a>
          </li>

        </ul>

        {{-- BOUTONS À DROITE --}}
        <div class="d-flex align-items-center gap-3 flex-nowrap ms-lg-3 mt-3 mt-lg-0">

          {{-- PILL CERTIFICATION (image cliquable → ouvre modal) --}}
          <a href="javascript:void(0);"
             class="brochure-pill d-flex align-items-center"
             id="openCertifModal">
            <div class="brochure-thumb">
              <img src="{{ asset('img/certif.png') }}" alt="Certification AuditVision">
            </div>
            <span class="brochure-label d-none d-md-inline">
              Notre certification
            </span>
          </a>

          {{-- Bouton Contact BLEU --}}
          <a href="{{ url('contact') }}" class="btn btn-contact-blue">
            Contact
          </a>

        </div>

      </div>
    </nav>
  </div>
</header>

{{-- ================== MODAL IMAGE CERTIFICATION ================== --}}
<div id="certifModal" class="certif-modal">
    <div class="certif-overlay"></div>

    <div class="certif-content">
        <img src="{{ asset('img/certif.png') }}" alt="Certification AuditVision">
        <button class="certif-close">&times;</button>
    </div>
</div>

{{-- ================== STYLES PERSO ================== --}}
<style>
/* LOGO PLUS GRAND */
.logo-navbar {
    height: 90px !important;
    width: auto;
}

/* Bouton bleu Contact */
.btn-contact-blue {
    background: #28327d !important;
    color: #ffffff !important;
    border-radius: 30px;
    padding: 8px 22px;
    font-weight: 600;
    border: none;
    transition: .2s ease;
}

.btn-contact-blue:hover {
    background: #1f265f !important;
    color: #fff;
}

/* Couleur du texte du menu */
.header-aisla .nav-link {
    color: #000 !important;
    font-weight: 500;
}

.header-aisla .nav-link.active {
    color: #28327d !important;
}

/* Sous-menus */
.header-aisla .dropdown-menu .dropdown-item {
    color: #000 !important;
    font-size: .9rem;
}

.header-aisla .dropdown-menu .dropdown-item.active {
    background: #e5edff;
    color: #28327d !important;
    font-weight: 600;
}

/* ===============================
   PILL CERTIFICATION – IMAGE MISE EN VALEUR
   =============================== */
.brochure-pill {
    padding: 4px 14px;
    border-radius: 999px;
    background: #ffffff;
    border: 1px solid rgba(15, 23, 42, 0.12);
    text-decoration: none;
    cursor: pointer;
    gap: 10px;
    box-shadow: 0 8px 20px rgba(15,23,42,0.10);
    transform: translateY(0) scale(1);
    transition: 
        background-color 0.20s ease,
        box-shadow 0.20s ease,
        transform 0.20s ease,
        border-color 0.20s ease;
}

.brochure-pill:hover {
    background: #f1f5f9;
    border-color: rgba(15, 23, 42, 0.28);
    box-shadow: 0 14px 32px rgba(15,23,42,0.18);
    transform: translateY(-1px) scale(1.01);
}

.brochure-thumb {
    width: 40px;
    height: 40px;
    border-radius: 14px;
    overflow: hidden;
    background: radial-gradient(circle at 30% 0%, #e0f2fe 0, #ffffff 55%);
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid rgba(148, 163, 184, 0.4);
    box-shadow: 0 8px 18px rgba(15,23,42,0.18);
}

.brochure-thumb img {
    width: 85%;
    height: 85%;
    object-fit: contain;
}

/* Texte à côté de l'image (caché sur très petit écran) */
.brochure-label {
    font-size: 0.82rem;
    font-weight: 600;
    color: #0f172a;
    white-space: nowrap;
}

/* Légères adaptations sur mobile */
@media (max-width: 575.98px) {
    .brochure-pill {
        padding: 3px 10px;
        box-shadow: 0 6px 16px rgba(15,23,42,0.12);
    }
    .brochure-thumb {
        width: 34px;
        height: 34px;
    }
}

/* =============================
   LIGHTBOX CERTIFICATION
   ============================= */

.certif-modal {
    position: fixed;
    inset: 0;
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 999999;
}

.certif-modal.active {
    display: flex;
}

/* Fond sombre flouté */
.certif-overlay {
    position: absolute;
    inset: 0;
    background: rgba(15, 23, 42, 0.65);
    backdrop-filter: blur(6px);
    opacity: 0;
    transition: opacity .35s ease;
}

.certif-modal.active .certif-overlay {
    opacity: 1;
}

/* Boîte contenant l'image */
.certif-content {
    position: relative;
    z-index: 10;
    background: #ffffff;
    border-radius: 20px;
    padding: 18px;
    box-shadow: 0 28px 90px rgba(0,0,0,.35);
    transform: scale(.75) translateY(40px);
    opacity: 0;
    transition: transform .35s ease, opacity .35s ease;
}

/* Animation d'apparition */
.certif-modal.active .certif-content {
    transform: scale(1) translateY(0);
    opacity: 1;
}

/* Image */
.certif-content img {
    max-width: 88vw;
    max-height: 78vh;
    border-radius: 12px;
    object-fit: contain;
}

/* Bouton X */
.certif-close {
    position: absolute;
    top: -12px;
    right: -12px;
    background: #fff;
    border: none;
    font-size: 32px;
    width: 42px;
    height: 42px;
    border-radius: 50%;
    line-height: 0;
    box-shadow: 0 10px 34px rgba(0,0,0,.25);
    cursor: pointer;
    transition: transform .2s ease;
}

.certif-close:hover {
    transform: scale(1.15);
}
</style>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const openBtn = document.getElementById("openCertifModal");
    const modal   = document.getElementById("certifModal");
    const closeBtn = modal ? modal.querySelector(".certif-close") : null;
    const overlay = modal ? modal.querySelector(".certif-overlay") : null;

    if (!openBtn || !modal || !closeBtn || !overlay) return;

    openBtn.addEventListener("click", () => {
        modal.classList.add("active");
    });

    closeBtn.addEventListener("click", () => {
        modal.classList.remove("active");
    });

    overlay.addEventListener("click", () => {
        modal.classList.remove("active");
    });
});
</script>
