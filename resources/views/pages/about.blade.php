@extends('layouts.app')

@section('title', $about->heading ?? 'À propos de nous')

@section('content')
<style>
/* =========================================================
   Aisla Nova – Page shell (same skin as Contact page)
   Scoped so it won't leak elsewhere.
   ========================================================= */
.page-about{
  --navy:#242958;
  --navyDark:#1d2760;
  --sky:#31b4eb;
  --accent:#7CAE2A;
  --ink:#0f172a;
  --muted:#6b7280;
  --field:#f5f7fb;
  --ring:#dbe6ff;
  --card:#ffffff;
  --shadow:0 20px 40px rgba(16,24,40,.08);
}
.page-about *{box-sizing:border-box}

/* ---------- HERO (identical to contact page) ---------- */
.pa-hero{
  background:var(--navy);
  color:#fff;
  padding:78px 0 92px;
  position:relative;
}
.pa-hero .pa-hgroup{max-width:1100px;margin:0 auto;padding:0 12px}
.pa-title{font-size:80px;line-height:2.05;font-weight:800;margin:0 0 10px}
.pa-hero h1,.pa-hero .pa-title,.pa-hero p,.pa-hero .pa-sub{color:#ffffff !important}
.pa-sub{max-width:620px;font-size:15px;line-height:1.7;margin:0;opacity:.95}
@media (max-width:768px){.pa-title{font-size:40px}}

/* breadcrumb pill */
.pa-bread-wrap{position:absolute;left:0;right:0;bottom:-28px;display:flex;justify-content:center}
.pa-bread{
  width:min(1180px, calc(100% - 48px));
  background:var(--sky);
  height:46px;border-radius:9999px;display:flex;align-items:center;gap:18px;
  padding:0 22px;font-weight:700;box-shadow:0 10px 18px rgba(3,102,140,.12);
  color:#fff !important;
}
.pa-bread a,.pa-bread span{color:#fff !important}
.pa-bread .sep{color:rgba(255,255,255,.85) !important}
.pa-bread .home-ico{display:inline-grid;place-items:center;width:26px;height:26px;border-radius:50%;
  background:rgba(255,255,255,.22);color:#fff !important;font-size:12px}

/* ---------- HEADINGS + buttons ---------- */
.pa-kicker{color:var(--sky);font-weight:800;text-transform:uppercase;letter-spacing:.12em;font-size:.85rem}
.pa-h1{color:var(--ink);font-weight:800;line-height:1.14;margin:8px 0 0}
.btn-accent{background:var(--accent);border:none;color:#fff;font-weight:800;padding:14px 22px;border-radius:14px;
  ;transition:.2s}
.btn-accent:hover{transform:translateY(-1px);filter:brightness(.98)}

/* ---------- Metrics (replaces bg-secondary strip) ---------- */
.metrics{padding:64px 0 48px}
.metric-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:18px}
@media (max-width:991.98px){.metric-grid{grid-template-columns:repeat(2,1fr)}}
@media (max-width:575.98px){.metric-grid{grid-template-columns:1fr}}
.metric-card{background:var(--card);border:1px solid #eef2f6;border-radius:18px;box-shadow:0 10px 18px rgba(0,0,0,.04);
  padding:22px;display:flex;align-items:center;gap:14px}
.metric-num{font-size:36px;font-weight:800;color:var(--sky);margin:0}
.metric-label{margin:0;color:#334155;font-weight:700}

/* ---------- About section ---------- */
.about-wrap{padding:56px 0}
.about-imgs{position:relative;height:100%}
.about-imgs .img-a{width:75%;border-radius:16px;box-shadow:var(--shadow);margin-bottom:25%}
.about-imgs .img-b{position:absolute;top:25%;left:25%;width:75%;border-radius:16px;box-shadow:var(--shadow)}
.about-text p{color:#475569}
.about-text h1{font-weight:800}

/* ---------- Team ---------- */
.team-wrap{padding:10px 0 70px}
.team-head{text-align:center;margin-bottom:26px}
.team-card{background:#f8fafc;border:1px solid #eef2f6;border-radius:18px;box-shadow:0 10px 18px rgba(0,0,0,.04);overflow:hidden}
.team-card .team-img{width:140px;height:140px;margin:22px auto 0;border-radius:50%;overflow:hidden}
.team-card .team-img img{width:100%;height:100%;object-fit:cover}
.team-card .team-name{padding:14px 12px;text-align:center}
.team-card .team-name h4{margin:0 0 6px;font-weight:800}
.team-card .team-name p{margin:0;color:#64748b}
.team-card .team-icon{display:flex;justify-content:center;gap:8px;padding:0 0 18px;}
.team-card .btn{width:36px;height:36px;border-radius:50%}
</style>

<section class="page-about">

  {{-- HERO (same layout as Contact page) --}}
  <header class="pa-hero">
    <div class="pa-hgroup container">
      <h1 class="pa-title">{{ $about->heading }}</h1>
      <p class="pa-sub">{{ $about->summary }}</p>
    </div>

 
  </header>

  <section class="metrics">
    <div class="container">
      <div class="metric-grid">
        
      </div>
    </div>
  </section>

  {{-- ABOUT SECTION --}}
  <section class="about-wrap">
    <div class="container">
      <div class="row g-5 align-items-center">
        <div class="col-lg-5 col-md-6">
          <div class="about-imgs">
            <img src="{{ asset('img/about-1.jpg') }}" alt="EcoCall" class="img-a">
            <img src="{{ asset('img/about-2.jpg') }}" alt="Formation" class="img-b">
          </div>
        </div>
        <div class="col-lg-7 col-md-6">
          <div class="pa-kicker">Qui sommes-nous ?</div>
          <h1 class="pa-h1">EcoCall, votre partenaire en formation et relation client</h1>
          <p class="mt-3">EcoCall est un centre de formation et de services dédié à l'excellence dans le domaine du call center. Nous accompagnons les entreprises et les particuliers dans le développement de leurs compétences en relation client, gestion des appels, communication commerciale et outils CRM.</p>
          <p class="mb-4">Grâce à des formateurs expérimentés et des modules adaptés aux exigences du marché, nous garantissons une montée en compétence rapide et efficace. Notre objectif est de professionnaliser les métiers de la relation client à travers une pédagogie moderne et des cas pratiques réels.</p>
          <a href="{{ url('/formation') }}" class="btn btn-accent">Voir nos formations</a>
        </div>
      </div>
    </div>
  </section>

  {{-- TEAM (keeps your owl-carousel classes) --}}
  <section class="team-wrap">
    <div class="container">
      <div class="team-head">
        <div class="pa-kicker">Notre équipe</div>
        <h2 class="pa-h1">Rencontrez nos formateurs experts</h2>
      </div>

      <div class="owl-carousel team-carousel">
        @foreach($teams as $member)
        <div class="team-card">
          <div class="team-img">
            <img src="{{ $member->image_url }}" alt="{{ $member->name }}">
          </div>
          <div class="team-name">
            <h4>{{ $member->name }}</h4>
            <p>{{ $member->role }}</p>
          </div>
          <div class="team-icon">
            @if($member->linkedin)
            <a class="btn btn-secondary text-white" href="{{ $member->linkedin }}"><i class="fab fa-linkedin-in"></i></a>
            @endif
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>

</section>
@endsection
