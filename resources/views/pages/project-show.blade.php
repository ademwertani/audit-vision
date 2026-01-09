@extends('layouts.app')
@section('title', $project->name . ' | Nos projets')
@section('content')
  <style>
    /* =========================================================
                 France Isolation – Project Details (same skin as Contact/About/Blog)
                 Scoped to this page only.
                 ========================================================= */
    .page-project {
      --navy: #242958;
      --navyDark: #1d2760;
      --sky: #7CAE2A;
      --accent: #7CAE2A;
      --ink: #0f172a;
      --muted: #6b7280;
      --card: #ffffff;
      --ring: #dbe6ff;
      --shadow-lg: 0 24px 48px rgba(16, 24, 40, .12);
      --shadow: 0 10px 18px rgba(0, 0, 0, .08);
    }

    .page-project * {
      box-sizing: border-box
    }

    /* ---------- HERO (left-aligned + long pill breadcrumb) ---------- */
    .pr-hero {
      background: var(--navy);
      color: #fff;
      padding: 78px 0 92px;
      position: relative;
    }

    .pr-hero .pr-hgroup {
      max-width: 1100px;
      margin: 0 auto;
      padding: 0 12px
    }

    .pr-title {
      font-size: 48px;
      line-height: 1.08;
      font-weight: 800;
      margin: 0 0 10px
    }

    @media (min-width:992px) {
      .pr-title {
        font-size: 56px
      }
    }

    .pr-hero h1,
    .pr-hero .pr-title,
    .pr-hero p,
    .pr-hero .pr-sub {
      color: #fff !important
    }

    .pr-sub {
      max-width: 680px;
      font-size: 15px;
      line-height: 1.7;
      margin: 0;
      opacity: .95
    }

    .pr-bread-wrap {
      position: absolute;
      left: 0;
      right: 0;
      bottom: -28px;
      display: flex;
      justify-content: center
    }

    .pr-bread {
      width: min(1180px, calc(100% - 48px));
      background: var(--sky);
      height: 46px;
      border-radius: 9999px;
      display: flex;
      align-items: center;
      gap: 18px;
      padding: 0 22px;
      font-weight: 700;
      box-shadow: 0 10px 18px rgba(3, 102, 140, .12);
      color: #fff !important;
    }

    .pr-bread a,
    .pr-bread span {
      color: #fff !important
    }

    .pr-bread .sep {
      color: rgba(255, 255, 255, .85) !important
    }

    .pr-bread .home-ico {
      display: inline-grid;
      place-items: center;
      width: 26px;
      height: 26px;
      border-radius: 50%;
      background: rgba(255, 255, 255, .22);
      color: #fff !important;
      font-size: 12px
    }

    /* ---------- Content ---------- */
    .pr-wrap {
      padding: 70px 0 60px
    }

    .pr-grid {
      display: grid;
      grid-template-columns: 1.05fr .95fr;
      gap: 28px;
      align-items: start
    }

    @media (max-width: 991.98px) {
      .pr-grid {
        grid-template-columns: 1fr
      }
    }

    /* Media */
    .media-card {
      background: var(--card);
      border: 1px solid #eef2f6;
      border-radius: 18px;
      overflow: hidden;
      box-shadow: var(--shadow);
    }

    .media-thumb {
      position: relative;
      aspect-ratio: 4/3;
      background: #f2f4f8
    }

    .media-thumb img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block
    }

    .media-placeholder {
      display: grid;
      place-items: center;
      aspect-ratio: 4/3;
      background: #f8fafc;
      color: #94a3b8
    }

    /* Text */
    .pr-body-card {
      background: var(--card);
      border: 1px solid #eef2f6;
      border-radius: 18px;
      box-shadow: var(--shadow);
      padding: 22px;
    }

    @media (min-width:992px) {
      .pr-body-card {
        padding: 28px
      }
    }

    .pr-h2 {
      font-weight: 800;
      color: #0f172a;
      margin: 0 0 8px
    }

    .pr-lead {
      color: #0ea5e9;
      margin: 0 0 12px;
      font-weight: 700
    }

    .prose {
      color: #1f2937;
      line-height: 1.75;
      font-size: 1.05rem
    }

    .prose p {
      margin-bottom: 1rem
    }

    /* Buttons */
    .btn-accent {
      background: var(--accent);
      color: #fff;
      border: none;
      font-weight: 800;
      padding: 12px 18px;
      border-radius: 14px;
    }

    .btn-accent:hover {
      filter: brightness(.98)
    }

    .btn-outline-accent {
      background: #fff;
      color: #0f1e3d;
      border: 1px solid #dbe4f0;
      font-weight: 700;
      padding: 12px 18px;
      border-radius: 14px;
    }

    .btn-outline-accent:hover {
      background: #f8fafc
    }

    /* Split hero (aligné avec Services) */
    .sv-hero--split {
      --sv-img-drop: 160px;
      margin-bottom: var(--sv-img-drop);
    }

    .sv-hero__inner {
      position: relative;
      z-index: 3;
    }

    .sv-hero::after {
      content: "";
      position: absolute;
      inset: 0;
      background: var(--navy);
      z-index: 2;
      pointer-events: none;
    }

    .sv-hero__media {
      position: absolute;
      right: var(--sv-img-right, 24px);
      bottom: calc(-1 * var(--sv-img-drop, 160px));
      width: var(--sv-img-w, 560px);
      height: var(--sv-img-h, 380px);
      border-radius: var(--sv-img-radius, 22px);
      overflow: hidden;
      background: transparent;
      z-index: 1;
    }

    .sv-hero__media img {
      width: 100%;
      height: 100%;
      display: block;
      object-fit: cover;
      border: 0;
      box-shadow: none !important;
      filter: none !important;
      transform: none !important;
    }

    .sv-hero {
      position: relative;
      background: var(--navy);
      color: #fff;
      padding: var(--sv-hero-pad, 140px) 0;
      overflow: visible;
      z-index: 5;
    }

    @media (max-width: 992px) {
      .sv-hero__media {
        position: static;
        width: 100%;
        height: var(--sv-img-h-mobile, 280px);
        right: auto;
        bottom: auto;
        margin-top: 18px;
      }
    }

    .page-service .sv-hero__copy {
      position: relative;
      transform: translate(-52px, -11px) !important;
      will-change: transform;
    }

    @import url('https://fonts.googleapis.com/css2?family=Epilogue:wght@400;600;800;900&display=swap');

    /* HERO projet */
    .pr-hero {
      position: relative;
      background: var(--navy);
      color: #fff;
      padding: var(--pr-hero-pad, 160px) 0;
      overflow: visible;
      z-index: 5;
    }

    .pr-hero::after {
      content: "";
      position: absolute;
      inset: 0;
      background: var(--navy);
      z-index: 2;
      pointer-events: none;
    }

    .pr-hero--split {
      --pr-img-drop: 220px;
      margin-bottom: var(--pr-img-drop);
    }

    .pr-hero__inner {
      position: relative;
      z-index: 3;
    }

    .pr-hero__copy {
      position: relative;
      transform: translate(var(--pr-copy-x, 0), var(--pr-copy-y, 0));
      will-change: transform;
    }

    .page-project .pr-title,
    .page-project .pr-sub {
      font-family: "Epilogue", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif !important;
      color: #fff !important;
    }

    .page-project .pr-title {
      font-size: clamp(24px, 4.5vw, 60px) !important;
      line-height: 1.05 !important;
      font-weight: 900 !important;
      margin: 0 0 10px;
    }

    .page-project .pr-sub {
      font-size: clamp(18px, 1.8vw, 24px) !important;
      line-height: 1.7 !important;
      opacity: .98 !important;
      margin: 0;
    }

    .pr-hero__media {
      position: absolute;
      right: var(--pr-img-right, 24px);
      bottom: calc(-1 * var(--pr-img-drop, 220px));
      width: var(--pr-img-w, 620px);
      height: var(--pr-img-h, 380px);
      border-radius: var(--pr-img-radius, 22px);
      overflow: hidden;
      background: transparent;
      z-index: 1;
    }

    .pr-hero__media img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
      border: 0;
      box-shadow: none !important;
      filter: none !important;
      transform: none !important;
    }

    @media (max-width: 992px) {
      .pr-hero--split {
        --pr-img-drop: 40px;
      }

      .pr-hero__media {
        position: static;
        right: auto;
        bottom: auto;
        width: 100%;
        height: var(--pr-img-h-mobile, 280px);
        margin-top: 18px;
      }
    }

    /* AVANT  : padding: var(--pr-hero-pad,160px) 0; */
    /* APRES : haut et bas indépendants, avec rétro-compatibilité */
    .pr-hero {
      padding: var(--pr-hero-pad-top, var(--pr-hero-pad, 160px)) 0 var(--pr-hero-pad-bottom, var(--pr-hero-pad, 160px));
    }

    .media-rotator img {
      transition: opacity .35s ease;
    }

    .media-rotator img.is-fading {
      opacity: 0;
    }
  </style>
  <section class="page-project">
    @php
      $projectHeroImg = !empty($project->image)
        ? asset('storage/' . ltrim($project->image, '/'))
        : asset('img/placeholder-hero.png');
    @endphp
    <header class="pr-hero pr-hero--split" style="
            --pr-hero-pad-top: 70px;     /* header plus haut */
            --pr-hero-pad-bottom: 190px;  /* garde un peu d'air en bas */
            --pr-img-drop: 300px;        /* remonte l'image */
            --pr-img-right: 10px;
            --pr-img-w: 560px;
      --pr-img-h: 340px;
            --pr-img-radius: 22px;
            --pr-copy-x: 8px;
            --pr-copy-y: -4px;
          ">
      <div class="container pr-hero__inner">
        <div class="pr-hero__copy">
          <h1 class="pr-title">{{ $project->name }}</h1>
          @if(!empty($project->summary))
            <p class="pr-sub">{{ $project->summary }}</p>
          @endif
        </div>
        <figure class="pr-hero__media">
          <img src="{{ $projectHeroImg }}" alt="{{ $project->name }}">
        </figure>
      </div>
    </header>
    {{-- DETAILS --}}
    <section class="pr-wrap">
      <div class="container">
        <div class="pr-grid">
          @php
            // Image principale
            $cover = $project->image ? asset('storage/' . ltrim($project->image, '/')) : null;
            // Images supplémentaires
            $more = collect($project->images ?? [])
              ->filter()
              ->map(fn($p) => \Illuminate\Support\Facades\Storage::url($p))
              ->values()
              ->all();
            // Fusionner : image principale + autres images
            $imageUrls = collect([$cover, ...$more])->filter()->unique()->values()->all();
          @endphp
          {{-- LEFT: image qui change automatiquement --}}
          <div class="media-card">
            @if(!empty($imageUrls))
              <figure class="media-thumb mb-2 media-rotator">
                <a data-fancybox="galerie" id="rotatingLink" href="{{ $imageUrls[0] }}">
                  <img id="rotatingImage" src="{{ $imageUrls[0] }}" alt="{{ $project->name }}">
                </a>
              </figure>
              {{-- Liens cachés pour Fancybox --}}
              @foreach($imageUrls as $idx => $u)
                @if($idx > 0)
                  <a data-fancybox="galerie" href="{{ $u }}" style="display:none;"></a>
                @endif
              @endforeach
            @else
              <div class="media-placeholder mb-2">
                <i class="fa fa-image fa-3x"></i>
              </div>
            @endif
          </div>
          {{-- RIGHT: Content --}}
          <div class="pr-body-card">
            <h2 class="pr-h2">{{ $project->name }}</h2>
            @if(!empty($project->summary))
              <h5 class="pr-lead">{{ $project->summary }}</h5>
            @endif
            {{-- Badges Service + Secteur --}}
            <div class="mb-3">
              {{-- Service --}}
              @if($project->service)
                <span class="badge bg-primary me-2">{{ $project->service->name }}</span>
              @else
                <span class="text-muted me-2">Service: —</span>
              @endif>
              {{-- Secteur --}}
              @php
                $map = [
                  'Tertiaire' => 'bg-info',
                  'Industrie' => 'bg-warning text-dark',
                  'Agricole' => 'bg-success',
                ];
                $cls = $map[$project->secteur] ?? 'bg-secondary';
              @endphp
              @if($project->secteur)
                <span class="badge {{ $cls }}">{{ $project->secteur }}</span>
              @endif
            </div>
            {{-- Description --}}
            @if(!empty($project->description))
              <div class="prose mb-3">
                {!! nl2br(e($project->description)) !!}
              </div>
            @endif
            {{-- Vidéo YouTube du service (si définie) --}}
            @if(optional($project->service)->youtube_embed)
              <div class="ratio ratio-16x9 my-3">
                <iframe src="{{ $project->service->youtube_embed }}" title="Service video" frameborder="0"
                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                  allowfullscreen>
                </iframe>
              </div>
            @endif
            <div class="d-flex flex-wrap align-items-center gap-2 pt-2">
              <a href="{{ $project->secteur ? route('projects.index', ['secteur' => $project->secteur]) : route('projects.sectors') }}"
                class="btn btn-accent">
                <i class="fas fa-arrow-left me-2"></i> Retour aux projets
              </a>
              <a href="{{ url('/contact') }}" class="btn btn-outline-accent">
                <i class="fas fa-phone-alt me-2"></i> Contactez-nous
              </a>
            </div>
          </div>
        </div>
      </div>
      <!-- Section Clean Energy System -->
      <section class="clean-energy my-5">
        <div class="container">
          <!-- Titre et description -->
          <h2 class="mb-3">Solutions d’Isolation Thermique et d’Économie d’Énergie</h2>
          <p class="mb-4 text-muted">
            Spécialisée dans l’isolation thermique, notre entreprise accompagne les professionnels du
            <strong>tertiaire, de l’industrie et du secteur agricole</strong> dans l’optimisation de la performance
            énergétique
            de leurs bâtiments et installations.
            Grâce à notre savoir-faire, nous contribuons à réduire durablement les consommations d’énergie,
            à améliorer le confort thermique et à valoriser les infrastructures.
          </p>
          <!-- Listes -->
          <div class="row mb-4">
            <div class="col-md-6">
              <ul class="list-unstyled">
                <li><i class="fas fa-check-circle text-primary me-2"></i> Isolation de réseaux hydrauliques de chauffage
                  pour limiter les pertes de chaleur.</li>
                <li><i class="fas fa-check-circle text-primary me-2"></i> Installation et calorifugeage des points
                  singuliers.</li>
                <li><i class="fas fa-check-circle text-primary me-2"></i> Isolation des combles pour un confort thermique
                  optimal été comme hiver.</li>
                <li><i class="fas fa-check-circle text-primary me-2"></i> Isolation des planchers bas pour réduire les
                  déperditions énergétiques.</li>
              </ul>
            </div>
            <div class="col-md-6">
              <ul class="list-unstyled">
                <li><i class="fas fa-check-circle text-primary me-2"></i> Installation de déstratificateurs d’air pour
                  homogénéiser la température ambiante.</li>
                <li><i class="fas fa-check-circle text-primary me-2"></i> Systèmes de régulation pour groupes froids à
                  haute pression flottante.</li>
                <li><i class="fas fa-check-circle text-primary me-2"></i> Intégration de déshumidificateurs d’air pour un
                  contrôle optimal de l’humidité.</li>
                <li><i class="fas fa-check-circle text-primary me-2"></i> Accompagnement complet de la conception à la
                  mise en œuvre des solutions énergétiques.</li>
              </ul>
            </div>
          </div>
          <!-- Citation -->
          <div class="quote bg-primary text-white p-4 rounded mb-5 d-flex align-items-center">
            <!-- Texte -->
            <p class="mb-0 fs-4">
              <strong>“L’efficacité énergétique est un investissement durable, au service de la performance et de
                l’environnement.”</strong>
            </p>
          </div>
          <!-- Services / What We Provide -->
          <div class="row text-center">
            <div class="col-md-4 mb-4">
              <div class="icon mb-3">
                <i class="fas fa-industry fa-2x text-primary"></i>
              </div>
              <h5>Projets Industriels</h5>
              <p class="text-muted">
                Isolation et régulation des installations industrielles pour optimiser les rendements et réduire les
                pertes énergétiques.
              </p>
            </div>
            <div class="col-md-4 mb-4">
              <div class="icon mb-3">
                <i class="fas fa-building fa-2x text-primary"></i>
              </div>
              <h5>Projets Tertiaires</h5>
              <p class="text-muted">
                Solutions d’isolation et de confort thermique pour les bâtiments de bureaux, établissements publics et
                infrastructures collectives.
              </p>
            </div>
            <div class="col-md-4 mb-4">
              <div class="icon mb-3">
                <i class="fas fa-tractor fa-2x text-primary"></i>
              </div>
              <h5>Projets Agricoles</h5>
              <p class="text-muted">
                Amélioration de la performance énergétique des exploitations agricoles, serres et bâtiments d’élevage
                grâce à des solutions adaptées.
              </p>
            </div>
          </div>
        </div>
      </section>
    </section>
  </section>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css" />
  <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
  <script>
    (function () {
      const images = @json($imageUrls ?? []);
      if (!images || images.length <= 1) return;
      const imgEl = document.getElementById('rotatingImage');
      const linkEl = document.getElementById('rotatingLink');
      let i = 0;
      // Préchargement des images
      images.forEach(src => { const im = new Image(); im.src = src; });
      function next() {
        i = (i + 1) % images.length;
        imgEl.classList.add('is-fading');
        setTimeout(() => {
          imgEl.src = images[i];
          linkEl.href = images[i];
          imgEl.classList.remove('is-fading');
        }, 200);
      }
      // Changement automatique toutes les 3s
      setInterval(next, 3000);
    })();
  </script>
@endsection