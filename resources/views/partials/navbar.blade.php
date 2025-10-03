{{-- ================== UNIFIED HEADER ================== --}}
@php
  $about = $about ?? (object) [];
  $social = $social ?? (object) [];
@endphp
<header class="header-aisla bg-white shadow-sm sticky-top">
  <div class="container-fluid"> {{-- full width pour coller totalement à gauche --}}
    <nav class="navbar navbar-expand-lg navbar-light py-1">
      {{-- Logo totalement à gauche et plus grand --}}
      <a href="{{ url('/') }}" class="navbar-brand me-auto d-flex align-items-center gap-2">
        @if(!empty($about->logo))
          <img src="{{ asset('storage/' . ltrim($about->logo, '/')) }}" alt="France Isolation" class="ms-0 logo-navbar">
        @else
          <img src="{{ asset('/img/png.png') }}" alt="Aisla Nova" class="ms-0 logo-navbar">
        @endif
      </a>
      {{-- Toggler mobile --}}
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapseNew"
        aria-controls="navbarCollapseNew" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      {{-- Liens + Boutons --}}
      <div class="collapse navbar-collapse" id="navbarCollapseNew">
        {{-- Liens centrés --}}
        <ul class="navbar-nav mx-auto align-items-lg-center gap-3">
          <li class="nav-item">
            <a href="{{ url('/') }}" class="nav-link {{ Request::is('/') ? 'active' : '' }}">Home</a>
          </li>
          <li class="nav-item dropdown">
            <a href="{{ url('/services') }}"
              class="nav-link dropdown-toggle {{ Request::is('services*') ? 'active' : '' }}"
              data-bs-toggle="dropdown">Services</a>
            <ul class="dropdown-menu">
              @foreach(($services ?? []) as $service)
                <li>
                  <a href="{{ route('services.show', $service->id) }}"
                    class="dropdown-item {{ Request::is('services/' . $service->id) ? 'active' : '' }}">
                    {{ $service->name }}
                  </a>
                </li>
              @endforeach
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{ route('projects.index') }}"
              class="nav-link {{ Request::is('projects*') ? 'active' : '' }}">Projects</a>
          </li>
          <li class="nav-item">
            <a href="{{ route('blog.index') }}" class="nav-link {{ Request::is('blog*') ? 'active' : '' }}">Blog</a>
          </li>
          <li class="nav-item">
            <a href="{{ url('/about') }}" class="nav-link {{ Request::is('about') ? 'active' : '' }}">About Us</a>
          </li>
          <li class="nav-item">
            <a href="{{ url('/contact') }}" class="nav-link {{ Request::is('Contact Us') ? 'active' : '' }}">Contact Us
            </a>
          </li>
        </ul>
        {{-- Boutons alignés à droite --}}
<div class="d-flex gap-3 ms-lg-3 mt-3 mt-lg-0">
  <a href="{{ url('contact') }}" class="btn btn-contact">Contact Us</a>

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
