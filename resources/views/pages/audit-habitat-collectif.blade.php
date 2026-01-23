@extends('layouts.app')

@section('title', 'Audit énergétique pour l’habitat collectif')

@section('content')
<style>
/* =========================================================
   PAGE – AUDIT HABITAT COLLECTIF
   ========================================================= */
.hc-page{
  --ink:#0f172a;
  --inkSoft:#111827;
  --navy:#1e293b;
  --accent:#7CAE2A;
  --accentSoft:#dcfce7;
  --muted:#6b7280;
  --border:#e5e7eb;
  --bg:#f9fafb;
  --card:#ffffff;
  --shadow-soft:0 20px 50px rgba(15,23,42,0.12);
  font-family: system-ui,-apple-system,BlinkMacSystemFont,"Inter",sans-serif;
}
.hc-page *{box-sizing:border-box;}

.hc-animate{
  opacity:0;
  transform:translateY(24px);
  transition:opacity .6s ease, transform .6s ease;
}
.hc-animate.hc-visible{
  opacity:1;
  transform:translateY(0);
}

/* =========================================================
   HERO – style “copro / immeuble résidentiel”
   ========================================================= */
.hc-hero{
  position:relative;
  padding:120px 0 90px;
  background:radial-gradient(circle at 0% 0%,#dcfce7 0,#f9fafb 50%,#eff6ff 100%);
  overflow:hidden;
}
.hc-hero::before{
  content:"";
  position:absolute;
  inset:-40%;
  background:
    radial-gradient(130% 130% at -10% 0%,rgba(34,197,94,0.35) 0,transparent 60%),
    radial-gradient(160% 160% at 120% 40%,rgba(59,130,246,0.25) 0,transparent 70%);
  opacity:.8;
  pointer-events:none;
}
.hc-hero-shell{
  position:relative;
  z-index:1;
}
.hc-hero-grid{
  display:grid;
  grid-template-columns:minmax(0,1.5fr) minmax(0,1.1fr);
  gap:40px;
  align-items:center;
}

/* Colonne texte */
.hc-hero-kicker{
  display:inline-flex;
  align-items:center;
  gap:8px;
  padding:4px 10px;
  border-radius:999px;
  background:#ecfdf5;
  border:1px solid rgba(22,163,74,0.35);
  color:#166534;
  font-size:.78rem;
  font-weight:600;
  letter-spacing:.16em;
  text-transform:uppercase;
  margin-bottom:10px;
}
.hc-hero-kicker span{
  width:7px;
  height:7px;
  border-radius:999px;
  background:#16a34a;
}

.hc-hero-title{
  font-size:clamp(30px,4.8vw,44px);
  line-height:1.08;
  font-weight:800;
  color:var(--inkSoft);
  margin-bottom:10px;
}
.hc-hero-sub{
  font-size:1rem;
  line-height:1.9;
  color:#4b5563;
  max-width:560px;
  margin-bottom:18px;
}

/* badges */
.hc-hero-pills{
  display:flex;
  flex-wrap:wrap;
  gap:9px;
  margin-bottom:24px;
}
.hc-hero-pill{
  display:inline-flex;
  align-items:center;
  gap:7px;
  padding:6px 11px;
  border-radius:999px;
  background:#ffffff;
  border:1px solid rgba(148,163,184,0.65);
  font-size:.8rem;
  color:#111827;
}
.hc-hero-pill i{
  font-size:.86rem;
  color:#16a34a;
}

/* CTA */
.hc-hero-actions{
  display:flex;
  flex-wrap:wrap;
  gap:12px;
  align-items:center;
}
.hc-btn-primary{
  display:inline-flex;
  align-items:center;
  gap:8px;
  padding:9px 20px;
  border-radius:999px;
  background:linear-gradient(135deg,#7CAE2A,#22c55e);
  color:#022c22;
  font-size:.95rem;
  font-weight:700;
  border:none;
  text-decoration:none;
  box-shadow:0 18px 48px rgba(21,128,61,0.55);
  transition:transform .16s ease, box-shadow .16s ease, filter .16s ease;
}
.hc-btn-primary i{font-size:.9rem;}
.hc-btn-primary:hover{
  filter:brightness(1.04);
  transform:translateY(-1px);
  box-shadow:0 22px 60px rgba(21,128,61,0.7);
}
.hc-btn-ghost{
  display:inline-flex;
  align-items:center;
  gap:7px;
  padding:8px 14px;
  border-radius:999px;
  background:#ffffff;
  border:1px solid rgba(148,163,184,0.8);
  font-size:.86rem;
  color:#111827;
  text-decoration:none;
}
.hc-btn-ghost i{
  font-size:.9rem;
  color:#6b7280;
}

/* Colonne visuel – immeuble stylisé + timeline charges */
.hc-hero-visual{
  display:flex;
  justify-content:flex-end;
}
.hc-hero-card{
  position:relative;
  border-radius:24px;
  padding:16px 16px 14px;
  background:#0f172a;
  color:#e5e7eb;
  box-shadow:0 26px 80px rgba(15,23,42,0.85);
  overflow:hidden;
  min-height:235px;
}

/* immeuble */
.hc-building{
  position:relative;
  border-radius:18px;
  background:linear-gradient(180deg,#1e293b,#020617);
  padding:14px 12px 12px;
  margin-bottom:12px;
  display:grid;
  grid-template-columns:1.3fr 1fr;
  gap:10px;
}

/* façade */
.hc-building-front{
  display:grid;
  grid-template-rows:repeat(4,1fr);
  gap:4px;
}
.hc-floor{
  display:grid;
  grid-template-columns:repeat(4,1fr);
  gap:4px;
}
.hc-window{
  height:16px;
  border-radius:4px;
  background:linear-gradient(135deg,#facc15,#fed7aa);
  opacity:.86;
  box-shadow:0 0 0 1px rgba(15,23,42,0.5);
}
.hc-floor:nth-child(2) .hc-window:nth-child(3),
.hc-floor:nth-child(3) .hc-window:nth-child(1){
  opacity:.4;
}

/* cage + entrée */
.hc-building-core{
  display:flex;
  flex-direction:column;
  justify-content:space-between;
}
.hc-core-top{
  border-radius:10px;
  padding:8px 8px;
  background:radial-gradient(circle at 0% 0%,#22c55e 0,rgba(15,23,42,1) 70%);
  font-size:.75rem;
}
.hc-core-top strong{
  color:#f9fafb;
}
.hc-core-bottom{
  border-radius:10px;
  padding:6px 8px;
  background:rgba(15,23,42,0.9);
  font-size:.74rem;
  display:flex;
  justify-content:space-between;
  gap:4px;
}
.hc-core-bottom span{
  color:#e5e7eb;
}

/* mini timeline charges */
.hc-charges{
  display:flex;
  flex-direction:column;
  gap:6px;
  font-size:.78rem;
}
.hc-charge-row{
  display:flex;
  align-items:center;
  gap:8px;
}
.hc-charge-label{
  width:95px;
  color:#cbd5f5;
}
.hc-charge-bar-wrap{
  flex:1;
  height:6px;
  border-radius:999px;
  background:rgba(15,23,42,0.85);
  overflow:hidden;
}
.hc-charge-bar{
  height:100%;
  border-radius:999px;
  background:linear-gradient(90deg,#7CAE2A,#22c55e);
  transform-origin:left;
  animation:hcCharge 4s ease-in-out infinite;
}
.hc-charge-bar.c1{width:50%;}
.hc-charge-bar.c2{width:35%;animation-delay:.2s;}
.hc-charge-bar.c3{width:20%;animation-delay:.4s;}

@keyframes hcCharge{
  0%,100%{transform:scaleX(1);}
  50%{transform:scaleX(.93);}
}

/* bas carte */
.hc-hero-footer{
  display:flex;
  justify-content:space-between;
  align-items:center;
  gap:10px;
  font-size:.8rem;
}
.hc-hero-footer .hc-pill{
  display:inline-flex;
  align-items:center;
  gap:6px;
  padding:3px 8px;
  border-radius:999px;
  background:rgba(15,23,42,0.9);
  border:1px solid rgba(148,163,184,0.7);
  font-size:.74rem;
}
.hc-hero-footer .hc-pill i{color:#bbf7d0;}
.hc-hero-footer strong{
  color:#f9fafb;
}

/* =========================================================
   SECTIONS GÉNÉRIQUES
   ========================================================= */
.hc-section{
  padding:64px 0;
}
.hc-section-header{
  text-align:center;
  max-width:780px;
  margin:0 auto 30px;
}
.hc-section-kicker{
  font-size:.8rem;
  text-transform:uppercase;
  letter-spacing:.16em;
  color:#6b7280;
  font-weight:600;
  margin-bottom:4px;
}
.hc-section-title{
  font-size:1.7rem;
  font-weight:800;
  color:var(--inkSoft);
  margin-bottom:8px;
}
.hc-section-lead{
  font-size:.96rem;
  color:#4b5563;
  line-height:1.85;
}

/* =========================================================
   DÉFINITION
   ========================================================= */
.hc-def{
  background:#ffffff;
}
.hc-def-grid{
  display:grid;
  grid-template-columns:minmax(0,1.6fr) minmax(0,1.1fr);
  gap:28px;
  align-items:flex-start;
}
.hc-def-text{
  font-size:.98rem;
  color:#374151;
  line-height:1.9;
}
.hc-def-text p{margin-bottom:1em;}

.hc-def-card{
  border-radius:22px;
  padding:18px 18px 14px;
  background:#f9fafb;
  border:1px solid rgba(148,163,184,0.7);
  box-shadow:0 18px 42px rgba(148,163,184,0.28);
}
.hc-def-tag{
  display:inline-flex;
  align-items:center;
  gap:7px;
  padding:4px 10px;
  border-radius:999px;
  background:#eef2ff;
  font-size:.78rem;
  font-weight:600;
  color:#3730a3;
  letter-spacing:.14em;
  text-transform:uppercase;
  margin-bottom:10px;
}
.hc-def-tag i{font-size:.9rem;}
.hc-def-card h3{
  font-size:1rem;
  font-weight:700;
  color:#111827;
  margin-bottom:8px;
}
.hc-def-card p{
  font-size:.9rem;
  color:#4b5563;
  margin-bottom:8px;
}
.hc-def-highlight{
  margin-top:6px;
  padding:10px 11px;
  border-radius:14px;
  background:#fefce8;
  font-size:.83rem;
  color:#422006;
}

/* =========================================================
   POURQUOI – carte grille
   ========================================================= */
.hc-why{
  background:#f9fafb;
}
.hc-why-grid{
  display:grid;
  grid-template-columns:repeat(3,minmax(0,1fr));
  gap:18px;
}
.hc-why-card{
  border-radius:20px;
  padding:14px 14px 13px;
  background:#ffffff;
  border:1px solid rgba(209,213,219,0.9);
  box-shadow:0 14px 32px rgba(148,163,184,0.18);
  font-size:.9rem;
  color:#111827;
}
.hc-why-icon{
  width:32px;
  height:32px;
  border-radius:999px;
  background:#ecfdf5;
  display:flex;
  align-items:center;
  justify-content:center;
  margin-bottom:8px;
}
.hc-why-icon i{
  color:#16a34a;
}
.hc-why-title{
  font-size:.98rem;
  font-weight:700;
  color:#0f172a;
  margin-bottom:4px;
}
.hc-why-text{
  font-size:.86rem;
  color:#4b5563;
}
.hc-why-note{
  margin-top:16px;
  font-size:.86rem;
  color:#6b7280;
  max-width:680px;
  text-align:center;
  margin-left:auto;
  margin-right:auto;
}

/* =========================================================
   MÉTHODOLOGIE – timeline verticale
   ========================================================= */
.hc-method{
  background:#ffffff;
}
.hc-method-shell{
  max-width:980px;
  margin:0 auto;
}
.hc-timeline{
  position:relative;
  margin-top:10px;
}
.hc-timeline::before{
  content:"";
  position:absolute;
  left:18px;
  top:0;
  bottom:0;
  border-left:2px dashed rgba(148,163,184,0.8);
}
.hc-step{
  position:relative;
  padding-left:52px;
  padding-bottom:20px;
}
.hc-step:last-child{
  padding-bottom:0;
}
.hc-step-marker{
  position:absolute;
  left:10px;
  top:4px;
  width:18px;
  height:18px;
  border-radius:999px;
  background:#ffffff;
  border:3px solid #7CAE2A;
  box-shadow:0 0 0 4px rgba(190,242,100,0.45);
}
.hc-step-label{
  font-size:.76rem;
  text-transform:uppercase;
  letter-spacing:.14em;
  color:#6b7280;
  margin-bottom:2px;
}
.hc-step-title{
  font-size:.98rem;
  font-weight:700;
  color:#0f172a;
  margin-bottom:4px;
}
.hc-step-text{
  font-size:.88rem;
  color:#4b5563;
}
.hc-step-badge{
  display:inline-flex;
  align-items:center;
  gap:6px;
  padding:3px 8px;
  border-radius:999px;
  background:#ecfdf5;
  color:#166534;
  font-size:.78rem;
  margin-top:6px;
}

/* =========================================================
   CTA FINAL
   ========================================================= */
.hc-cta{
  padding:70px 0 90px;
  background:radial-gradient(circle at 0% 0%,#dcfce7 0,#1f2937 55%,#020617 100%);
  color:#e5e7eb;
}
.hc-cta-card{
  max-width:820px;
  margin:0 auto;
  border-radius:26px;
  padding:26px 24px 22px;
  background:linear-gradient(135deg,rgba(15,23,42,0.95),rgba(15,23,42,0.96));
  box-shadow:0 28px 90px rgba(15,23,42,0.9);
  border:1px solid rgba(190,242,100,0.4);
  text-align:center;
}
.hc-cta-title{
  font-size:1.6rem;
  font-weight:800;
  margin-bottom:8px;
  color:#f9fafb;
}
.hc-cta-text{
  font-size:.96rem;
  color:#e0f2fe;
  margin-bottom:18px;
}
.hc-cta-actions{
  display:flex;
  justify-content:center;
  flex-wrap:wrap;
  gap:12px;
}

/* RESPONSIVE */
@media (max-width: 991.98px){
  .hc-hero{
    padding:100px 0 70px;
  }
  .hc-hero-grid{
    grid-template-columns:1fr;
  }
  .hc-def-grid{
    grid-template-columns:1fr;
  }
  .hc-why-grid{
    grid-template-columns:repeat(2,minmax(0,1fr));
  }
}
@media (max-width: 575.98px){
  .hc-hero{
    padding:90px 0 60px;
  }
  .hc-hero-actions{
    flex-direction:column;
    align-items:flex-start;
  }
  .hc-why-grid{
    grid-template-columns:1fr;
  }
}
</style>

<section class="hc-page">

  {{-- ================= HERO ================= --}}
  <section class="hc-hero">
    <div class="container hc-hero-shell">
      <div class="hc-hero-grid">

        {{-- Colonne texte --}}
        <div class="hc-animate">
          <div class="hc-hero-kicker">
            <span></span>
            Audit énergétique pour l’habitat collectif
          </div>
          <h1 class="hc-hero-title">
            Audit énergétique pour l’habitat collectif
          </h1>
          <p class="hc-hero-sub">
            Une analyse détaillée des performances énergétiques de votre immeuble
            en copropriété ou ensemble résidentiel, couvrant les <strong>parties communes</strong>,
            les <strong>systèmes collectifs</strong>, l’enveloppe et un échantillon
            de logements, conforme à la <strong>loi Climat et Résilience</strong>.
          </p>

          <div class="hc-hero-pills">
            <div class="hc-hero-pill">
              <i class="fa-solid fa-building"></i>
              Copropriétés &amp; ensembles résidentiels
            </div>
            <div class="hc-hero-pill">
              <i class="fa-solid fa-file-circle-check"></i>
              PPT &amp; DPE collectif
            </div>
            <div class="hc-hero-pill">
              <i class="fa-solid fa-hand-holding-dollar"></i>
              Charges énergétiques maîtrisées
            </div>
          </div>

          <div class="hc-hero-actions">

            <a href="{{ url('/') }}#home-end" class="hc-btn-primary">
              Demander un audit habitat collectif
              <i class="fa-solid fa-arrow-right"></i>
            </a>
            <a href="#section-method" class="hc-btn-ghost">
              Voir la méthodologie
              <i class="fa-solid fa-circle-down"></i>
            </a>
          </div>
        </div>

        {{-- Colonne visuel --}}
        <div class="hc-hero-visual hc-animate">
          <div class="hc-hero-card">
            <div class="hc-building">
              <div class="hc-building-front">
                <div class="hc-floor">
                  <div class="hc-window"></div>
                  <div class="hc-window"></div>
                  <div class="hc-window"></div>
                  <div class="hc-window"></div>
                </div>
                <div class="hc-floor">
                  <div class="hc-window"></div>
                  <div class="hc-window"></div>
                  <div class="hc-window"></div>
                  <div class="hc-window"></div>
                </div>
                <div class="hc-floor">
                  <div class="hc-window"></div>
                  <div class="hc-window"></div>
                  <div class="hc-window"></div>
                  <div class="hc-window"></div>
                </div>
                <div class="hc-floor">
                  <div class="hc-window"></div>
                  <div class="hc-window"></div>
                  <div class="hc-window"></div>
                  <div class="hc-window"></div>
                </div>
              </div>

              <div class="hc-building-core">
                <div class="hc-core-top">
                  <div style="font-size:.74rem;">Plan Pluriannuel de Travaux</div>
                  <strong>PPT alimenté par l’audit</strong>
                </div>
                <div class="hc-core-bottom">
                  <span>Parties communes</span>
                  <span>Chaufferie / ECS</span>
                </div>
              </div>
            </div>

            <div class="hc-charges">
              <div class="hc-charge-row">
                <div class="hc-charge-label">Chauffage&nbsp;:</div>
                <div class="hc-charge-bar-wrap">
                  <div class="hc-charge-bar c1"></div>
                </div>
                <span>-30&nbsp;% visé</span>
              </div>
              <div class="hc-charge-row">
                <div class="hc-charge-label">ECS&nbsp;:</div>
                <div class="hc-charge-bar-wrap">
                  <div class="hc-charge-bar c2"></div>
                </div>
                <span>-20&nbsp;% visé</span>
              </div>
              <div class="hc-charge-row">
                <div class="hc-charge-label">Parties communes&nbsp;:</div>
                <div class="hc-charge-bar-wrap">
                  <div class="hc-charge-bar c3"></div>
                </div>
                <span>-15&nbsp;% visé</span>
              </div>
            </div>

            <div class="hc-hero-footer" style="margin-top:10px;">
              <div class="hc-pill">
                <i class="fa-solid fa-people-roof"></i>
                <span>MaPrimeRénov’ Copropriété</span>
              </div>
              <strong>DPE collectif • Loi Climat &amp; Résilience</strong>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  {{-- ================= DÉFINITION ================= --}}
  <section class="hc-section hc-def">
    <div class="container">
      <div class="hc-def-grid">

        <div class="hc-animate">
          <div class="hc-section-header" style="text-align:left;margin-bottom:16px;">
            <div class="hc-section-kicker">Définition</div>
            <h2 class="hc-section-title" style="margin-bottom:8px;">
              Un audit énergétique dédié à l’habitat collectif
            </h2>
          </div>
          <div class="hc-def-text">
            <p>
              L’audit énergétique des bâtiments d’<strong>habitations collectives</strong>
              est une analyse détaillée des performances énergétiques d’un <strong>immeuble
              en copropriété</strong> ou d’un ensemble résidentiel.
            </p>
            <p>
              Il examine les <strong>parties communes</strong>, les <strong>systèmes collectifs</strong>
              (chauffage, ventilation, eau chaude sanitaire), l’<strong>enveloppe du bâtiment</strong>
              (toiture, façades, menuiseries) et un <strong>échantillon représentatif
              des logements privatifs</strong>.
            </p>
            <p>
              L’audit est conduit en conformité avec les exigences de la
              <strong>loi Climat et Résilience</strong> et du <strong>Code de la construction
              et de l’habitation</strong>.
            </p>
          </div>
        </div>

        <div class="hc-def-card hc-animate">
          <div class="hc-def-tag">
            <i class="fa-solid fa-scale-balanced"></i>
            Cadre réglementaire
          </div>
          <h3>Un outil clé pour la rénovation énergétique des copropriétés</h3>
          <p>
            L’audit énergétique constitue le socle technique pour définir un
            <strong>projet de rénovation globale</strong> ou par étapes, nourrir
            le <strong>Plan Pluriannuel de Travaux</strong> et préparer les
            décisions en Assemblée Générale.
          </p>
          <p>
            Il éclaire les arbitrages entre confort, réduction des charges,
            impact carbone et valorisation du patrimoine.
          </p>
          <div class="hc-def-highlight">
            AuditVision accompagne syndics et conseils syndicaux pour bâtir un
            <strong>parcours de rénovation réaliste</strong>, compatible avec les
            capacités d’investissement de la copropriété.
          </div>
        </div>

      </div>
    </div>
  </section>

  {{-- ================= POURQUOI RÉALISER UN AUDIT ? ================= --}}
  <section class="hc-section hc-why">
    <div class="container">

      <div class="hc-section-header hc-animate">
        <div class="hc-section-kicker">
          Pourquoi réaliser un audit en habitat collectif&nbsp;?
        </div>
        <h2 class="hc-section-title">
          Préparer les travaux, maîtriser les charges, valoriser le parc
        </h2>
        <p class="hc-section-lead">
          L’audit énergétique fournit une vision claire et partagée des
          <strong>performances du bâtiment</strong>, des <strong>travaux à engager</strong>
          et des <strong>aides mobilisables</strong>, au service des copropriétaires.
        </p>
      </div>

      <div class="hc-why-grid">
        <div class="hc-why-card hc-animate">
          <div class="hc-why-icon">
            <i class="fa-solid fa-clipboard-list"></i>
          </div>
          <div class="hc-why-title">Plan Pluriannuel de Travaux (PPT)</div>
          <div class="hc-why-text">
            Préparer et alimenter le <strong>PPT obligatoire</strong> avec des
            recommandations hiérarchisées, argumentées techniquement et chiffrées.
          </div>
        </div>

        <div class="hc-why-card hc-animate">
          <div class="hc-why-icon">
            <i class="fa-solid fa-house-circle-check"></i>
          </div>
          <div class="hc-why-title">DPE collectif &amp; valeur des logements</div>
          <div class="hc-why-text">
            Anticiper ou compléter le <strong>DPE collectif</strong> et
            <strong>améliorer la classe énergétique</strong> pour renforcer
            l’attractivité du parc immobilier.
          </div>
        </div>

        <div class="hc-why-card hc-animate">
          <div class="hc-why-icon">
            <i class="fa-solid fa-hand-holding-dollar"></i>
          </div>
          <div class="hc-why-title">Réduction des charges énergétiques</div>
          <div class="hc-why-text">
            Réduire durablement les <strong>charges de chauffage et d’ECS</strong>
            supportées par les copropriétaires, en ciblant les principaux postes
            de déperditions et de surconsommations.
          </div>
        </div>

        <div class="hc-why-card hc-animate">
          <div class="hc-why-icon">
            <i class="fa-solid fa-earth-europe"></i>
          </div>
          <div class="hc-why-title">Contribution climat &amp; SNBC</div>
          <div class="hc-why-text">
            Diminuer les <strong>émissions de CO₂</strong> du parc résidentiel
            et contribuer aux objectifs de la <strong>Stratégie Nationale
            Bas-Carbone</strong>.
          </div>
        </div>

        <div class="hc-why-card hc-animate">
          <div class="hc-why-icon">
            <i class="fa-solid fa-piggy-bank"></i>
          </div>
          <div class="hc-why-title">Aides financières collectives</div>
          <div class="hc-why-text">
            Faciliter l’accès aux aides collectives&nbsp;:
            <strong>MaPrimeRénov’ Copropriété</strong>, <strong>CEE</strong>,
            <strong>Éco-PTZ collectif</strong>, etc.
          </div>
        </div>

        <div class="hc-why-card hc-animate">
          <div class="hc-why-icon">
            <i class="fa-solid fa-people-group"></i>
          </div>
          <div class="hc-why-title">Décision en Assemblée Générale</div>
          <div class="hc-why-text">
            Mettre à disposition un <strong>rapport clair et pédagogique</strong>,
            permettant de présenter les scénarios en AG et de faciliter l’adhésion
            des copropriétaires.
          </div>
        </div>
      </div>

      <div class="hc-why-note hc-animate">
        L’audit devient un support de <strong>concertation</strong> entre
        syndic, conseil syndical et copropriétaires, pour construire un projet
        de rénovation durable et accepté.
      </div>

    </div>
  </section>

  {{-- ================= MÉTHODOLOGIE AUDITVISION ================= --}}
  <section id="section-method" class="hc-section hc-method">
    <div class="container">
      <div class="hc-method-shell">

        <div class="hc-section-header hc-animate">
          <div class="hc-section-kicker">Méthodologie AuditVision</div>
          <h2 class="hc-section-title">
            Une démarche structurée, du diagnostic au plan d’actions priorisé
          </h2>
          <p class="hc-section-lead">
            AuditVision déploie une méthodologie adaptée à l’habitat collectif,
            combinant <strong>analyse technique</strong>, <strong>modélisation énergétique</strong>
            et <strong>approche économique</strong>, pour construire un plan
            de rénovation cohérent et finançable.
          </p>
        </div>

        <div class="hc-timeline">

          <div class="hc-step hc-animate">
            <div class="hc-step-marker"></div>
            <div class="hc-step-label">Étape 1</div>
            <div class="hc-step-title">Collecte des données</div>
            <div class="hc-step-text">
              Recueil des <strong>factures</strong> (communes et, si possible, privatives),
              des plans, DPE existants, données d’occupation et informations
              de gestion de la copropriété.
            </div>
          </div>

          <div class="hc-step hc-animate">
            <div class="hc-step-marker"></div>
            <div class="hc-step-label">Étape 2</div>
            <div class="hc-step-title">Visites terrain approfondies</div>
            <div class="hc-step-text">
              Inspection détaillée de l’<strong>enveloppe</strong> (toiture, façades,
              menuiseries), de la <strong>chaufferie</strong>, de la <strong>ventilation</strong>,
              de l’<strong>ECS</strong> et de <strong>logements témoins</strong>.
            </div>
          </div>

          <div class="hc-step hc-animate">
            <div class="hc-step-marker"></div>
            <div class="hc-step-label">Étape 3</div>
            <div class="hc-step-title">Diagnostic énergétique complet</div>
            <div class="hc-step-text">
              Modélisation du bâtiment et des systèmes, identification des
              <strong>déperditions</strong> et des points de faiblesse,
              analyse des consommations par poste.
            </div>
          </div>

          <div class="hc-step hc-animate">
            <div class="hc-step-marker"></div>
            <div class="hc-step-label">Étape 4</div>
            <div class="hc-step-title">Scénarios de rénovation</div>
            <div class="hc-step-text">
              Élaboration de scénarios de <strong>travaux globaux ou par étapes</strong>,
              estimation des <strong>gains énergétiques</strong>, des <strong>aides
              mobilisables</strong> et du <strong>temps de retour</strong>.
            </div>
            <div class="hc-step-badge">
              <i class="fa-solid fa-seedling"></i>
              Gains, aides &amp; ROI intégrés
            </div>
          </div>

          <div class="hc-step hc-animate">
            <div class="hc-step-marker"></div>
            <div class="hc-step-label">Étape 5</div>
            <div class="hc-step-title">Plan d’actions priorisé &amp; rapport</div>
            <div class="hc-step-text">
              Construction d’un <strong>plan d’actions priorisé</strong> (efficacité,
              impact charges, faisabilité en AG) et remise d’un <strong>rapport clair
              et pédagogique</strong>, prêt à être présenté en Assemblée Générale.
            </div>
          </div>

        </div>

      </div>
    </div>
  </section>

  {{-- ================= CTA FINAL ================= --}}
  <section class="hc-cta">
    <div class="container">
      <div class="hc-cta-card hc-animate">
        <h2 class="hc-cta-title">
          Construire une stratégie de rénovation performante et durable
        </h2>
        <p class="hc-cta-text">
          AuditVision accompagne les <strong>syndics</strong> et les
          <strong>conseils syndicaux</strong> pour transformer les contraintes
          réglementaires en <strong>opportunités de rénovation énergétique</strong>,
          au service du confort des occupants, de la maîtrise des charges
          et de la valeur du patrimoine.
        </p>
        <div class="hc-cta-actions">
          <a href="{{ url('contact') }}" class="hc-btn-primary">
            Demander un audit habitat collectif
            <i class="fa-solid fa-arrow-right"></i>
          </a>
          <a href="{{ route('services.index') }}" class="hc-btn-ghost">
            Découvrir nos autres services
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
    const animated = document.querySelectorAll('.hc-animate');

    if ('IntersectionObserver' in window) {
        const obs = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('hc-visible');
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });

        animated.forEach(el => obs.observe(el));
    } else {
        animated.forEach(el => el.classList.add('hc-visible'));
    }
});
</script>
@endsection
