@extends('layouts.app')

@section('title', $project->name . ' | Nos projets')

@section('content')
  <style>
    /* =========================================================
         Aisla Nova – Project Details (same skin as Contact/About/Blog)
         Scoped to this page only.
         ========================================================= */
    .page-project {
      --navy: #2f3582;
      --navyDark: #1d2760;
      --sky: #31b4eb;
      --accent: #ff6b35;
      --ink: #0f172a;
      --muted: #6b7280;
      --card: #ffffff;
      --ring: #dbe6ff;
      --shadow-lg: 0 24px 48px rgba(16, 24, 40, .12);
      --shadow: 0 10px 18px rgba(0, 0, 0, .08);
    }

    .page-project * {
      box-sizing: border-box
    }

    /* ---------- HERO (left-aligned + long pill breadcrumb) ---------- */
    .pr-hero {
      background: var(--navy);
      color: #fff;
      padding: 78px 0 92px;
      position: relative;
    }

    .pr-hero .pr-hgroup {
      max-width: 1100px;
      margin: 0 auto;
      padding: 0 12px
    }

    .pr-title {
      font-size: 48px;
      line-height: 1.08;
      font-weight: 800;
      margin: 0 0 10px
    }

    @media (min-width:992px) {
      .pr-title {
        font-size: 56px
      }
    }

    .pr-hero h1,
    .pr-hero .pr-title,
    .pr-hero p,
    .pr-hero .pr-sub {
      color: #fff !important
    }

    .pr-sub {
      max-width: 680px;
      font-size: 15px;
      line-height: 1.7;
      margin: 0;
      opacity: .95
    }

    /* breadcrumb pill */
    .pr-bread-wrap {
      position: absolute;
      left: 0;
      right: 0;
      bottom: -28px;
      display: flex;
      justify-content: center
    }

    .pr-bread {
      width: min(1180px, calc(100% - 48px));
      background: var(--sky);
      height: 46px;
      border-radius: 9999px;
      display: flex;
      align-items: center;
      gap: 18px;
      padding: 0 22px;
      font-weight: 700;
      box-shadow: 0 10px 18px rgba(3, 102, 140, .12);
      color: #fff !important;
    }

    .pr-bread a,
    .pr-bread span {
      color: #fff !important
    }

    .pr-bread .sep {
      color: rgba(255, 255, 255, .85) !important
    }

    .pr-bread .home-ico {
      display: inline-grid;
      place-items: center;
      width: 26px;
      height: 26px;
      border-radius: 50%;
      background: rgba(255, 255, 255, .22);
      color: #fff !important;
      font-size: 12px
    }

    /* ---------- Content ---------- */
    .pr-wrap {
      padding: 70px 0 60px
    }

    .pr-grid {
      display: grid;
      grid-template-columns: 1.05fr .95fr;
      gap: 28px;
      align-items: start
    }

    @media (max-width: 991.98px) {
      .pr-grid {
        grid-template-columns: 1fr
      }
    }

    /* Media */
    .media-card {
      background: var(--card);
      border: 1px solid #eef2f6;
      border-radius: 18px;
      overflow: hidden;
      box-shadow: var(--shadow);
    }

    .media-thumb {
      position: relative;
      aspect-ratio: 4/3;
      background: #f2f4f8
    }

    .media-thumb img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block
    }

    .media-placeholder {
      display: grid;
      place-items: center;
      aspect-ratio: 4/3;
      background: #f8fafc;
      color: #94a3b8
    }

    /* Text */
    .pr-body-card {
      background: var(--card);
      border: 1px solid #eef2f6;
      border-radius: 18px;
      box-shadow: var(--shadow);
      padding: 22px;
    }

    @media (min-width:992px) {
      .pr-body-card {
        padding: 28px
      }
    }

    .pr-h2 {
      font-weight: 800;
      color: #0f172a;
      margin: 0 0 8px
    }

    .pr-lead {
      color: #0ea5e9;
      margin: 0 0 12px;
      font-weight: 700
    }

    .prose {
      color: #1f2937;
      line-height: 1.75;
      font-size: 1.05rem
    }

    .prose p {
      margin-bottom: 1rem
    }

    /* Buttons */
    .btn-accent {
      background: var(--accent);
      color: #fff;
      border: none;
      font-weight: 800;
      padding: 12px 18px;
      border-radius: 14px;
      box-shadow: 0 10px 18px rgba(255, 107, 53, .2);
    }

    .btn-accent:hover {
      filter: brightness(.98)
    }

    .btn-outline-accent {
      background: #fff;
      color: #0f1e3d;
      border: 1px solid #dbe4f0;
      font-weight: 700;
      padding: 12px 18px;
      border-radius: 14px;
    }

    .btn-outline-accent:hover {
      background: #f8fafc
    }
  </style>

  <section class="page-project">

    {{-- HERO --}}
    <header class="pr-hero">
      <div class="pr-hgroup container">
        <h1 class="pr-title">{{ $project->name }}</h1>
        @if(!empty($project->summary))
          <p class="pr-sub">{{ $project->summary }}</p>
        @endif
      </div>

      {{-- Long rounded breadcrumb pill --}}
      <div class="pr-bread-wrap">
        <div class="pr-bread">
          <span class="home-ico"><i class="fa fa-home"></i></span>
          <a href="{{ url('/') }}">Accueil</a>
          <span class="sep">|</span>
          <a href="{{ route('projects.index') }}">Projets</a>
          <span class="sep">|</span>
          <span>{{ \Illuminate\Support\Str::limit($project->name, 60) }}</span>
        </div>
      </div>
    </header>

    {{-- DETAILS --}}
    <section class="pr-wrap">
      <div class="container">
        <div class="pr-grid">

          {{-- LEFT: Image --}}
          <div class="media-card">
            @if($project->image)
              <figure class="media-thumb">
                <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->name }}">
              </figure>
            @else
              <div class="media-placeholder">
                <i class="fa fa-image fa-3x"></i>
              </div>
            @endif
          </div>

          {{-- RIGHT: Content --}}
          <div class="pr-body-card">
            <h2 class="pr-h2">{{ $project->name }}</h2>
            @if(!empty($project->summary))
              <h5 class="pr-lead">{{ $project->summary }}</h5>
            @endif

            @if(!empty($project->description))
              <div class="prose mb-3">
                {!! nl2br(e($project->description)) !!}
              </div>
            @endif

            <div class="d-flex flex-wrap align-items-center gap-2 pt-2">
              <a href="{{ route('projects.index') }}" class="btn btn-accent">
                <i class="fas fa-arrow-left me-2"></i> Retour aux projets
              </a>
              <a href="{{ url('/contact') }}" class="btn btn-outline-accent">
                <i class="fas fa-phone-alt me-2"></i> Contactez-nous
              </a>
            </div>




          </div>

        </div>
      </div>

      <!-- Section Clean Energy System -->
      <section class="clean-energy my-5">
        <div class="container">
          <!-- Titre et description -->
          <h2 class="mb-3">Clean Energy System</h2>
          <p class="mb-4 text-muted">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
            dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
            ex ea commodo consequat.
          </p>

          <!-- Listes -->
          <div class="row mb-4">
            <div class="col-md-6">
              <ul class="list-unstyled">
                <li><i class="fas fa-check-circle text-primary me-2"></i> Far curiosity incommode now led smallness
                  allowance.</li>
                <li><i class="fas fa-check-circle text-primary me-2"></i> Favour bed assure son things yet.</li>
                <li><i class="fas fa-check-circle text-primary me-2"></i> She consisted consulted elsewhere
                  happiness.</li>
                <li><i class="fas fa-check-circle text-primary me-2"></i> Disposing household any old the.</li>
                <li><i class="fas fa-check-circle text-primary me-2"></i> Widow downs you new shade did't hopes
                  small.</li>
                <li><i class="fas fa-check-circle text-primary me-2"></i> Interested discretion estimating on
                  stimulated.</li>
              </ul>
            </div>
            <div class="col-md-6">
              <ul class="list-unstyled">
                <li><i class="fas fa-check-circle text-primary me-2"></i> Far curiosity incommode now led smallness
                  allowance.</li>
                <li><i class="fas fa-check-circle text-primary me-2"></i> Favour bed assure son things yet.</li>
                <li><i class="fas fa-check-circle text-primary me-2"></i> She consisted consulted elsewhere
                  happiness.</li>
                <li><i class="fas fa-check-circle text-primary me-2"></i> Disposing household any old the.</li>
                <li><i class="fas fa-check-circle text-primary me-2"></i> Widow downs you new shade did't hopes
                  small.</li>
                <li><i class="fas fa-check-circle text-primary me-2"></i> Interested discretion estimating on
                  stimulated.</li>
              </ul>
            </div>
          </div>

      <!-- Citation -->
