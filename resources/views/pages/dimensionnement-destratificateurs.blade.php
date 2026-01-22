@extends('layouts.app')

@section('title', 'Dimensionnement et calepinage de destratificateurs')

@section('content')
<style>
/* =========================================================
   PAGE – DESTRATIFICATEURS
   ========================================================= */
.page-destrat{
  --ink:#020617;
  --inkSoft:#0b1120;
  --sky:#0ea5e9;
  --skySoft:#e0f2fe;
  --emerald:#10b981;
  --amber:#fbbf24;
  --muted:#6b7280;
  --border:#e5e7eb;
  --bg:#f9fafb;
  --card:#ffffff;
  --shadow-soft:0 18px 40px rgba(15,23,42,0.12);
  font-family: system-ui,-apple-system,BlinkMacSystemFont,"Inter",sans-serif;
}
.page-destrat *{box-sizing:border-box;}

.d-animate{
  opacity:0;
  transform:translateY(22px);
  transition:opacity .6s ease, transform .6s ease;
}
.d-animate.d-visible{
  opacity:1;
  transform:translateY(0);
}

/* =========================================================
   HERO – layout circulaire
   ========================================================= */
.d-hero{
  position:relative;
  padding:120px 0 90px;
  background:
    radial-gradient(circle at 5% 0%,#e0f2fe 0,#f9fafb 50%,#e5f3ff 100%);
  overflow:hidden;
}
.d-hero::before{
  content:"";
  position:absolute;
  width:430px;
  height:430px;
  border-radius:999px;
  background:radial-gradient(circle,#0ea5e9 0,transparent 65%);
  opacity:.12;
  right:-80px;
  top:-80px;
}
.d-hero-shell{
  position:relative;
  z-index:1;
}
.d-hero-grid{
  display:grid;
  grid-template-columns:minmax(0,1.4fr) minmax(0,1.1fr);
  gap:36px;
  align-items:center;
}

/* TEXT HERO */
.d-hero-kicker{
  display:inline-flex;
  align-items:center;
  gap:8px;
  padding:4px 11px;
  border-radius:999px;
  background:#ecfeff;
  border:1px solid rgba(14,165,233,0.45);
  color:#0369a1;
  font-size:.78rem;
  letter-spacing:.16em;
  text-transform:uppercase;
  font-weight:600;
  margin-bottom:12px;
}
.d-hero-kicker span{
  width:7px;
  height:7px;
  border-radius:999px;
  background:#22d3ee;
}

.d-hero-title{
  font-size:clamp(30px,4.6vw,42px);
  line-height:1.08;
  font-weight:800;
  color:var(--inkSoft);
  margin-bottom:10px;
}
.d-hero-sub{
  font-size:1rem;
  line-height:1.8;
  color:var(--muted);
  max-width:540px;
  margin-bottom:18px;
}

/* points clés */
.d-hero-tags{
  display:flex;
  flex-wrap:wrap;
  gap:8px;
  margin-bottom:22px;
}
.d-tag-pill{
  padding:6px 11px;
  border-radius:999px;
  background:#f1f5f9;
  border:1px solid rgba(148,163,184,.6);
  font-size:.8rem;
  color:#0f172a;
}

/* CTA */
.d-hero-actions{
  display:flex;
  flex-wrap:wrap;
  gap:12px;
  align-items:center;
}
.d-btn-primary{
  display:inline-flex;
  align-items:center;
  gap:8px;
  padding:9px 20px;
  border-radius:999px;
  background:linear-gradient(135deg,#0f766e,#10b981);
  color:#fff;
  font-size:.95rem;
  font-weight:600;
  border:none;
  text-decoration:none;
  box-shadow:0 18px 40px rgba(15,23,42,0.3);
  transition:transform .16s ease, box-shadow .16s ease, filter .16s ease;
}
.d-btn-primary i{font-size:.9rem;}
.d-btn-primary:hover{
  filter:brightness(1.05);
  transform:translateY(-1px);
  box-shadow:0 22px 55px rgba(15,23,42,0.45);
}
.d-btn-ghost{
  display:inline-flex;
  align-items:center;
  gap:6px;
  padding:8px 14px;
  border-radius:999px;
  background:#ffffff;
  border:1px solid rgba(148,163,184,.7);
  font-size:.85rem;
  color:#111827;
  text-decoration:none;
}
.d-btn-ghost i{
  font-size:.9rem;
  color:#64748b;
}

/* HERO VISUAL – cercle stratification */
.d-hero-visual{
  display:flex;
  justify-content:center;
}
.d-hero-orbit{
  position:relative;
  width:280px;
  height:280px;
}
.d-orbit-circle{
  position:absolute;
  inset:0;
  border-radius:999px;
  background:radial-gradient(circle at 50% 10%,#e0f2fe 0,#0b1120 55%,#020617 100%);
  box-shadow:0 28px 90px rgba(15,23,42,.65);
  overflow:hidden;
}
.d-orbit-ring{
  position:absolute;
  inset:18px;
  border-radius:999px;
  border:1px dashed rgba(148,163,184,0.5);
}
.d-orbit-ring:nth-child(2){
  inset:34px;
  border-style:solid;
  border-color:rgba(56,189,248,0.5);
}

/* gradients verticaux pour symboliser la stratification */
.d-layer{
  position:absolute;
  left:18%;
  right:18%;
  border-radius:999px;
  background:linear-gradient(180deg,rgba(248,250,252,0.1),rgba(56,189,248,0.9));
  opacity:.6;
}
.d-layer:nth-child(1){height:14%; top:16%;}
.d-layer:nth-child(2){height:17%; top:34%; opacity:.55;}
.d-layer:nth-child(3){height:20%; top:54%; opacity:.5;}
.d-layer:nth-child(4){height:18%; top:74%; opacity:.45;}

/* petits ventilateurs */
.d-fan-dot{
  position:absolute;
  width:36px;
  height:36px;
  border-radius:999px;
  background:radial-gradient(circle,#0ea5e9 0,#020617 70%);
  display:flex;
  align-items:center;
  justify-content:center;
  box-shadow:0 10px 25px rgba(15,23,42,.6);
}
.d-fan-dot i{
  color:#e0f2fe;
  font-size:1rem;
}
.d-fan-dot:nth-child(1){top:24%; left:12%;}
.d-fan-dot:nth-child(2){top:20%; right:10%;}
.d-fan-dot:nth-child(3){bottom:18%; left:22%;}
.d-fan-dot:nth-child(4){bottom:22%; right:18%;}

/* indicateurs */
.d-orbit-metric{
  position:absolute;
  font-size:.8rem;
  color:#e5e7eb;
}
.d-orbit-metric strong{color:#fef9c3;}
.d-orbit-metric.top{
  top:10%;
  right:-4px;
}
.d-orbit-metric.bottom{
  bottom:10%;
  left:-6px;
}

/* =========================================================
   SECTION DÉFINITION
   ========================================================= */
.d-section{
  padding:64px 0;
}
.d-def{
  background:#f9fafc;
}
.d-def-grid{
  display:grid;
  grid-template-columns:minmax(0,1.4fr) minmax(0,1fr);
  gap:28px;
  align-items:flex-start;
}
.d-def-title{
  font-size:1.6rem;
  font-weight:800;
  color:var(--inkSoft);
  margin-bottom:10px;
}
.d-def-text{
  font-size:.98rem;
  color:#374151;
  line-height:1.9;
}
.d-def-text p{margin-bottom:1em;}

.d-def-aside{
  border-radius:20px;
  padding:18px 18px 14px;
  background:#ffffff;
  border:1px solid rgba(148,163,184,0.55);
  box-shadow:0 16px 40px rgba(148,163,184,0.25);
}
.d-badge-circle{
  width:40px;
  height:40px;
  border-radius:999px;
  background:radial-gradient(circle,#0ea5e9,#0369a1);
  display:flex;
  align-items:center;
  justify-content:center;
  color:#e0f2fe;
  margin-bottom:8px;
}
.d-def-aside h3{
  font-size:1rem;
  font-weight:700;
  color:#0f172a;
  margin-bottom:8px;
}
.d-def-aside p{
  font-size:.9rem;
  color:#4b5563;
  margin-bottom:14px;
}
.d-def-metrics{
  display:grid;
  grid-template-columns:repeat(2,minmax(0,1fr));
  gap:10px;
}
.d-def-metric{
  padding:10px 10px;
  border-radius:14px;
  background:#f1f5f9;
  font-size:.8rem;
  color:#0f172a;
}
.d-def-metric span{
  display:block;
  font-size:.76rem;
  color:#6b7280;
}

/* =========================================================
   POURQUOI – grille cartes
   ========================================================= */
.d-section-header{
  max-width:760px;
  margin:0 auto 28px;
  text-align:center;
}
.d-section-kicker{
  font-size:.8rem;
  text-transform:uppercase;
  letter-spacing:.16em;
  color:#64748b;
  font-weight:600;
  margin-bottom:4px;
}
.d-section-title{
  font-size:1.7rem;
  font-weight:800;
  color:var(--inkSoft);
  margin-bottom:8px;
}
.d-section-lead{
  font-size:.96rem;
  color:#4b5563;
  line-height:1.8;
}

.d-why-grid{
  display:grid;
  grid-template-columns:repeat(3,minmax(0,1fr));
  gap:18px;
}
.d-why-card{
  border-radius:20px;
  padding:16px 15px 14px;
  background:#ffffff;
  border:1px solid rgba(148,163,184,0.55);
  box-shadow:0 16px 40px rgba(148,163,184,0.28);
  position:relative;
  overflow:hidden;
}
.d-why-card::before{
  content:"";
  position:absolute;
  width:90px;
  height:90px;
  border-radius:999px;
  background:radial-gradient(circle,rgba(14,165,233,0.20),transparent 70%);
  right:-35px;
  top:-30px;
}
.d-why-icon{
  width:32px;
  height:32px;
  border-radius:999px;
  background:#eff6ff;
  display:flex;
  align-items:center;
  justify-content:center;
  margin-bottom:8px;
}
.d-why-icon i{
  color:#0284c7;
}
.d-why-title{
  font-size:.96rem;
  font-weight:700;
  color:#0f172a;
  margin-bottom:6px;
}
.d-why-text{
  font-size:.86rem;
  color:#4b5563;
  line-height:1.7;
}

/* =========================================================
   MÉTHODOLOGIE – timeline zigzag
   ========================================================= */
.d-method{
  background:#0b1120;
  color:#e5e7eb;
  position:relative;
  overflow:hidden;
}
.d-method::before{
  content:"";
  position:absolute;
  inset:-40%;
  background:
    radial-gradient(130% 160% at -10% 0%,rgba(56,189,248,0.35) 0,transparent 60%),
    radial-gradient(170% 190% at 110% 100%,rgba(16,185,129,0.45) 0,transparent 70%);
  opacity:.88;
  pointer-events:none;
}
.d-method-shell{
  position:relative;
  z-index:1;
}
.d-method-header{
  max-width:780px;
  margin:0 auto 26px;
  text-align:center;
}
.d-method-header h2{
  font-size:1.8rem;
  font-weight:800;
  color:#f9fafb;
  margin-bottom:8px;
}
.d-method-header p{
  font-size:.96rem;
  color:#dbeafe;
  line-height:1.8;
}

/* timeline */
.d-timeline{
  position:relative;
  max-width:900px;
  margin:0 auto;
  padding:10px 0 20px;
}
.d-timeline-line{
  position:absolute;
  left:50%;
  top:0;
  bottom:0;
  width:2px;
  background:linear-gradient(180deg,rgba(148,163,184,0.7),rgba(148,163,184,0.1));
  transform:translateX(-50%);
}
.d-step{
  position:relative;
  margin-bottom:24px;
  display:grid;
  grid-template-columns:repeat(2,minmax(0,1fr));
  gap:18px;
}
.d-step-marker{
  position:absolute;
  left:50%;
  top:18px;
  width:18px;
  height:18px;
  border-radius:999px;
  background:#0b1120;
  border:3px solid #22d3ee;
  transform:translateX(-50%);
  box-shadow:0 0 0 5px rgba(34,211,238,0.2);
}
.d-step-card{
  border-radius:20px;
  padding:14px 14px 13px;
  background:rgba(15,23,42,0.95);
  border:1px solid rgba(148,163,184,0.65);
  box-shadow:0 18px 50px rgba(15,23,42,0.85);
}
.d-step-left{grid-column:1/2;}
.d-step-right{grid-column:2/3;}

.d-step-label{
  font-size:.76rem;
  text-transform:uppercase;
  letter-spacing:.14em;
  color:#93c5fd;
  margin-bottom:3px;
}
.d-step-title{
  font-size:.96rem;
  font-weight:700;
  color:#f9fafb;
  margin-bottom:5px;
}
.d-step-text{
  font-size:.86rem;
  color:#dbeafe;
  line-height:1.7;
}

/* =========================================================
   BLOC TYPE D’ACTIONS / OPTIMISATION
   ========================================================= */
.d-actions{
  background:#f1f5f9;
}
.d-actions-grid{
  display:grid;
  grid-template-columns:minmax(0,1.2fr) minmax(0,1.1fr);
  gap:24px;
  align-items:flex-start;
}
.d-actions-text{
  font-size:.96rem;
  color:#374151;
  line-height:1.8;
}
.d-actions-text p{margin-bottom:1em;}

.d-actions-board{
  border-radius:22px;
  padding:18px 18px 16px;
  background:#ffffff;
  border:1px solid rgba(148,163,184,0.7);
  box-shadow:0 18px 40px rgba(148,163,184,0.3);
}
.d-board-title{
  font-size:1rem;
  font-weight:700;
  color:#0f172a;
  margin-bottom:8px;
}
.d-board-tagline{
  font-size:.86rem;
  color:#6b7280;
  margin-bottom:10px;
}
.d-board-list{
  list-style:none;
  padding:0;
  margin:0;
  display:grid;
  grid-template-columns:repeat(2,minmax(0,1fr));
  gap:10px;
}
.d-board-item{
  border-radius:16px;
  padding:10px 11px;
  background:#f1f5f9;
  font-size:.85rem;
  color:#0f172a;
  display:flex;
  align-items:flex-start;
  gap:8px;
}
.d-board-item i{
  margin-top:3px;
  color:#0ea5e9;
}

/* =========================================================
   CONCLUSION / CTA
   ========================================================= */
.d-cta{
  padding:70px 0 90px;
  background:radial-gradient(circle at 0% 0%,#e0f2fe 0,#0b1120 55%,#020617 100%);
  color:#e5e7eb;
}
.d-cta-card{
  max-width:820px;
  margin:0 auto;
  border-radius:26px;
  padding:26px 24px 22px;
  background:linear-gradient(135deg,rgba(15,23,42,0.96),rgba(15,23,42,0.94));
  box-shadow:0 28px 90px rgba(15,23,42,0.9);
  border:1px solid rgba(191,219,254,0.35);
  text-align:center;
}
.d-cta-title{
  font-size:1.6rem;
  font-weight:800;
  margin-bottom:8px;
  color:#f9fafb;
}
.d-cta-text{
  font-size:.96rem;
  color:#dbeafe;
  margin-bottom:18px;
}
.d-cta-actions{
  display:flex;
  justify-content:center;
  flex-wrap:wrap;
  gap:12px;
}

/* RESPONSIVE */
@media (max-width: 991.98px){
  .d-hero{
    padding:100px 0 70px;
  }
  .d-hero-grid{
    grid-template-columns:1fr;
  }
  .d-def-grid{
    grid-template-columns:1fr;
  }
  .d-why-grid{
    grid-template-columns:repeat(2,minmax(0,1fr));
  }
  .d-actions-grid{
    grid-template-columns:1fr;
  }
  .d-step{
    grid-template-columns:1fr;
  }
  .d-step-left,
  .d-step-right{
    grid-column:1/2;
  }
  .d-timeline-line{
    left:18px;
    transform:none;
  }
  .d-step-marker{
    left:18px;
    transform:none;
  }
}
@media (max-width: 575.98px){
  .d-hero{
    padding:90px 0 60px;
  }
  .d-hero-actions{
    flex-direction:column;
    align-items:flex-start;
  }
  .d-why-grid{
    grid-template-columns:1fr;
  }
  .d-board-list{
    grid-template-columns:1fr;
  }
}
</style>

<section class="page-destrat">

  {{-- ================= HERO ================= --}}
  <section class="d-hero">
    <div class="container d-hero-shell">
      <div class="d-hero-grid">

        {{-- Colonne texte --}}
        <div class="d-animate">
          <div class="d-hero-kicker">
            <span></span>
            Dimensionnement &amp; calepinage
          </div>
          <h1 class="d-hero-title">
            Dimensionnement et calepinage de destratificateurs
          </h1>
          <p class="d-hero-sub">
            Concevoir et positionner de manière optimale les destratificateurs
            dans vos bâtiments à grand volume pour homogénéiser la température,
            réduire les pertes de chaleur et optimiser vos consommations de chauffage.
          </p>

          <div class="d-hero-tags">
            <span class="d-tag-pill">Entrepôts, hangars, gymnases, GMS…</span>
            <span class="d-tag-pill">Réduction des écarts de température sol/toiture</span>
            <span class="d-tag-pill">Étude technique &amp; calepinage sur plans</span>
          </div>

          <div class="d-hero-actions">
            <a href="{{ url('contact') }}" class="d-btn-primary">
              Demander une étude destratificateurs
              <i class="fa-solid fa-arrow-right"></i>
            </a>
            <a href="#section-method" class="d-btn-ghost">
              Découvrir la méthodologie
              <i class="fa-solid fa-circle-down"></i>
            </a>
          </div>
        </div>

        {{-- Colonne visuel circulaire --}}
        <div class="d-hero-visual d-animate">
          <div class="d-hero-orbit">
            <div class="d-orbit-circle">
              <div class="d-orbit-ring"></div>
              <div class="d-orbit-ring"></div>

              {{-- couches de stratification thermique --}}
              <div class="d-layer"></div>
              <div class="d-layer"></div>
              <div class="d-layer"></div>
              <div class="d-layer"></div>

              {{-- destratificateurs --}}
              <div class="d-fan-dot">
                <i class="fa-solid fa-fan"></i>
              </div>
              <div class="d-fan-dot">
                <i class="fa-solid fa-fan"></i>
              </div>
              <div class="d-fan-dot">
                <i class="fa-solid fa-fan"></i>
              </div>
              <div class="d-fan-dot">
                <i class="fa-solid fa-fan"></i>
              </div>

              <div class="d-orbit-metric top">
                Écart initial<br><strong>8 à 15&nbsp;°C</strong>
              </div>
              <div class="d-orbit-metric bottom">
                Gains chauffage<br><strong>-20 à -40&nbsp;%</strong>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  {{-- ================= DÉFINITION ================= --}}
  <section class="d-section d-def">
    <div class="container">
      <div class="d-def-grid">

        <div class="d-animate">
          <h2 class="d-def-title">
            Qu’est-ce que le dimensionnement et le calepinage de destratificateurs&nbsp;?
          </h2>
          <div class="d-def-text">
            <p>
              Le dimensionnement et le calepinage de destratificateurs consistent à
              <strong>concevoir</strong> et <strong>positionner</strong> de façon optimale des ventilateurs de
              destratification dans des bâtiments à grand volume (entrepôts, hangars,
              gymnases, supermarchés…).
            </p>
            <p>
              Ces appareils réduisent la <strong>stratification thermique</strong> en homogénéisant
              la température de l’air, limitant ainsi les pertes de chaleur par la toiture
              et améliorant le <strong>confort thermique</strong> des occupants.
            </p>
          </div>
        </div>

        <div class="d-def-aside d-animate">
          <div class="d-badge-circle">
            <i class="fa-solid fa-temperature-arrow-down"></i>
          </div>
          <h3>Une action ciblée sur un poste majeur</h3>
          <p>
            La stratification peut générer des écarts de température importants entre
            le sol et la toiture, entraînant des surconsommations de chauffage et une
            qualité de confort inégale dans les zones de travail.
          </p>
          <div class="d-def-metrics">
            <div class="d-def-metric">
              <span>Écart vertical constaté</span>
              <strong>+8 à +15&nbsp;°C</strong>
            </div>
            <div class="d-def-metric">
              <span>Réduction des besoins chauffage</span>
              <strong>-20 à -40&nbsp;%</strong>
            </div>
            <div class="d-def-metric">
              <span>Confort thermique</span>
              <strong>Température homogène</strong>
            </div>
            <div class="d-def-metric">
              <span>Impact climat</span>
              <strong>Baisse des émissions CO₂</strong>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  {{-- ================= POURQUOI RÉALISER CETTE ÉTUDE ? ================= --}}
  <section class="d-section">
    <div class="container">

      <div class="d-section-header d-animate">
        <div class="d-section-kicker">Pourquoi réaliser cette étude&nbsp;?</div>
        <h2 class="d-section-title">
          Transformer un phénomène subi en levier d’économies
        </h2>
        <p class="d-section-lead">
          La stratification thermique peut générer jusqu’à <strong>8 à 15&nbsp;°C d’écart</strong>
          entre le sol et la toiture. Une étude dédiée permet d’agir sur ce phénomène
          en dimensionnant précisément les destratificateurs et leur implantation.
        </p>
      </div>

      <div class="d-why-grid">
        <div class="d-why-card d-animate">
          <div class="d-why-icon">
            <i class="fa-solid fa-arrow-up-long"></i>
          </div>
          <div class="d-why-title">Limiter la stratification thermique</div>
          <div class="d-why-text">
            La chaleur s’accumule en partie haute des bâtiments à grand volume,
            créant des écarts de température importants et des zones de travail
            insuffisamment chauffées.
          </div>
        </div>

        <div class="d-why-card d-animate">
          <div class="d-why-icon">
            <i class="fa-solid fa-fire-flame-curved"></i>
          </div>
          <div class="d-why-title">Réduire les consommations de chauffage</div>
          <div class="d-why-text">
            Une bonne destratification permet de réduire les besoins en chauffage
            de <strong>20 à 40&nbsp;%</strong> selon les configurations et les usages.
          </div>
        </div>

        <div class="d-why-card d-animate">
          <div class="d-why-icon">
            <i class="fa-solid fa-user-check"></i>
          </div>
          <div class="d-why-title">Améliorer le confort thermique</div>
          <div class="d-why-text">
            Température plus homogène dans les zones occupées, diminution des
            “courants d’air froid” au sol et meilleure perception de confort
            pour les équipes.
          </div>
        </div>

        <div class="d-why-card d-animate">
          <div class="d-why-icon">
            <i class="fa-solid fa-leaf"></i>
          </div>
          <div class="d-why-title">Réduire les émissions de CO₂</div>
          <div class="d-why-text">
            Contribution directe aux objectifs de la <strong>SNBC</strong> et du
            <strong>Décret Tertiaire</strong> en diminuant les consommations liées
            au chauffage.
          </div>
        </div>

        <div class="d-why-card d-animate">
          <div class="d-why-icon">
            <i class="fa-solid fa-sack-dollar"></i>
          </div>
          <div class="d-why-title">Optimiser les investissements</div>
          <div class="d-why-text">
            Choix du type d’appareil, <strong>nombre</strong>, puissance,
            emplacement et hauteur d’installation optimisés pour maximiser
            le retour sur investissement.
          </div>
        </div>

        <div class="d-why-card d-animate">
          <div class="d-why-icon">
            <i class="fa-solid fa-file-shield"></i>
          </div>
          <div class="d-why-title">Accéder aux aides &amp; sécuriser les systèmes</div>
          <div class="d-why-text">
            Prise en compte des <strong>fiches CEE</strong> (BAT-TH-142, IND-BA-110…)
            et amélioration de la durée de vie des systèmes de chauffage existants.
          </div>
        </div>
      </div>

    </div>
  </section>

  {{-- ================= MÉTHODOLOGIE AUDITVISION ================= --}}
  <section id="section-method" class="d-section d-method">
    <div class="container d-method-shell">

      <div class="d-method-header d-animate">
        <h2>Comment se déroule l’étude chez AuditVision&nbsp;?</h2>
        <p>
          AuditVision propose une étude technique complète, du relevé de terrain
          jusqu’au <strong>rapport final clé en main</strong>, intégrant scénarios
          technico-économiques et calepinage détaillé sur plans.
        </p>
      </div>

      <div class="d-timeline">

        <div class="d-timeline-line"></div>

        {{-- Étape 1 --}}
        <div class="d-step d-animate">
          <div class="d-step-marker"></div>
          <div class="d-step-card d-step-left">
            <div class="d-step-label">Étape 1 – Collecte des données</div>
            <div class="d-step-title">Plans, volumes et puissances installées</div>
            <div class="d-step-text">
              Récupération des plans, hauteurs sous plafond, volumes à traiter,
              puissances de chauffage existantes, relevés de températures et
              profils d’occupation des bâtiments.
            </div>
          </div>
        </div>

        {{-- Étape 2 --}}
        <div class="d-step d-animate">
          <div class="d-step-marker"></div>
          <div class="d-step-card d-step-right">
            <div class="d-step-label">Étape 2 – Visites terrain</div>
            <div class="d-step-title">Mesures de stratification &amp; analyse des flux d’air</div>
            <div class="d-step-text">
              Mesures de stratification (profil vertical de température),
              observation des flux d’air, identification des obstacles
              (rayonnages, machines, mezzanines) et des sources de chaleur.
            </div>
          </div>
        </div>

        {{-- Étape 3 --}}
        <div class="d-step d-animate">
          <div class="d-step-marker"></div>
          <div class="d-step-card d-step-left">
            <div class="d-step-label">Étape 3 – Modélisation thermique</div>
            <div class="d-step-title">Comprendre les déperditions et les volumes à traiter</div>
            <div class="d-step-text">
              Modélisation des apports de chaleur, des déperditions et du volume
              d’air à mélanger pour atteindre une température homogène dans la
              zone occupée.
            </div>
          </div>
        </div>

        {{-- Étape 4 --}}
        <div class="d-step d-animate">
          <div class="d-step-marker"></div>
          <div class="d-step-card d-step-right">
            <div class="d-step-label">Étape 4 – Dimensionnement précis</div>
            <div class="d-step-title">Choix du type d’appareil et du débit d’air</div>
            <div class="d-step-text">
              Définition du débit d’air par destratificateur, choix du type
              d’appareil (hélicoïdal, Venturi, haute portée…), puissance moteur
              et hauteur d’installation compatible avec la configuration du bâtiment.
            </div>
          </div>
        </div>

        {{-- Étape 5 --}}
        <div class="d-step d-animate">
          <div class="d-step-marker"></div>
          <div class="d-step-card d-step-left">
            <div class="d-step-label">Étape 5 – Calepinage optimisé</div>
            <div class="d-step-title">Positionnement exact sur plans</div>
            <div class="d-step-text">
              Calepinage sur plans (orientation, espacement, alignement ou
              implantation en quinconce) pour couvrir efficacement l’ensemble
              des volumes, tout en limitant les zones “mortes”.
            </div>
          </div>
        </div>

        {{-- Étape 6 --}}
        <div class="d-step d-animate">
          <div class="d-step-marker"></div>
          <div class="d-step-card d-step-right">
            <div class="d-step-label">Étape 6 – Scénarios &amp; rapport final</div>
            <div class="d-step-title">Scénarios technico-économiques et accompagnement</div>
            <div class="d-step-text">
              Élaboration de scénarios avec coûts, économies annuelles,
              aides financières mobilisables (CEE…) et temps de retour sur
              investissement, complétés par un rapport final avec plans annotés,
              fiches techniques recommandées et recommandations d’installation
              et de maintenance.
            </div>
          </div>
        </div>

      </div>

    </div>
  </section>

  {{-- ================= TYPES D’ACTIONS / VUE SYNTHÈSE ================= --}}
  <section class="d-section d-actions">
    <div class="container">

      <div class="d-section-header d-animate">
        <div class="d-section-kicker">Bénéfices et types d’actions</div>
        <h2 class="d-section-title">
          Des actions concrètes au service de la performance globale
        </h2>
      </div>

      <div class="d-actions-grid">
        <div class="d-actions-text d-animate">
          <p>
            L’étude de dimensionnement et de calepinage transforme un poste de
            <strong>surconsommation souvent sous-estimé</strong> en levier d’économies
            substantielles, tout en améliorant le confort et la performance globale
            des bâtiments tertiaires et industriels.
          </p>
          <p>
            AuditVision vous aide à <strong>choisir les équipements adaptés</strong>,
            à les positionner de manière optimale et à sécuriser les gains énergétiques
            et financiers associés, en cohérence avec vos projets de rénovation
            énergétique et vos objectifs climat.
          </p>
        </div>

        <div class="d-actions-board d-animate">
          <div class="d-board-title">Exemples d’actions issues de l’étude</div>
          <div class="d-board-tagline">
            Une feuille de route opérationnelle, exploitable par les équipes techniques
            et les décideurs.
          </div>
          <ul class="d-board-list">
            <li class="d-board-item">
              <i class="fa-solid fa-wind"></i>
              <span>Installation de destratificateurs adaptés au volume et à la hauteur
              des bâtiments.</span>
            </li>
            <li class="d-board-item">
              <i class="fa-solid fa-sitemap"></i>
              <span>Reconfiguration des zones de soufflage pour optimiser les flux d’air
              et limiter les zones froides.</span>
            </li>
            <li class="d-board-item">
              <i class="fa-solid fa-gauge-simple-high"></i>
              <span>Ajustement des consignes de chauffage grâce à la réduction de
              l’écart de température vertical.</span>
            </li>
            <li class="d-board-item">
              <i class="fa-solid fa-plug-circle-bolt"></i>
              <span>Couplage avec la régulation et scénarios de fonctionnement
              adaptés à l’occupation.</span>
            </li>
            <li class="d-board-item">
              <i class="fa-solid fa-file-circle-check"></i>
              <span>Valorisation des économies via les dispositifs d’aides (CEE…)
              et intégration dans les plans d’actions énergie-climat.</span>
            </li>
            <li class="d-board-item">
              <i class="fa-solid fa-screwdriver-wrench"></i>
              <span>Recommandations d’installation et de maintenance pour garantir
              la performance dans le temps.</span>
            </li>
          </ul>
        </div>
      </div>

    </div>
  </section>

  {{-- ================= CONCLUSION / CTA ================= --}}
  <section class="d-cta">
    <div class="container">
      <div class="d-cta-card d-animate">
        <h2 class="d-cta-title">
          Construire votre stratégie de destratification avec AuditVision
        </h2>
        <p class="d-cta-text">
          AuditVision transforme un poste majeur de surconsommation en levier
          d’économies substantielles, tout en améliorant le confort thermique
          des occupants et la performance globale de vos bâtiments tertiaires
          et industriels.
        </p>
        <div class="d-cta-actions">
          <a href="{{ url('contact') }}" class="d-btn-primary">
            Construire votre Dimensionnement et calepinage de destratificateurs
            <i class="fa-solid fa-arrow-right"></i>
          </a>
          <a href="{{ route('services.index') }}" class="d-btn-ghost">
            Découvrir nos autres études
            <i class="fa-solid fa-layer-group"></i>
          </a>
        </div>
      </div>
    </div>
  </section>

</section>
 
{{-- ================= JS : animation au scroll ================= --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const animated = document.querySelectorAll('.d-animate');

    if ('IntersectionObserver' in window) {
        const obs = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('d-visible');
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });

        animated.forEach(el => obs.observe(el));
    } else {
        animated.forEach(el => el.classList.add('d-visible'));
    }
});
</script>
@endsection
