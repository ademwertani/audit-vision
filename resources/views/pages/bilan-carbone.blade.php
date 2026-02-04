@extends('layouts.app')

@section('title', 'Bilan Carbone – Évaluation des Émissions GES')

@section('content')
<style>
/* =========================================================
   PAGE – BILAN CARBONE (NOUVEAU DESIGN)
   ========================================================= */
.cb-page{
  --cb-navy:#020617;
  --cb-navySoft:#0f172a;
  --cb-accent:#16a34a;
  --cb-accentSoft:#bbf7d0;
  --cb-accentDeep:#15803d;
  --cb-muted:#6b7280;
  --cb-border:#e5e7eb;
  --cb-bg:#f3f4f6;
  --cb-card:#ffffff;
  --cb-shadow-card:0 20px 45px rgba(15,23,42,0.14);
  font-family: system-ui, -apple-system, BlinkMacSystemFont, "Inter", sans-serif;
}
.cb-page *{
  box-sizing:border-box;
}

/* Animation simple au scroll */
.cb-reveal{
  opacity:0;
  transform:translateY(26px);
  transition:opacity .6s ease, transform .6s ease;
}
.cb-reveal.cb-inview{
  opacity:1;
  transform:translateY(0);
}

/* =========================================================
   HERO – BANDE DIAGONALE
   ========================================================= */
