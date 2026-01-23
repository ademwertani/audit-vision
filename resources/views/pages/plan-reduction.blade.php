@extends('layouts.app')

@section('title', 'Plan d’Actions de Réduction des Émissions')

@section('content')
<style>
/* =========================================================
   PAGE – PLAN D’ACTIONS CO₂
   ========================================================= */
.page-plan{
  --navy:#020617;
  --navySoft:#1e293b;
  --accent:#16a34a;
  --accentSoft:#bbf7d0;
  --muted:#64748b;
  --border:#e2e8f0;
  --bg:#f8fafc;
  --card:#ffffff;
  --shadow-card:0 18px 40px rgba(15,23,42,0.12);
  font-family: system-ui, -apple-system, BlinkMacSystemFont, "Inter", sans-serif;
}
.page-plan *{box-sizing:border-box;}

.p-animate{
  opacity:0;
  transform:translateY(22px);
  transition:opacity .6s ease, transform .6s ease;
}
.p-animate.p-visible{
  opacity:1;
  transform:translateY(0);
}

/* =========================================================
   HERO
   ========================================================= */
.p-hero{
  position:relative;
  padding:120px 0 90px;
  background:
    radial-gradient(circle at 0% 0%, #dcfce7 0, #ecfeff 36%, #f8fafc 76%, #e0f2fe 100%);
  overflow:hidden;
}
.p-hero::before{
  content:"";
  position:absolute;
  inset:-40%;
  background:
    radial-gradient(120% 160% at 10% 0%,
      rgba(56,189,248,0.32) 0%,
      transparent 60%),
    radial-gradient(150% 200% at 100% 10%,
      rgba(22,163,74,0.55) 0%,
      transparent 68%);
  opacity:.85;
  pointer-events:none;
}
.p-hero-shell{
  position:relative;
  z-index:1;
}
.p-hero-grid{
  display:grid;
  grid-template-columns:minmax(0,1.5fr) minmax(0,1.1fr);
  gap:40px;
  align-items:center;
}

/* texte hero */
.p-hero-kicker{
  display:inline-flex;
  align-items:center;
  gap:8px;
  padding:3px 10px;
  border-radius:999px;
  border:1px solid rgba(22,163,74,.3);
  background:#ecfdf5;
  color:#166534;
  font-size:.78rem;
  font-weight:600;
  letter-spacing:.16em;
  text-transform:uppercase;
  margin-bottom:12px;
}
.p-hero-kicker span{
  width:6px;
  height:6px;
  border-radius:999px;
  background:#22c55e;
}

.p-hero-title{
  font-size:clamp(32px, 5vw, 46px);
  line-height:1.08;
  font-weight:800;
  color:var(--navySoft);
  margin-bottom:10px;
}
.p-hero-sub{
  font-size:1rem;
  line-height:1.8;
  color:var(--muted);
  max-width:540px;
  margin-bottom:18px;
}

/* points hero */
.p-hero-points{
  display:flex;
  flex-wrap:wrap;
  gap:10px;
  margin-bottom:22px;
}
.p-hero-chip{
  display:inline-flex;
  align-items:center;
  gap:8px;
  padding:6px 11px;
  border-radius:999px;
  background:#f1f5f9;
  border:1px solid rgba(148,163,184,.55);
  font-size:.8rem;
  color:#0f172a;
}
.p-hero-chip i{
  font-size:.9rem;
  color:#16a34a;
}

/* CTA hero */
.p-hero-actions{
  display:flex;
  flex-wrap:wrap;
  gap:12px;
  align-items:center;
}
.p-btn-primary{
  display:inline-flex;
  align-items:center;
  gap:8px;
  padding:9px 20px;
  border-radius:999px;
  background:linear-gradient(135deg,#15803d,#16a34a);
  color:#fff;
  font-size:.95rem;
  font-weight:600;
  border:none;
  text-decoration:none;
  box-shadow:0 18px 40px rgba(22,163,74,0.45);
  transition:transform .16s ease, box-shadow .16s ease, filter .16s ease;
}
.p-btn-primary i{font-size:.9rem;}
.p-btn-primary:hover{
  filter:brightness(1.04);
  transform:translateY(-1px);
  box-shadow:0 22px 55px rgba(22,163,74,0.55);
}
.p-btn-ghost{
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
.p-btn-ghost i{
  font-size:.9rem;
  color:#64748b;
}

/* visuel hero – “radar CO₂” */
.p-hero-visual{
  position:relative;
}
.p-hero-panel{
  position:relative;
  border-radius:26px;
  background:#020617;
  padding:18px 18px 16px;
  overflow:hidden;
  box-shadow:0 26px 80px rgba(15,23,42,.7);
}
.p-hero-panel::before{
  content:"";
  position:absolute;
  inset:-30%;
  background:
    radial-gradient(120% 160% at 20% 0%,rgba(52,211,153,0.7) 0,transparent 50%),
    radial-gradient(160% 200% at 100% 100%,rgba(56,189,248,0.55) 0,transparent 70%);
  opacity:.9;
  mix-blend-mode:screen;
  pointer-events:none;
}
.p-radar{
  position:relative;
  border-radius:22px;
  background:radial-gradient(circle at 50% 50%,#022c22 0,#020617 60%,#000 100%);
  height:240px;
  overflow:hidden;
}
.p-radar-grid{
  position:absolute;
  inset:18px;
  border-radius:18px;
  border:1px dashed rgba(148,163,184,0.4);
}
.p-radar-circle{
  position:absolute;
  border-radius:999px;
  border:1px solid rgba(34,197,94,0.5);
}
.p-radar-circle:nth-child(1){
  inset:26px;
  opacity:.6;
}
.p-radar-circle:nth-child(2){
  inset:46px;
  opacity:.45;
}
.p-radar-scope{
  position:absolute;
  inset:0;
  display:flex;
  align-items:center;
  justify-content:center;
  color:#bbf7d0;
  font-size:.8rem;
  text-transform:uppercase;
  letter-spacing:.18em;
}
.p-radar-scope span{
  background:rgba(15,23,42,0.9);
  padding:4px 10px;
  border-radius:999px;
  border:1px solid rgba(34,197,94,0.7);
}

/* petits tags sous le visuel */
.p-hero-metrics{
  margin-top:12px;
  display:flex;
  justify-content:space-between;
  gap:10px;
  font-size:.8rem;
  color:#e5e7eb;
}
.p-hero-metric{
  display:flex;
  flex-direction:column;
  gap:2px;
}
.p-hero-metric strong{
  font-size:.9rem;
}
.p-hero-tag{
  padding:3px 8px;
  border-radius:999px;
  background:rgba(15,23,42,0.9);
}

/* =========================================================
   SECTION – DÉFINITION
   ========================================================= */
.p-section{
  padding:64px 0;
}
.p-section-header{
  max-width:760px;
  margin:0 auto 32px;
  text-align:center;
}
.p-section-kicker{
  font-size:.8rem;
  text-transform:uppercase;
  letter-spacing:.16em;
  color:#64748b;
  font-weight:600;
  margin-bottom:4px;
}
.p-section-title{
  font-size:1.9rem;
  font-weight:800;
  color:var(--navySoft);
  margin-bottom:10px;
}
.p-section-lead{
  font-size:.98rem;
  color:#4b5563;
  line-height:1.8;
}

.p-def-grid{
  display:grid;
  grid-template-columns:minmax(0,1.35fr) minmax(0,1.05fr);
  gap:26px;
  align-items:flex-start;
}
.p-def-text{
  font-size:.98rem;
  color:#334155;
  line-height:1.8;
}
.p-def-text p{margin-bottom:1em;}

.p-def-side{
  border-radius:20px;
  padding:18px 18px 16px;
  background:#0f172a;
  color:#e5e7eb;
  box-shadow:0 20px 60px rgba(15,23,42,0.7);
  position:relative;
  overflow:hidden;
}
.p-def-side::before{
  content:"+ SNBC 2050";
  position:absolute;
  top:12px;
  right:18px;
  font-size:.72rem;
  text-transform:uppercase;
  letter-spacing:.18em;
  color:rgba(148,163,184,0.8);
}
.p-def-side-title{
  font-size:.95rem;
  font-weight:700;
  text-transform:uppercase;
  letter-spacing:.16em;
  color:#a5b4fc;
  margin-bottom:6px;
}
.p-def-side-main{
  font-size:.9rem;
  color:#e5e7eb;
  margin-bottom:10px;
}
.p-def-badges{
  display:flex;
  flex-wrap:wrap;
  gap:6px;
}
.p-def-badge{
  padding:4px 9px;
  border-radius:999px;
  background:rgba(15,23,42,0.9);
  border:1px solid rgba(129,140,248,0.7);
  font-size:.78rem;
}

/* =========================================================
   SECTION – POURQUOI ?
   ========================================================= */
.p-why{
  background:#0b1120;
  color:#e5e7eb;
  position:relative;
  overflow:hidden;
}
.p-why::before{
  content:"";
  position:absolute;
  inset:-30%;
  background:
    radial-gradient(130% 150% at -10% 0%,rgba(56,189,248,0.42) 0,transparent 60%),
    radial-gradient(160% 160% at 110% 100%,rgba(21,128,61,0.70) 0,transparent 70%);
  opacity:.9;
  pointer-events:none;
}
.p-why-shell{
  position:relative;
  z-index:1;
}
.p-why-header{
  max-width:720px;
  margin:0 auto 30px;
  text-align:center;
}
.p-why-header h2{
  font-size:1.9rem;
  font-weight:800;
  color:#f9fafb;
  margin-bottom:8px;
}
.p-why-header p{
  font-size:.96rem;
  color:#cbd5f5;
  line-height:1.8;
}

/* 2 colonnes : raisons + “bandeau” objectifs */
.p-why-layout{
  display:grid;
  grid-template-columns:minmax(0,1.4fr) minmax(0,1.1fr);
  gap:26px;
  align-items:flex-start;
}
.p-why-list{
  display:flex;
  flex-direction:column;
  gap:14px;
}
.p-why-item{
  display:flex;
  gap:10px;
}
.p-why-icon{
  width:28px;
  height:28px;
  border-radius:999px;
  background:rgba(15,23,42,0.9);
  display:flex;
  align-items:center;
  justify-content:center;
}
.p-why-icon i{
  color:#4ade80;
  font-size:.9rem;
}
.p-why-text strong{
  font-size:.9rem;
  color:#e5e7eb;
}
.p-why-text{
  font-size:.86rem;
  color:#cbd5f5;
  line-height:1.6;
}

/* bandeau à droite */
.p-why-panel{
  border-radius:20px;
  padding:16px 18px 14px;
  background:linear-gradient(135deg,rgba(15,23,42,.98),rgba(15,23,42,.9));
  border:1px solid rgba(129,140,248,0.7);
  box-shadow:0 18px 60px rgba(15,23,42,.85);
}
.p-why-panel-title{
  font-size:.9rem;
  text-transform:uppercase;
  letter-spacing:.16em;
  color:#a5b4fc;
  margin-bottom:6px;
}
.p-why-targets{
  display:flex;
  flex-direction:column;
  gap:8px;
  font-size:.86rem;
}
.p-target{
  display:flex;
  justify-content:space-between;
  gap:8px;
  padding:6px 8px;
  border-radius:10px;
  background:rgba(15,23,42,0.85);
}
.p-target span:first-child{
  color:#e5e7eb;
}
.p-target span:last-child{
  color:#bbf7d0;
}

/* =========================================================
   SECTION – MÉTHODOLOGIE
   ========================================================= */
.p-method{
  background:#f8fafc;
}
.p-method-grid{
  display:grid;
  grid-template-columns:minmax(0,1.15fr) minmax(0,1.25fr);
  gap:30px;
  align-items:flex-start;
}
.p-method-intro{
  font-size:.96rem;
  color:#334155;
  line-height:1.8;
}
.p-method-tag{
  display:inline-flex;
  align-items:center;
  gap:8px;
  padding:5px 11px;
  border-radius:999px;
  background:#ecfdf3;
  color:#15803d;
  font-size:.78rem;
  font-weight:600;
  letter-spacing:.14em;
  text-transform:uppercase;
  margin-bottom:10px;
}
.p-method-tag i{font-size:.9rem;}

/* timeline verticale */
.p-steps{
  position:relative;
  margin-top:6px;
}
.p-steps::before{
  content:"";
  position:absolute;
  left:14px;
  top:0;
  bottom:0;
  border-left:2px dashed rgba(148,163,184,0.7);
}
.p-step{
  position:relative;
  padding-left:44px;
  padding-bottom:18px;
}
.p-step:last-child{padding-bottom:0;}
.p-step-marker{
  position:absolute;
  left:6px;
  top:4px;
  width:16px;
  height:16px;
  border-radius:999px;
  background:#fff;
  border:3px solid #22c55e;
  box-shadow:0 0 0 4px rgba(34,197,94,0.18);
}
.p-step-title{
  font-size:.98rem;
  font-weight:700;
  color:#0f172a;
  margin-bottom:3px;
}
.p-step-text{
  font-size:.88rem;
  color:#4b5563;
}

/* colonne droite : carte synthèse */
.p-method-card{
  border-radius:22px;
  padding:18px 20px 16px;
  background:#ffffff;
  border:1px solid rgba(148,163,184,0.5);
  box-shadow:0 18px 55px rgba(148,163,184,0.35);
}
.p-method-label{
  font-size:.8rem;
  text-transform:uppercase;
  letter-spacing:.14em;
  color:#64748b;
  margin-bottom:4px;
}
.p-method-title{
  font-size:1.1rem;
  font-weight:700;
  color:#0f172a;
  margin-bottom:6px;
}
.p-method-note{
  font-size:.88rem;
  color:#4b5563;
  margin-bottom:10px;
}
.p-method-tags{
  display:flex;
  flex-wrap:wrap;
  gap:6px;
}
.p-method-tagchip{
  padding:4px 9px;
  border-radius:999px;
  border:1px solid rgba(148,163,184,0.7);
  background:#f9fafb;
  font-size:.78rem;
}

/* =========================================================
   SECTION – TYPES D’ACTIONS (NOUVEAU DESIGN)
   ========================================================= */
.p-actions{
  padding:70px 0;
  background:#ffffff; /* 🔒 fond normal, clair, sans halo */
}
.p-actions-header{
  max-width:760px;
  margin:0 auto 26px;
  text-align:center;
}
.p-actions-kicker{
  font-size:.8rem;
  text-transform:uppercase;
  letter-spacing:.16em;
  color:#64748b;
  font-weight:600;
  margin-bottom:4px;
}
.p-actions-title{
  font-size:1.8rem;
  font-weight:800;
  color:#0f172a;
  margin-bottom:8px;
}
.p-actions-lead{
  font-size:.96rem;
  color:#4b5563;
  line-height:1.8;
}

/* grille de cartes actions */
.p-actions-grid{
  display:grid;
  grid-template-columns:repeat(3,minmax(0,1fr));
  gap:20px;
  margin-top:24px;
}
.p-action-card{
  position:relative;
  border-radius:20px;
  padding:14px 16px 14px 18px;
  background:#f9fafb;
  border:1px solid rgba(148,163,184,0.55);
  box-shadow:0 12px 28px rgba(148,163,184,0.25);
  display:flex;
  flex-direction:column;
  gap:6px;
  overflow:hidden;
}
.p-action-strip{
  position:absolute;
  left:0;
  top:0;
  bottom:0;
  width:4px;
  background:linear-gradient(180deg,#16a34a,#22c55e);
}
.p-action-icon{
  width:30px;
  height:30px;
  border-radius:999px;
  background:#dcfce7;
  display:flex;
  align-items:center;
  justify-content:center;
  margin-bottom:4px;
}
.p-action-icon i{
  color:#15803d;
  font-size:.9rem;
}
.p-action-title{
  font-size:.96rem;
  font-weight:700;
  color:#0f172a;
}
.p-action-text{
  font-size:.86rem;
  color:#4b5563;
  line-height:1.6;
}
.p-action-tag{
  align-self:flex-start;
  margin-top:4px;
  padding:3px 8px;
  border-radius:999px;
  background:#e0f2fe;
  color:#0f172a;
  font-size:.75rem;
}

/* =========================================================
   CTA FINAL
   ========================================================= */
.p-cta{
  padding:70px 0 90px;
  background:radial-gradient(circle at 0% 0%,#bbf7d0 0,#0f172a 55%,#020617 100%);
  color:#e5e7eb;
}
.p-cta-card{
  max-width:840px;
  margin:0 auto;
  border-radius:26px;
  padding:26px 24px 22px;
  background:linear-gradient(135deg,rgba(15,23,42,0.96),rgba(22,163,74,0.92));
  box-shadow:0 28px 90px rgba(15,23,42,0.85);
  border:1px solid rgba(187,247,208,0.35);
  text-align:center;
}
.p-cta-title{
  font-size:1.6rem;
  font-weight:800;
  margin-bottom:8px;
  color:#f9fafb;
}
.p-cta-text{
  font-size:.96rem;
  color:#d1fae5;
  margin-bottom:18px;
}
.p-cta-actions{
  display:flex;
  justify-content:center;
  flex-wrap:wrap;
  gap:12px;
}

/* RESPONSIVE */
@media (max-width: 991.98px){
  .p-hero{
    padding:100px 0 70px;
  }
  .p-hero-grid{
    grid-template-columns:1fr;
  }
  .p-def-grid{
    grid-template-columns:1fr;
  }
  .p-why-layout{
    grid-template-columns:1fr;
  }
  .p-method-grid{
    grid-template-columns:1fr;
  }
  .p-actions-grid{
    grid-template-columns:repeat(2,minmax(0,1fr));
  }
}
@media (max-width: 575.98px){
  .p-hero{
    padding:90px 0 60px;
  }
  .p-hero-actions{
    flex-direction:column;
    align-items:flex-start;
  }
  .p-actions-grid{
    grid-template-columns:1fr;
  }
}
</style>

<section class="page-plan">

  {{-- ================= HERO ================= --}}
  <section class="p-hero">
    <div class="container p-hero-shell">
      <div class="p-hero-grid">

        {{-- Colonne texte --}}
        <div class="p-animate">
          <div class="p-hero-kicker">
            <span></span>
            Stratégie bas-carbone
          </div>
          <h1 class="p-hero-title">
            Plan d’Actions de Réduction des Émissions
          </h1>
          <p class="p-hero-sub">
            Traduire le bilan carbone en un plan d’actions opérationnel, priorisé et finançable
            pour aligner votre organisation avec les objectifs de neutralité carbone 2050.
          </p>

          <div class="p-hero-points">
            <div class="p-hero-chip">
              <i class="fa-solid fa-chart-line"></i>
              De la mesure à l’action
            </div>
            <div class="p-hero-chip">
              <i class="fa-solid fa-seedling"></i>
              Aligné SNBC &amp; climat
            </div>
            <div class="p-hero-chip">
              <i class="fa-solid fa-euro-sign"></i>
              Investissements priorisés
            </div>
          </div>

          <div class="p-hero-actions">
            
            <a href="{{ url('/') }}#home-end" class="p-btn-primary">
      Construire votre stratégie bas-carbone
      <i class="fa-solid fa-arrow-right"></i>
    </a>
            <a href="#section-methodologie" class="p-btn-ghost">
              Découvrir la méthodologie
              <i class="fa-solid fa-circle-down"></i>
            </a>
          </div>
        </div>

        {{-- Colonne visuel --}}
        <div class="p-hero-visual p-animate">
          <div class="p-hero-panel">
            <div class="p-radar">
              <div class="p-radar-grid"></div>
              <div class="p-radar-circle"></div>
              <div class="p-radar-circle"></div>
              <div class="p-radar-scope">
                <span>Scopes 1 · 2 · 3</span>
              </div>
            </div>
            <div class="p-hero-metrics">
              <div class="p-hero-metric">
                <span class="p-hero-tag">Réduction visée</span>
                <strong>-45&nbsp;% GES</strong>
              </div>
              <div class="p-hero-metric">
                <span class="p-hero-tag">Horizon</span>
                <strong>2030 – 2050</strong>
              </div>
              <div class="p-hero-metric">
                <span class="p-hero-tag">RSE &amp; CSRD</span>
                <strong>Feuille de route climat</strong>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  {{-- ================= DÉFINITION ================= --}}
  <section class="p-section">
    <div class="container">

      <div class="p-section-header p-animate">
        <div class="p-section-kicker">Définition</div>
        <h2 class="p-section-title">
          Du bilan carbone au plan d’actions CO₂
        </h2>
        <p class="p-section-lead">
          Le plan d’actions CO₂ traduit votre bilan carbone en <strong>mesures concrètes</strong>
          et chiffrées, permettant de réduire durablement les émissions, d’optimiser les dépenses
          énergétiques et de se conformer aux objectifs nationaux (SNBC – neutralité carbone 2050).
        </p>
      </div>

      <div class="p-def-grid">
        <div class="p-def-text p-animate">
          <p>
            Après la phase de diagnostic (bilan carbone, audits énergétiques, études sectorielles),
            le plan d’actions permet de construire une trajectoire cohérente avec vos
            <strong>enjeux économiques, climatiques et réglementaires</strong>.
          </p>
          <p>
            Il combine des actions sur les <strong>énergies, les procédés, les déplacements,
            les achats et les usages</strong>, en les hiérarchisant selon leur impact carbone,
            leur coût et leur faisabilité.
          </p>
        </div>

        <div class="p-def-side p-animate">
          <div class="p-def-side-title">
            Bilan carbone &amp; SNBC
          </div>
          <div class="p-def-side-main">
            AuditVision s’appuie sur les référentiels <strong>ADEME</strong> et
            <strong>GHG Protocol</strong> pour construire des plans alignés
            avec la trajectoire <strong>SNBC 2050</strong>.
          </div>
          <div class="p-def-badges">
            <span class="p-def-badge">Méthodologie ADEME</span>
            <span class="p-def-badge">GHG Protocol</span>
            <span class="p-def-badge">Scopes 1, 2 et 3</span>
          </div>
        </div>

      </div>

    </div>
  </section>

  {{-- ================= POURQUOI UN PLAN CO₂ ? ================= --}}
  <section class="p-why">
    <div class="container p-why-shell">

      <div class="p-why-header p-animate">
        <h2>Pourquoi structurer un plan d’actions CO₂&nbsp;?</h2>
        <p>
          Le plan d’actions transforme la photographie du bilan carbone en un
          <strong>levier de pilotage</strong> concret, mobilisateur et compatible avec
          vos contraintes opérationnelles et réglementaires.
        </p>
      </div>

      <div class="p-why-layout">

        <div class="p-why-list p-animate">
          <div class="p-why-item">
            <div class="p-why-icon">
              <i class="fa-solid fa-list-check"></i>
            </div>
            <div class="p-why-text">
              <strong>Transformer les obligations en actions concrètes</strong><br>
              Passer du reporting climatique à un plan de mise en œuvre
              <strong>séquencé et suivi</strong> dans le temps.
            </div>
          </div>

          <div class="p-why-item">
            <div class="p-why-icon">
              <i class="fa-solid fa-mountain-sun"></i>
            </div>
            <div class="p-why-text">
              <strong>Atteindre les objectifs de la SNBC</strong><br>
              Construire une trajectoire compatible avec la neutralité carbone
              à l’horizon 2050, en cohérence avec votre secteur.
            </div>
          </div>

          <div class="p-why-item">
            <div class="p-why-icon">
              <i class="fa-solid fa-sack-dollar"></i>
            </div>
            <div class="p-why-text">
              <strong>Prioriser les investissements les plus rentables</strong><br>
              Identifier les actions à <strong>fort impact carbone</strong> et
              <strong>retour sur investissement attractif</strong>.
            </div>
          </div>

          <div class="p-why-item">
            <div class="p-why-icon">
              <i class="fa-solid fa-file-shield"></i>
            </div>
            <div class="p-why-text">
              <strong>Préparer la conformité CSRD &amp; reporting climat</strong><br>
              Structurer un plan compatible avec les <strong>exigences de transparence</strong>
              et les attentes des parties prenantes.
            </div>
          </div>

          <div class="p-why-item">
            <div class="p-why-icon">
              <i class="fa-solid fa-handshake-angle"></i>
            </div>
            <div class="p-why-text">
              <strong>Renforcer la stratégie climat &amp; RSE</strong><br>
              Donner de la visibilité aux équipes et aux décideurs sur la
              feuille de route bas-carbone.
            </div>
          </div>
        </div>

        <div class="p-why-panel p-animate">
          <div class="p-why-panel-title">Objectifs principaux</div>
          <div class="p-why-targets">
            <div class="p-target">
              <span>Réduction des émissions GES</span>
              <span>-30 à -50&nbsp;% (horizon 2030)</span>
            </div>
            <div class="p-target">
              <span>Résilience énergie &amp; coûts</span>
              <span>Moins de dépendance aux fossiles</span>
            </div>
            <div class="p-target">
              <span>Conformité &amp; image</span>
              <span>Alignement réglementaire &amp; RSE</span>
            </div>
          </div>
        </div>

      </div>

    </div>
  </section>

  {{-- ================= MÉTHODOLOGIE ================= --}}
  <section id="section-methodologie" class="p-section p-method">
    <div class="container">

      <div class="p-section-header p-animate">
        <div class="p-section-kicker">Méthodologie AuditVision</div>
        <h2 class="p-section-title">
          Une démarche structurée pour piloter la réduction des émissions
        </h2>
        <p class="p-section-lead">
          Le plan d’actions CO₂ s’appuie sur une analyse détaillée du bilan carbone
          et des audits existants, puis sur <strong>la construction de scénarios</strong>
          hiérarchisés, chiffrés et planifiés.
        </p>
      </div>

      <div class="p-method-grid">

        {{-- Colonne gauche : timeline --}}
        <div class="p-animate">
          <div class="p-method-tag">
            <i class="fa-solid fa-diagram-project"></i>
            Étapes clés
          </div>
          <div class="p-method-intro">
            <p>
              AuditVision structure la démarche en étapes claires&nbsp;:
              <strong>analyse, conception, priorisation et pilotage</strong>.
              Chaque action est associée à un impact carbone estimé, un coût
              et des indicateurs de suivi.
            </p>
          </div>

          <div class="p-steps">
            <div class="p-step">
              <div class="p-step-marker"></div>
              <div class="p-step-title">Analyse du bilan carbone et des audits existants</div>
              <div class="p-step-text">
                Relecture des bilans carbone, audits énergétiques et diagnostics sectoriels
                afin d’identifier les principaux gisements de réduction.
              </div>
            </div>

            <div class="p-step">
              <div class="p-step-marker"></div>
              <div class="p-step-title">Identification des actions possibles</div>
              <div class="p-step-text">
                Efficacité énergétique, substitution d’énergies, mobilité, achats, déchets…
                un large spectre d’actions est passé en revue.
              </div>
            </div>

            <div class="p-step">
              <div class="p-step-marker"></div>
              <div class="p-step-title">Évaluation technico-économique</div>
              <div class="p-step-text">
                Estimation des gains carbone, des économies d’énergie, des coûts d’investissement
                et des aides mobilisables pour chaque action.
              </div>
            </div>

            <div class="p-step">
              <div class="p-step-marker"></div>
              <div class="p-step-title">Construction de scénarios</div>
              <div class="p-step-text">
                Scénarios à court, moyen et long terme, compatibles avec vos contraintes
                budgétaires et opérationnelles.
              </div>
            </div>

            <div class="p-step">
              <div class="p-step-marker"></div>
              <div class="p-step-title">Priorisation &amp; planification</div>
              <div class="p-step-text">
                Classement des actions selon l’impact climatique, le coût, la faisabilité,
                et élaboration d’un calendrier de déploiement.
              </div>
            </div>

            <div class="p-step">
              <div class="p-step-marker"></div>
              <div class="p-step-title">Indicateurs &amp; suivi</div>
              <div class="p-step-text">
                Définition des KPIs, modalités de suivi et outils de pilotage
                pour suivre la mise en œuvre et les résultats.
              </div>
            </div>
          </div>
        </div>

        {{-- Colonne droite : carte synthèse --}}
        <div class="p-method-card p-animate">
          <div class="p-method-label">Plan d’actions CO₂</div>
          <div class="p-method-title">
            Un outil de décision pour les équipes et la direction
          </div>
          <div class="p-method-note">
            Le plan d’actions est livré sous une forme exploitable par les équipes
            opérationnelles, la direction et les instances de gouvernance.
          </div>
          <div class="p-method-tags">
            <span class="p-method-tagchip">Tableaux de bord</span>
            <span class="p-method-tagchip">Fiches actions</span>
            <span class="p-method-tagchip">Scénarios chiffrés</span>
            <span class="p-method-tagchip">Indicateurs de suivi</span>
          </div>
        </div>

      </div>

    </div>
  </section>

  {{-- ================= TYPES D’ACTIONS – NOUVEAU DESIGN ================= --}}
  <section class="p-actions">
    <div class="container">

      <div class="p-actions-header p-animate">
        <div class="p-actions-kicker">Types d’actions proposées dans le plan CO₂</div>
        <h2 class="p-actions-title">
          Des leviers concrets pour décarboner votre organisation
        </h2>
        <p class="p-actions-lead">
          Le plan d’actions CO₂ combine des mesures techniques, organisationnelles
          et comportementales, adaptées à votre activité et à vos priorités.
        </p>
      </div>

      <div class="p-actions-grid">

        <div class="p-action-card p-animate">
          <div class="p-action-strip"></div>
          <div class="p-action-icon">
            <i class="fa-solid fa-building-columns"></i>
          </div>
          <div class="p-action-title">Rénovation énergétique</div>
          <div class="p-action-text">
            Isolation, modernisation des systèmes CVC, optimisation de l’éclairage
            et pilotage des usages pour réduire durablement les consommations.
          </div>
          <div class="p-action-tag">Bâtiments &amp; enveloppe</div>
        </div>

        <div class="p-action-card p-animate">
          <div class="p-action-strip"></div>
          <div class="p-action-icon">
            <i class="fa-solid fa-gears"></i>
          </div>
          <div class="p-action-title">Optimisation des procédés</div>
          <div class="p-action-text">
            Amélioration des procédés industriels, récupération de chaleur,
            pilotage fin des équipements et réduction des pertes énergétiques.
          </div>
          <div class="p-action-tag">Procédés &amp; production</div>
        </div>

        <div class="p-action-card p-animate">
          <div class="p-action-strip"></div>
          <div class="p-action-icon">
            <i class="fa-solid fa-car-side"></i>
          </div>
          <div class="p-action-title">Réduction des émissions liées aux déplacements</div>
          <div class="p-action-text">
            Plans de mobilité, optimisation des déplacements professionnels,
            covoiturage, télétravail, mobilité douce et flotte bas-carbone.
          </div>
          <div class="p-action-tag">Mobilité &amp; transport</div>
        </div>

        <div class="p-action-card p-animate">
          <div class="p-action-strip"></div>
          <div class="p-action-icon">
            <i class="fa-solid fa-solar-panel"></i>
          </div>
          <div class="p-action-title">Développement des énergies renouvelables</div>
          <div class="p-action-text">
            Autoconsommation photovoltaïque, chaleur renouvelable, contrats d’approvisionnement
            vert et diversification du mix énergétique.
          </div>
          <div class="p-action-tag">Énergies renouvelables</div>
        </div>

        <div class="p-action-card p-animate">
          <div class="p-action-strip"></div>
          <div class="p-action-icon">
            <i class="fa-solid fa-cart-shopping"></i>
          </div>
          <div class="p-action-title">Politique d’achats responsables</div>
          <div class="p-action-text">
            Intégration du critère carbone dans les achats, sélection de fournisseurs
            engagés, réflexion sur les matières, la logistique et les services.
          </div>
          <div class="p-action-tag">Achats &amp; chaîne de valeur</div>
        </div>

        <div class="p-action-card p-animate">
          <div class="p-action-strip"></div>
          <div class="p-action-icon">
            <i class="fa-solid fa-people-group"></i>
          </div>
          <div class="p-action-title">Mobilité durable &amp; changements d’usages</div>
          <div class="p-action-text">
            Sensibilisation des équipes, programmes internes, écogestes,
            nouvelles pratiques de travail et d’organisation.
          </div>
          <div class="p-action-tag">Culture &amp; comportements</div>
        </div>

      </div>

    </div>
  </section>

  {{-- ================= CTA FINAL – inchangé ================= --}}
  <section class="p-cta">
    <div class="container">
      <div class="p-cta-card p-animate">
        <h2 class="p-cta-title">
          Construire votre stratégie bas-carbone
        </h2>
        <p class="p-cta-text">
          Vous souhaitez transformer votre bilan carbone en une feuille de route concrète&nbsp;?
          AuditVision vous accompagne pour définir et piloter un plan d’actions
          <strong>ambitieux, réaliste et aligné avec vos objectifs</strong>.
        </p>
        <div class="p-cta-actions">
          <a href="{{ url('contact') }}" class="p-btn-primary">
            Démarrer votre plan d’actions CO₂
            <i class="fa-solid fa-arrow-right"></i>
          </a>
          <a href="{{ route('bilan-carbone') }}" class="p-btn-ghost">
            Voir le bilan carbone
            <i class="fa-solid fa-chart-pie"></i>
          </a>
        </div>
      </div>
    </div>
  </section>

</section>

{{-- ================= JS : animation entrée au scroll ================= --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const animated = document.querySelectorAll('.p-animate');

    if ('IntersectionObserver' in window) {
        const obs = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('p-visible');
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });

        animated.forEach(el => obs.observe(el));
    } else {
        animated.forEach(el => el.classList.add('p-visible'));
    }
});
</script>
@endsection
