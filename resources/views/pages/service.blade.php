@extends('layouts.app')

@section('title', 'Our Services')

@section('content')
  <!-- Page Styles (brand-respecting, lightweight) -->
  <style>
    :root{
      /* ← Adjust these if you need exact hex codes */
      --brand-blue: #0d2a86;   /* navbar blue from your theme */
      --brand-green:#1f6f10;   /* fact band green from your theme */
      --ink:#0b1220; --muted:#6b7280; --line:#e6e6e6; --panel:#fff; --panel-2:#f7f7f7;
    }

    /* Keep your header background image (provided by theme); only refine overlay/readability */
    .page-header{ position:relative; isolation:isolate; overflow:hidden; }
    .page-header::after{
      content:""; position:absolute; inset:0; pointer-events:none;
      background: linear-gradient(180deg, rgba(0,0,0,.25), rgba(0,0,0,0) 40%);
    }

    /* Facts (green band) */
    .fact-band{ background: var(--brand-green); color:#fff; border-top:1px solid rgba(255,255,255,.08); border-bottom:1px solid rgba(0,0,0,.08); }
    .fact-card{ display:flex; align-items:center; gap:12px; padding:10px 0; }
    .fact-number{ font-weight:800; color: var(--brand-blue); text-shadow: 0 2px 0 rgba(0,0,0,.08); }
    .fact-label{ margin:0; color:#e8f0e8; }

    /* Services */
    .services-wrap{ position:relative; }
    .section-lead h1{ letter-spacing:.2px; }
    .tag-muted{ color: var(--muted); }

    .services-toolbar{ display:flex; gap:12px; align-items:center; justify-content:center; flex-wrap:wrap; }
    .services-search{ max-width:520px; width:100%; position:relative; }
    .services-search input{
      width:100%; border:1px solid var(--line); border-radius:999px; padding:.7rem 1rem .7rem 2.4rem; background:#fff; outline:0;
      transition:border-color .2s ease, box-shadow .2s ease;
    }
    .services-search input:focus{ border-color:var(--brand-blue); box-shadow:0 0 0 .2rem rgba(13,42,134,.15); }
    .services-search .fa-search{ position:absolute; left:12px; top:50%; transform:translateY(-50%); opacity:.7; }

    .services-grid .card{
      background:var(--panel); border:1px solid var(--line); border-radius:18px; overflow:hidden;
      transition: transform .22s ease, box-shadow .22s ease, border-color .22s ease; height:100%;
    }
    .services-grid .card:hover{
      transform: translateY(-6px);
      box-shadow: 0 14px 36px rgba(0,0,0,.08);
      border-color: rgba(13,42,134,.35);
    }
    .svc-img{ aspect-ratio: 3/2; width:100%; object-fit:cover; display:block; background:var(--panel-2); }
    .svc-body{ padding:1rem 1rem 1.15rem; }
    .svc-title{ margin-bottom:.35rem; }
    .svc-summary{
      margin-bottom:1rem; color:var(--muted);
      display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden; min-height:3.8em;
    }
    .btn-read{ border-radius:999px; padding:.5rem 1rem; font-weight:600; background:var(--brand-blue); border-color:var(--brand-blue); }
    .btn-read:hover{ filter:brightness(1.05); }

    .services-empty{ background:var(--panel-2); border:1px dashed var(--line); border-radius:16px; padding:24px; }
  </style>

  <!-- Page Header (keeps your background image) -->
  <div class="container-fluid page-header py-5">
    <div class="container text-center py-5">
      <h1 class="display-2 text-white mb-3">Services</h1>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-center mb-0">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item"><span>Pages</span></li>
          <li class="breadcrumb-item active" aria-current="page">Services</li>
        </ol>
      </nav>
    </div>
  </div>

  <!-- Facts (brand green band) -->
  <section class="container-fluid fact-band py-4">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-6 col-lg-3 wow fadeIn" data-wow-delay=".1s">
          <div class="fact-card">
            <i class="fa fa-smile-o fa-lg text-white"></i>
            <div>
              <div class="h2 mb-1 fact-number count" data-target="99">99</div>
              <p class="fact-label">Happy Customers</p>
            </div>
          </div>
        </div>
        <div class="col-6 col-lg-3 wow fadeIn" data-wow-delay=".2s">
          <div class="fact-card">
            <i class="fa fa-sitemap fa-lg text-white"></i>
            <div>
              <div class="h2 mb-1 fact-number count" data-target="25">25</div>
              <p class="fact-label">Successful Projects</p>
            </div>
          </div>
        </div>
        <div class="col-6 col-lg-3 wow fadeIn" data-wow-delay=".3s">
          <div class="fact-card">
            <i class="fa fa-users fa-lg text-white"></i>
            <div>
              <div class="h2 mb-1 fact-number count" data-target="120">120</div>
              <p class="fact-label">Total Clients</p>
            </div>
          </div>
        </div>
        <div class="col-6 col-lg-3 wow fadeIn" data-wow-delay=".4s">
          <div class="fact-card">
            <i class="fa fa-star fa-lg text-white"></i>
            <div>
              <div class="h2 mb-1 fact-number">5</div>
              <p class="fact-label">Star Rating</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Services -->
  <section class="container-fluid services-wrap py-5 my-4">
    <div class="container">
      <div class="text-center mx-auto pb-3 section-lead" style="max-width: 720px;">
        <h5 class="fw-semibold" style="color:var(--brand-blue)">Our Services</h5>
        <h1 class="fw-bold">Services Built Specifically For Your Business</h1>
        <p class="tag-muted mt-1">Browse and click any card to see full details.</p>
      </div>

      <!-- Search (client-side filter) -->
      <div class="services-toolbar mb-4">
        <div class="services-search">
          <i class="fa fa-search"></i>
          <input id="serviceSearch" type="search" aria-label="Search services" placeholder="Search by name or keywords…">
        </div>
        <div class="tag-muted" id="resultsCount" aria-live="polite"></div>
      </div>

      <div class="row g-4 services-grid">
        @forelse($services as $service)
          @php
            // Preserve YOUR image path exactly:
            // - if already "storage/..." or starts with "/" or http, use as-is via asset()
            // - else prefix with "storage/"
            $img = $service->image;
            $src = \Illuminate\Support\Str::startsWith($img, ['http://','https://','/','storage/'])
                  ? asset($img)
                  : asset('storage/'.$img);
            $delay = ($loop->index % 6) * 0.1; // wow delay in seconds
          @endphp
          <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="{{ number_format($delay,1) }}s"
               data-name="{{ \Illuminate\Support\Str::of($service->name)->lower() }}"
               data-summary="{{ \Illuminate\Support\Str::of($service->summary)->lower() }}">
            <div class="card h-100">
              @if($service->image)
                <img src="{{ $src }}" alt="{{ $service->name }}" class="svc-img" loading="lazy">
              @else
                <div class="d-flex align-items-center justify-content-center svc-img">
                  <i class="fa fa-code fa-3x" style="color:var(--brand-blue)"></i>
                  <span class="visually-hidden">Service image placeholder</span>
                </div>
              @endif

              <div class="svc-body">
                <h4 class="svc-title">{{ $service->name }}</h4>
                <p class="svc-summary">{{ $service->summary }}</p>
                <a href="{{ route('services.show', $service->id) }}" class="btn btn-primary btn-read">
                  Read More
                </a>
              </div>
            </div>
          </div>
        @empty
          <div class="col-12">
            <div class="services-empty text-center">
              <p class="lead mb-2">No services available at the moment.</p>
              <p class="mb-0 tag-muted">Please check back soon or <a href="{{ url('/contact') }}">contact us</a> for a custom request.</p>
            </div>
          </div>
        @endforelse
      </div>
    </div>
  </section>

  <!-- Minimal scripts (search only; WOW.js remains yours) -->
  <script>
    (function(){
      const input = document.getElementById('serviceSearch');
      const cards = Array.from(document.querySelectorAll('.services-grid > [data-name]'));
      const counter = document.getElementById('resultsCount');
      if(!input) return;

      const updateCount = (n) => {
        const total = cards.length;
        counter.textContent = n===total ? '' : `${n} result${n!==1?'s':''} of ${total}`;
      };

      const filter = () => {
        const q = (input.value || '').trim().toLowerCase();
        let visible = 0;
        cards.forEach(card=>{
          const name = card.getAttribute('data-name') || '';
          const sum  = card.getAttribute('data-summary') || '';
          const show = !q || name.includes(q) || sum.includes(q);
          card.style.display = show ? '' : 'none';
          if(show) visible++;
        });
        updateCount(visible);
      };

      input.addEventListener('input', filter);
      updateCount(cards.length);
    })();
  </script>
@endsection
