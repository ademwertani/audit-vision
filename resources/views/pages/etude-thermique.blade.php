@extends('layouts.app')

@section('title', 'Étude thermique des chambres froides')

@section('content')
<style>
/* =========================================================
   PAGE – ÉTUDE THERMIQUE CHAMBRES FROIDES
   ========================================================= */
.page-thermal{
  --navy:#020617;
  --navySoft:#0f172a;
  --blue:#0ea5e9;
  --blueSoft:#e0f2fe;
  --cyan:#22d3ee;
  --muted:#64748b;
  --border:#e2e8f0;
  --bg:#f8fafc;
  --card:#ffffff;
  --shadow-card:0 20px 40px rgba(15,23,42,0.14);
  font-family: system-ui, -apple-system, BlinkMacSystemFont, "Inter", sans-serif;
}
.page-thermal *{box-sizing:border-box;}

.t-animate{
  opacity:0;
  transform:translateY(22px);
  transition:opacity .6s ease, transform .6s ease;
}
.t-animate.t-visible{
  opacity:1;
  transform:translateY(0);
}

/* =========================================================
   HERO
   ========================================================= */
.t-hero{
  position:relative;
  padding:120px 0 90px;
  background:
    radial-gradient(circle at 0% 0%, #e0f2fe 0, #f0f9ff 40%, #f8fafc 76%, #e0f2fe 100%);
  overflow:hidden;
}
.t-hero::before{
  content:"";
  position:absolute;
  inset:-35%;
  background:
    radial-gradient(140% 160% at -10% -10%,rgba(56,189,248,0.45) 0,transparent 60%),
    radial-gradient(190% 220% at 110% 0%,rgba(34,211,238,0.55) 0,transparent 70%);
  opacity:.9;
  pointer-events:none;
}
.t-hero-shell{
  position:relative;
  z-index:1;
}
.t-hero-grid{
  display:grid;
  grid-template-columns:minmax(0,1.4fr) minmax(0,1.1fr);
  gap:36px;
  align-items:center;
}

/* Texte hero */
.t-hero-kicker{
  display:inline-flex;
  align-items:center;
  gap:8px;
  padding:4px 11px;
  border-radius:999px;
  background:#ecfeff;
  border:1px solid rgba(14,165,233,0.4);
  color:#0369a1;
  font-size:.78rem;
  letter-spacing:.16em;
  text-transform:uppercase;
  font-weight:600;
  margin-block-end:12px;
}
.t-hero-kicker span{
  inline-size:7px;
  block-size:7px;
  border-radius:999px;
  background:#22d3ee;
}

.t-hero-title{
  font-size:clamp(32px, 4.8vw, 46px);
  line-height:1.08;
  font-weight:800;
  color:var(--navySoft);
  margin-block-end:10px;
}
.t-hero-sub{
  font-size:1rem;
  line-height:1.8;
  color:var(--muted);
  max-inline-size:520px;
  margin-block-end:18px;
}

/* Points clés hero */
.t-hero-points{
  display:flex;
  flex-wrap:wrap;
  gap:10px;
  margin-block-end:22px;
}
.t-hero-chip{
  display:inline-flex;
  align-items:center;
  gap:8px;
  padding:6px 11px;
  border-radius:999px;
  background:#f1f5f9;
  border:1px solid rgba(148,163,184,.6);
  font-size:.8rem;
  color:#0f172a;
}
.t-hero-chip i{
  font-size:.9rem;
  color:#0284c7;
}

/* CTA hero */
.t-hero-actions{
  display:flex;
  flex-wrap:wrap;
  gap:12px;
  align-items:center;
}
.t-btn-primary{
  display:inline-flex;
  align-items:center;
  gap:8px;
  padding:9px 20px;
  border-radius:999px;
  background:linear-gradient(135deg,#0369a1,#0ea5e9);
  color:#fff;
  font-size:.95rem;
  font-weight:600;
  border:none;
  text-decoration:none;
  box-shadow:0 18px 40px rgba(15,23,42,0.35);
  transition:transform .16s ease, box-shadow .16s ease, filter .16s ease;
}
.t-btn-primary i{font-size:.9rem;}
.t-btn-primary:hover{
  filter:brightness(1.05);
  transform:translateY(-1px);
  box-shadow:0 22px 55px rgba(15,23,42,0.45);
}
.t-btn-ghost{
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
.t-btn-ghost i{
  font-size:.9rem;
  color:#64748b;
}

/* Visuel hero – “dashboard chambre froide” */
.t-hero-visual{
  position:relative;
}
.t-hero-card{
  position:relative;
  border-radius:26px;
  background:#020617;
  padding:16px 16px 14px;
  box-shadow:0 26px 80px rgba(15,23,42,.85);
  overflow:hidden;
}
.t-hero-card::before{
  content:"";
  position:absolute;
  inset:-28%;
  background:
    radial-gradient(140% 180% at 10% 0%,rgba(56,189,248,0.7) 0,transparent 55%),
    radial-gradient(180% 220% at 100% 100%,rgba(34,211,238,0.6) 0,transparent 70%);
  mix-blend-mode:screen;
  opacity:.95;
  pointer-events:none;
}

.t-cold-header{
  position:relative;
  z-index:1;
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-block-end:10px;
  color:#e5e7eb;
  font-size:.8rem;
}
.t-cold-name{
  display:flex;
  flex-direction:column;
  gap:2px;
}
.t-cold-name strong{
  font-size:.9rem;
}
.t-cold-badge{
  padding:3px 7px;
  border-radius:999px;
  background:rgba(15,23,42,0.9);
  border:1px solid rgba(56,189,248,0.8);
  font-size:.72rem;
}

/* zone centrale */
.t-cold-main{
  position:relative;
  border-radius:20px;
  background:radial-gradient(circle at 50% 0%,#e0f2fe 0,#0f172a 60%,#020617 100%);
  block-size:210px;
  padding:12px;
  overflow:hidden;
}
.t-cold-layout{
  display:grid;
  grid-template-columns:1.1fr 1fr;
  gap:10px;
  block-size:100%;
}

/* jauge température */
.t-temp-card{
  background:rgba(15,23,42,0.85);
  border-radius:16px;
  padding:10px 12px;
  border:1px solid rgba(148,163,184,0.6);
  display:flex;
  flex-direction:column;
  justify-content:space-between;
  color:#e5e7eb;
}
.t-temp-label{
  font-size:.76rem;
  text-transform:uppercase;
  letter-spacing:.16em;
  color:#bae6fd;
}
.t-temp-value{
  font-size:1.6rem;
  font-weight:700;
}
.t-temp-bar-wrap{
  margin-block-start:6px;
  inline-size:100%;
  block-size:7px;
  border-radius:999px;
  background:#0f172a;
  overflow:hidden;
}
.t-temp-bar{
  inline-size:78%;
  block-size:100%;
  border-radius:999px;
  background:linear-gradient(90deg,#22c55e,#eab308,#f97316);
}

/* mini stats */
.t-mini-stats{
  display:grid;
  grid-template-columns:repeat(2,minmax(0,1fr));
  gap:6px;
  margin-block-start:6px;
}
.t-mini{
  font-size:.72rem;
  color:#cbd5f5;
}

/* courbe compresseur simplifiée */
.t-curve-card{
  background:rgba(15,23,42,0.9);
  border-radius:16px;
  padding:10px 10px 8px;
  border:1px solid rgba(34,211,238,0.6);
  color:#e5e7eb;
  font-size:.76rem;
  display:flex;
  flex-direction:column;
  justify-content:space-between;
}
.t-curve-title{
  font-size:.78rem;
  letter-spacing:.12em;
  text-transform:uppercase;
  color:#a5b4fc;
}
.t-curve-line{
  margin-block-start:8px;
  block-size:52px;
  border-radius:10px;
  background:
    linear-gradient(135deg,rgba(8,47,73,0.85),rgba(15,23,42,0.95));
  position:relative;
  overflow:hidden;
}
.t-curve-fill{
  position:absolute;
  inset:0;
  background-image:linear-gradient(
    90deg,
    rgba(56,189,248,.8) 0%,
    rgba(34,211,238,.9) 20%,
    rgba(8,47,73,0.1) 40%,
    rgba(56,189,248,.7) 60%,
    rgba(34,211,238,.9) 80%,
    rgba(8,47,73,0.1) 100%
  );
  opacity:.8;
  animation:tCurveMove 6s linear infinite;
}
@keyframes tCurveMove{
  0%{transform:translateX(0);}
  100%{transform:translateX(-40%);}
}
.t-curve-note{
  margin-block-start:5px;
  font-size:.72rem;
  color:#cbd5f5;
}

/* bas du visuel */
.t-cold-footer{
  margin-block-start:10px;
  display:flex;
  justify-content:space-between;
  gap:8px;
  font-size:.78rem;
  color:#e5e7eb;
}
.t-foot-tag{
  padding:3px 8px;
  border-radius:999px;
  background:rgba(15,23,42,0.85);
}

/* =========================================================
   SECTIONS GÉNÉRIQUES
   ========================================================= */
.t-section{
  padding:64px 0;
}
.t-section-header{
  max-inline-size:760px;
  margin:0 auto 28px;
  text-align:center;
}
.t-section-kicker{
  font-size:.8rem;
  text-transform:uppercase;
  letter-spacing:.16em;
  color:#64748b;
  font-weight:600;
  margin-block-end:4px;
}
.t-section-title{
  font-size:1.8rem;
  font-weight:800;
  color:var(--navySoft);
  margin-block-end:8px;
}
.t-section-lead{
  font-size:.98rem;
  color:#4b5563;
  line-height:1.8;
}

/* =========================================================
   POURQUOI – cartes horizontales
   ========================================================= */
.t-why{
  background:#0b1120;
  color:#e5e7eb;
  position:relative;
  overflow:hidden;
}
.t-why::before{
  content:"";
  position:absolute;
  inset:-35%;
  background:
    radial-gradient(130% 160% at -10% 0%,rgba(56,189,248,0.45) 0,transparent 60%),
    radial-gradient(150% 180% at 110% 100%,rgba(15,118,110,0.7) 0,transparent 70%);
  opacity:.9;
  pointer-events:none;
}
.t-why-shell{
  position:relative;
  z-index:1;
}
.t-why-header{
  max-inline-size:760px;
  margin:0 auto 26px;
  text-align:center;
}
.t-why-header h2{
  font-size:1.9rem;
  font-weight:800;
  color:#f9fafb;
  margin-block-end:8px;
}
.t-why-header p{
  font-size:.96rem;
  color:#cbd5f5;
  line-height:1.8;
}

/* liste en cartes “rail” */
.t-why-rail{
  display:flex;
  gap:18px;
  overflow-x:auto;
  padding-block-end:8px;
  scroll-snap-type:x mandatory;
}
.t-why-card{
  min-inline-size:240px;
  max-inline-size:280px;
  scroll-snap-align:start;
  background:rgba(15,23,42,0.95);
  border-radius:20px;
  padding:14px 14px 12px;
  border:1px solid rgba(148,163,184,0.6);
  box-shadow:0 16px 50px rgba(15,23,42,0.85);
}
.t-why-icon{
  inline-size:30px;
  block-size:30px;
  border-radius:999px;
  background:rgba(15,23,42,0.9);
  display:flex;
  align-items:center;
  justify-content:center;
  margin-block-end:8px;
}
.t-why-icon i{
  color:#7dd3fc;
}
.t-why-title{
  font-size:.94rem;
  font-weight:700;
  margin-block-end:6px;
}
.t-why-text{
  font-size:.84rem;
  color:#cbd5f5;
  line-height:1.7;
}

/* =========================================================
   RÉSULTATS OBTENUS – grille de “pills cartes”
   ========================================================= */
.t-results{
  background:#f8fafc;
}
.t-results-grid{
  display:grid;
  grid-template-columns:repeat(3,minmax(0,1fr));
  gap:18px;
  margin-block-start:20px;
}
.t-result-card{
  border-radius:18px;
  padding:14px 14px 12px;
  background:#ffffff;
  border:1px solid rgba(148,163,184,0.5);
  box-shadow:0 14px 32px rgba(148,163,184,0.25);
  display:flex;
  gap:10px;
}
.t-result-dot{
  inline-size:10px;
  block-size:10px;
  border-radius:999px;
  background:linear-gradient(135deg,#0ea5e9,#22d3ee);
  margin-block-start:4px;
}
.t-result-text strong{
  font-size:.94rem;
  color:#0f172a;
}
.t-result-text{
  font-size:.86rem;
  color:#4b5563;
  line-height:1.6;
}

/* =========================================================
   MÉTHODOLOGIE – bande claire avec steps horizontaux
   ========================================================= */
.t-method{
  background:#e0f2fe;
}
.t-method-shell{
  max-inline-size:1040px;
  margin:0 auto;
}
.t-method-intro{
  font-size:.96rem;
  color:#0f172a;
  line-height:1.8;
  text-align:center;
  margin-block-end:20px;
}
.t-steps{
  display:grid;
  grid-template-columns:repeat(3,minmax(0,1fr));
  gap:18px;
}
.t-step-card{
  position:relative;
  border-radius:20px;
  padding:16px 15px 14px;
  background:#ffffff;
  border:1px solid rgba(148,163,184,0.6);
  box-shadow:0 16px 40px rgba(148,163,184,0.3);
}
.t-step-num{
  position:absolute;
  inset-block-start:10px;
  inset-inline-end:12px;
  font-size:.76rem;
  text-transform:uppercase;
  letter-spacing:.16em;
  color:#93c5fd;
}
.t-step-label{
  display:inline-flex;
  align-items:center;
  gap:7px;
  padding:4px 9px;
  border-radius:999px;
  background:#eff6ff;
  font-size:.78rem;
  color:#0f172a;
  margin-block-end:8px;
}
.t-step-label i{
  color:#0284c7;
  font-size:.9rem;
}
.t-step-title{
  font-size:.96rem;
  font-weight:700;
  color:#0f172a;
  margin-block-end:4px;
}
.t-step-text{
  font-size:.86rem;
  color:#4b5563;
  line-height:1.6;
}

/* =========================================================
   CTA FINAL
   ========================================================= */
.t-cta{
  padding:70px 0 90px;
  background:radial-gradient(circle at 0% 0%,#e0f2fe 0,#0f172a 55%,#020617 100%);
  color:#e5e7eb;
}
.t-cta-card{
  max-inline-size:820px;
  margin:0 auto;
  border-radius:26px;
  padding:26px 24px 22px;
  background:linear-gradient(135deg,rgba(15,23,42,0.96),rgba(8,47,73,0.95));
  box-shadow:0 28px 90px rgba(15,23,42,0.85);
  border:1px solid rgba(191,219,254,0.35);
  text-align:center;
}
.t-cta-title{
  font-size:1.6rem;
  font-weight:800;
  margin-block-end:8px;
  color:#f9fafb;
}
.t-cta-text{
  font-size:.96rem;
  color:#dbeafe;
  margin-block-end:18px;
}
.t-cta-actions{
  display:flex;
  justify-content:center;
  flex-wrap:wrap;
  gap:12px;
}

/* RESPONSIVE */
@media (max-width: 991.98px){
  .t-hero{
    padding:100px 0 70px;
  }
  .t-hero-grid{
    grid-template-columns:1fr;
  }
  .t-results-grid{
    grid-template-columns:repeat(2,minmax(0,1fr));
  }
  .t-steps{
    grid-template-columns:repeat(2,minmax(0,1fr));
  }
}
@media (max-width: 575.98px){
  .t-hero{
    padding:90px 0 60px;
  }
  .t-hero-actions{
    flex-direction:column;
    align-items:flex-start;
  }
  .t-results-grid,
  .t-steps{
    grid-template-columns:1fr;
  }
}
</style>

<section class="page-thermal">

  {{-- ================= HERO ================= --}}
  <section class="t-hero">
    <div class="container t-hero-shell">
      <div class="t-hero-grid">

        {{-- Colonne texte --}}
        <div class="t-animate">
          <div class="t-hero-kicker">
            <span></span>
            Étude thermique – chambres froides
          </div>
          <h1 class="t-hero-title">
            Étude thermique des chambres froides et amélioration des performances frigorifiques
          </h1>
          <p class="t-hero-sub">
            Analyse des performances frigorifiques, identification des apports de chaleur
            et optimisation des consommations pour vos chambres froides positives
            ou négatives.
          </p>

          <div class="t-hero-points">
            <div class="t-hero-chip">
              <i class="fa-solid fa-snowflake"></i>
              Jusqu’à 20&nbsp;% de la conso du l'electricité
            </div>
            <div class="t-hero-chip">
              <i class="fa-solid fa-temperature-low"></i>
              moins d'armortissement de température des produits
            </div>
            <div class="t-hero-chip">
              <i class="fa-solid fa-gauge-high"></i>
              Réduire les surconsommations
            </div>
          </div>

          <div class="t-hero-actions">
            <a href="{{ url('/') }}#home-end" class="t-btn-primary">
      Demander une étude thermique
      <i class="fa-solid fa-arrow-right"></i>
    </a>
            
            <a href="#section-methodologie" class="t-btn-ghost">
              Voir la méthodologie
              <i class="fa-solid fa-circle-down"></i>
            </a>
          </div>
        </div>

        {{-- Colonne visuel dashboard froid --}}
        <div class="t-hero-visual t-animate">
          <div class="t-hero-card">

            <div class="t-cold-header">
              <div class="t-cold-name">
                <span>Chambre froide négative</span>
                <strong>Zone Surgelés – CF-03</strong>
              </div>
              <span class="t-cold-badge">Suivi thermique</span>
            </div>

            <div class="t-cold-main">
              <div class="t-cold-layout">

                {{-- Température & mini stats --}}
                <div class="t-temp-card">
                  <div class="t-temp-label">Température moyenne</div>
                  <div class="t-temp-value">-21,5&nbsp;°C</div>

                  <div class="t-temp-bar-wrap">
                    <div class="t-temp-bar"></div>
                  </div>

                  <div class="t-mini-stats">
                    <div class="t-mini">
                      Δ consigne&nbsp;: <strong>+0,5&nbsp;°C</strong>
                    </div>
                    <div class="t-mini">
                      Pertes estimées&nbsp;: <strong>-18&nbsp;%</strong>
                    </div>
                    <div class="t-mini">
                      Cycle compresseur&nbsp;: <strong>-12&nbsp;%</strong>
                    </div>
                    <div class="t-mini">
                      Fuite d’air&nbsp;: <strong>OK</strong>
                    </div>
                  </div>
                </div>

                {{-- Compresseur / cycles --}}
                <div class="t-curve-card">
                  <div class="t-curve-title">Cycle compresseur</div>
                  <div class="t-curve-line">
                    <div class="t-curve-fill"></div>
                  </div>
                  <div class="t-curve-note">
                    Après optimisation&nbsp;: baisse de la fréquence de démarrage
                    et meilleure stabilité des régimes.
                  </div>
                </div>

              </div>
            </div>

            <div class="t-cold-footer">
              <div class="t-foot-tag">Isolation &amp; portes optimisées</div>
              <div class="t-foot-tag">Gains énergétiques projetés&nbsp;: -25&nbsp;% kWh</div>
            </div>

          </div>
        </div>

      </div>
    </div>
  </section>

  {{-- ================= INTRO / POURQUOI ================= --}}
  <section class="t-why">
    <div class="container t-why-shell">

      <div class="t-why-header t-animate">
        <h2>Pourquoi réaliser une étude thermique de vos chambres froides&nbsp;?</h2>
        <p>
          Les installations frigorifiques peuvent représenter jusqu’à
          <strong>50&nbsp;% de la consommation électrique</strong> d’un site.
          Une étude thermique permet d’identifier les surconsommations, d’optimiser
          les réglages et de sécuriser la qualité des produits stockés.
        </p>
      </div>

      <div class="t-why-rail">

        <div class="t-why-card t-animate">
          <div class="t-why-icon">
            <i class="fa-solid fa-battery-half"></i>
          </div>
          <div class="t-why-title">Jusqu’à 20 % de la conso du l'electricité</div>
          <div class="t-why-text">
            Les chambres froides positives et négatives sont des postes majeurs de
            consommation&nbsp;: leur optimisation a un impact direct sur la facture d’énergie.
          </div>
        </div>

        <div class="t-why-card t-animate">
          <div class="t-why-icon">
            <i class="fa-solid fa-door-open"></i>
          </div>
          <div class="t-why-title">Réduire les surconsommations</div>
          <div class="t-why-text">
            Isolation, infiltrations d’air, portes, régulation, dégivrages…
            l’étude met en évidence les causes réelles de surconsommation.
          </div>
        </div>

        <div class="t-why-card t-animate">
          <div class="t-why-icon">
            <i class="fa-solid fa-shield-heart"></i>
          </div>
          <div class="t-why-title">Sécuriser la température &amp; la qualité</div>
          <div class="t-why-text">
            Stabiliser les températures et limiter les fluctuations pour
            garantir la qualité sanitaire et organoleptique des produits.
          </div>
        </div>

        <div class="t-why-card t-animate">
          <div class="t-why-icon">
            <i class="fa-solid fa-hand-holding-dollar"></i>
          </div>
          <div class="t-why-title">Optimiser les coûts d’exploitation</div>
          <div class="t-why-text">
            Moins de cycles compresseurs, meilleure régulation, interventions ciblées
            et accès aux aides (CEE BAT-TH, IND-UT…).
          </div>
        </div>

      </div>

    </div>
  </section>

  {{-- ================= RÉSULTATS OBTENUS ================= --}}
  <section class="t-section t-results">
    <div class="container">

      <div class="t-section-header t-animate">
        <div class="t-section-kicker">Résultats obtenus</div>
        <h2 class="t-section-title">
          Des gains mesurables sur l’énergie et la fiabilité
        </h2>
        <p class="t-section-lead">
          L’étude thermique vise des résultats concrets, à la fois sur les
          <strong>consommations</strong>, la <strong>durée de vie</strong> des équipements
          et la <strong>qualité des produits</strong>.
        </p>
      </div>

      <div class="t-results-grid">

        <div class="t-result-card t-animate">
          <div class="t-result-dot"></div>
          <div class="t-result-text">
            <strong>Identification des pertes thermiques</strong><br>
            Identification des ponts thermiques, défauts d’isolation et fuites d’air,
            avec chiffrage des gains liés aux améliorations proposées.
          </div>
        </div>

        <div class="t-result-card t-animate">
          <div class="t-result-dot"></div>
          <div class="t-result-text">
            <strong>Amélioration de la régulation</strong><br>
            Réglage des consignes, étagement des compresseurs, gestion des dégivrages
            et des ventilateurs pour une régulation plus fine.
          </div>
        </div>

        <div class="t-result-card t-animate">
          <div class="t-result-dot"></div>
          <div class="t-result-text">
            <strong>Réduction du cycle des compresseurs</strong><br>
            Moins de démarrages intempestifs, fonctionnement plus stable et
            baisse des contraintes mécaniques.
          </div>
        </div>

        <div class="t-result-card t-animate">
          <div class="t-result-dot"></div>
          <div class="t-result-text">
            <strong>Prolongation de la durée de vie des équipements</strong><br>
            Des compresseurs et échangeurs moins sollicités, mieux dimensionnés,
            pour une meilleure disponibilité et moins de pannes.
          </div>
        </div>

        <div class="t-result-card t-animate">
          <div class="t-result-dot"></div>
          <div class="t-result-text">
            <strong>Économies sur les coûts d’énergie</strong><br>
            Réduction de la consommation de l'électricité et accès possible aux <strong>aides CEE</strong>
            (BAT-TH, IND-UT, etc.) pour financer une partie des travaux.
          </div>
        </div>

        <div class="t-result-card t-animate">
          <div class="t-result-dot"></div>
          <div class="t-result-text">
            <strong>Meilleure maîtrise des risques</strong><br>
            Limitation des pertes de produits, moins d’arrêts d’exploitation,
            et meilleure anticipation des investissements.
          </div>
        </div>

      </div>

    </div>
  </section>

  {{-- ================= MÉTHODOLOGIE AUDITVISION ================= --}}
  <section id="section-methodologie" class="t-section t-method">
    <div class="container">
      <div class="t-method-shell">

        <div class="t-section-header t-animate">
          <div class="t-section-kicker">Méthodologie AuditVision</div>
          <h2 class="t-section-title">
            Une approche complète pour vos chambres froides
          </h2>
        </div>

        <div class="t-method-intro t-animate">
          L’étude thermique des chambres froides suit une démarche structurée&nbsp;:
          depuis la <strong>collecte des données techniques</strong> jusqu’au
          <strong>rapport final</strong> et à l’accompagnement dans la mise en œuvre
          des scénarios d’optimisation.
        </div>

        <div class="t-steps">

          <div class="t-step-card t-animate">
            <div class="t-step-num">Étape 1</div>
            <div class="t-step-label">
              <i class="fa-solid fa-database"></i>
              Collecte &amp; données
            </div>
            <div class="t-step-title">Collecte des données techniques</div>
            <div class="t-step-text">
              Caractéristiques des chambres, groupes froids, consignes de température,
              historiques de consommation et relevés d’exploitation.
            </div>
          </div>

          <div class="t-step-card t-animate">
            <div class="t-step-num">Étape 2</div>
            <div class="t-step-label">
              <i class="fa-solid fa-person-walking"></i>
              Inspection terrain
            </div>
            <div class="t-step-title">Inspection de l’enveloppe &amp; des équipements</div>
            <div class="t-step-text">
              Visite détaillée des chambres (parois, sols, plafonds, portes),
              des échangeurs, des compresseurs et des organes de régulation.
            </div>
          </div>

          <div class="t-step-card t-animate">
            <div class="t-step-num">Étape 3</div>
            <div class="t-step-label">
              <i class="fa-solid fa-temperature-three-quarters"></i>
              Mesures
            </div>
            <div class="t-step-title">Mesures thermiques précises</div>
            <div class="t-step-text">
              Mesures de températures, relevés de fonctionnement, analyse des dégivrages
              et des cycles de marche/arrêt des équipements.
            </div>
          </div>

          <div class="t-step-card t-animate">
            <div class="t-step-num">Étape 4</div>
            <div class="t-step-label">
              <i class="fa-solid fa-calculator"></i>
              Bilan
            </div>
            <div class="t-step-title">Bilan thermique complet</div>
            <div class="t-step-text">
              Calcul des apports de chaleur, des pertes, des charges frigorifiques
              et identification des principaux leviers de réduction.
            </div>
          </div>

          <div class="t-step-card t-animate">
            <div class="t-step-num">Étape 5</div>
            <div class="t-step-label">
              <i class="fa-solid fa-lightbulb"></i>
              Scénarios
            </div>
            <div class="t-step-title">Scénarios d’optimisation</div>
            <div class="t-step-text">
              Propositions de travaux et actions (enveloppe, équipements, régulation),
              avec estimation des gains et des coûts associés.
            </div>
          </div>

          <div class="t-step-card t-animate">
            <div class="t-step-num">Étape 6</div>
            <div class="t-step-label">
              <i class="fa-solid fa-file-contract"></i>
              Rapport &amp; aides
            </div>
            <div class="t-step-title">Analyse économique &amp; rapport final</div>
            <div class="t-step-text">
              Analyse économique détaillée, intégration des aides CEE,
              rapport final et accompagnement pour le passage à l’action.
            </div>
          </div>

        </div>

      </div>
    </div>
  </section>

  {{-- ================= CTA FINAL ================= --}}
  <section class="t-cta">
    <div class="container">
      <div class="t-cta-card t-animate">
        <h2 class="t-cta-title">
          Demander une étude thermique de vos chambres froides
        </h2>
        <p class="t-cta-text">
          Vous exploitez des chambres froides positives ou négatives et souhaitez
          réduire vos consommations tout en sécurisant vos produits&nbsp;?
          AuditVision vous accompagne avec une étude thermique
          <strong>orientée résultats</strong>.
        </p>
        <div class="t-cta-actions">
          <a href="{{ url('contact') }}" class="t-btn-primary">
            Demander une étude thermique
            <i class="fa-solid fa-arrow-right"></i>
          </a>
          <a href="{{ route('services.index') }}" class="t-btn-ghost">
            Voir nos autres services
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
    const animated = document.querySelectorAll('.t-animate');

    if ('IntersectionObserver' in window) {
        const obs = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('t-visible');
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });

        animated.forEach(el => obs.observe(el));
    } else {
        animated.forEach(el => el.classList.add('t-visible'));
    }
});
</script>
@endsection
