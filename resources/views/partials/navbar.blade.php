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

          {{-- MENU SERVICES (inchangé, juste raccourci visuellement) --}}
          <li class="nav-item dropdown services-dd position-relative">
            <a href="{{ route('services.index') }}"
              class="nav-link {{ Request::is('services') || Request::is('services/*') ? 'active' : '' }}"
              data-bs-toggle="dropdown">
              Audit Energetique
            </a>

            @if(!empty($navCategories) && count($navCategories))
            <div class="dropdown-menu services-level1 p-2 border-0 shadow-lg">
              <ul class="list-unstyled m-0">
                @foreach($navCategories as $cat)
                <li class="dropdown-submenu position-relative">

                  <a href="{{ route('services.index') }}?category={{ $cat->id }}"
                     class="dropdown-item d-flex justify-content-between align-items-center"
                     @click.prevent data-bs-toggle="submenu">
                    <span>{{ $cat->name }}</span>
                    <span class="caret">›</span>
                  </a>

                  <ul class="dropdown-menu submenu p-2 shadow">
                    @forelse($cat->services as $srv)
                      <li><a class="dropdown-item" href="{{ route('services.show', $srv->id) }}">{{ $srv->name }}</a></li>
                    @empty
                      <li><span class="dropdown-item text-muted">Aucun service</span></li>
                    @endforelse
                  </ul>

                </li>
                @endforeach
              </ul>
            </div>
            @endif
          </li>

          <li class="nav-item">
            <a href="{{ route('projects.index') }}"
              class="nav-link {{ Request::is('projects*') ? 'active' : '' }}">Etude Thermique</a>
          </li>

          <li class="nav-item">
            <a href="{{ route('blog.index') }}" 
               class="nav-link {{ Request::is('blog*') ? 'active' : '' }}">Stratégie Bas-Carbone</a>
          </li>

          <li class="nav-item">
            <a href="{{ url('/about') }}" 
               class="nav-link {{ Request::is('about') ? 'active' : '' }}">Etude Eclairage</a>
          </li>

          <li class="nav-item">
            <a href="{{ url('/blog') }}" 
               class="nav-link {{ Request::is('blog') ? 'active' : '' }}">Blog</a>
          </li>

        </ul>

        {{-- BOUTON DROITE (OFFICIEL) --}}
        <div class="d-flex gap-3 ms-lg-3 mt-3 mt-lg-0">

          {{-- Bouton Contact BLEU --}}
          <a href="{{ url('contact') }}" class="btn btn-contact-blue">
            Contact
          </a>

        </div>

      </div>
    </nav>
  </div>
</header>

{{-- ================== STYLES PERSO ================== --}}
<style>
/* LOGO PLUS GRAND */
.logo-navbar {
    height: 90px !important;  /* ← tu peux augmenter à 70 ou 80 si tu veux */
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
    color: #28327d !important; /* actif bleu */
}

/* Sous-menus */
.header-aisla .dropdown-menu .dropdown-item {
    color: #000 !important;
}
</style>
