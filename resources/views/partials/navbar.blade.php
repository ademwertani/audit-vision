{{-- ================== UNIFIED HEADER ================== --}}
@php
  $about  = $about  ?? (object)[];
  $social = $social ?? (object)[];
@endphp

<header class="header-aisla">
  {{-- Unified header with light blue background containing both topbar and navbar --}}
  <div class="unified-header">
    <div class="container">
      {{-- Top section with social links and contact info --}}
      <div class="topbar-section d-none d-md-block">
        <div class="topbar-row">
          {{-- Socials --}}
          <div class="topbar-social">
            @if(!empty($social->facebook))
              <a href="{{ $social->facebook }}" target="_blank"><i class="fab fa-facebook-f"></i><span>Facebook</span></a>
            @endif
            @if(!empty($social->twitter))
              <a href="{{ $social->twitter }}" target="_blank"><i class="fab fa-twitter"></i><span>Twitter</span></a>
            @endif
            @if(!empty($social->linkedin))
              <a href="{{ $social->linkedin }}" target="_blank"><i class="fab fa-linkedin-in"></i><span>Linked In</span></a>
            @endif
          </div>

          {{-- Contact info --}}
          <div class="topbar-info">
            @if(!empty($about->email))
              <span class="info-item">
                <span class="badge-icon"><i class="far fa-envelope"></i></span>
                <span class="info-text">{{ $about->email }}</span>
              </span>
            @endif
            @if(!empty($about->location))
              <span class="info-item">
                <span class="badge-icon"><i class="fas fa-map-marker-alt"></i></span>
                <span class="info-text">{{ $about->location }}</span>
              </span>
            @endif
          </div>
        </div>
      </div>

      {{-- White pill navigation --}}
      <div class="nav-pill nav-pill-bar">
        <nav class="navbar navbar-expand-lg navbar-aisla p-0">
          {{-- Brand --}}
          <a href="{{ url('/') }}" class="navbar-brand d-flex align-items-center gap-2">
            @if(!empty($about->logo))
              <img src="{{ asset('storage/' . ltrim($about->logo, '/')) }}" alt="Aisla Nova">
            @else
              <img src="{{ asset('img/logo-aisla.png') }}" alt="Aisla Nova">
            @endif
          </a>

          {{-- Toggler --}}
          <button class="navbar-toggler me-2" type="button" data-bs-toggle="collapse"
                  data-bs-target="#navbarCollapseNew" aria-controls="navbarCollapseNew"
                  aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          {{-- Links --}}
          <div class="collapse navbar-collapse" id="navbarCollapseNew">
            <div class="navbar-nav ms-auto mx-xl-auto p-0 align-items-lg-center">
              <a href="{{ url('/') }}" class="nav-item nav-link {{ Request::is('/') ? 'active' : '' }}">Home</a>
              <a href="{{ url('/about') }}" class="nav-item nav-link {{ Request::is('about') ? 'active' : '' }}">About</a>
              <a href="{{ route('projects.index') }}" class="nav-item nav-link {{ Request::is('projects') || Request::is('projects/*') ? 'active' : '' }}">Projects</a>
              <span class="nav-divider d-none d-lg-block"></span>
              <div class="nav-item dropdown">
                <a href="{{ url('/services') }}" class="nav-link dropdown-toggle {{ Request::is('services') || Request::is('services/*') ? 'active' : '' }}" data-bs-toggle="dropdown">Services</a>
                <div class="dropdown-menu">
                  @foreach(($services ?? []) as $service)
                    <a href="{{ route('services.show', $service->id) }}" class="dropdown-item {{ Request::is('services/'.$service->id) ? 'active' : '' }}">{{ $service->name }}</a>
                  @endforeach
                </div>
              </div>
              <a href="{{ url('/blog') }}" class="nav-item nav-link {{ Request::is('blog') ? 'active' : '' }}">Blog</a>
              <a href="{{ url('/contact') }}" class="nav-item nav-link {{ Request::is('contact') ? 'active' : '' }}">Contact</a>
            </div>

            {{-- Right rail --}}
            <div class="d-flex align-items-center right-rail ms-lg-2">
              <button class="search-btn me-2" type="button" aria-label="Search">
                <i class="fas fa-search"></i>
              </button>
              <a href="{{ url('/contact') }}" class="btn cta-btn">Request a Quote</a>
            </div>
          </div>
        </nav>
      </div>
    </div>
  </div>

  {{-- Removed separate sky apron as it's now part of unified header --}}
</header>
{{-- ================== /HEADER ================== --}}
