@extends('layouts.app')

@section('title', 'Projets par secteur')

@section('content')
<style>
.page-sectors{
  --navy:#242958; --sky:#7CAE2A; --accent:#7CAE2A; --ink:#0f172a;
}
.ps-hero{ background:var(--navy); color:#fff; padding:120px 0 80px; position:relative; }
.ps-hero .title{ font-weight:900; font-size:clamp(36px, 5.5vw, 64px); margin:0 0 8px; }
.ps-hero p{ margin:0; opacity:.95; font-size:clamp(16px,1.6vw,20px) }

.ps-hero__media{
  position: absolute; right: 24px; bottom: -120px; width: 560px; height: 360px;
  border-radius: 22px; overflow:hidden; z-index:1; display:none;
}
.ps-hero__media img{ width:100%; height:100%; object-fit:cover; }

.ps-wrap{ padding: 120px 0 60px; }
.sector-grid{ display:grid; grid-template-columns: repeat(3,1fr); gap:22px; }
@media (max-width: 991.98px){ .sector-grid{ grid-template-columns: 1fr; } }

.sector-card{
  border:1px solid #e5e7eb; border-radius:16px; padding:20px; background:#fff;
  box-shadow: 0 10px 18px rgba(0,0,0,.06);
}
.sector-card h3{ margin:0 0 8px; font-weight:800; color:var(--ink) }
.sector-card p{ margin:0 0 16px; color:#475569 }
.btn-accent{
  background:var(--accent); color:#fff; border:none; border-radius:12px; padding:10px 14px; font-weight:800;
}
.btn-accent:hover{ filter:brightness(.98) }
.ps-hero .title{
    color: #fff !important;
  }
</style>

<section class="page-sectors">
  <header class="ps-hero">
    <div class="container position-relative">
      <h1 class="title">Choisissez votre secteur</h1>
      <p>Accédez aux projets correspondant à votre secteur d’activité.</p>
    </div>
    {{-- image optionnelle de fond (si tu veux) --}}
    {{-- <figure class="ps-hero__media"><img src="{{ $heroBannerImg }}" alt=""></figure> --}}
  </header>

  <div class="ps-wrap">
    <div class="container">
      <div class="sector-grid">
        @foreach($sectors as $s)
          <article class="sector-card">
            <h3>{{ $s }}</h3>
            <p>Voir les références et réalisations pour le secteur {{ strtolower($s) }}.</p>
            <a href="{{ route('projects.index', ['secteur' => $s]) }}" class="btn btn-accent">
              Voir les projets {{ strtolower($s) }}
            </a>
          </article>
        @endforeach
      </div>
    </div>
  </div>
</section>
@endsection
