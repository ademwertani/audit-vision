@extends('layouts.app')

@section('title', $service->name . ' | Nos services')

@section('content')
  <!-- Page Styles (brand colors respected) -->
  <style>
    :root{
      /* Adjust to your exact palette if needed */
      --brand-blue: #0d2a86;   /* your navbar blue */
      --brand-green:#1f6f10;   /* your green accent */
      --ink:#0b1220; --muted:#6b7280; --line:#e6e6e6; --panel:#fff; --panel-2:#f7f7f7;
    }

    .page-header{ position:relative; isolation:isolate; overflow:hidden; }
    .page-header::after{
      content:""; position:absolute; inset:0; pointer-events:none;
      background: linear-gradient(180deg, rgba(0,0,0,.28), rgba(0,0,0,0) 44%);
    }

    .svc-title { letter-spacing:.2px; }
    .svc-summary { color: var(--brand-blue); }
    .lead-muted { color: var(--muted); }

    /* Media card */
    .media-card{
      background: var(--panel);
      border: 1px solid var(--line);
      border-radius: 18px;
      overflow: hidden;
      box-shadow: 0 10px 24px rgba(0,0,0,.05);
    }
    .media-img{
      width:100%; height:auto; display:block; aspect-ratio: 4/3; object-fit: cover; background: var(--panel-2);
    }
    .zoom-btn{
      position:absolute; right:12px; bottom:12px;
      background: rgba(13,42,134,.9); color:#fff;
      border:0; border-radius:999px; padding:.5rem .7rem; line-height:1; cursor:pointer;
      display:flex; align-items:center; gap:6px;
    }
    .zoom-btn:hover{ filter: brightness(1.05); }

    /* Buttons */
    .btn-brand{
      background: var(--brand-blue); border-color: var(--brand-blue); color:#fff; font-weight:600;
      border-radius: 999px; padding:.6rem 1.1rem;
    }
    .btn-brand:hover{ filter:brightness(1.05); }
    .btn-outline-brand{
      border-color: var(--brand-blue); color: var(--brand-blue); font-weight:600;
      border-radius:999px; padding:.6rem 1.1rem; background:#fff;
    }
    .btn-outline-brand:hover{ background: var(--brand-blue); color:#fff; }

    /* Readability */
    .content-box{
      background: var(--panel); border:1px solid var(--line); border-radius:18px; padding:1.25rem 1.25rem;
    }
    .content-box p{ margin-bottom: .9rem; }

    /* Simple lightbox modal */
    .lb-backdrop{
      position: fixed; inset:0; background: rgba(0,0,0,.75);
      display:none; z-index: 1050; align-items:center; justify-content:center; padding: 2rem;
    }
    .lb-backdrop.is-open{ display:flex; }
    .lb-img{
      max-width: min(1200px, 96vw);
      max-height: 86vh;
      border-radius: 14px; box-shadow: 0 20px 60px rgba(0,0,0,.35);
    }
    .lb-close{
      position:absolute; top:14px; right:16px; background:#fff; border:0; border-radius:999px;
      padding:.35rem .6rem; cursor:pointer; font-weight:700; color:#111;
    }

    /* Small meta row */
    .meta{ font-size:.95rem; color: var(--muted); }
    .meta .dot{ margin: 0 .5rem; opacity:.6; }
  </style>

  <!-- Page Header -->
  <div class="container-fluid page-header py-5">
    <div class="container text-center py-5">
      <h1 class="display-2 text-white mb-3 animated slideInDown">{{ $service->name }}</h1>
      <nav aria-label="breadcrumb" class="animated slideInDown">
        <ol class="breadcrumb justify-content-center mb-0">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Accueil</a></li>
          <li class="breadcrumb-item"><a href="{{ route('services.index') }}">Services</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{ $service->name }}</li>
        </ol>
      </nav>
    </div>
  </div>

  <!-- Service Details -->
  <div class="container-fluid py-5">
    <div class="container">
      <div class="row g-4 g-lg-5 align-items-start">
        <!-- Media -->
        <div class="col-lg-5 wow fadeIn" data-wow-delay=".3s">
          @php
            $img = $service->image;
            $src = \Illuminate\Support\Str::startsWith($img, ['http://','https://','/','storage/'])
                  ? asset($img)
                  : asset('storage/'.$img);
          @endphp
          <div class="position-relative media-card">
            @if($service->image)
              <img src="{{ $src }}" alt="{{ $service->name }}" class="media-img" loading="lazy">
              <button class="zoom-btn" type="button" id="openLightbox" aria-label="Agrandir l’image">
                <i class="fa fa-search-plus"></i><span>Zoom</span>
              </button>
            @else
              <div class="d-flex align-items-center justify-content-center" style="aspect-ratio:4/3;">
                <i class="fa fa-code fa-5x" style="color:var(--brand-blue)"></i>
                <span class="visually-hidden">Aucune image disponible</span>
              </div>
            @endif
          </div>

          @if(!empty($service->updated_at))
            <div class="meta mt-2">
              Mis à jour le {{ $service->updated_at->format('d/m/Y') }}
            </div>
          @endif
        </div>

        <!-- Content -->
        <div class="col-lg-7 wow fadeIn" data-wow-delay=".5s">
          <h2 class="svc-title mb-2">{{ $service->name }}</h2>
          @if(!empty($service->summary))
            <h5 class="svc-summary mb-3">{{ $service->summary }}</h5>
          @endif>

          <div class="content-box mb-3">
            <p class="lead-muted mb-2">À propos du service</p>
            <div class="mb-0">{!! nl2br(e($service->description)) !!}</div>
          </div>

          <div class="d-flex flex-wrap gap-2 align-items-center">
            <a href="{{ url('/contact') }}" class="btn btn-brand">
              <i class="fas fa-phone-alt me-2"></i> Contactez-nous
            </a>
            <a href="{{ route('services.index') }}" class="btn btn-outline-brand">
              <i class="fas fa-arrow-left me-2"></i> Retour aux services
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Lightbox (only if image exists) -->
  @if($service->image)
    <div class="lb-backdrop" id="lightbox" aria-modal="true" role="dialog">
      <button class="lb-close" id="closeLightbox" aria-label="Fermer">×</button>
      <img src="{{ $src }}" alt="{{ $service->name }}" class="lb-img">
    </div>
  @endif

  <!-- Minimal JS -->
  <script>
    (function(){
      const open = document.getElementById('openLightbox');
      const lb   = document.getElementById('lightbox');
      const close= document.getElementById('closeLightbox');
      if(!open || !lb || !close) return;
      open.addEventListener('click', ()=> lb.classList.add('is-open'));
      close.addEventListener('click', ()=> lb.classList.remove('is-open'));
      lb.addEventListener('click', (e)=>{ if(e.target === lb) lb.classList.remove('is-open'); });
      document.addEventListener('keydown', (e)=>{ if(e.key === 'Escape') lb.classList.remove('is-open'); });
    })();
  </script>
@endsection
