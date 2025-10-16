{{-- ================== UNIFIED HEADER ================== --}}
@php
  $about = $about ?? (object) [];
  $social = $social ?? (object) [];
@endphp
<header class="header-aisla bg-white shadow-sm sticky-top">
  <div class="container-fluid">
    <nav class="navbar navbar-expand-lg navbar-light py-1">
      {{-- Logo totalement à gauche et plus grand --}}
      <a href="{{ url('/') }}" class="navbar-brand me-auto d-flex align-items-center gap-2">
        @if(!empty($about->logo))
          <img src="{{ asset('storage/' . ltrim($about->logo, '/')) }}" alt="France Isolation" class="ms-0 logo-navbar">
        @else
          <img src="{{ asset('/img/lo.png') }}" alt="France Isolation" class="ms-0 logo-navbar">
        @endif
      </a>

      {{-- Toggler mobile --}}
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapseNew"
        aria-controls="navbarCollapseNew" aria-expanded="false" aria-label="Basculer la navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      {{-- Liens + Boutons --}}
      <div class="collapse navbar-collapse" id="navbarCollapseNew">
        {{-- Liens centrés --}}
        <ul class="navbar-nav mx-auto align-items-lg-center gap-3">
          <li class="nav-item">
            <a href="{{ url('/') }}" class="nav-link {{ Request::is('/') ? 'active' : '' }}">Accueil</a>
          </li>

          <li class="nav-item dropdown services-dd d-flex align-items-center gap-1 position-relative">
            <a href="{{ route('services.index') }}"
              class="nav-link {{ Request::is('services') || Request::is('services/*') ? 'active' : '' }}">
              Services
            </a>

            @if(!empty($services) && count($services))
              <button class="btn btn-link p-0 dropdown-toggle dropdown-toggle-split nav-caret"
                      type="button"
                      data-bs-toggle="dropdown"
                      data-bs-offset="0,10"
                      aria-expanded="false"
                      aria-label="Voir la liste des services"></button>

              <ul class="dropdown-menu services-menu">
                @foreach($services as $service)
                  <li>
                    <a href="{{ route('services.show', $service->id) }}"
                      class="dropdown-item {{ Request::is('services/' . $service->id) ? 'active' : '' }}">
                      {{ $service->name }}
                    </a>
                  </li>
                @endforeach
              </ul>
            @endif
          </li>

          <style>
            /* Ouvre au survol (desktop) */
            @media (min-width: 992px) {
              .header-aisla .services-dd:hover > .dropdown-menu,
              .header-aisla .services-dd .dropdown-menu:hover{
                display: block;
                opacity: 1;
                visibility: visible;
              }
            }
            /* Place le menu immédiatement sous "Services" */
            .header-aisla .navbar .dropdown .dropdown-menu {
              position: absolute !important;
              top: 100% !important;
              left: 0 !important;
              right: auto !important;
              transform: none !important;
              margin: 0 !important;
              z-index: 1050;
            }
            .nav-caret { line-height: 1; }
            /* Pont invisible anti-flicker */
            .header-aisla .services-dd { position: relative; }
            .header-aisla .services-dd::after{
              content: "";
              position: absolute;
              left: 0; right: 0;
              top: 100%;
              height: 10px;
            }
          </style>

          <li class="nav-item">
            <a href="{{ route('projects.index') }}"
              class="nav-link {{ Request::is('projects*') ? 'active' : '' }}">Projets</a>
          </li>

          <li class="nav-item">
            <a href="{{ route('blog.index') }}" class="nav-link {{ Request::is('blog*') ? 'active' : '' }}">Blog</a>
          </li>

          <li class="nav-item">
            <a href="{{ url('/about') }}" class="nav-link {{ Request::is('about') ? 'active' : '' }}">À propos</a>
          </li>

          <li class="nav-item">
            <a href="{{ url('/contact') }}" class="nav-link {{ Request::is('contact') ? 'active' : '' }}">Contact</a>
          </li>
        </ul>

        {{-- Boutons alignés à droite --}}
        <div class="d-flex gap-3 ms-lg-3 mt-3 mt-lg-0">
          <a href="{{ url('contact') }}" class="btn btn-contact">Contactez-nous</a>
          @if(!request()->is('quote'))
            <a href="{{ url('quote') }}" class="btn btn-outline-contact quote-btn">
              Demander un devis
            </a>
          @endif
        </div>
      </div>
    </nav>
  </div>
</header>