<div class="quote bg-primary text-white p-4 rounded mb-5 d-flex align-items-center">
  <!-- Image -->
  <img src="/img/akon.png" alt="Icon" 
       style="width: 60px; height: 60px; margin-right: 15px;">

  <!-- Texte -->
  <p class="mb-0 fs-3">
    <strong>“Success is the result of perfection, hard work, learning<br> 
      from failure, loyalty, and persistence”</strong>
  </p>
</div>


          <!-- Services / What We Provide -->
          <div class="row text-center">
            <div class="col-md-4 mb-4">
              <div class="icon mb-3">
                <i class="fas fa-battery-full fa-2x text-primary"></i>
              </div>
              <h5>Battery Storage Solutions</h5>
              <p class="text-muted">We fully utilise the latest corporate renewable energy technology to generate
                significant energy.</p>
            </div>
            <div class="col-md-4 mb-4">
              <div class="icon mb-3">
                <i class="fas fa-solar-panel fa-2x text-primary"></i>
              </div>
              <h5>Commercial Solar Energy</h5>
              <p class="text-muted">We fully utilise the latest corporate renewable energy technology to generate
                significant energy.</p>
            </div>
            <div class="col-md-4 mb-4">
              <div class="icon mb-3">
                <i class="fas fa-chart-line fa-2x text-primary"></i>
              </div>
              <h5>High Return On Investment</h5>
              <p class="text-muted">We fully utilise the latest corporate renewable energy technology to generate
                significant energy.</p>
            </div>
          </div>
        </div>
      </section>
    </section>

  </section>
@endsection