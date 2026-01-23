@extends('layouts.app')

@section('title', 'Audit énergétique des bâtiments tertiaires')

@section('content')
<style>
/* =========================================================
   PAGE – AUDIT ÉNERGÉTIQUE TERTIAIRE
   ========================================================= */
.page-tertiaire{
  --ink:#020617;
  --inkSoft:#0b1120;
  --navy:#111827;
  --navySoft:#1f2937;
  --accent:#7CAE2A;
  --accentSoft:#dcfce7;
  --muted:#6b7280;
  --border:#e5e7eb;
  --bg:#f9fafb;
  --card:#ffffff;
  --shadow-soft:0 18px 40px rgba(15,23,42,0.12);
  font-family: system-ui,-apple-system,BlinkMacSystemFont,"Inter",sans-serif;
}
.page-tertiaire *{box-sizing:border-box;}

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
   HERO – Bande verticale + layout corporate
   ========================================================= */
.t-hero{
  position:relative;
  padding:120px 0 90px;
  background:#0b1120;
  color:#e5e7eb;
  overflow:hidden;
}
.t-hero::before{
  content:"";
  position:absolute;
  left:-40px;
  top:-40px;
  bottom:-40px;
  width:180px;
  background:linear-gradient(180deg,#7CAE2A,#22c55e);
  box-shadow:0 0 0 1px rgba(0,0,0,.25);
}
.t-hero::after{
  content:"";
  position:absolute;
  inset:-40%;
  background:
    radial-gradient(160% 130% at 100% 0%,rgba(34,197,94,0.25) 0,transparent 60%),
    radial-gradient(150% 180% at 120% 80%,rgba(56,189,248,0.28) 0,transparent 70%);
  opacity:.85;
  pointer-events:none;
}
.t-hero-shell{
  position:relative;
  z-index:1;
}
.t-hero-grid{
  display:grid;
  grid-template-columns:minmax(0,1.6fr) minmax(0,1.15fr);
  gap:38px;
  align-items:center;
}

/* Kicker + titres */
.t-hero-kicker{
  display:inline-flex;
  align-items:center;
  gap:8px;
  padding:4px 11px;
  border-radius:999px;
  background:rgba(15,23,42,0.85);
  border:1px solid rgba(148,163,184,0.6);
  font-size:.78rem;
  letter-spacing:.16em;
  text-transform:uppercase;
  font-weight:600;
  color:#e5e7eb;
  margin-bottom:10px;
}
.t-hero-kicker span{
  width:7px;
  height:7px;
  border-radius:999px;
  background:#bbf7d0;
}

.t-hero-title{
  font-size:clamp(30px,4.7vw,44px);
  line-height:1.08;
  font-weight:800;
  color:#f9fafb;
  margin-bottom:10px;
}
.t-hero-sub{
  font-size:1rem;
  line-height:1.9;
  color:#cbd5f5;
  max-width:560px;
  margin-bottom:18px;
}

/* Étiquettes Décret / SNBC / Patrimoine */
.t-hero-tags{
  display:flex;
  flex-wrap:wrap;
  gap:8px;
  margin-bottom:24px;
}
.t-tag-pill{
  padding:6px 11px;
  border-radius:999px;
  background:rgba(15,23,42,0.95);
  border:1px solid rgba(148,163,184,0.65);
  font-size:.8rem;
  color:#e5e7eb;
  display:inline-flex;
  align-items:center;
  gap:7px;
}
.t-tag-pill i{
  font-size:.85rem;
  color:#bbf7d0;
}

/* CTA */
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
  background:linear-gradient(135deg,#7CAE2A,#16a34a);
  color:#022c22;
  font-size:.95rem;
  font-weight:700;
  border:none;
  text-decoration:none;
  box-shadow:0 20px 50px rgba(21,128,61,0.55);
  transition:transform .16s ease, box-shadow .16s ease, filter .16s ease;
}
.t-btn-primary i{font-size:.9rem;}
.t-btn-primary:hover{
  filter:brightness(1.04);
  transform:translateY(-1px);
  box-shadow:0 24px 60px rgba(21,128,61,0.7);
}
.t-btn-ghost{
  display:inline-flex;
  align-items:center;
  gap:7px;
  padding:8px 14px;
  border-radius:999px;
  background:rgba(15,23,42,0.75);
  border:1px solid rgba(148,163,184,0.7);
  font-size:.86rem;
  color:#e5e7eb;
  text-decoration:none;
}
.t-btn-ghost i{
  font-size:.9rem;
  color:#9ca3af;
}

/* Visuel hero : carte “Décret Tertiaire” */
.t-hero-visual{
  display:flex;
  justify-content:flex-end;
}
.t-hero-card{
  position:relative;
  border-radius:26px;
  padding:18px 18px 14px;
  background:radial-gradient(circle at 0% 0%,#1f2937 0,#020617 60%,#020617 100%);
  box-shadow:0 26px 90px rgba(0,0,0,0.85);
  overflow:hidden;
  min-height:230px;
}
.t-hero-badge{
  display:inline-flex;
  align-items:center;
  gap:7px;
  padding:4px 10px;
  border-radius:999px;
  background:rgba(15,23,42,0.85);
  border:1px solid rgba(148,163,184,0.6);
  font-size:.78rem;
  color:#e5e7eb;
  margin-bottom:12px;
}
.t-hero-badge i{
  color:#fde68a;
}

/* barre objectifs */
.t-targets{
  display:flex;
  flex-direction:column;
  gap:8px;
  margin-bottom:14px;
}
.t-target-row{
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap:10px;
  font-size:.82rem;
  color:#e5e7eb;
}
.t-target-label strong{color:#facc15;}
.t-target-bar-wrap{
  flex:1;
  height:7px;
  border-radius:999px;
  background:rgba(15,23,42,0.9);
  overflow:hidden;
}
.t-target-bar{
  height:100%;
  border-radius:999px;
  background:linear-gradient(90deg,#7CAE2A,#16a34a);
  transform-origin:left;
  animation:tBarGrow 4s ease-in-out infinite;
}
.t-target-bar.bar-2030{width:40%;}
.t-target-bar.bar-2040{width:50%;animation-delay:.15s;}
.t-target-bar.bar-2050{width:60%;animation-delay:.3s;}

@keyframes tBarGrow{
  0%,100%{transform:scaleX(1);}
  50%{transform:scaleX(.94);}
}

/* mini stats */
.t-hero-metrics{
  display:flex;
  justify-content:space-between;
  align-items:center;
  gap:10px;
  font-size:.8rem;
  color:#e5e7eb;
  margin-top:4px;
}
.t-metric{
  display:flex;
  flex-direction:column;
  gap:2px;
}
.t-metric span{
  font-size:.75rem;
  color:#9ca3af;
}
.t-metric strong{
  color:#f9fafb;
}

/* halo décoratif */
.t-hero-halo{
  position:absolute;
  width:220px;
  height:220px;
  border-radius:999px;
  background:radial-gradient(circle,rgba(190,242,100,0.4) 0,transparent 65%);
  right:-60px;
  bottom:-40px;
  opacity:.8;
}

/* =========================================================
   SECTION DÉFINITION
   ========================================================= */
.t-section{
  padding:64px 0;
}
.t-def{
  background:#f9fafb;
}
.t-def-grid{
  display:grid;
  grid-template-columns:minmax(0,1.55fr) minmax(0,1.1fr);
  gap:28px;
  align-items:flex-start;
}
.t-def-title{
  font-size:1.7rem;
  font-weight:800;
  color:var(--inkSoft);
  margin-bottom:10px;
}
.t-def-text{
  font-size:.98rem;
  color:#374151;
  line-height:1.9;
}
.t-def-text p{margin-bottom:1em;}

/* carte NF EN + Décret */
.t-def-card{
  border-radius:22px;
  padding:18px 18px 15px;
  background:#ffffff;
  border:1px solid rgba(148,163,184,0.6);
  box-shadow:0 18px 44px rgba(148,163,184,0.3);
}
.t-def-tag{
  display:inline-flex;
  align-items:center;
  gap:7px;
  padding:4px 10px;
  border-radius:999px;
  background:#ecfdf5;
  color:#166534;
  font-size:.78rem;
  font-weight:600;
  text-transform:uppercase;
  letter-spacing:.14em;
  margin-bottom:10px;
}
.t-def-tag i{font-size:.9rem;}
.t-def-card h3{
  font-size:1rem;
  font-weight:700;
  color:#0f172a;
  margin-bottom:8px;
}
.t-def-card p{
  font-size:.9rem;
  color:#4b5563;
  margin-bottom:10px;
}
.t-def-highlight{
  margin-top:6px;
  padding:10px 11px;
  border-radius:14px;
  background:#fefce8;
  font-size:.83rem;
  color:#422006;
}

/* =========================================================
   POURQUOI – doubles colonnes + check list
   ========================================================= */
.t-why{
  background:#ffffff;
}
.t-section-header{
  max-width:760px;
  margin:0 auto 26px;
  text-align:center;
}
.t-section-kicker{
  font-size:.8rem;
  text-transform:uppercase;
  letter-spacing:.16em;
  color:#64748b;
  font-weight:600;
  margin-bottom:4px;
}
.t-section-title{
  font-size:1.7rem;
  font-weight:800;
  color:var(--inkSoft);
  margin-bottom:8px;
}
.t-section-lead{
  font-size:.96rem;
  color:#4b5563;
  line-height:1.8;
}

.t-why-grid{
  display:grid;
  grid-template-columns:minmax(0,1.35fr) minmax(0,1.05fr);
  gap:26px;
  align-items:flex-start;
}
.t-why-list{
  list-style:none;
  padding:0;
  margin:0;
  display:flex;
  flex-direction:column;
  gap:10px;
}
.t-why-item{
  display:flex;
  align-items:flex-start;
  gap:10px;
  padding:10px 11px;
  border-radius:16px;
  background:#f9fafb;
  border:1px solid rgba(209,213,219,0.9);
  font-size:.9rem;
  color:#111827;
}
.t-why-item i{
  margin-top:3px;
  color:#16a34a;
}
.t-why-note{
  font-size:.88rem;
  color:#6b7280;
  margin-top:10px;
}

/* carte “réponses réglementaires” */
.t-why-card{
  border-radius:22px;
  padding:16px 16px 14px;
  background:#0b1120;
  color:#e5e7eb;
  border:1px solid rgba(148,163,184,0.9);
  box-shadow:0 24px 70px rgba(15,23,42,0.9);
}
.t-why-card h3{
  font-size:1rem;
  font-weight:700;
  margin-bottom:8px;
}
.t-why-card p{
  font-size:.88rem;
  color:#cbd5f5;
  margin-bottom:10px;
}
.t-pill-small{
  display:inline-flex;
  align-items:center;
  gap:6px;
  padding:3px 8px;
  border-radius:999px;
  background:rgba(15,23,42,0.9);
  border:1px solid rgba(148,163,184,0.7);
  font-size:.75rem;
  color:#e5e7eb;
}

/* =========================================================
   MÉTHODOLOGIE – step cards horizontales
   ========================================================= */
.t-method{
  background:#f3f4f6;
}
.t-method-header{
  max-width:780px;
  margin:0 auto 26px;
  text-align:center;
}
.t-method-header h2{
  font-size:1.7rem;
  font-weight:800;
  color:var(--inkSoft);
  margin-bottom:8px;
}
.t-method-header p{
  font-size:.96rem;
  color:#4b5563;
  line-height:1.8;
}

/* steps */
.t-steps-grid{
  display:grid;
  grid-template-columns:repeat(3,minmax(0,1fr));
  gap:18px;
}
.t-step-card{
  position:relative;
  border-radius:20px;
  padding:14px 14px 13px;
  background:#ffffff;
  border:1px solid rgba(148,163,184,0.75);
  box-shadow:0 18px 42px rgba(148,163,184,0.28);
  font-size:.88rem;
  color:#374151;
}
.t-step-number{
  position:absolute;
  top:10px;
  right:12px;
  font-size:1.5rem;
  font-weight:800;
  color:rgba(148,163,184,0.3);
}
.t-step-label{
  font-size:.76rem;
  text-transform:uppercase;
  letter-spacing:.14em;
  color:#6b7280;
  margin-bottom:4px;
}
.t-step-title{
  font-size:.98rem;
  font-weight:700;
  color:#0f172a;
  margin-bottom:5px;
}
.t-step-text{
  font-size:.86rem;
  color:#4b5563;
}
.t-step-badge{
  display:inline-flex;
  align-items:center;
  gap:6px;
  padding:3px 8px;
  border-radius:999px;
  background:#ecfdf5;
  color:#166534;
  font-size:.78rem;
  margin-top:7px;
}

/* mini timeline horizontale */
.t-mini-line{
  display:flex;
  justify-content:center;
  align-items:center;
  gap:6px;
  margin:18px auto 0;
  max-width:380px;
  font-size:.78rem;
  color:#6b7280;
}
.t-mini-dot{
  width:7px;
  height:7px;
  border-radius:999px;
  background:#16a34a;
}
.t-mini-bar{
  flex:1;
  height:2px;
  border-radius:999px;
  background:linear-gradient(90deg,#bbf7d0,#16a34a);
}

/* =========================================================
   CONCLUSION / CTA
   ========================================================= */
.t-cta{
  padding:70px 0 90px;
  background:radial-gradient(circle at 0% 0%,#dcfce7 0,#0b1120 55%,#020617 100%);
  color:#e5e7eb;
}
.t-cta-card{
  max-width:820px;
  margin:0 auto;
  border-radius:26px;
  padding:26px 24px 22px;
  background:linear-gradient(135deg,rgba(15,23,42,0.96),rgba(15,23,42,0.94));
  box-shadow:0 28px 90px rgba(15,23,42,0.9);
  border:1px solid rgba(190,242,100,0.45);
  text-align:center;
}
.t-cta-title{
  font-size:1.6rem;
  font-weight:800;
  margin-bottom:8px;
  color:#f9fafb;
}
.t-cta-text{
  font-size:.96rem;
  color:#dbeafe;
  margin-bottom:18px;
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
  .t-hero::before{
    left:-60px;
    width:120px;
  }
  .t-hero-grid{
    grid-template-columns:1fr;
  }
  .t-def-grid{
    grid-template-columns:1fr;
  }
  .t-why-grid{
    grid-template-columns:1fr;
  }
  .t-steps-grid{
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
  .t-steps-grid{
    grid-template-columns:1fr;
  }
}
</style>

<section class="page-tertiaire">

  {{-- ================= HERO ================= --}}
  <section class="t-hero">
    <div class="container t-hero-shell">
      <div class="t-hero-grid">

        {{-- Colonne texte --}}
        <div class="t-animate">
          <div class="t-hero-kicker">
            <span></span>
            Audit énergétique des bâtiments tertiaires
          </div>
          <h1 class="t-hero-title">
            Audit énergétique des bâtiments tertiaires
          </h1>
          <p class="t-hero-sub">
            Une étude approfondie des consommations d’énergie de vos bâtiments tertiaires
            (bureaux, commerces, hôtels, santé, enseignement…) pour identifier les postes
            énergivores, les déperditions et les leviers d’amélioration, en conformité
            avec le <strong>Décret Tertiaire</strong>.
          </p>

          <div class="t-hero-tags">
            <span class="t-tag-pill">
              <i class="fa-solid fa-building"></i>
              Bureaux, commerces, hôtels, santé, enseignement…
            </span>
            <span class="t-tag-pill">
              <i class="fa-solid fa-scale-balanced"></i>
              Décret Tertiaire &amp; SNBC
            </span>
            <span class="t-tag-pill">
              <i class="fa-solid fa-arrow-trend-down"></i>
              Factures d’énergie durablement réduites
            </span>
          </div>

          <div class="t-hero-actions">
            <a href="{{ url('/') }}#home-end" class="t-btn-primary">
      Demander un audit énergétique tertiaire
      <i class="fa-solid fa-arrow-right"></i>
    </a>
            <a href="#section-method" class="t-btn-ghost">
              Découvrir la méthodologie
              <i class="fa-solid fa-circle-down"></i>
            </a>
          </div>
        </div>

        {{-- Colonne visuel --}}
        <div class="t-hero-visual t-animate">
          <div class="t-hero-card">
            <div class="t-hero-badge">
              <i class="fa-solid fa-gauge-high"></i>
              Décret Tertiaire – Trajectoire de réduction
            </div>

            <div class="t-targets">
              <div class="t-target-row">
                <div class="t-target-label">
                  <strong>-40&nbsp;%</strong> d’ici 2030
                </div>
                <div class="t-target-bar-wrap">
                  <div class="t-target-bar bar-2030"></div>
                </div>
              </div>
              <div class="t-target-row">
                <div class="t-target-label">
                  <strong>-50&nbsp;%</strong> d’ici 2040
                </div>
                <div class="t-target-bar-wrap">
                  <div class="t-target-bar bar-2040"></div>
                </div>
              </div>
              <div class="t-target-row">
                <div class="t-target-label">
                  <strong>-60&nbsp;%</strong> d’ici 2050
                </div>
                <div class="t-target-bar-wrap">
                  <div class="t-target-bar bar-2050"></div>
                </div>
              </div>
            </div>

            <div class="t-hero-metrics">
              <div class="t-metric">
                <span>Patrimoine couvert</span>
                <strong>Bâtiments tertiaires &gt; 1000&nbsp;m²</strong>
              </div>
              <div class="t-metric">
                <span>Outil</span>
                <strong>Plateforme OPERAT</strong>
              </div>
              <div class="t-metric">
                <span>Vision</span>
                <strong>Stratégie Bas-Carbone</strong>
              </div>
            </div>

            <div class="t-hero-halo"></div>
          </div>
        </div>

      </div>
    </div>
  </section>

  {{-- ================= DÉFINITION ================= --}}
  <section class="t-section t-def">
    <div class="container">
      <div class="t-def-grid">

        <div class="t-animate">
          <h2 class="t-def-title">
            Audit énergétique tertiaire&nbsp;: une vision globale de vos consommations
          </h2>
          <div class="t-def-text">
            <p>
              L’audit énergétique des bâtiments tertiaires est une <strong>étude approfondie</strong>
              des consommations d’énergie d’un bâtiment ou d’un ensemble de bâtiments à usage
              professionnel&nbsp;: bureaux, commerces, hôtels, établissements de santé,
              enseignement, etc.
            </p>
            <p>
              Il permet d’identifier les <strong>postes énergivores</strong>, les
              <strong>déperditions thermiques</strong> et les potentiels d’amélioration,
              tout en respectant strictement les <strong>exigences réglementaires françaises</strong>,
              notamment le <strong>Décret Tertiaire (Éco Énergie Tertiaire)</strong>.
            </p>
          </div>
        </div>

        <div class="t-def-card t-animate">
          <div class="t-def-tag">
            <i class="fa-solid fa-file-contract"></i>
            Cadre réglementaire &amp; normes
          </div>
          <h3>Une démarche alignée sur NF EN 16247 &amp; Décret Tertiaire</h3>
          <p>
            AuditVision applique une méthodologie conforme à la <strong>norme NF EN 16247</strong>
            et aux exigences de l’<strong>Éco Énergie Tertiaire</strong>, en intégrant l’ensemble des
            usages du bâtiment et les objectifs de la <strong>Stratégie Nationale Bas-Carbone (SNBC)</strong>.
          </p>
          <div class="t-def-highlight">
            Résultat&nbsp;: un audit reconnu, exploitable pour vos obligations déclaratives
            sur la plateforme <strong>OPERAT</strong> et pour piloter votre stratégie
            de réduction des consommations.
          </div>
        </div>

      </div>
    </div>
  </section>

  {{-- ================= POURQUOI RÉALISER UN AUDIT TERTIAIRE ? ================= --}}
  <section class="t-section t-why">
    <div class="container">

      <div class="t-section-header t-animate">
        <div class="t-section-kicker">Pourquoi réaliser un audit tertiaire&nbsp;?</div>
        <h2 class="t-section-title">
          Transformer une obligation en levier de performance énergétique
        </h2>
        <p class="t-section-lead">
          L’audit énergétique tertiaire permet de respecter les objectifs du Décret Tertiaire
          tout en <strong>réduisant durablement les factures d’énergie</strong> et en
          <strong>valorisant votre patrimoine</strong>.
        </p>
      </div>

      <div class="t-why-grid">
        {{-- Liste des raisons --}}
        <div class="t-animate">
          <ul class="t-why-list">
            <li class="t-why-item">
              <i class="fa-solid fa-scale-balanced"></i>
              <span>Respecter les objectifs du <strong>Décret Tertiaire</strong>&nbsp;:
                –40&nbsp;% d’ici 2030, –50&nbsp;% d’ici 2040, –60&nbsp;% d’ici 2050.</span>
            </li>
            <li class="t-why-item">
              <i class="fa-solid fa-lightbulb"></i>
              <span>Identifier les <strong>leviers d’économies</strong> les plus performants
                et rentables (enveloppe, systèmes, usages).</span>
            </li>
            <li class="t-why-item">
              <i class="fa-solid fa-receipt"></i>
              <span>Réduire durablement les <strong>factures d’énergie</strong> et
                maîtriser les risques liés à la volatilité des prix.</span>
            </li>
            <li class="t-why-item">
              <i class="fa-solid fa-earth-europe"></i>
              <span>Contribuer à la <strong>Stratégie Nationale Bas-Carbone (SNBC)</strong>
                et aux objectifs climat de votre organisation.</span>
            </li>
            <li class="t-why-item">
              <i class="fa-solid fa-building-circle-check"></i>
              <span>Valoriser le patrimoine immobilier&nbsp;: amélioration du <strong>DPE</strong>,
                accès ou maintien de labels (HQE, BREEAM…).</span>
            </li>
            <li class="t-why-item">
              <i class="fa-solid fa-shield-halved"></i>
              <span>Anticiper les sanctions et <strong>sécuriser la déclaration OPERAT</strong>
                grâce à une trajectoire argumentée et documentée.</span>
            </li>
          </ul>

          <div class="t-why-note">
            L’audit devient ainsi un <strong>outil de décision</strong> pour structurer votre
            plan de travaux, prioriser les investissements et communiquer vos engagements
            de décarbonation.
          </div>
        </div>

        {{-- Carte réglementaire / RSE --}}
        <div class="t-why-card t-animate">
          <h3>Un pilier de votre stratégie énergie-climat</h3>
          <p>
            Au-delà du respect des obligations réglementaires, l’audit tertiaire nourrit votre
            <strong>stratégie RSE</strong>, vos plans de <strong>transition énergétique</strong>
            et votre communication auprès des parties prenantes (actionnaires, clients,
            collaborateurs…).
          </p>
          <p>
            AuditVision met en cohérence les exigences du <strong>Décret Tertiaire</strong>
            avec vos objectifs internes&nbsp;: politique climat, trajectoires net zéro,
            certifications, plans d’investissements.
          </p>

          <div class="t-pill-small" style="margin-top:6px;">
            <i class="fa-solid fa-diagram-project"></i>
            Décret Tertiaire • SNBC • Patrimoine &amp; RSE
          </div>
        </div>

      </div>

    </div>
  </section>

  {{-- ================= MÉTHODOLOGIE AUDITVISION ================= --}}
  <section id="section-method" class="t-section t-method">
    <div class="container">

      <div class="t-method-header t-animate">
        <h2>
          Comment se déroule l’audit tertiaire chez AuditVision&nbsp;?
        </h2>
        <p>
          AuditVision applique une méthodologie rigoureuse conforme à la
          <strong>norme NF EN 16247</strong>, depuis la collecte de données jusqu’au
          <strong>plan d’actions priorisé</strong> et à l’accompagnement pour OPERAT.
        </p>
      </div>

      <div class="t-steps-grid">
        {{-- Étape 1 --}}
        <div class="t-step-card t-animate">
          <div class="t-step-number">1</div>
          <div class="t-step-label">Collecte des données</div>
          <div class="t-step-title">Factures, plans et consommations</div>
          <div class="t-step-text">
            Récupération des <strong>factures sur 3 ans</strong>, plans détaillés,
            relevés de consommation, données d’occupation et d’exploitation
            pour disposer d’une base solide.
          </div>
        </div>

        {{-- Étape 2 --}}
        <div class="t-step-card t-animate">
          <div class="t-step-number">2</div>
          <div class="t-step-label">Visite technique</div>
          <div class="t-step-title">Analyse sur site des systèmes</div>
          <div class="t-step-text">
            Visite complète&nbsp;: <strong>enveloppe</strong> (isolation, menuiseries),
            chauffage, climatisation, ventilation, éclairage, usages spécifiques
            et modalités d’exploitation.
          </div>
        </div>

        {{-- Étape 3 --}}
        <div class="t-step-card t-animate">
          <div class="t-step-number">3</div>
          <div class="t-step-label">Diagnostic énergétique</div>
          <div class="t-step-title">Modélisation &amp; déperditions</div>
          <div class="t-step-text">
            Diagnostic énergétique complet&nbsp;: modélisation des consommations,
            identification des <strong>déperditions</strong> et des principaux postes
            énergivores par usage.
          </div>
        </div>

        {{-- Étape 4 --}}
        <div class="t-step-card t-animate">
          <div class="t-step-number">4</div>
          <div class="t-step-label">Scénarios optimisés</div>
          <div class="t-step-title">Bouquets de travaux &amp; économies</div>
          <div class="t-step-text">
            Construction de <strong>bouquets de travaux</strong> avec calcul des
            économies d’énergie, estimation des coûts, prises en compte des
            <strong>aides financières</strong> (CEE, MaPrimeRénov’, Fonds Vert…).
          </div>
          <div class="t-step-badge">
            <i class="fa-solid fa-seedling"></i>
            Gains &amp; aides intégrés
          </div>
        </div>

        {{-- Étape 5 --}}
        <div class="t-step-card t-animate">
          <div class="t-step-number">5</div>
          <div class="t-step-label">Plan d’actions</div>
          <div class="t-step-title">Priorisation &amp; trajectoire</div>
          <div class="t-step-text">
            <strong>Plan d’actions priorisé</strong> avec classement par impact,
            rentabilité et facilité de mise en œuvre, pour piloter efficacement
            la trajectoire de réduction.
          </div>
        </div>

        {{-- Étape 6 --}}
        <div class="t-step-card t-animate">
          <div class="t-step-number">6</div>
          <div class="t-step-label">Rapport &amp; OPERAT</div>
          <div class="t-step-title">Livrables &amp; accompagnement</div>
          <div class="t-step-text">
            Rapport final <strong>conforme</strong> et exploitable, synthèses de décision,
            et accompagnement pour la <strong>déclaration sur OPERAT</strong>
            et le suivi des objectifs.
          </div>
        </div>
      </div>

      <div class="t-mini-line t-animate">
        <span class="t-mini-dot"></span>
        <div class="t-mini-bar"></div>
        <span>De la donnée brute au plan d’actions opérationnel</span>
      </div>

    </div>
  </section>

  {{-- ================= CONCLUSION / CTA ================= --}}
  <section class="t-cta">
    <div class="container">
      <div class="t-cta-card t-animate">
        <h2 class="t-cta-title">
          Transformer vos obligations en opportunités de performance
        </h2>
        <p class="t-cta-text">
          AuditVision transforme vos obligations réglementaires en véritables
          <strong>opportunités d’efficacité énergétique</strong>, de réduction des coûts
          et de <strong>valorisation du patrimoine</strong>. Ensemble, nous bâtissons
          une trajectoire compatible avec le Décret Tertiaire et votre stratégie
          bas-carbone.
        </p>
        <div class="t-cta-actions">
          <a href="{{ url('contact') }}" class="t-btn-primary">
            Lancer un audit énergétique tertiaire
            <i class="fa-solid fa-arrow-right"></i>
          </a>
          <a href="{{ route('services.index') }}" class="t-btn-ghost">
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
