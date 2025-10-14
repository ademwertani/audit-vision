@extends('layouts.app')

@section('title', 'Notre équipe')

@section('content')
<style>
/* =========================================================
   France Isolation – Team (unified skin like Contact/About/Blog)
   Scoped to this page only.
   ========================================================= */
.page-team{
  --navy:#2f3582;
  --navyDark:#1d2760;
  --sky:#31b4eb;
  --accent:#ff6b35;
  --ink:#0f172a;
  --muted:#6b7280;
  --card:#ffffff;
  --ring:#dbe6ff;
  --shadow-lg:0 24px 48px rgba(16,24,40,.12);
  --shadow:0 10px 18px rgba(0,0,0,.08);
}
.page-team *{box-sizing:border-box}

/* ---------- HERO (left-aligned + long pill breadcrumb) ---------- */
.tm-hero{
  background:var(--navy); color:#fff; padding:78px 0 92px; position:relative;
}
.tm-hero .tm-hgroup{max-width:1100px;margin:0 auto;padding:0 12px}
.tm-title{font-size:48px;line-height:1.08;font-weight:800;margin:0 0 10px}
@media (min-width:992px){ .tm-title{font-size:56px} }
.tm-hero h1,.tm-hero .tm-title,.tm-hero p,.tm-hero .tm-sub{color:#fff !important}
.tm-sub{max-width:680px;font-size:15px;line-height:1.7;margin:0;opacity:.95}

/* breadcrumb pill */
.tm-bread-wrap{position:absolute;left:0;right:0;bottom:-28px;display:flex;justify-content:center}
.tm-bread{
  width:min(1180px, calc(100% - 48px));
  background:var(--sky); height:46px; border-radius:9999px;
  display:flex; align-items:center; gap:18px; padding:0 22px;
  font-weight:700; box-shadow:0 10px 18px rgba(3,102,140,.12);
  color:#fff !important;
}
.tm-bread a,.tm-bread span{color:#fff !important}
.tm-bread .sep{color:rgba(255,255,255,.85) !important}
.tm-bread .home-ico{display:inline-grid;place-items:center;width:26px;height:26px;border-radius:50%;
  background:rgba(255,255,255,.22);color:#fff !important;font-size:12px}

/* ---------- METRICS (harmonised with other pages) ---------- */
.metrics{padding:64px 0 48px}
.metric-grid{display:grid;grid-template-columns:repeat(12,1fr);gap:18px}
.metric-col{grid-column:span 3}
@media (max-width:991.98px){.metric-col{grid-column:span 6}}
@media (max-width:575.98px){.metric-col{grid-column:span 12}}
.metric-card{
  background:var(--card);border:1px solid #eef2f6;border-radius:18px;box-shadow:0 10px 18px rgba(0,0,0,.04);
  padding:22px;display:flex;align-items:center;gap:14px
}
.metric-num{font-size:36px;font-weight:800;color:var(--sky);margin:0}
.metric-label{margin:0;color:#334155;font-weight:700}

/* ---------- TEAM carousel ---------- */
.team-wrap{padding:16px 0 70px}
.team-head{text-align:center;max-width:820px;margin:0 auto 24px}
.kicker{color:var(--sky);font-weight:800;text-transform:uppercase;letter-spacing:.12em;font-size:.85rem}
.h-main{color:var(--ink);font-weight:800;line-height:1.14;margin:8px 0 0}

.team-item{
  background:#f8fafc;border:1px solid #eef2f6;border-radius:18px;box-shadow:0 10px 18px rgba(0,0,0,.04);
  overflow:hidden; padding:8px 8px 0;
}
.team-content{display:flex;flex-direction:column;align-items:center}
.team-img{width:140px;height:140px;margin:22px auto 0;border-radius:50%;overflow:hidden;box-shadow:0 8px 18px rgba(0,0,0,.06)}
.team-img img{width:100%;height:100%;object-fit:cover;display:block}
.team-name{padding:14px 12px;text-align:center}
.team-name h4{margin:0 0 6px;font-weight:800}
.team-name p{margin:0;color:#64748b}
.team-icon{display:flex;justify-content:center;gap:8px;padding:0 0 18px}
.team-icon .btn{width:36px;height:36px;border-radius:50%;display:inline-grid;place-items:center}
.team-icon .btn.btn-secondary{background:var(--accent);border:none}
.team-icon .btn.btn-secondary:hover{filter:brightness(.96)}
</style>

<section class="page-team">

  {{-- HERO --}}
  <header class="tm-hero">
    <div class="tm-hgroup container">
      <h1 class="tm-title">Notre équipe</h1>
      <p class="tm-sub">Rencontrez les personnes derrière nos projets et notre service client.</p>
    </div>


  </header>

  {{-- METRICS (replaces old bg-secondary band) --}}
  <section class="metrics">
    <div class="container">
      <div class="metric-grid">
        <div class="metric-col">
          <div class="metric-card">
            <h3 class="metric-num">99</h3>
            <p class="metric-label">Clients satisfaits</p>
          </div>
        </div>
        <div class="metric-col">
          <div class="metric-card">
            <h3 class="metric-num">25</h3>
            <p class="metric-label">Entreprises prospères</p>
          </div>
        </div>
        <div class="metric-col">
          <div class="metric-card">
            <h3 class="metric-num">120</h3>
            <p class="metric-label">Clients fidèles</p>
          </div>
        </div>
        <div class="metric-col">
          <div class="metric-card">
            <h3 class="metric-num">5★</h3>
            <p class="metric-label">Note moyenne</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- TEAM --}}
  <section class="team-wrap">
    <div class="container">
      <div class="team-head">
        <div class="kicker">Notre équipe</div>
        <h2 class="h-main">Rencontrez notre équipe d'experts</h2>
      </div>

      {{-- Keep your Owl Carousel classes so your JS keeps working --}}
      <div class="owl-carousel team-carousel wow fadeIn" data-wow-delay=".5s">
        {{-- Item 1 --}}
        <div class="team-item">
          <div class="team-content">
            <div class="team-img">
              <img src="{{ asset('img/team-1.jpg') }}" class="img-fluid" alt="Membre d'équipe 1">
            </div>
            <div class="team-name text-center">
              <h4>Nom complet</h4>
              <p class="m-0">Poste</p>
            </div>
            <div class="team-icon">
              <a class="btn btn-secondary text-white" href="#"><i class="fab fa-facebook-f"></i></a>
              <a class="btn btn-secondary text-white" href="#"><i class="fab fa-twitter"></i></a>
              <a class="btn btn-secondary text-white" href="#"><i class="fab fa-instagram"></i></a>
              <a class="btn btn-secondary text-white" href="#"><i class="fab fa-linkedin-in"></i></a>
            </div>
          </div>
        </div>

        {{-- Item 2 --}}
        <div class="team-item">
          <div class="team-content">
            <div class="team-img">
              <img src="{{ asset('img/team-2.jpg') }}" class="img-fluid" alt="Membre d'équipe 2">
            </div>
            <div class="team-name text-center">
              <h4>Nom complet</h4>
              <p class="m-0">Poste</p>
            </div>
            <div class="team-icon">
              <a class="btn btn-secondary text-white" href="#"><i class="fab fa-facebook-f"></i></a>
              <a class="btn btn-secondary text-white" href="#"><i class="fab fa-twitter"></i></a>
              <a class="btn btn-secondary text-white" href="#"><i class="fab fa-instagram"></i></a>
              <a class="btn btn-secondary text-white" href="#"><i class="fab fa-linkedin-in"></i></a>
            </div>
          </div>
        </div>

        {{-- Item 3 --}}
        <div class="team-item">
          <div class="team-content">
            <div class="team-img">
              <img src="{{ asset('img/team-3.jpg') }}" class="img-fluid" alt="Membre d'équipe 3">
            </div>
            <div class="team-name text-center">
              <h4>Nom complet</h4>
              <p class="m-0">Poste</p>
            </div>
            <div class="team-icon">
              <a class="btn btn-secondary text-white" href="#"><i class="fab fa-facebook-f"></i></a>
              <a class="btn btn-secondary text-white" href="#"><i class="fab fa-twitter"></i></a>
              <a class="btn btn-secondary text-white" href="#"><i class="fab fa-instagram"></i></a>
              <a class="btn btn-secondary text-white" href="#"><i class="fab fa-linkedin-in"></i></a>
            </div>
          </div>
        </div>

        {{-- Item 4 --}}
        <div class="team-item">
          <div class="team-content">
            <div class="team-img">
              <img src="{{ asset('img/team-4.jpg') }}" class="img-fluid" alt="Membre d'équipe 4">
            </div>
            <div class="team-name text-center">
              <h4>Full Name</h4>
              <p class="m-0">Designation</p>
            </div>
            <div class="team-icon">
              <a class="btn btn-secondary text-white" href="#"><i class="fab fa-facebook-f"></i></a>
              <a class="btn btn-secondary text-white" href="#"><i class="fab fa-twitter"></i></a>
              <a class="btn btn-secondary text-white" href="#"><i class="fab fa-instagram"></i></a>
              <a class="btn btn-secondary text-white" href="#"><i class="fab fa-linkedin-in"></i></a>
            </div>
          </div>
        </div>

      </div>
      {{-- /owl-carousel --}}
    </div>
  </section>

</section>
@endsection