.cb-hero{
  position:relative;
  padding:110px 0 70px;
  background:#f9fafb;
  overflow:hidden;
}
.cb-hero-diag{
  position:absolute;
  inset:0;
  background:
    linear-gradient(120deg, #bbf7d0 0%, #ecfdf3 30%, #ecfeff 60%, #eff6ff 100%);
  clip-path:polygon(0 0, 100% 0, 100% 65%, 0 100%);
  opacity:.95;
  pointer-events:none;
}
.cb-hero-shell{
  position:relative;
  z-index:1;
}
.cb-hero-grid{
  display:grid;
  grid-template-columns:minmax(0,1.7fr) minmax(0,1.1fr);
  gap:40px;
  align-items:center;
}

/* texte hero */
.cb-kicker{
  display:inline-flex;
  align-items:center;
  gap:8px;
  padding:4px 11px;
  border-radius:999px;
  background:#ecfdf3;
  color:#166534;
  font-size:.78rem;
  font-weight:600;
  letter-spacing:.14em;
  text-transform:uppercase;
  margin-bottom:12px;
}
.cb-kicker span{
  width:6px;
  height:6px;
  border-radius:999px;
  background:#22c55e;
}
.cb-hero-title{
  font-size:clamp(32px, 4.6vw, 44px);
  line-height:1.06;
  font-weight:800;
  color:var(--cb-navy);
  margin-bottom:10px;
}
.cb-hero-sub{
  font-size:1rem;
  line-height:1.8;
  color:var(--cb-muted);
  max-width:520px;
  margin-bottom:18px;
}
.cb-hero-tags{
  display:flex;
  flex-wrap:wrap;
  gap:8px;
  margin-bottom:24px;
}
.cb-tag{
  padding:5px 10px;
  border-radius:999px;
  font-size:.78rem;
  background:#ecfeff;
  color:#022c22;
  border:1px solid rgba(8,47,73,0.16);
  display:inline-flex;
  align-items:center;
  gap:6px;
}
.cb-tag i{
  font-size:.86rem;
  color:#0f766e;
}

/* CTA hero */
.cb-hero-actions{
  display:flex;
  flex-wrap:wrap;
  gap:12px;
  align-items:center;
}
.cb-btn-primary{
  display:inline-flex;
  align-items:center;
  gap:8px;
  padding:9px 22px;
  border-radius:999px;
  background:linear-gradient(135deg,#16a34a,#0f766e);
  color:#fff;
  font-size:.95rem;
  font-weight:600;
  border:none;
  text-decoration:none;
  box-shadow:0 20px 48px rgba(22,163,74,0.35);
  transition:transform .16s ease, box-shadow .16s ease, filter .16s ease;
}
.cb-btn-primary i{
  font-size:.9rem;
}
.cb-btn-primary:hover{
  filter:brightness(1.05);
  transform:translateY(-1px);
  box-shadow:0 24px 60px rgba(22,163,74,0.45);
}
.cb-btn-ghost{
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
.cb-btn-ghost i{
  font-size:.9rem;
  color:#64748b;
}

/* visuel hero : carte stats verticale */
.cb-hero-panel{
  position:relative;
  border-radius:24px;
  background:#020617;
  padding:18px 18px 16px;
  box-shadow:0 26px 70px rgba(15,23,42,0.80);
  overflow:hidden;
}
.cb-hero-panel::before{
  content:"";
  position:absolute;
  inset:-20%;
  background:
    radial-gradient(120% 140% at 0% 0%, rgba(34,197,94,0.5) 0, transparent 55%),
    radial-gradient(130% 160% at 110% 15%, rgba(8,145,178,0.5) 0, transparent 65%);
  opacity:.9;
  mix-blend-mode:screen;
  pointer-events:none;
}
.cb-hero-panel-inner{
  position:relative;
  z-index:1;
}

/* petit header badge */
.cb-panel-header{
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-bottom:10px;
  color:#e5e7eb;
  font-size:.78rem;
}
.cb-panel-chip{
  padding:3px 9px;
  border-radius:999px;
  background:rgba(15,23,42,0.9);
  border:1px solid rgba(187,247,208,0.55);
  font-size:.72rem;
}

/* graph barre horizontale scopes */
.cb-scope-bar-wrap{
  border-radius:18px;
  background:rgba(15,23,42,0.9);
  border:1px solid rgba(148,163,184,0.7);
  padding:12px 14px;
  margin-bottom:14px;
}
.cb-scope-bar{
  height:12px;
  border-radius:999px;
  overflow:hidden;
  display:flex;
}
.cb-scope-seg{
  height:100%;
}
.cb-scope-s1{background:#22c55e; width:25%;}
.cb-scope-s2{background:#38bdf8; width:30%;}
.cb-scope-s3{background:#eab308; width:45%;}

/* légende sous la barre */
.cb-scope-legend-row{
  display:flex;
  justify-content:space-between;
  gap:10px;
  margin-top:8px;
  color:#e5e7eb;
  font-size:.74rem;
}
.cb-scope-leg-item{
  display:flex;
  align-items:center;
  gap:6px;
}
.cb-scope-dot{
  width:9px;
  height:9px;
  border-radius:999px;
}
.cb-dot-s1{background:#22c55e;}
.cb-dot-s2{background:#38bdf8;}
.cb-dot-s3{background:#eab308;}

/* petites cartes chiffres */
.cb-hero-stats{
  display:grid;
  grid-template-columns:repeat(3,minmax(0,1fr));
  gap:10px;
  margin-top:8px;
}
.cb-stat-card{
  border-radius:16px;
  padding:9px 9px 7px;
  background:rgba(15,23,42,0.88);
  border:1px solid rgba(148,163,184,0.7);
  color:#e5e7eb;
  font-size:.78rem;
}
.cb-stat-label{
  font-size:.72rem;
  color:#9ca3af;
}
.cb-stat-value{
  font-size:.95rem;
  font-weight:700;
}

/* =========================================================
   SECTIONS GÉNÉRIQUES
   ========================================================= */
.cb-section{
  padding:64px 0;
}
.cb-section-header{
  max-width:780px;
  margin:0 auto 30px;
  text-align:left;
}
.cb-section-kicker{
  font-size:.78rem;
  text-transform:uppercase;
  letter-spacing:.16em;
  color:#6b7280;
  font-weight:600;
  margin-bottom:4px;
}
.cb-section-title{
  font-size:1.9rem;
  font-weight:800;
  color:var(--cb-navy);
  margin-bottom:10px;
}
.cb-section-lead{
  font-size:.98rem;
  color:#4b5563;
  line-height:1.85;
}

/* =========================================================
   SECTION – POURQUOI (LISTE VERTICALE + TIMELINE)
   ========================================================= */
.cb-why{
  background:#ffffff;
}
.cb-why-grid{
  display:grid;
  grid-template-columns:minmax(0,1.3fr) minmax(0,1.1fr);
  gap:32px;
  align-items:flex-start;
}
.cb-why-list{
  margin-top:8px;
}
.cb-why-item{
  display:flex;
  gap:12px;
  padding:12px 0;
  border-bottom:1px solid #e5e7eb;
}
.cb-why-item:last-child{
  border-bottom:none;
}
.cb-why-icon{
  width:32px;
  height:32px;
  border-radius:999px;
  background:#ecfdf3;
  display:flex;
  align-items:center;
  justify-content:center;
  color:#15803d;
}
.cb-why-body-title{
  font-size:.98rem;
  font-weight:700;
  color:#0f172a;
  margin-bottom:4px;
}
.cb-why-body-text{
  font-size:.9rem;
  color:#4b5563;
  line-height:1.7;
}

/* Colonne droite : mini timeline “bénéfices” */
.cb-why-timeline{
  position:relative;
  border-radius:20px;
  padding:16px 18px 14px;
  background:#0f172a;
  color:#e5e7eb;
  box-shadow:0 22px 65px rgba(15,23,42,0.9);
}
.cb-why-timeline::before{
  content:"";
  position:absolute;
  left:18px;
  top:16px;
  bottom:16px;
  border-left:2px dashed rgba(148,163,184,0.7);
}
.cb-tline-item{
  position:relative;
  padding-left:42px;
  padding-bottom:14px;
}
.cb-tline-item:last-child{
  padding-bottom:0;
}
.cb-tline-marker{
  position:absolute;
  left:10px;
  top:4px;
  width:16px;
  height:16px;
  border-radius:999px;
  background:#0f172a;
  border:3px solid #22c55e;
  box-shadow:0 0 0 4px rgba(22,163,74,0.25);
}
.cb-tline-title{
  font-size:.9rem;
  font-weight:700;
}
.cb-tline-text{
  font-size:.82rem;
  color:#cbd5f5;
}

/* =========================================================
   SECTION – CONTENU DU BILAN (SCOPES EN CARTES)
   ========================================================= */
.cb-content{
  background:#f9fafb;
}
.cb-content-shell{
  max-width:1000px;
  margin:0 auto;
}
.cb-content-text{
  font-size:.95rem;
  color:#4b5563;
  line-height:1.8;
  margin-bottom:18px;
}
.cb-content-grid{
  display:grid;
  grid-template-columns:repeat(3,minmax(0,1fr));
  gap:16px;
}
.cb-scope-card{
  border-radius:20px;
  padding:14px 14px 12px;
  background:#ffffff;
  border:1px solid rgba(148,163,184,0.7);
  box-shadow:0 16px 40px rgba(15,23,42,0.10);
  font-size:.88rem;
  color:#4b5563;
}
.cb-scope-head{
  display:flex;
  align-items:center;
  justify-content:space-between;
  margin-bottom:6px;
}
.cb-scope-chip{
  padding:3px 9px;
  border-radius:999px;
  font-size:.74rem;
  font-weight:600;
  text-transform:uppercase;
  letter-spacing:.12em;
}
.cb-chip-s1{ background:#dcfce7; color:#166534;}
.cb-chip-s2{ background:#e0f2fe; color:#075985;}
.cb-chip-s3{ background:#fef9c3; color:#854d0e;}
.cb-scope-label{
  font-size:.76rem;
  color:#6b7280;
}

/* liste contenu global */
.cb-content-list{
  margin-top:18px;
  border-radius:18px;
  padding:15px 18px 14px;
  background:#ecfeff;
  border:1px solid rgba(59,130,246,0.3);
  font-size:.9rem;
  color:#0f172a;
}
.cb-content-list ul{
  padding-left:1.1em;
  margin:0;
}
.cb-content-list li{
  margin-bottom:.35em;
}

/* =========================================================
   SECTION – MÉTHODOLOGIE (ZIGZAG)
   ========================================================= */
.cb-method{
  background:#ffffff;
}
.cb-method-shell{
  max-width:960px;
  margin:0 auto;
}
.cb-method-intro{
  font-size:.96rem;
  color:#374151;
  line-height:1.85;
  margin-bottom:22px;
}

/* zigzag */
.cb-zigzag{
  display:flex;
  flex-direction:column;
  gap:14px;
}
.cb-step-card{
  border-radius:18px;
  padding:14px 16px 12px;
  background:#f9fafb;
  border:1px solid #e5e7eb;
  box-shadow:0 10px 26px rgba(15,23,42,0.06);
  display:grid;
  grid-template-columns:auto minmax(0,1fr);
  gap:12px;
}
.cb-step-badge{
  width:30px;
  height:30px;
  border-radius:999px;
  background:#ecfdf3;
  display:flex;
  align-items:center;
  justify-content:center;
  font-size:.86rem;
  font-weight:700;
  color:#15803d;
}
.cb-step-body-title{
  font-size:.96rem;
  font-weight:700;
  color:#0f172a;
  margin-bottom:4px;
}
.cb-step-body-text{
  font-size:.9rem;
  color:#4b5563;
  line-height:1.75;
}

/* bloc vert à la fin méthode */
.cb-method-highlight{
  margin-top:18px;
  border-radius:20px;
  padding:15px 18px 13px;
  background:#022c22;
  color:#d1fae5;
 .p-actions {
  background: #0b1120;
  color: #e5e7eb;
  position: relative;
}
}
.cb-method-highlight-title{
  font-size:.98rem;
  font-weight:700;
  margin-bottom:6px;
}
.cb-method-highlight-text{
  font-size:.86rem;
  color:#a7f3d0;
}

/* =========================================================
   CTA FINAL
   ========================================================= */
.cb-cta{
  padding:60px 0 80px;
  background:#f1f5f9;
}
.cb-cta-card{
  max-width:820px;
  margin:0 auto;
  border-radius:24px;
  padding:24px 22px 20px;
  background:#ffffff;
  box-shadow:0 20px 60px rgba(15,23,42,0.12);
  border:1px solid #e5e7eb;
  text-align:center;
}
.cb-cta-title{
  font-size:1.6rem;
  font-weight:800;
  color:#022c22;
  margin-bottom:8px;
}
.cb-cta-text{
  font-size:.96rem;
  color:#4b5563;
  margin-bottom:18px;
}
.cb-cta-actions{
  display:flex;
  justify-content:center;
  flex-wrap:wrap;
  gap:12px;
}

/* RESPONSIVE */
@media (max-width: 991.98px){
  .cb-hero{
    padding:95px 0 60px;
  }
  .cb-hero-grid{
    grid-template-columns:1fr;
  }
  .cb-why-grid{
    grid-template-columns:1fr;
  }
  .cb-content-grid{
    grid-template-columns:repeat(2,minmax(0,1fr));
  }
}
@media (max-width: 575.98px){
  .cb-hero-actions{
    flex-direction:column;
    align-items:flex-start;
  }
  .cb-content-grid{
    grid-template-columns:1fr;
  }
}
</style>

<section class="cb-page">

  {{-- ================= HERO ================= --}}
  <section class="cb-hero">
    <div class="cb-hero-diag"></div>

    <div class="container cb-hero-shell">
      <div class="cb-hero-grid">

        {{-- Colonne texte --}}
        <div class="cb-reveal">
          <div class="cb-kicker">
            <span></span>
            Bilan carbone &amp; GES
          </div>

          <h1 class="cb-hero-title">
            Bilan Carbone – Évaluation des Émissions GES
          </h1>

          <p class="cb-hero-sub">
            Le bilan carbone identifie, quantifie et analyse les émissions de gaz à effet de serre
            générées par vos activités. AuditVision réalise des bilans conformes à la
            <strong>méthodologie ADEME</strong> et au <strong>GHG Protocol</strong>, pour une vision
            claire, comparable et exploitable.
          </p>

          <div class="cb-hero-tags">
            <span class="cb-tag">
              <i class="fa-solid fa-scale-balanced"></i>
              Méthodologie ADEME
            </span>
            <span class="cb-tag">
              <i class="fa-solid fa-layer-group"></i>
              Scopes 1, 2 &amp; 3
            </span>
            <span class="cb-tag">
              <i class="fa-solid fa-seedling"></i>
              Stratégie climat &amp; RSE
            </span>
          </div>

          <div class="cb-hero-actions">
            <a href="{{ url('/') }}#home-end" class="cb-btn-primary">
      Réaliser un bilan carbone
      <i class="fa-solid fa-arrow-right"></i>
    </a>
            
            <a href="#cb-method" class="cb-btn-ghost">
              Voir notre méthodologie
              <i class="fa-solid fa-circle-down"></i>
            </a>
          </div>
        </div>

        {{-- Colonne visuel (nouveau design) --}}
        <div class="cb-reveal">
          <div class="cb-hero-panel">
            <div class="cb-hero-panel-inner">
              <div class="cb-panel-header">
                <span style="font-weight:600;font-size:.8rem;">Profil d’émissions</span>
                <span class="cb-panel-chip">Bilan GES complet</span>
              </div>

              <div class="cb-scope-bar-wrap">
                <div class="cb-scope-bar">
                  <div class="cb-scope-seg cb-scope-s1"></div>
                  <div class="cb-scope-seg cb-scope-s2"></div>
                  <div class="cb-scope-seg cb-scope-s3"></div>
                </div>

                <div class="cb-scope-legend-row">
                  <div class="cb-scope-leg-item">
                    <span class="cb-scope-dot cb-dot-s1"></span>
                    <span>Scope 1</span>
                  </div>
                  <div class="cb-scope-leg-item">
                    <span class="cb-scope-dot cb-dot-s2"></span>
                    <span>Scope 2</span>
                  </div>
                  <div class="cb-scope-leg-item">
                    <span class="cb-scope-dot cb-dot-s3"></span>
                    <span>Scope 3</span>
                  </div>
                </div>
              </div>

              <div class="cb-hero-stats">
                <div class="cb-stat-card">
                  <div class="cb-stat-label">Obligations réglementaires</div>
                  <div class="cb-stat-value">Entreprises &gt; 500 salariés</div>
                </div>
                <div class="cb-stat-card">
                  <div class="cb-stat-label">Périmètre</div>
                  <div class="cb-stat-value">Scopes 1 / 2 / 3</div>
                </div>
                <div class="cb-stat-card">
                  <div class="cb-stat-label">Vision</div>
                  <div class="cb-stat-value">transition énergétique &amp; écologique</div>
                </div>
              </div>

            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  {{-- ================= SECTION POURQUOI ================= --}}
  <section class="cb-section cb-why">
    <div class="container">

      <div class="cb-section-header cb-reveal">
        <div class="cb-section-kicker">Pourquoi réaliser un bilan carbone&nbsp;?</div>
        <h2 class="cb-section-title">
          Transformer vos émissions en levier de stratégie climat
        </h2>
        <p class="cb-section-lead">
          Le bilan carbone n’est pas seulement une photographie des émissions.
          C’est un outil de pilotage pour prioriser vos actions, répondre aux obligations
          réglementaires et engager votre organisation sur une trajectoire bas-carbone.
        </p>
      </div>

      <div class="cb-why-grid">
        {{-- Liste verticale des raisons --}}
        <div class="cb-why-list cb-reveal">
          <div class="cb-why-item">
            <div class="cb-why-icon">
              <i class="fa-solid fa-gavel"></i>
            </div>
            <div>
              <div class="cb-why-body-title">Répondre aux obligations réglementaires</div>
              <div class="cb-why-body-text">
                Entreprises de plus de 500 salariés, collectivités et acteurs publics doivent
                réaliser et actualiser un bilan GES. AuditVision vous aide à rester conforme,
                sans perdre de vue vos enjeux opérationnels.
              </div>
            </div>
          </div>

          <div class="cb-why-item">
            <div class="cb-why-icon">
              <i class="fa-solid fa-fire-flame-curved"></i>
            </div>
            <div>
              <div class="cb-why-body-title">Identifier les postes les plus émetteurs</div>
              <div class="cb-why-body-text">
                Les émissions liées aux déplacements, aux achats ou aux process peuvent
                représenter la majorité de l’empreinte. Le bilan carbone met en lumière où
                concentrer vos efforts.
              </div>
            </div>
          </div>

          <div class="cb-why-item">
            <div class="cb-why-icon">
              <i class="fa-solid fa-gas-pump"></i>
            </div>
            <div>
              <div class="cb-why-body-title">Réduire les risques liés aux énergies fossiles</div>
              <div class="cb-why-body-text">
                En anticipant la hausse des coûts, les risques de rupture et les contraintes
                réglementaires, vous renforcez la résilience de votre modèle économique.
              </div>
            </div>
          </div>

          <div class="cb-why-item">
            <div class="cb-why-icon">
              <i class="fa-solid fa-hand-holding-dollar"></i>
            </div>
            <div>
              <div class="cb-why-body-title">Stratégie bas carbone &amp; accéder aux financements</div>
              <div class="cb-why-body-text">
                Un bilan carbone structuré crédibilise vos engagements RSE, facilite le dialogue
                avec les financeurs et ouvre l’accès à certaines aides ou dispositifs de soutien.
              </div>
            </div>
          </div>
        </div>

        {{-- Timeline bénéfices / vision long terme --}}
        <div class="cb-why-timeline cb-reveal">
          <div class="cb-tline-item">
            <div class="cb-tline-marker"></div>
            <div class="cb-tline-title">Étape 1&nbsp;: Conformité et transparence</div>
            <div class="cb-tline-text">
              Répondre aux exigences réglementaires, publier des indicateurs robustes et partager
              une vision claire des émissions avec les parties prenantes.
            </div>
          </div>

          <div class="cb-tline-item">
            <div class="cb-tline-marker"></div>
            <div class="cb-tline-title">Étape 2&nbsp;: Priorisation des actions</div>
            <div class="cb-tline-text">
              Identifier les postes clés, quantifier les marges de réduction et structurer
              un plan d’actions réaliste, hiérarchisé et chiffré.
            </div>
          </div>

          <div class="cb-tline-item">
            <div class="cb-tline-marker"></div>
            <div class="cb-tline-title">Étape 3&nbsp;: Trajectoire bas-carbone</div>
            <div class="cb-tline-text">
              Aligner vos objectifs avec les scénarios SNBC, suivre vos progrès année après année
              et intégrer le climat dans votre stratégie globale.
            </div>
          </div>
        </div>

      </div>

    </div>
  </section>

  {{-- ================= SECTION CONTENU DU BILAN ================= --}}
  <section class="cb-section cb-content">
    <div class="container">
      <div class="cb-content-shell">

        <div class="cb-section-header cb-reveal">
          <div class="cb-section-kicker">Contenu du bilan carbone</div>
          <h2 class="cb-section-title">
            Une analyse complète des émissions de gaz à effet de serre
          </h2>
        </div>

        <div class="cb-content-text cb-reveal">
          Le bilan carbone repose sur une analyse systématique de vos activités et de vos flux&nbsp;:
          énergie, déplacements, achats, déchets, immobilisations… AuditVision applique les
          <strong>facteurs d’émission ADEME</strong> et les références reconnues pour obtenir
          un diagnostic précis, comparable et fiable.
        </div>

        <div class="cb-content-grid cb-reveal">
          <div class="cb-scope-card">
            <div class="cb-scope-head">
              <span class="cb-scope-chip cb-chip-s1">Scope 1</span>
              <span class="cb-scope-label">Émissions directes</span>
            </div>
            <p>
              Combustibles consommés sur site, flotte de véhicules, procédés industriels,
              fuites de fluides frigorigènes… Toutes les émissions directement liées à vos
              installations.
            </p>
          </div>

          <div class="cb-scope-card">
            <div class="cb-scope-head">
              <span class="cb-scope-chip cb-chip-s2">Scope 2</span>
              <span class="cb-scope-label">Énergie achetée</span>
            </div>
            <p>
              Électricité, chaleur, froid, vapeur achetés et consommés sur vos sites.
              Ce scope reflète l’impact de vos consommations énergétiques et du mix
              de vos fournisseurs.
            </p>
          </div>

          <div class="cb-scope-card">
            <div class="cb-scope-head">
              <span class="cb-scope-chip cb-chip-s3">Scope 3</span>
              <span class="cb-scope-label">Émissions indirectes</span>
            </div>
            <p>
              Achats, immobilisations, transport de marchandises, déplacements,
              déchets, usage des produits vendus… Souvent la part la plus importante
              de votre empreinte carbone.
            </p>
          </div>
        </div>

        <div class="cb-content-list cb-reveal">
          <strong style="display:block;margin-bottom:6px;">Votre bilan carbone inclut notamment&nbsp;:</strong>
          <ul>
            <li>Analyse détaillée des <strong>Scopes 1, 2 et 3</strong>.</li>
            <li>Collecte et exploitation de toutes les <strong>données d’activité</strong>.</li>
            <li>Application des <strong>facteurs d’émission ADEME</strong>.</li>
            <li>Répartition des émissions par <strong>poste, site, activité ou produit</strong>.</li>
            <li>Comparaison avec des <strong>benchmarks sectoriels</strong> lorsque disponibles.</li>
          </ul>
        </div>

      </div>
    </div>
  </section>

  {{-- ================= SECTION MÉTHODOLOGIE (ZIGZAG) ================= --}}
  <section id="cb-method" class="cb-section cb-method">
    <div class="container">
      <div class="cb-method-shell">

        <div class="cb-section-header cb-reveal">
          <div class="cb-section-kicker">Méthodologie</div>
          <h2 class="cb-section-title">
            Une démarche structurée, du périmètre au plan d’actions
          </h2>
        </div>

        <div class="cb-method-intro cb-reveal">
          AuditVision suit une méthodologie alignée sur l’ADEME et le GHG Protocol&nbsp;:
          définition du périmètre, collecte des données, calcul des émissions, analyse
          détaillée puis recommandations et plan d’actions climat.
        </div>

        <div class="cb-zigzag cb-reveal">

          <div class="cb-step-card">
            <div class="cb-step-badge">1</div>
            <div>
              <div class="cb-step-body-title">Définition du périmètre et des activités</div>
              <div class="cb-step-body-text">
                Choix du cadre organisationnel (sites, entités, filiales) et du périmètre
                opérationnel (scopes, catégories d’émissions) en cohérence avec vos objectifs
                et obligations.
              </div>
            </div>
          </div>

          <div class="cb-step-card">
            <div class="cb-step-badge">2</div>
            <div>
              <div class="cb-step-body-title">Collecte des données</div>
              <div class="cb-step-body-text">
                Récupération structurée des données&nbsp;: énergie, déplacements, achats,
                immobilisations, déchets, etc. Appui aux équipes internes pour fiabiliser
                les informations manquantes.
              </div>
            </div>
          </div>

          <div class="cb-step-card">
            <div class="cb-step-badge">3</div>
            <div>
              <div class="cb-step-body-title">Calcul des émissions GES</div>
              <div class="cb-step-body-text">
                Application des facteurs d’émission ADEME et d’autres référentiels reconnus,
                vérification des ordres de grandeur et consolidation par scope, poste
                et site.
              </div>
            </div>
          </div>

          <div class="cb-step-card">
            <div class="cb-step-badge">4</div>
            <div>
              <div class="cb-step-body-title">Analyse par scope et par poste</div>
              <div class="cb-step-body-text">
                Identification des postes prioritaires, analyses croisées par activité,
                énergie, processus ou chaîne de valeur, comparaison avec des benchmarks
                sectoriels lorsque disponibles.
              </div>
            </div>
          </div>

          <div class="cb-step-card">
            <div class="cb-step-badge">5</div>
            <div>
              <div class="cb-step-body-title">Identification des leviers de réduction</div>
              <div class="cb-step-body-text">
                Définition des leviers à court, moyen et long terme&nbsp;:
                efficacité énergétique, mobilité, achats responsables, évolution du mix,
                éco-conception, sobriété…
              </div>
            </div>
          </div>

          <div class="cb-step-card">
            <div class="cb-step-badge">6</div>
            <div>
              <div class="cb-step-body-title">Présentation du rapport et recommandations</div>
              <div class="cb-step-body-text">
                Restitution claire, rapport détaillé, fiches actions et éléments de
                communication pour intégrer le bilan carbone dans votre trajectoire
                climat et votre stratégie RSE.
              </div>
            </div>
          </div>

        </div>

        <div class="cb-method-highlight cb-reveal">
          <div class="cb-method-highlight-title">
            Un bilan carbone pour décider et agir, pas seulement pour se conformer
          </div>
          <div class="cb-method-highlight-text">
            Au-delà de la conformité, AuditVision transforme le bilan carbone en
            véritable outil de pilotage&nbsp;: trajectoire bas-carbone, priorisation des
            investissements, mobilisation des équipes et dialogue avec vos partenaires.
          </div>
        </div>

      </div>
    </div>
  </section>

  {{-- ================= CTA FINAL ================= --}}
  <section class="cb-cta">
    <div class="container">
      <div class="cb-cta-card cb-reveal">
        <h2 class="cb-cta-title">
          Prêt à lancer votre bilan carbone&nbsp;?
        </h2>
        <p class="cb-cta-text">
          Vous représentez une entreprise, une collectivité ou une organisation engagée
          dans la transition climatique&nbsp;? AuditVision vous accompagne pour réaliser
          un bilan carbone <strong>conforme, robuste et actionnable</strong>, au service
          de vos objectifs de décarbonation.
        </p>
        <div class="cb-cta-actions">
          <a href="{{ url('contact') }}" class="cb-btn-primary">
            Parler de votre projet
            <i class="fa-solid fa-arrow-right"></i>
          </a>
          <a href="{{ route('services.index') }}" class="cb-btn-ghost">
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
    const blocks = document.querySelectorAll('.cb-reveal');

    if ('IntersectionObserver' in window) {
        const obs = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('cb-inview');
                    obs.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.15
        });

        blocks.forEach(el => obs.observe(el));
    } else {
        blocks.forEach(el => el.classList.add('cb-inview'));
    }
});
</script>
@endsection
