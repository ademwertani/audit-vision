@extends('layouts.app')

@section('title', 'Nos projets')

@section('content')
<style>
/* =========================================================
   Aisla Nova – Projects Index (same skin as Contact/About/Blog)
   Scoped to this page only.
   ========================================================= */
.page-projects{
  --navy:#242958;
  --navyDark:#1d2760;
  --sky:#31b4eb;
  --accent:#7CAE2A;
  --ink:#0f172a;
  --muted:#6b7280;
  --card:#ffffff;
  --ring:#dbe6ff;
  --shadow-lg:0 24px 48px rgba(16,24,40,.12);
  --shadow:0 10px 18px rgba(0,0,0,.08);
}
.page-projects *{box-sizing:border-box}

/* ---------- HERO (left-aligned + long pill breadcrumb) ---------- */
.px-hero{
  background:var(--navy); color:#fff; padding:78px 0 92px; position:relative;
}
.px-hero .px-hgroup{max-width:1100px;margin:0 auto;padding:0 12px}
.px-title{font-size:48px;line-height:1.08;font-weight:800;margin:0 0 10px}
@media (min-width:992px){ .px-title{font-size:56px} }
.px-hero h1,.px-hero .px-title,.px-hero p,.px-hero .px-sub{color:#fff !important}
.px-sub{max-width:680px;font-size:15px;line-height:1.7;margin:0;opacity:.95}

/* breadcrumb pill */
.px-bread-wrap{position:absolute;left:0;right:0;bottom:-28px;display:flex;justify-content:center}
.px-bread{
  width:min(1180px, calc(100% - 48px));
  background:var(--sky); height:46px; border-radius:9999px;
  display:flex; align-items:center; gap:18px; padding:0 22px;
  font-weight:700; box-shadow:0 10px 18px rgba(3,102,140,.12);
  color:#fff !important;
}
.px-bread a,.px-bread span{color:#fff !important}
.px-bread .sep{color:rgba(255,255,255,.85) !important}
.px-bread .home-ico{display:inline-grid;place-items:center;width:26px;height:26px;border-radius:50%;
  background:rgba(255,255,255,.22);color:#fff !important;font-size:12px}

/* ---------- Section head ---------- */
.px-wrap{padding:70px 0 40px}
.px-head{text-align:center;max-width:820px;margin:0 auto 26px}
.px-kicker{color:var(--sky);font-weight:800;text-transform:uppercase;letter-spacing:.12em;font-size:.85rem}
.px-h1{color:var(--ink);font-weight:800;line-height:1.14;margin:8px 0 0}

/* ---------- Projects grid ---------- */
.proj-grid{display:grid;grid-template-columns:repeat(12,1fr);gap:24px}
.proj-col{grid-column:span 4}
@media (max-width: 991.98px){.proj-col{grid-column:span 6}}
@media (max-width: 575.98px){.proj-col{grid-column:span 12}}

.card-proj{
  background:var(--card); border:1px solid #eef2f6; border-radius:18px; overflow:hidden;
  box-shadow:var(--shadow); height:100%; display:flex; flex-direction:column;
}
.card-proj .thumb{
  position:relative; aspect-ratio:16/11; background:#f2f4f8; overflow:hidden; display:block; text-decoration:none;
}
.card-proj .thumb img{width:100%;height:100%;object-fit:cover;display:block}
.card-proj .overlay{
  position:absolute; inset:0; display:flex; flex-direction:column; justify-content:flex-end;
  padding:16px; gap:6px;
  background: linear-gradient(180deg, rgba(0,0,0,0) 35%, rgba(0,0,0,.65) 100%);
  color:#fff; transition:opacity .2s ease; opacity:.95;
}
.card-proj:hover .overlay{opacity:1}
.ov-title{margin:0;font-weight:800;font-size:1.05rem;color:#fff}
.ov-sub{margin:0;color:rgba(255,255,255,.9);font-size:.95rem}

/* Optional footer with CTA */
.card-footer{padding:12px 16px;display:flex;justify-content:flex-start;gap:8px}
.btn-accent{
  background:var(--accent); color:#fff; border:none; font-weight:800;
  padding:10px 14px; border-radius:14px; 
}
.btn-accent:hover{filter:brightness(.98)}
</style>

<section class="page-projects">

  {{-- HERO --}}
  <header class="px-hero">
    <div class="px-hgroup container">
      <h1 class="px-title">Projets</h1>
      <p class="px-sub">Nos réalisations récentes et études de cas pour nos clients.</p>
    </div>

    {{-- Long rounded breadcrumb pill --}}
    <div class="px-bread-wrap">
      <div class="px-bread">
        <span class="home-ico"><i class="fa fa-home"></i></span>
        <a href="{{ url('/') }}">Accueil</a>
        <span class="sep">|</span>
        <span>Projets</span>
      </div>
    </div>
  </header>

  {{-- LIST --}}
  <div class="px-wrap">
    <div class="container">

      <div class="px-head">
        <div class="px-kicker">Nos projets</div>
        <h2 class="px-h1">Nos projets récemment réalisés</h2>
      </div>

      @if($projects->count())
        <div class="proj-grid">
          @foreach($projects as $project)
            <article class="proj-col wow fadeIn" data-wow-delay=".{{ $loop->index % 3 * 2 + 3 }}s">
              <div class="card-proj">
                <a href="{{ route('projects.show', $project->id) }}" class="thumb">
                  @if($project->image)
                    <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->name }}">
                  @else
                    <img src="{{ asset('img/default-project.jpg') }}" alt="Projet">
                  @endif
                  <div class="overlay">
                    <h3 class="ov-title">{{ $project->name }}</h3>
                    @if(!empty($project->summary))
                      <p class="ov-sub">{{ $project->summary }}</p>
                    @endif
                  </div>
                </a>
                {{-- Optional CTA below the image --}}
                {{-- <div class="card-footer">
                  <a href="{{ route('projects.show', $project->id) }}" class="btn btn-accent">Voir le projet</a>
                </div> --}}
              </div>
            </article>
          @endforeach
        </div>

        {{-- Pagination if available --}}
        @if(method_exists($projects, 'links'))
          <div class="mt-4 d-flex justify-content:center">
            {{ $projects->links() }}
          </div>
        @endif
      @else
        <p class="lead text-center">Aucun projet disponible pour le moment.</p>
      @endif

    </div>
  </div>

</section>
@endsection
