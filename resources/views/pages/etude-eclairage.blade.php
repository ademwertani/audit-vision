@extends('layouts.app')

@section('title', 'Étude d’éclairage intérieur')

@section('content')
<style>
/* =========================================================
   PAGE – ÉTUDE D’ÉCLAIRAGE INTÉRIEUR
   ========================================================= */
.page-lighting{
  --navy:#111827;
  --navySoft:#1f2937;
  --accent:#7CAE2A;
  --accentSoft:#d9f99d;
  --muted:#6b7280;
  --border:#e5e7eb;
  --bg:#f3f4f6;
  --card:#ffffff;
  --shadow-card:0 18px 40px rgba(15,23,42,0.12);
  --pill:#e0f2fe;
  font-family: system-ui, -apple-system, BlinkMacSystemFont, "Inter", sans-serif;
}

.page-lighting *{
  box-sizing:border-box;
}

/* Utilitaire animation */
.l-animate{
  opacity:0;
  transform:translateY(24px);
  transition:opacity .6s ease, transform .6s ease;
}
.l-animate.l-visible{
  opacity:1;
  transform:translateY(0);
}

/* =========================================================
   HERO
   ========================================================= */
.l-hero{
  position:relative;
  padding:120px 0 90px;
  background:
    radial-gradient(circle at 0% 0%, #dbeafe 0, #eff6ff 40%, #f9fafb 76%, #eef2ff 100%);
  overflow:hidden;
}

.l-hero::before{
  content:"";
  position:absolute;
  inset:-40%;
  background:
    radial-gradient(120% 160% at 10% 0%,
      rgba(37,99,235,0.25) 0%,
      transparent 55%),
    radial-gradient(160% 200% at 105% 15%,
      rgba(124,174,42,0.30) 0%,
      transparent 65%);
  opacity:.85;
  pointer-events:none;
}

.l-hero-shell{
  position:relative;
  z-index:1;
}

.l-hero-grid{
  display:grid;
  grid-template-columns:minmax(0,1.5fr) minmax(0,1.1fr);
  gap:40px;
  align-items:center;
}

/* texte hero */
.l-hero-kicker{
  display:inline-flex;
  align-items:center;
  gap:8px;
  padding:4px 10px;
  border-radius:999px;
  background:#ecfdf5;
  color:#166534;
  font-size:.78rem;
  font-weight:600;
  letter-spacing:.14em;
  text-transform:uppercase;
  margin-block-end:12px;
}
.l-hero-kicker span{
  inline-size:6px;
  block-size:6px;
  border-radius:999px;
  background:#22c55e;
}

.l-hero-title{
  font-size:clamp(32px, 5vw, 46px);
  line-height:1.08;
  font-weight:800;
  color:var(--navy);
  margin-block-end:12px;
}
.l-hero-sub{
  font-size:1rem;
  line-height:1.8;
  color:var(--muted);
  max-inline-size:520px;
  margin-block-end:18px;
}

/* puces hero */
.l-hero-badges{
  display:flex;
  flex-wrap:wrap;
  gap:10px;
  margin-block-end:24px;
}
.l-hero-pill{
  display:inline-flex;
  align-items:center;
  gap:8px;
  padding:6px 11px;
  border-radius:999px;
  background:#eff6ff;
  border:1px solid rgba(129,140,248,.35);
  font-size:.8rem;
  color:#1e293b;
}
.l-hero-pill i{
  font-size:.9rem;
  color:#1d4ed8;
}

/* CTA hero */
.l-hero-actions{
  display:flex;
  flex-wrap:wrap;
  gap:12px;
  align-items:center;
}

.l-btn-primary{
  display:inline-flex;
  align-items:center;
  gap:8px;
  padding:9px 20px;
  border-radius:999px;
  background:linear-gradient(135deg,#28327d,#4f46e5);
  color:#fff;
  font-size:.95rem;
  font-weight:600;
  border:none;
  text-decoration:none;
  box-shadow:0 18px 40px rgba(30,64,175,0.35);
  transition:transform .16s ease, box-shadow .16s ease, filter .16s ease;
}
.l-btn-primary i{
  font-size:.9rem;
}
.l-btn-primary:hover{
  filter:brightness(1.04);
  transform:translateY(-1px);
  box-shadow:0 22px 55px rgba(30,64,175,0.45);
}

.l-btn-ghost{
  display:inline-flex;
  align-items:center;
  gap:6px;
  padding:8px 14px;
  border-radius:999px;
  background:#f9fafb;
  border:1px solid rgba(148,163,184,.6);
  font-size:.85rem;
  color:#111827;
  text-decoration:none;
}
.l-btn-ghost i{
  font-size:.9rem;
  color:#6b7280;
}

/* visuel hero */
.l-hero-visual{
  position:relative;
}
.l-hero-card{
  position:relative;
  border-radius:26px;
  background:#020617;
  padding:18px 18px 16px;
  overflow:hidden;
  box-shadow:0 24px 80px rgba(15,23,42,.50);
}
.l-hero-light{
  position:absolute;
  inset:-30%;
  background:
    radial-gradient(130% 160% at 50% 0%,
      rgba(250,250,250,0.90) 0%,
      rgba(250,250,250,0.0) 55%),
    radial-gradient(150% 200% at 50% 100%,
      rgba(56,189,248,0.35) 0%,
      transparent 70%);
  mix-blend-mode:screen;
  opacity:.85;
  pointer-events:none;
}

.l-hero-room{
  position:relative;
  border-radius:22px;
  background:radial-gradient(circle at 50% 0%,#f9fafb 0,#111827 60%,#020617 100%);
  block-size:230px;
  overflow:hidden;
}
.l-hero-bars{
  position:absolute;
  inset:18px 18px 40px 18px;
  display:grid;
  grid-template-columns:repeat(4,1fr);
  align-items:end;
  gap:10px;
}
.l-bar{
  position:relative;
  border-radius:999px;
  overflow:hidden;
  background:#0f172a;
}
.l-bar-fill{
  position:absolute;
  inset-inline-start:0;inset-inline-end:0;inset-block-end:0;
  background:linear-gradient(180deg,#a7f3d0,#22c55e);
  transform-origin:bottom;
  animation:meterPulse 4s ease-in-out infinite;
}
.l-bar:nth-child(1) .l-bar-fill{block-size:68%;}
.l-bar:nth-child(2) .l-bar-fill{block-size:82%; animation-delay:.2s;}
.l-bar:nth-child(3) .l-bar-fill{block-size:54%; animation-delay:.4s;}
.l-bar:nth-child(4) .l-bar-fill{block-size:76%; animation-delay:.6s;}

@keyframes meterPulse{
  0%,100%{transform:scaleY(1);}
  50%{transform:scaleY(.94);}
}

/* bande basse */
.l-hero-metrics{
  margin-block-start:12px;
  display:flex;
  justify-content:space-between;
  align-items:center;
  gap:12px;
  color:#e5e7eb;
  font-size:.8rem;
}
.l-metric{
  display:flex;
  flex-direction:column;
  gap:2px;
}
.l-metric strong{
  font-size:.9rem;
}
.l-pill-small{
  padding:3px 8px;
  border-radius:999px;
  background:rgba(15,23,42,0.7);
  font-size:.7rem;
}

/* =========================================================
   SECTION INTRO
   ========================================================= */
.l-section{
  padding:64px 0;
}
.l-section-header{
  text-align:center;
  max-inline-size:760px;
  margin:0 auto 32px;
}
.l-section-kicker{
  font-size:.8rem;
  text-transform:uppercase;
  letter-spacing:.16em;
  color:#64748b;
  font-weight:600;
  margin-block-end:4px;
}
.l-section-title{
  font-size:1.8rem;
  font-weight:800;
  color:var(--navy);
  margin-block-end:10px;
}
.l-section-lead{
  font-size:.98rem;
  color:#4b5563;
  line-height:1.8;
}

/* Intro cards */
.l-intro-grid{
  display:grid;
  grid-template-columns:minmax(0,1.3fr) minmax(0,1fr);
  gap:26px;
  align-items:flex-start;
}
.l-intro-text{
  font-size:.98rem;
  color:#374151;
  line-height:1.8;
}
.l-intro-text p{
  margin-block-end:1em;
}
.l-intro-highlight{
  padding:17px 18px;
  border-radius:18px;
  background:#f0f9ff;
  border:1px solid rgba(59,130,246,0.25);
  font-size:.9rem;
  color:#0f172a;
}

/* stats */
.l-stats-grid{
  display:grid;
  grid-template-columns:repeat(2,minmax(0,1fr));
  gap:14px;
}
.l-stat-card{
  padding:14px 14px 12px;
  border-radius:18px;
  background:#fff;
  border:1px solid rgba(148,163,184,0.5);
  box-shadow:0 10px 26px rgba(15,23,42,0.08);
}
.l-stat-label{
  font-size:.78rem;
  text-transform:uppercase;
  letter-spacing:.12em;
  color:#6b7280;
  margin-block-end:2px;
}
.l-stat-value{
  font-size:1.1rem;
  font-weight:800;
  color:#111827;
}
.l-stat-note{
  font-size:.8rem;
  color:#6b7280;
}

/* =========================================================
   SECTION POURQUOI
   ========================================================= */
.l-why{
  background:#0b1120;
  color:#e5e7eb;
  position:relative;
  overflow:hidden;
  padding: 80px 0 90px;  /* haut, droite/gauche, bas */
}
.l-why::before{
  content:"";
  position:absolute;
  inset:-40%;
  background:
    radial-gradient(130% 140% at -10% 0%,rgba(56,189,248,0.45) 0,transparent 60%),
    radial-gradient(150% 150% at 110% 0%,rgba(124,174,42,0.55) 0,transparent 70%);
  opacity:.85;
  pointer-events:none;
}
.l-why-shell{
  position:relative;
  z-index:1;
}
.l-why-header{
  max-inline-size:720px;
  margin:0 auto 30px;
  text-align:center;
}
.l-why-header h2{
  font-size:1.9rem;
  font-weight:800;
  color:#f9fafb;
  margin-block-end:8px;
}
.l-why-header p{
  font-size:.96rem;
  color:#cbd5f5;
  line-height:1.8;
}

/* 3 colonnes raisons */
.l-why-grid{
  display:grid;
  grid-template-columns:repeat(3,minmax(0,1fr));
  gap:20px;
}
.l-why-card{
  background:rgba(15,23,42,0.9);
  border-radius:20px;
  padding:16px 16px 14px;
  border:1px solid rgba(129,140,248,0.45);
  box-shadow:0 14px 40px rgba(15,23,42,0.65);
}
.l-why-icon{
  inline-size:32px;
  block-size:32px;
  border-radius:999px;
  background:rgba(15,118,110,0.16);
  display:flex;
  align-items:center;
  justify-content:center;
  margin-block-end:10px;
}
.l-why-icon i{
  color:#6ee7b7;
}
.l-why-title{
  font-size:.98rem;
  font-weight:700;
  color:#e5e7eb;
  margin-block-end:6px;
}
.l-why-text{
  font-size:.86rem;
  color:#cbd5f5;
  line-height:1.7;
}

/* =========================================================
   MÉTHODOLOGIE
   ========================================================= */
.l-method{
  background:#f9fafb;
}
.l-method-grid{
  display:grid;
  grid-template-columns:minmax(0,1.1fr) minmax(0,1.3fr);
  gap:28px;
  align-items:flex-start;
}
.l-method-intro{
  font-size:.96rem;
  color:#374151;
  line-height:1.8;
}
.l-method-tag{
  display:inline-flex;
  align-items:center;
  gap:8px;
  padding:5px 10px;
  border-radius:999px;
  background:#ecfdf3;
  color:#15803d;
  font-size:.78rem;
  font-weight:600;
  letter-spacing:.14em;
  text-transform:uppercase;
  margin-block-end:10px;
}
.l-method-tag i{
  font-size:.9rem;
}

/* timeline */
.l-steps{
  position:relative;
  margin-block-start:4px;
}
.l-steps::before{
  content:"";
  position:absolute;
  inset-inline-start:14px;
  inset-block-start:0;
  inset-block-end:0;
  border-inline-start:2px dashed rgba(148,163,184,0.7);
}
.l-step{
  position:relative;
  padding-inline-start:44px;
  padding-block-end:18px;
}
.l-step:last-child{
  padding-block-end:0;
}
.l-step-marker{
  position:absolute;
  inset-inline-start:6px;
  inset-block-start:4px;
  inline-size:16px;
  block-size:16px;
  border-radius:999px;
  background:#fff;
  border:3px solid #22c55e;
  box-shadow:0 0 0 4px rgba(34,197,94,0.18);
}
.l-step-title{
  font-size:.98rem;
  font-weight:700;
  color:#0f172a;
  margin-block-end:3px;
}
.l-step-text{
  font-size:.88rem;
  color:#4b5563;
}

/* bloc double colonnes tertiaire / habitat */
.l-two-blocks{
  margin-block-start:38px;
  display:grid;
  grid-template-columns:repeat(2,minmax(0,1fr));
  gap:20px;
}
.l-block-card{
  background:#ffffff;
  border-radius:20px;
  padding:16px 18px 16px;
  border:1px solid rgba(148,163,184,0.45);
  box-shadow:0 14px 34px rgba(148,163,184,0.25);
}
.l-block-label{
  font-size:.78rem;
  text-transform:uppercase;
  letter-spacing:.14em;
  color:#6b7280;
  margin-block-end:4px;
}
.l-block-title{
  font-size:1.02rem;
  font-weight:700;
  color:#0f172a;
  margin-block-end:8px;
}
.l-block-list{
  padding-inline-start:1.1em;
  margin:0;
  font-size:.9rem;
  color:#374151;
}
.l-block-list li{
  margin-block-end:.35em;
}

/* =========================================================
   CTA FINAL
   ========================================================= */
.l-cta{
  padding:60px 0 80px;
  background:radial-gradient(circle at 0% 0%,#dbeafe 0,#1e293b 55%,#020617 100%);
  color:#e5e7eb;
}
.l-cta-card{
  max-inline-size:840px;
  margin:0 auto;
  border-radius:26px;
  padding:26px 24px 22px;
  background:linear-gradient(135deg,rgba(15,23,42,0.96),rgba(30,64,175,0.92));
  box-shadow:0 28px 90px rgba(15,23,42,0.8);
  border:1px solid rgba(191,219,254,0.32);
  text-align:center;
}
.l-cta-title{
  font-size:1.6rem;
  font-weight:800;
  margin-block-end:8px;
  color:#f9fafb;
}
.l-cta-text{
  font-size:.96rem;
  color:#c7d2fe;
  margin-block-end:18px;
}
.l-cta-actions{
  display:flex;
  justify-content:center;
  flex-wrap:wrap;
  gap:12px;
}

/* RESPONSIVE */
@media (max-width: 991.98px){
  .l-hero{
    padding:100px 0 70px;
  }
  .l-hero-grid{
    grid-template-columns:1fr;
  }
  .l-intro-grid{
    grid-template-columns:1fr;
  }
  .l-why-grid{
    grid-template-columns:repeat(2,minmax(0,1fr));
  }
  .l-method-grid{
    grid-template-columns:1fr;
  }
  .l-two-blocks{
    grid-template-columns:1fr;
  }
}

@media (max-width: 575.98px){
  .l-hero{
    padding:90px 0 60px;
  }
  .l-why-grid{
    grid-template-columns:1fr;
  }
  .l-hero-actions{
    flex-direction:column;
    align-items:flex-start;
  }
}
</style>

<section class="page-lighting">

  {{-- ================= HERO ================= --}}
  <section class="l-hero">
    <div class="container l-hero-shell">
      <div class="l-hero-grid">

        {{-- Colonne texte --}}
        <div class="l-hero-text l-animate">
          <div class="l-hero-kicker">
            <span></span>
            Étude d’éclairage intérieur
          </div>
          <h1 class="l-hero-title">
            Étude d’éclairage intérieur
          </h1>
          <p class="l-hero-sub">
            Performance énergétique, confort visuel et conformité normative&nbsp;:
            nous concevons des solutions d’éclairage adaptées à vos usages
            et aux exigences de la NF EN 12464-1/NF EN 12464-2.
          </p>

          <div class="l-hero-badges">
            <div class="l-hero-pill">
              <i class="fa-solid fa-bolt"></i>
              20 à 40&nbsp;% de la conso électrique
            </div>
            <div class="l-hero-pill">
              <i class="fa-solid fa-eye"></i>
              Confort &amp; sécurité des occupants
            </div>
            <div class="l-hero-pill">
              <i class="fa-solid fa-scale-balanced"></i>
              Conformité NF EN 12464-1
            </div>
          </div>

          <div class="l-hero-actions">
    <a href="{{ url('/') }}#home-end" class="l-btn-primary">
      Optimiser l’éclairage de vos bâtiments
      <i class="fa-solid fa-arrow-right"></i>
    </a>

    <a href="#section-method" class="l-btn-ghost">
      Découvrir la méthodologie
      <i class="fa-solid fa-circle-down"></i>
    </a>
</div>

        </div>

        {{-- Colonne visuel --}}
        <div class="l-hero-visual l-animate">
          <div class="l-hero-card">
            <div class="l-hero-light"></div>
            <div class="l-hero-room">
              <div class="l-hero-bars">
                <div class="l-bar">
                  <div class="l-bar-fill"></div>
                </div>
                <div class="l-bar">
                  <div class="l-bar-fill"></div>
                </div>
                <div class="l-bar">
                  <div class="l-bar-fill"></div>
                </div>
                <div class="l-bar">
                  <div class="l-bar-fill"></div>
                </div>
              </div>
            </div>
            <div class="l-hero-metrics">
              <div class="l-metric">
                <span class="l-pill-small">Lux moyen simulé</span>
                <strong>500&nbsp;lx</strong>
              </div>
              <div class="l-metric">
                <span class="l-pill-small">Uniformité</span>
                <strong>0,6 U<sub>o</sub></strong>
              </div>
              <div class="l-metric">
                <span class="l-pill-small">Scénario LED</span>
                <strong>-35&nbsp;% kWh/an</strong>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  {{-- ============ INTRO – POURQUOI UNE ÉTUDE ? ============ --}}
  <section class="l-section">
    <div class="container">

      <div class="l-section-header l-animate">
        <div class="l-section-kicker">Pourquoi une étude d’éclairage ?</div>
        <h2 class="l-section-title">
          Maîtriser l’énergie tout en améliorant le confort visuel
        </h2>
        <p class="l-section-lead">
          L’éclairage représente souvent entre <strong>20 et 40&nbsp;% de la consommation électrique</strong>
          d’un bâtiment tertiaire ou industriel. Une étude d’éclairage rigoureuse permet de réduire
          durablement les consommations, de sécuriser la conformité aux normes et d’offrir un
          environnement de travail confortable et sûr.
        </p>
      </div>

      <div class="l-intro-grid">

        <div class="l-intro-text l-animate">
          <p>
            Nous analysons vos installations existantes, vos usages et vos contraintes
            (maintenance, horaires, exigences métier) pour proposer des solutions d’éclairage
            <strong>efficaces, pérennes et adaptées</strong>.
          </p>
          <p>
            Notre approche intègre à la fois les aspects <strong>photométriques</strong>
            (niveau d’éclairement, uniformité, éblouissement) et les enjeux
            <strong>économiques et réglementaires</strong>, en particulier la norme
            <strong>NF EN 12464-1</strong> pour les lieux de travail intérieurs.
          </p>

          <div class="l-intro-highlight">
            Une étude d’éclairage bien conduite devient un véritable levier de
            <strong>performance énergétique</strong>, de <strong>bien-être des occupants</strong>
            et de <strong>valorisation du patrimoine immobilier</strong>.
          </div>
        </div>

        <div class="l-animate">
          <div class="l-stats-grid">
            <div class="l-stat-card">
              <div class="l-stat-label">Part de l’éclairage</div>
              <div class="l-stat-value">20 à 40&nbsp;%</div>
              <div class="l-stat-note">
                de la consommation électrique d’un bâtiment tertiaire ou industriel.
              </div>
            </div>
            <div class="l-stat-card">
              <div class="l-stat-label">Potentiel de réduction</div>
              <div class="l-stat-value">-30 à -60&nbsp;%</div>
              <div class="l-stat-note">
                en combinant LED, détection de présence et variation.
              </div>
            </div>
            <div class="l-stat-card">
              <div class="l-stat-label">Norme de référence</div>
              <div class="l-stat-value">NF EN 12464-1</div>
              <div class="l-stat-note">
                exigences en lux, uniformité et confort visuel.
              </div>
            </div>
            <div class="l-stat-card">
              <div class="l-stat-label">Bénéfices</div>
              <div class="l-stat-value">Confort &amp; sécurité</div>
              <div class="l-stat-note">
                Productivité, réduction des risques et satisfaction des occupants.
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>
  </section>

  {{-- ================= SECTION POURQUOI (BLOC DARK) ================= --}}
  <section class="l-why">
    <div class="container l-why-shell">

      <div class="l-why-header l-animate">
        <h2>Un éclairage au service de l’énergie, du confort et de la sécurité</h2>
        <p>
          Au-delà des kWh cumac économisés, l’éclairage structure vos espaces de travail.
          Une étude d’éclairage permet de concilier <strong>performance énergétique</strong>,
          <strong>confort visuel</strong> , <strong>sécurité des déplacements</strong> et <strong>respect aux exigences européennes</strong>.
        </p>
      </div>

      <div class="l-why-grid">
        <div class="l-why-card l-animate">
          <div class="l-why-icon">
            <i class="fa-solid fa-sun"></i>
          </div>
          <div class="l-why-title">Confort &amp;visuelle</div>
          <div class="l-why-text">
            Limitation de l’éblouissement, niveaux d’éclairement adaptés aux tâches,
            meilleure perception des contrastes et réduction de la fatigue visuelle.
          </div>
        </div>

        <div class="l-why-card l-animate">
          <div class="l-why-icon">
            <i class="fa-solid fa-person-walking"></i>
          </div>
          <div class="l-why-title">Sécurité &amp; circulation</div>
          <div class="l-why-text">
            L'éclairage intérieur doit être conçu pour mettre en évidence les zones de circulation, 
            les escaliers, les issues de secours et les zones à risque, afin de garantir la sécurité des occupants et prévenir les accidents.
          </div>
        </div>

        <div class="l-why-card l-animate">
          <div class="l-why-icon">
            <i class="fa-solid fa-piggy-bank"></i>
          </div>
          <div class="l-why-title">Performance économique</div>
          <div class="l-why-text">
            Réduction de la consommation électrique, 
            augmentation de la durée de vie des installations d'éclairage et meilleure gestion des coûts de maintenance.
          </div>
        </div>
      </div>

    </div>
  </section>

  {{-- ================= MÉTHODOLOGIE ================= --}}
  <section id="section-method" class="l-section l-method">
    <div class="container">

      <div class="l-section-header l-animate">
        <div class="l-section-kicker">Méthodologie</div>
        <h2 class="l-section-title">
          Une démarche structurée pour l'installation d'un éclairage efficace et optimal, adapté à vos besoins.
        </h2>
        <p class="l-section-lead">
          Notre méthodologie couvre l’ensemble du cycle&nbsp;: état des lieux,
          mesures in situ, simulations 3D et analyse économique pour bâtir un
          <strong>scénario d’optimisation réaliste et finançable</strong>.
        </p>
      </div>

      <div class="l-method-grid">

        {{-- colonne gauche : texte + timeline --}}
        <div class="l-animate">
          <div class="l-method-tag">
            <i class="fa-solid fa-route"></i>
            Étapes clés
          </div>
          <div class="l-method-intro">
            <p>
              L’étude d’éclairage est construite autour de <strong>mesures objectives</strong>,
              de <strong>simulations photométriques</strong> (DIALux evo) et d’une
              <strong>analyse économique complète</strong>. Chaque étape est documentée
              pour faciliter les décisions et le déploiement des travaux.
            </p>
          </div>

          <div class="l-steps">
  <div class="l-steps">
  <div class="l-step">
    <div class="l-step-marker"></div>
    <div class="l-step-title">Collecte des données</div>
    <div class="l-step-text">
      Recueil des plans, inventaire des luminaires, caractéristiques techniques, factures d’énergie, horaires d'occupation et usages des espaces.
    </div>
  </div>

  <div class="l-step">
    <div class="l-step-marker"></div>
    <div class="l-step-title">Mesures sur site</div>
    <div class="l-step-text">
      Évaluation des niveaux d’éclairement, uniformité, éblouissement et conditions réelles des systèmes d'éclairage existants.
    </div>
  </div>

  <div class="l-step">
    <div class="l-step-marker"></div>
    <div class="l-step-title">Diagnostic énergétique et confort visuel</div>
    <div class="l-step-text">
      Analyse du système d'éclairage selon les normes énergétiques et de confort visuel, pour identifier les axes d'amélioration.
    </div>
  </div>

  <div class="l-step">
    <div class="l-step-marker"></div>
    <div class="l-step-title">Modélisation et simulations 3D</div>
    <div class="l-step-text">
      Modélisation des espaces avec DIALux evo et simulations de scénarios d’éclairage (LED, variations, détection, zonage).
    </div>
  </div>

  <div class="l-step">
    <div class="l-step-marker"></div>
    <div class="l-step-title">Scénarios d’optimisation et analyse économique</div>
    <div class="l-step-text">
      Chiffrage des travaux, estimation des gains énergétiques et identification des aides financières (CEE).
    </div>
  </div>

  <div class="l-step">
    <div class="l-step-marker"></div>
    <div class="l-step-title">Rapport final et plans photométriques</div>
    <div class="l-step-text">
      Remise d’un rapport détaillé avec plans photométriques et recommandations à présenter aux décideurs.
    </div>
  </div>
</div>
</div>

        </div>

        {{-- colonne droite : blocs tertiaire / habitat --}}
        <div class="l-animate">
          <div class="l-two-blocks">

            <div class="l-block-card">
              <div class="l-block-label">Bâtiments tertiaires</div>
              <div class="l-block-title">
                Bureaux, commerces, enseignement, santé, logistique…
              </div>
              <ul class="l-block-list">
                <li>Optimisation de l’éclairage des open spaces, salles de réunion et zones d’accueil.</li>
                <li>Amélioration des conditions lumineuses dans les salles de classe et espaces de soins.</li>
                <li>Réduction des consommations dans les surfaces commerciales et entrepôts.</li>
                <li>Scénarios d’éclairage adaptés aux horaires étendus et aux usages spécifiques.</li>
              </ul>
            </div>

            <div class="l-block-card">
              <div class="l-block-label">Habitat collectif</div>
              <div class="l-block-title">
                Parties communes, parkings, circulations verticales…
              </div>
              <ul class="l-block-list">
                <li>Réduction des charges liées à l’éclairage des parties communes.</li>
                <li>Mise en sécurité des circulations, parkings, locaux techniques.</li>
                <li>Scénarios LED + détection de présence pour limiter le fonctionnement inutile.</li>
              </ul>
            </div>

          </div>
        </div>

      </div>

    </div>
  </section>

  {{-- ================= CTA FINAL ================= --}}
  <section class="l-cta">
    <div class="container">
      <div class="l-cta-card l-animate">
        <h2 class="l-cta-title">
          Optimiser l’éclairage de vos bâtiments
        </h2>
        <p class="l-cta-text">
          Vous exploitez un bâtiment tertiaire, une usine, un établissement de santé
          ou un immeuble collectif&nbsp;? Nous concevons avec vous une étude d’éclairage
          <strong>orientée résultats</strong>, au service de vos occupants et de vos objectifs
          énergétiques.
        </p>
        <div class="l-cta-actions">
          <a href="{{ url('contact') }}" class="l-btn-primary">
            Demander une étude d’éclairage
            <i class="fa-solid fa-arrow-right"></i>
          </a>
          <a href="{{ route('services.index') }}" class="l-btn-ghost">
            Voir nos autres services
            <i class="fa-solid fa-layer-group"></i>
          </a>
        </div>
      </div>
    </div>
  </section>

</section>

{{-- ================= JS : animation entrée au scroll ================= --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const animated = document.querySelectorAll('.l-animate');

    if ('IntersectionObserver' in window) {
        const obs = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('l-visible');
                    obs.unobserve(entry.target);
                }
            });
        },{
            threshold: 0.15
        });

        animated.forEach(el => obs.observe(el));
    } else {
        // fallback vieux navigateurs
        animated.forEach(el => el.classList.add('l-visible'));
    }
});
</script>
@endsection
