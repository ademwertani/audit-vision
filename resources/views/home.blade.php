@extends('layouts.app')
@section('title', 'France Isolation - Énergie fiable pour la société')
@section('content')
    {{-- =============== HERO (Updated to match Figma design) =============== --}}
    @php
        $hero = optional($banners)->first();
        $heroTitle = trim($hero->title ?? '') ?: "Énergiser la société\nÉnergie fiable";
        $heroSummary = trim($hero->summary ?? '') ?: "Des technologies d’énergies renouvelables pratiques qui réduisent les coûts et protègent l’environnement";
        // Si tu as une description longue en base, elle sera utilisée dans la "boîte verre".
        // Sinon on retombe sur le summary pour ne rien casser.
        $heroDesc = trim($hero->description ?? '') ?: $heroSummary;
        $heroImg = !empty($hero?->image) ? asset('storage/' . ltrim($hero->image, '/')) : asset('img/default-banner.jpg');
        $bannerData = $banners->map(fn($b) => [
            'title' => $b->title,
            'summary' => $b->summary,
            'image' => !empty($b->image) ? asset('storage/' . ltrim($b->image, '/')) : asset('img/default-banner.jpg'),
        ]);
    @endphp
    <div class="hero-aisla" style="--hero-bg-img: url('{{ $heroImg }}');">
        <div class="hero-overlay"></div>
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-lg-6">
                    <div class="hero-copy">
                        <h1 class="hero-title">{!! nl2br(e($heroTitle)) !!}</h1>
                        <p class="hero-sub mb-3">{{ $heroSummary }}</p>
                    </div>
                    <div class="d-flex gap-3 flex-wrap justify-content-center hero-buttons">
                        <a href="{{ url('/contact') }}" class="btn btn-accent rounded-pill px-4 py-3">
                            Commencer
                        </a>
                        <a href="#video" class="btn btn-dark-ghost rounded-pill px-4 py-3 js-scroll-video">
                            <i class="fas fa-play me-2"></i> Regarder la vidéo complète
                        </a>
                    </div>
                </div>
            </div>
        </div>
        {{-- Flèches navigation --}}
        <button class="hero-arrow hero-arrow-left" aria-label="Diapositive précédente">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="hero-arrow hero-arrow-right" aria-label="Diapositive suivante">
            <i class="fas fa-chevron-right"></i>
        </button>
        <div class="hero-curve" aria-hidden="true"></div>
    </div>
    <script>
        const banners = @json($bannerData);
        let currentIndex = 0;

        function updateHero(index) {
            if (!banners || !banners.length) return;

            const hero = document.querySelector('.hero-aisla');
            const heroTitle = document.querySelector('.hero-title');
            const heroSub = document.querySelector('.hero-sub');

            hero.style.setProperty('--hero-bg-img', `url('${banners[index].image}')`);
            heroTitle.innerHTML = (banners[index].title || '').replace(/\n/g, "<br>");
            heroSub.textContent = banners[index].summary || '';
        }

        // Navigation
        function prev() {
            if (!banners || !banners.length) return;
            currentIndex = (currentIndex - 1 + banners.length) % banners.length;
            updateHero(currentIndex);
        }
        function next() {
            if (!banners || !banners.length) return;
            currentIndex = (currentIndex + 1) % banners.length;
            updateHero(currentIndex);
        }

        // Flèches
        document.querySelector('.hero-arrow-left')?.addEventListener('click', () => {
            prev();
            restartAutoplay();
        });
        document.querySelector('.hero-arrow-right')?.addEventListener('click', () => {
            next();
            restartAutoplay();
        });

        // Lecture automatique toutes les 2 secondes
        const AUTOPLAY_MS = 2000;
        let autoplayId = null;

        function startAutoplay() {
            if (autoplayId || !banners || banners.length <= 1) return;
            autoplayId = setInterval(next, AUTOPLAY_MS);
        }
        function stopAutoplay() {
            if (!autoplayId) return;
            clearInterval(autoplayId);
            autoplayId = null;
        }
        function restartAutoplay() {
            stopAutoplay();
            startAutoplay();
        }

        // Pause au survol du hero
        const heroEl = document.querySelector('.hero-aisla');
        heroEl?.addEventListener('mouseenter', stopAutoplay);
        heroEl?.addEventListener('mouseleave', startAutoplay);

        // Init
        updateHero(currentIndex);
        startAutoplay();
    </script>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        /* 🔧 Annule tout flou sur le hero */
        .hero-aisla,
        .hero-aisla::before,
        .hero-aisla .hero-overlay {
            filter: none !important;
            -webkit-filter: none !important;
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
        }

        /* Optionnel : superposition sombre sans blur */
        .hero-aisla .hero-overlay {
            background: rgba(0, 0, 0, .25);
        }

        .hero-aisla::before {
            transform: none !important;
            opacity: 1 !important;
        }

        .hero-aisla {
            background-image: var(--hero-bg-img);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        /* Parent en référence */
        #blogCarousel {
            position: relative;
        }

        .bottom-controls {
            position: absolute;
            left: 50%;
            bottom: 10px;
            transform: translateX(-50%);
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 5;
            pointer-events: none;
        }

        .bottom-controls .bcb {
            pointer-events: auto;
            width: 36px;
            height: 36px;
            border-radius: 999px;
            border: 1px solid #e5e7eb;
            background: rgba(255, 255, 255, .92);
            box-shadow: 0 6px 18px rgba(15, 23, 42, .12);
            display: grid;
            place-items: center;
            color: #111827;
            transition: transform .15s ease, background-color .15s ease, box-shadow .15s ease, opacity .2s ease;
        }

        .bottom-controls .bcb:hover {
            transform: translateY(-1px);
        }

        .bottom-controls .bcb:active {
            transform: translateY(0);
            box-shadow: 0 3px 10px rgba(15, 23, 42, .18);
        }

        /* ---- Ajuste l’offset vertical de P3 ---- */
        .projects-grid .grid-p3 {
            /* décale P3 vers le bas */
            margin-top: 22px;
            /* ajuste 10–40px selon rendu */
            align-self: start;
            /* évite un recentrage vertical inattendu */
        }

        /* ---- Taille fixe uniquement pour la carte P3 ---- */
        .projects-grid .grid-p3.proj-card--md {
            width: 700px;
            /* largeur fixe */
            height: 680px;
            /* hauteur fixe */
        }

        /* L'image remplit la carte proprement */
        .projects-grid .grid-p3.proj-card--md>img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* L’overlay suit la hauteur fixe */
        .projects-grid .grid-p3.proj-card--md .proj-overlay {
            position: absolute;
            /* si ce n'est pas déjà le cas dans ton skin */
            inset: 0;
            display: flex;
            align-items: flex-end;
            padding: 14px;
        }

        @media (max-width: 768px) {
            .projects-grid .grid-p3 {
                margin-top: 12px;
            }

            .projects-grid .grid-p3.proj-card--md {
                width: 100%;
                height: 220px;
                /* ou auto si tu préfères */
            }
        }

        /* Remonter P3 (override) */
        .projects-grid .grid-p3 {
            margin-top: -180px !important;
            /* mets 0, -6, -12, -20 selon le rendu souhaité */
        }

        /* Optionnel : sur mobile on reste léger */
        @media (max-width: 768px) {
            .projects-grid .grid-p3 {
                margin-top: -4px !important;
            }
        }
.stat {
    padding: 20px;
    font-size: 1.2rem;
    min-width: 180px;
    min-height: 100px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.stat--offset {
        margin-left: 10px !important;
        background: #ffe; /* pour visualiser si appliqué */
    }
.stat--accent {
    background-color: #f0f0f0; /* Exemple */
    font-weight: bold;
}

        /* Option: masquer les flèches latérales si réactivées ailleurs
      #blogCarousel .carousel-control-prev,
      #blogCarousel .carousel-control-next{ display:none !important; } */
    </style>
    {{-- Section après le Hero --}}
    <section class="after-hero-text py-5">
        <div class="container">
            <h2 class="big-title">
                <div class="text-green text-start"> Votre confort </div>
                <div class="text-darkblue text-center"> notre expertise </div>
            </h2>
        </div>
    </section>

    <!-- Projects Start -->
    <div class="container-fluid py-5 mb-5">
        <div class="container">
            <div class="projects-grid">
                {{-- ======= P1 : Grand projet (haut gauche) ======= --}}
                @if(($p1 = $projects->get(0)))
                    <a href="{{ route('projects.show', $p1->id) }}"
                        class="proj-card proj-card--lg text-decoration-none grid-p1">
                        @if($p1->image)
                            <img src="{{ asset('storage/' . $p1->image) }}" alt="{{ $p1->name }}">
                        @endif
                        <div class="proj-overlay">
                            <span class="pill pill--muted">
                                {{ $p1->address ?? $p1->location ?? $p1->name }}
                            </span>
                            <span class="pill pill--action">
                                <i class="fas fa-play me-2"></i> Regarder la vidéo complète du projet
                            </span>
                        </div>
                        <span class="stretched-link" aria-label="Voir {{ $p1->name }}"></span>
                    </a>
                @endif

                {{-- ======= Bloc statique : Bannière verte (haut droite) ======= --}}
                <div class="promo-card grid-promo">
                    <p class="m-0" style="font-size: 1.5rem; font-weight: 600;">
                        France Expert Isolation vous accompagne à chaque étape de votre projet : 
                        de l’étude technique à la constitution du dossier CEE, jusqu’à la réalisation des travaux et le suivi post-intervention.
                    </p>
                    <span class="promo-dot"></span>
                </div>

                {{-- ======= P2 : Projet (bas gauche) ======= --}}
                @if(($p2 = $projects->get(1)))
                    <a href="{{ route('projects.show', $p2->id) }}"
                        class="proj-card proj-card--md text-decoration-none grid-p2">
                        @if($p2->image)
                            <img src="{{ asset('storage/' . $p2->image) }}" alt="{{ $p2->name }}">
                        @endif
                        <div class="proj-overlay">
                            <span class="pill pill--muted">
                                {{ $p2->address ?? $p2->location ?? $p2->name }}
                            </span>
                            <span class="pill pill--action">
                                <i class="fas fa-play me-2"></i> Regarder la vidéo complète du projet
                            </span>
                        </div>
                        <span class="stretched-link" aria-label="Voir {{ $p2->name }}"></span>
                    </a>
                @endif

                {{-- ======= P3 : Projet (milieu/droite, plus haut) ======= --}}
                @if(($p3 = $projects->get(2)))
                    <a href="{{ route('projects.show', $p3->id) }}"
                        class="proj-card proj-card--md text-decoration-none grid-p3">
                        @if($p3->image)
                            <img src="{{ asset('storage/' . $p3->image) }}" alt="{{ $p3->name }}">
                        @endif
                        <div class="proj-overlay">
                            <span class="pill pill--muted">
                                {{ $p3->address ?? $p3->location ?? $p3->name }}
                            </span>
                            <span class="pill pill--action">
                                <i class="fas fa-play me-2"></i> Regarder la vidéo complète du projet
                            </span>
                        </div>
                        <span class="stretched-link" aria-label="Voir {{ $p3->name }}"></span>
                    </a>
                @endif

                {{-- ======= Bloc Stats (dynamique) ======= --}}
                <div class="stats-card grid-stats">
                    <h5 class="text-start mb-4 ps-2">Nous avons déjà alimenté avec succès</h5>
                    <div class="stats-row">
                        @forelse($stats as $stat)
                            <div class="stat {{ $stat->is_accent ? 'stat--accent' : '' }} {{ $loop->index === 1 ? 'stat--offset' : '' }}">
                                <div class="stat-number">{{ number_format($stat->value) }}</div>
                                <div class="stat-label">{{ $stat->label }}</div>
                            </div>
                        @empty
                            {{-- Fallback si aucune stat en base --}}
                            <div class="stat">
                                <div class="stat-number">0</div>
                                <div class="stat-label">Foyers</div>
                            </div>
                            <div class="stat">
                                <div class="stat-number">0</div>
                                <div class="stat-label">Entreprises</div>
                            </div>
                            <div class="stat stat--accent">
                                <div class="stat-number">0</div>
                                <div class="stat-label">Fermes</div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --radius: 18px;
            --gap: 28px;
            /* espace entre les cartes */
            --accent: #7CAE2A;
            --primary: #2d3281;
            --muted: #e9eef3;
        }

        /* ====== GRID LAYOUT AVEC ZONES ====== */
        .projects-grid {
            display: grid;
            grid-template-columns: 1.05fr 1fr;
            /* léger avantage à gauche */
            gap: var(--gap);
            grid-template-areas:
                "p1    promo"
                "p2    p3"
                ".     stats";
        }

        .grid-p1 {
            grid-area: p1;
        }

        .grid-promo {
            grid-area: promo;
        }

        .grid-p2 {
            grid-area: p2;
        }

        .grid-p3 {
            grid-area: p3;
        }

        .grid-stats {
            grid-area: stats;
        }

        /* ====== CARTES ====== */
        .proj-card,
        .promo-card {
            min-height: 240px;
            border-radius: var(--radius);
            overflow: hidden;
            position: relative;
            box-shadow: 0 6px 18px rgba(0, 0, 0, .06);
            background: #fff;
        }

        .stats-card {
            padding: 20px;
            margin-top: -200px;
            margin-bottom: 400px;
            /* <= espace sous les stats (sera réduit plus bas) */
        }

        .proj-card--lg {
            min-height: 360px;
        }

        .grid-promo {
            min-height: 120px;
        }

        .grid-p3 {
            min-height: 300px;
        }

        .grid-stats {
            min-height: 150px;
        }

        /* ====== IMAGES ====== */
        .proj-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .6s ease;
        }

        .proj-card:hover img {
            transform: scale(1.04);
        }

        /* ====== OVERLAY + PILLS ====== */
        .proj-overlay {
            position: absolute;
            inset: auto 0 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 14px;
            background: linear-gradient(to top, rgba(0, 0, 0, .55), transparent);
        }

        .pill {
            border-radius: 999px;
            padding: 8px 12px;
            font-size: .8rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .pill--muted {
            background: rgba(255, 255, 255, .9);
            color: #2c313a;
        }

        .pill--action {
            background: var(--accent);
            color: #fff;
        }

        /* ====== PROMO ====== */
        .promo-card {
            background: #69bb36;
            color: #fff;
            width: 700px;
            height: 180px;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .promo-dot {
            width: 35px;
            height: 30px;
            background: #1d2a78;
            border-radius: 4px;
            position: absolute;
            bottom: 0;
            right: 0;
        }

        /* ====== STATS ====== */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .stat {
            background: #e8eef7;
            padding: 12px;
            border-radius: 10px;
            text-align: center;
        }

        .stat--accent {
            background: #e5f5e2;
        }

        .stat-number {
            font-size: 22px;
            font-weight: 700;
            color: var(--primary);
        }

        .stat--accent .stat-number {
            color: var(--accent);
        }

        .stat-label {
            font-size: 13px;
            color: #3f4759;
        }

        /* ====== RESPONSIVE ====== */
        @media (max-width: 992px) {
            .projects-grid {
                grid-template-columns: 1fr;
                grid-template-areas:
                    "p1"
                    "promo"
                    "p2"
                    "p3"
                    "stats";
            }

            .proj-card--lg {
                min-height: 300px;
            }

            .grid-p3 {
                min-height: 260px;
            }
        }

        /* Remonter uniquement la 3e carte (P3) */
        .grid-p3 {
            margin-top: -240px;
            margin-bottom: 240px;
        }

        /* Aligner le bouton avec le texte et le garder en bas (blog) */
        .blog-card__content {
            display: flex;
            flex-direction: column;
            padding: 24px;
            padding-bottom: 24px;
        }

        .blog-card__btn {
            position: static !important;
            inset: auto !important;
            align-self: flex-start;
            margin-top: auto;
            display: inline-flex;
        }

        /* S'assure que le parent est la référence */
        #servicesCarousel {
            position: relative;
        }

        /* Contrôles bas centrés */
        .services-bottom-controls {
            position: absolute;
            left: 50%;
            bottom: 10px;
            transform: translateX(-50%);
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 5;
            pointer-events: none;
        }

        .services-bottom-controls .scb {
            pointer-events: auto;
            width: 36px;
            height: 36px;
            border-radius: 999px;
            border: 1px solid #e5e7eb;
            background: rgba(255, 255, 255, .92);
            box-shadow: 0 6px 18px rgba(15, 23, 42, .12);
            display: grid;
            place-items: center;
            color: #111827;
            transition: transform .15s ease, background-color .15s ease, box-shadow .15s ease, opacity .2s ease;
        }

        .services-bottom-controls .scb:hover {
            transform: translateY(-1px);
        }

        .services-bottom-controls .scb:active {
            transform: translateY(0);
            box-shadow: 0 3px 10px rgba(15, 23, 42, .18);
        }

        @media (min-width: 992px) {
            .services-bottom-controls {
                opacity: .98;
            }
        }

        #servicesCarousel .carousel-control-prev,
        #servicesCarousel .carousel-control-next {
            /* display: none !important; */
            /* décommente pour masquer les flèches latérales */
        }
        
    </style>
    <!-- Projects End -->

    <!-- =============== ABOUT (comme la maquette) =============== -->
    @php
        $aboutImg = $aboutImg
            ?? (isset($banners) && $banners->count()
                ? asset('storage/' . ltrim($banners->first()->image, '/'))
                : asset('img/about.jpg')); // fallback
    @endphp
    <section class="about-fei pt-2 pb-5">
        <div class="container">
            <div class="about-grid">
                {{-- Colonne gauche : textes --}}
                <div class="about-left">
                    <div class="about-kicker">À PROPOS</div>
                    <h2 class="about-title">Qui sommes-nous ?</h2>
                    <p class="about-text">
                        France Expert Isolation – Spécialiste de l’isolation thermique et de l’efficacité énergétique.
                        Nous sommes une entreprise spécialisée dans l’isolation thermique des bâtiments et installations
                        industrielles. Notre mission est claire : améliorer la performance énergétique, réduire les
                        déperditions de chaleur et optimiser le confort tout en contribuant à la maîtrise des coûts
                        énergétiques.
                    </p>
                    <div class="values-kicker">NOS VALEURS</div>
                    <div class="values-row">
                        <div class="value-chip">
                            <img src="/img/im1.png" alt="Expertise" class="icon">
                            <span class="label">L’expertise</span>
                        </div>
                        <div class="value-chip">
                            <img src="/img/im2.png" alt="Qualité" class="icon">
                            <span class="label">La qualité</span>
                        </div>
                        <div class="value-chip lower"> <!-- 🔥 AJOUT -->
                            <img src="/img/im3.png" alt="Innovation" class="icon">
                            <span class="label">L’innovation</span>
                        </div>
                        <div class="value-chip lowerr">
                            <img src="/img/im4.png" alt="Respect des délais" class="icon">
                            <span class="label">Respect des délais</span>
                        </div>
                    </div>

                    {{-- Ton bouton existant --}}
                    <a href="{{ url('/about') }}" class="btn about-btn mt-3">
                        En savoir plus
                        <span class="btn-icon" aria-hidden="true">→</span>
                    </a>
                </div>
                {{-- Colonne droite : image --}}
                <div class="about-right">
                    <div class="about-media">
                        <div class="navy-plate" aria-hidden="true"></div>
                        <div class="about-image-box">
                            <img src="{{ $aboutImg }}" alt="Notre équipe sur le terrain">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- =============== FEATURE CARDS / SERVICES =============== --}}
    <div id="servicesCarousel" class="carousel slide" data-bs-ride="false">
        <div class="carousel-inner">
            <!-- Contrôles bas centrés -->
            <div class="services-bottom-controls">
                <button class="scb scb-prev" type="button" data-bs-target="#servicesCarousel" data-bs-slide="prev"
                    aria-label="Précédent">
                    <svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true">
                        <path d="M15 19l-7-7 7-7" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </button>

                <button class="scb scb-next" type="button" data-bs-target="#servicesCarousel" data-bs-slide="next"
                    aria-label="Suivant">
                    <svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true">
                        <path d="M9 5l7 7-7 7" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </button>
            </div>

            @foreach($services->chunk(3) as $chunkIndex => $chunk)
                <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                    <div class="container py-4">
                        <div class="row g-5">
                            @foreach($chunk as $service)
                                @php
                                    $img = !empty($service->image)
                                        ? asset('storage/' . ltrim($service->image, '/'))
                                        : asset('img/placeholders/service.jpg');
                                  @endphp
                                <div class="col-12 col-md-6 col-lg-4">
                                    <a href="{{ route('services.show', $service->id) }}" class="text-decoration-none text-dark">
                                        <div class="service-card">
                                            <img src="{{ $img }}" alt="{{ $service->name }}" class="service-card__img">
                                            <div class="service-card__info service-card__info--lower">
                                                <h5 class="service-card__name">{{ $service->name }}</h5>
                                                <p class="service-card__text">
                                                    {{ Str::limit($service->description, 160) }}
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

    {{-- pub --}}
    <section class="pub-section pt-2 pb-5 mt-5">
        <div class="full-width-img partners-wrap">
            <img src="{{ asset('img/pubb.png') }}" alt="pub" class="partners-bg">
            <div class="partners-overlay">
                <h2 class="partners-title">Nos Partenaires</h2>
                @if(!empty($partners) && $partners->count())
                    @php
                        $top = $partners->take(4);
                        $bottom = $partners->skip(4)->take(4);
                    @endphp
                    <div class="partners-logos partners-logos--two-rows">
                        @foreach($top as $p)
                            <span class="partner-logo-link" title="{{ $p->name }}">
                                <img src="{{ asset('storage/' . ltrim($p->logo, '/')) }}" alt="{{ $p->name }}" class="partner-logo">
                            </span>
                        @endforeach
                        @foreach($bottom as $p)
                            <span class="partner-logo-link" title="{{ $p->name }}">
                                <img src="{{ asset('storage/' . ltrim($p->logo, '/')) }}" alt="{{ $p->name }}" class="partner-logo">
                            </span>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Blog Start -->
    <div class="container-fluid py-5 mb-5">
        <div class="container">
            <div class="blog-intro pb-4">
                <div>
                    <h2 class="blog-intro__title m-0">Blog</h2>
                    <p class="blog-intro__desc mb-0">
                        Chaque programme que nous menons est pensé pour répondre aux besoins spécifiques des communautés,
                        en mettant l’accent sur la durabilité et l’autonomisation.<br>
                    </p>
                </div>
                <a href="{{ route('blog.index') }}" class="blog-intro__cta">
                    Tout voir <span class="blog-intro__cta-icon">→</span>
                </a>
            </div>

            {{-- ===== Carousel Blog ===== --}}
            <div id="blogCarousel" class="carousel slide" data-bs-ride="false">
                <div class="carousel-inner">
                    @php
                        $chunks = $blogs->take(9)->chunk(3); // 3 cartes par slide
                    @endphp

                    @foreach($chunks as $chunkIndex => $chunk)
                        <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                            <div class="container py-2">
                                <div class="row g-4 justify-content-center">
                                    @foreach($chunk as $blog)
                                        <div class="col-12 col-md-6 col-lg-4 d-flex">
                                            <a href="{{ route('blog.show', $blog->slug ?? $blog->id) }}"
                                                class="text-decoration-none w-100">
                                                <article
                                                    class="blog-card rounded-4 overflow-hidden position-relative h-100 d-flex flex-column">
                                                    {{-- Image --}}
                                                    @if($blog->image)
                                                        <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}"
                                                            class="blog-card__img">
                                                    @else
                                                        <div class="blog-card__img blog-card__img--placeholder"></div>
                                                    @endif

                                                    <div class="blog-card__overlay"></div>

                                                    <div class="blog-card__content d-flex flex-column flex-grow-1">
                                                        <p class="blog-card__cat text-uppercase mb-1">
                                                            {{ $blog->title ?? 'GESTION DE L’ENVIRONNEMENT' }}
                                                        </p>
                                                        <h3 class="blog-card__title">{{ $blog->title }}</h3>

                                                        <div class="blog-card__meta mb-2">
                                                            <span class="blog-card__date">
                                                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                                                    aria-hidden="true">
                                                                    <circle cx="12" cy="12" r="9" stroke="currentColor"
                                                                        stroke-width="1.8" />
                                                                    <path d="M12 7v5l3 2" stroke="currentColor" stroke-width="1.8"
                                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                                </svg>
                                                                {{ $blog->created_at->translatedFormat('j F Y') }}
                                                            </span>
                                                        </div>



                                                        <span class="blog-card__btn mt-auto">
                                                            Lire plus <span class="blog-card__btn-icon">→</span>
                                                        </span>
                                                    </div>
                                                </article>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Petites icônes bas --}}
                <div class="bottom-controls">
                    <button class="bcb bcb-prev" type="button" data-bs-target="#blogCarousel" data-bs-slide="prev"
                        aria-label="Précédent">
                        <svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true">
                            <path d="M15 19l-7-7 7-7" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                    <button class="bcb bcb-next" type="button" data-bs-target="#blogCarousel" data-bs-slide="next"
                        aria-label="Suivant">
                        <svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true">
                            <path d="M9 5l7 7-7 7" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.querySelector('.js-scroll-video');
            if (!btn) return;
            btn.addEventListener('click', function (e) {
                const target = document.getElementById('video');
                if (target) {
                    e.preventDefault();
                    const header = document.querySelector('.header-aisla');
                    const offset = header ? header.offsetHeight : 0;
                    const y = target.getBoundingClientRect().top + window.pageYOffset - offset - 8;
                    window.scrollTo({ top: y, behavior: 'smooth' });
                } else {
                    window.location.href = "{{ url('/video') }}";
                }
            });
        });
    </script>

    <!-- Blog End -->
    <div class="position-relative">
        <div class="row justify-content-center align-items-center">
        </div>
        @if(!empty($video?->url))
            @php
                $embed = null;
                $url = $video->url;
                if (Str::contains($url, 'youtu.be/')) {
                    $id = Str::after($url, 'youtu.be/');
                } elseif (Str::contains($url, 'watch?v=')) {
                    $id = Str::after($url, 'watch?v=');
                } elseif (Str::contains($url, 'embed/')) {
                    $id = Str::after($url, 'embed/');
                } else {
                    $id = null;
                }
                if (!empty($id)) {
                    $id = Str::before($id, '&');
                    $embed = 'https://www.youtube.com/embed/' . $id;
                }
            @endphp
            @if($embed)
                <div class="container-fluid py-5 my-5" id="video">
                    <div class="container">
                        <div class="text-center mb-5">
                            <p class="fw-light mb-1" style="color: var(--dark); font-size: 26px;">
                                Rejoignez notre communauté de clients satisfaits et découvrez la beauté<br>
                                et les avantages de l’isolation thermique.
                            </p>
                        </div>
                        <div class="row g-4 align-items-center">
                            <div class="row g-4 align-items-center justify-content-center">
                                <div class="col-lg-8">
                                    <div class="ratio ratio-16x9">
                                        <iframe src="{{ $embed }}" title="Vidéo YouTube" allowfullscreen
                                            class="mx-auto d-block"></iframe>
                                    </div>
                                </div>
                            </div>
                            <style>
                                .uniform-img {
                                    width: 150px;
                                    height: 150px;
                                    object-fit: contain;
                                }

                                .uniform-title {
                                    color: var(--dark);
                                    font-size: 1.6rem;
                                    font-weight: 600;
                                }

                                .uniform-text {
                                    font-size: 1.2rem;
                                    color: #6c757d;
                                }
                            </style>
                        </div>
            @endif
        @endif
            </div>
        </div>
{{--
        <section class="hcw my-5">
            <div class="container">
                <h1 class="hcw-title text-center">
                    <span>Clients heureux</span><br>

                </h1>
                @if(!empty($customers) && $customers->count())
                    <div class="row g-4 mt-4">
                        @foreach($customers as $c)
                            <div class="col-12 col-md-6 col-lg-4 d-flex">
                                <article class="t-card w-100 rounded-4 d-flex flex-column">
                                    @php $r = (int) ($c->rating ?? $c->note ?? 0); @endphp
                                    <div class="t-stars" aria-label="Note {{ $r }} sur 5">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="{{ $i <= $r ? 'fa-solid' : 'fa-regular' }} fa-star"></i>
                                        @endfor
                                    </div>
                                    <h3 class="t-title mb-3">{{ $c->title }}</h3>
                                    <p class="t-comment mb-0 flex-grow-1">
                                        {{ $c->comment }}
                                    </p>
                                    <div class="t-author mt-3">{{ $c->customer_name }}</div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
--}}
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const servicesSection = document.querySelector('.services-section');
                if (servicesSection) {
                    const slides = servicesSection.querySelectorAll('.service-slide');
                    servicesSection.querySelectorAll('.card').forEach(card => {
                        card.addEventListener('mouseenter', () => card.style.transform = 'translateY(-5px)');
                        card.addEventListener('mouseleave', () => card.style.transform = '');
                    });
                    if (slides.length > 1) {
                        let sIndex = 0;
                        const prevBtn = servicesSection.querySelector('.services-prev');
                        const nextBtn = servicesSection.querySelector('.services-next');
                        const progressBarServices = servicesSection.querySelector('.services-progress-bar');
                        function showSlide(newIndex) {
                            slides[sIndex].classList.add('d-none');
                            sIndex = (newIndex + slides.length) % slides.length;
                            slides[sIndex].classList.remove('d-none');
                            const progress = ((sIndex + 1) / slides.length) * 100;
                            progressBarServices.style.width = progress + '%';
                        }
                        prevBtn.addEventListener('click', () => showSlide(sIndex - 1));
                        nextBtn.addEventListener('click', () => showSlide(sIndex + 1));
                        progressBarServices.style.width = (1 / slides.length * 100) + '%';
                    }
                }

                const teamContainer = document.getElementById('team-container');
                const teamPrev = document.getElementById('team-prev');
                const teamNext = document.getElementById('team-next');
                const teamProgress = document.getElementById('team-progress');
                let teamPage = 1;
                const teamPerPage = 3;

                function loadTeam(page = 1) {
                    fetch(`/api/team?page=${page}&per_page=${teamPerPage}`)
                        .then(response => response.json())
                        .then(data => {
                            teamContainer.innerHTML = '';
                            data.data.forEach(member => {
                                const col = document.createElement('div');
                                col.className = 'col-md-6 mb-4';
                                col.innerHTML = `
                                        <div class="d-flex align-items-center team-card p-3 rounded">
                                            <div class="team-photo position-relative me-3">
                                                <div class="circle-border">
                                                    <img src="${member.image_url}" class="img-fluid rounded-circle" alt="${member.name}">
                                                </div>
                                            </div>
                                            <div class="team-info flex-grow-1">
                                                <h4 class="fw-bold mb-1">${member.name}</h4>
                                                <p class="mb-2" style="color: #fe5716;">${member.role}</p>
                                            </div>
                                        </div>
                                    `;
                                teamContainer.appendChild(col);
                            });
                            teamPage = data.current_page;
                            const totalPages = data.last_page;
                            teamPrev.disabled = teamPage === 1;
                            teamNext.disabled = teamPage === totalPages;
                            teamProgress.style.width = (teamPage / totalPages * 100) + '%';
                        });
                }

                teamPrev?.addEventListener('click', () => loadTeam(teamPage - 1));
                teamNext?.addEventListener('click', () => loadTeam(teamPage + 1));
                if (teamContainer) loadTeam();

                const donut = document.querySelector('.hero-donut');
                if (!donut) return;
                const banners = donut.dataset.banners ? JSON.parse(donut.dataset.banners) : [];
                if (!banners.length) return;
                let index = 0;
                const titleEl = document.querySelector('.hero-title');
                const leadEl = document.querySelector('.hero-lead');
                const imageEl = donut.querySelector('.donut-image');
                const dotsContainer = document.querySelector('.hero-dots');
                const progressBar = document.querySelector('.hero-progress-bar');

                function renderDots() {
                    dotsContainer.innerHTML = '';
                    banners.forEach((_, i) => {
                        const span = document.createElement('span');
                        span.className = 'dot' + (i === index ? ' active' : '');
                        span.dataset.index = i;
                        dotsContainer.appendChild(span);
                    });
                }
                function update() {
                    const banner = banners[index] || {};
                    const title = (banner.title || '').split('\n').map(s => s.trim()).join('<br>');
                    const summary = banner.summary || '';
                    const img = banner.image || '/img/default-banner.jpg';
                    titleEl.innerHTML = title;
                    leadEl.textContent = summary;
                    imageEl.style.backgroundImage = `url('${img}')`;
                    Array.from(dotsContainer.children).forEach((dot, i) => {
                        dot.classList.toggle('active', i === index);
                    });
                    const progress = ((index + 1) / banners.length) * 100;
                    progressBar.style.width = progress + '%';
                }
                function goTo(newIndex) {
                    index = (newIndex + banners.length) % banners.length;
                    update();
                }
                renderDots();
                update();
                donut.querySelector('.hero-nav.next')?.addEventListener('click', () => goTo(index + 1));
                donut.querySelector('.hero-nav.prev')?.addEventListener('click', () => goTo(index - 1));
                dotsContainer.addEventListener('click', e => {
                    if (e.target.classList.contains('dot')) {
                        goTo(parseInt(e.target.dataset.index, 10));
                    }
                });
            });

                /* Mode "zoom stable" (désactive les changements de breakpoint au zoom) */
                .stable - zoom { min - width: 1280px; }
                .stable - zoom.container, .stable - zoom.container - fluid { max - width: 1280px!important; }
                .stable - zoom.col - lg - 4 { flex: 0 0 auto; width: 33.333333 % !important; }
                .stable - zoom.col - md - 6 { flex: 0 0 auto; width: 50 % !important; }
                .stable - zoom.hero - aisla { min - height: 520px; }
                .stable - zoom.service - card__img, .stable - zoom.blog - card__img { aspect - ratio: 16 / 9; object - fit: cover; }
                .stable - zoom.grid - p3 { margin - top: 0!important; margin - bottom: 0!important; }
                .stable - zoom.projects - grid > .grid - stats.stats - card { margin - bottom: 24px!important; }
        </script>

        <style>
            /* Règles globales de sécurité */
            html,
            body {
                overflow-x: hidden;
            }

            img,
            iframe {
                max-width: 100%;
                height: auto;
                display: block;
            }

            /* 🔒 Mobile only */
            @media (max-width: 575.98px) {

                .container,
                .container-fluid {
                    padding-left: 12px !important;
                    padding-right: 12px !important;
                }

                .row {
                    margin-left: 0 !important;
                    margin-right: 0 !important;
                }

                [class^="col-"],
                [class*=" col-"] {
                    padding-left: 8px !important;
                    padding-right: 8px !important;
                }

                .services-section .card {
                    width: 100% !important;
                }

                .services-section img {
                    max-width: 100%;
                    height: auto;
                }

                .project-item .card {
                    width: 100% !important;
                    height: auto !important;
                }

                .project-item img {
                    height: 180px !important;
                    object-fit: cover;
                }

                .container-fluid[style*="background: var(--primary)"] img[alt="Contact Image"] {
                    position: static !important;
                    width: 70vw !important;
                    max-width: 320px !important;
                    margin: 16px auto 0 !important;
                }

                img[alt="Image sous zone bleue"] {
                    width: 100% !important;
                    height: auto !important;
                }

                .text-center[style*="margin-top: -190px"] {
                    margin-top: 0 !important;
                }

                .uniform-img {
                    width: 96px !important;
                    height: 96px !important;
                    object-fit: contain;
                }

                .hero-aisla,
                .about-aisla,
                .blog,
                .team,
                .project-carousel,
                .services-section {
                    overflow-x: hidden !important;
                }

                @media (min-width: 576px) {
                    .project-item .card {
                        width: 600px;
                    }
                }
            }
        </style>

        <style>
            /* Réduit uniquement l'espace sous le bloc stats */
            .projects-grid>.grid-stats.stats-card {
                margin-bottom: 9px !important;
            }

            @media (max-width: 992px) {
                .projects-grid>.grid-stats.stats-card {
                    margin-bottom: 56px !important;
                }
            }

            /* === Partners: mobile layout — logos juste sous l'image === */
            @media (max-width: 575.98px) {
                .partners-wrap {
                    position: relative;
                }

                .partners-bg {
                    display: block;
                    width: 100%;
                    height: auto;
                }

                /* L’overlay descend sous l’image au lieu de la recouvrir */
                .partners-overlay {
                    position: static !important;
                    margin-top: -10px;
                    /* remonte un peu le bloc sous l'image */
                    padding: 12px 14px 6px !important;
                    background: transparent !important;
                    /* pas de voile foncé sur mobile */
                    text-align: center;
                }

                .partners-title {
                    font-size: 1.15rem;
                    margin: 6px 0 8px;
                    line-height: 1.2;
                }

                /* Grille compacte de logos, juste après l’image */
                .partners-logos,
                .partners-logos.partners-logos--two-rows {
                    display: grid !important;
                    grid-template-columns: repeat(4, 1fr);
                    /* 2 rangées × 4 colonnes si 8 logos */
                    gap: 10px 10px;
                    margin: 4px auto 0;
                    max-width: 100%;
                    align-items: center;
                    justify-items: center;
                }

                .partner-logo-link {
                    display: block;
                }

                .partner-logo {
                    max-height: 30px;
                    /* lisible mais compact */
                    width: auto;
                    object-fit: contain;
                    filter: none !important;
                    /* garde les couleurs d’origine */
                }
            }

            @media (max-width: 768px) {
                .partners-overlay {
                    margin-top: -280px !important;
                }
            }

            /* Mobile : remonter SEULEMENT les 4 derniers logos (2e rangée) */
            @media (max-width: 575.98px) {
                .partners-logos.partners-logos--two-rows>.partner-logo-link:nth-child(n+5) {
                    margin-top: -100px !important;
                    /* ← monte la 2e rangée (ajuste à -6px, -8px, -12px…) */
                    /* ou, si tu préfères: transform: translateY(-10px) !important; */
                }
            }

            /* Mobile : pousser l'image et la bande bleue (navy-plate) vers la gauche */
            @media (max-width: 575.98px) {
                .about-right .about-media {
                    position: relative;
                    overflow: visible;
                }

                /* valeur unique à ajuster */
                .about-right .about-media {
                    --about-shift: 60px;
                    /* ← mets 8, 12, 16, 20px selon ton rendu */
                }

                /* décale l'image */
                .about-right .about-image-box img {
                    display: block;
                    transform: translateX(calc(-1 * var(--about-shift)));
                    /* si tu veux éviter une bande blanche à droite : */
                    width: calc(100% + var(--about-shift));
                }

                /* décale la bande bleue exactement de la même valeur */
                .about-right .navy-plate {
                    position: absolute;
                    /* au cas où elle ne l'est pas déjà */
                    left: calc(-1 * var(--about-shift));
                    /* tu peux aussi faire: transform: translateX(calc(-1 * var(--about-shift))); */
                    z-index: 0;
                    /* derrière l'image */
                }

                /* s'assurer que l'image reste au-dessus de la plaque */
                .about-right .about-image-box {
                    position: relative;
                    z-index: 1;
                }
            }

            /* 📱 Mobile : stats plus petites et titre à gauche */
            @media (max-width: 575.98px) {

                /* Titre aligné à gauche */
                .grid-stats h5,
                .stats-card h5 {
                    text-align: left !important;
                    margin-bottom: 10px !important;
                }

                /* Carte stats compacte (évite aussi le clipping) */
                .projects-grid>.grid-stats.stats-card,
                .stats-card {
                    padding: 12px !important;
                    margin-top: 12px !important;
                    margin-bottom: 12px !important;
                    min-height: unset !important;
                    position: relative !important;
                    z-index: 2 !important;
                }

                /* Grille plus dense : 3 colonnes (mets 2 si les libellés sont longs) */
                .stats-row {
                    grid-template-columns: repeat(1, 1fr) !important;
                    /* ← mets repeat(2,1fr) si besoin */
                    gap: 8px !important;
                    /* espace entre cartes */
                }

                /* Cartes plus petites */
                .stat {
                    padding: 8px !important;
                    border-radius: 8px !important;
                }

                /* Tailles de texte réduites pour tenir sur une ligne */
                .stat-number {
                    font-size: 16px !important;
                    /* avant ~22px */
                    line-height: 1.1 !important;
                }

                .stat-label {
                    font-size: 11px !important;
                    /* avant 13px */
                    line-height: 1.15 !important;
                    white-space: nowrap;
                    /* évite les retours à la ligne */
                    overflow: hidden;
                    text-overflow: ellipsis;
                }

                /* Sécurité : annule tout décalage agressif pouvant cacher la section */
                .projects-grid .grid-p3 {
                    margin-top: 0 !important;
                    margin-bottom: 0 !important;
                }
            }

            /* 📱 Mobile : aligner chiffres et libellés à gauche dans les stats */
            @media (max-width: 575.98px) {

                /* Titre déjà demandé à gauche */
                .grid-stats h5,
                .stats-card h5 {
                    text-align: left !important;
                }

                /* Chaque carte stat : alignement gauche */
                .stats-row {
                    justify-items: stretch !important;
                }

                /* les cartes prennent toute la largeur de leur colonne */
                .stat {
                    text-align: left !important;
                    /* override du center */
                    display: flex !important;
                    flex-direction: column !important;
                    align-items: flex-start !important;
                    gap: 2px;
                }

                /* Chiffres et libellés bien calés à gauche */
                .stat-number,
                .stat-label {
                    display: block;
                    text-align: left !important;
                }
            }

            /* =====================================================
       📱 MOBILE — FIX FINAL POUR LES BOUTONS DU HERO
       ===================================================== */
            @media (max-width: 575.98px) {

                /* 🔥 Forcer l'annulation du centrage vertical */
                .hero-aisla .row.h-100.align-items-center {
                    align-items: flex-start !important;
                    height: auto !important;
                }

                /* 🔥 Ajuster la zone du texte */
                .hero-aisla .hero-copy {
                    margin-top: 0 !important;
                    margin-bottom: 15px !important;
                }

                /* =====================================================
           🔥🔥 FORCER LA POSITION DES BOUTONS (Méthode Ultime)
           ===================================================== */
                .hero-aisla .hero-buttons {
                    position: relative !important;
                    top: 290px !important;
                    /* ⇦ AUGMENTER pour descendre plus bas : 80px / 100px */
                    left: 121px !important;
                    display: flex !important;
                    justify-content: center !important;
                    gap: 8px !important;
                }

                /* 🔥 Réduire les boutons */
                .hero-aisla .hero-buttons .btn {
                    padding: 8px 14px !important;
                    font-size: 0.75rem !important;
                    border-radius: 50px !important;
                }

                /* 🔥 Réduire taille des textes du hero */
                .hero-aisla .hero-title {
                    font-size: 1.28rem !important;
                    line-height: 1.2 !important;
                }

                .hero-aisla .hero-sub {
                    font-size: 0.78rem !important;
                    line-height: 1.25 !important;
                }

                /* =====================================================
           📌 AJUSTEMENT DU HEADER (Mobile)
           ===================================================== */
                .header-aisla {
                    padding-top: 4px !important;
                    padding-bottom: 4px !important;
                }

                .header-aisla .nav-link,
                .header-aisla .btn {
                    font-size: 0.70rem !important;
                    padding: 4px 6px !important;
                }

                .header-aisla .btn-accent {
                    padding: 6px 12px !important;
                    font-size: 0.72rem !important;
                }
            }

            /* =====================================================
       📱 VERSION MOBILE — MINI ULTRA EXTREME + GAUCHE
       ===================================================== */
            @media (max-width: 575.98px) {

                /* Décaler toute la section vers la gauche */
                .projects-grid {
                    transform: translateX(-19px);
                    /* ⇦ augmente: -15px / -20px si tu veux plus gauche */
                    gap: 6px !important;
                    padding: 0 !important;
                    margin: 0 !important;
                }

                /* Hauteur ultra réduite des cartes */
                .proj-card--lg,
                .proj-card--md,
                .promo-card,
                .stats-card {
                    min-height: 90px !important;
                    height: 90px !important;
                }

                /* Réduire images */
                .proj-card img {
                    height: 90px !important;
                    object-fit: cover !important;
                }

                /* Overlay minuscule */
                .proj-overlay {
                    padding: 3px !important;
                }

                /* Pills minuscules */
                .pill {
                    font-size: 0.48rem !important;
                    padding: 2px 4px !important;
                    border-radius: 999px !important;
                }

                .pill i {
                    font-size: 0.48rem !important;
                }

                /* Promo card ultra compacte */
                .promo-card {
                    padding: 4px !important;
                    min-height: 70px !important;
                    height: auto !important;
                    font-size: 0.65rem !important;
                    line-height: 1.1 !important;
                }

                .promo-card p {
                    font-size: 0.65rem !important;
                    line-height: 1.1 !important;
                }

                /* Stats ultra petites */
                .stats-card {
                    padding: 4px !important;
                    margin-top: 4px !important;
                    margin-bottom: 4px !important;
                }

                .stats-row {
                    grid-template-columns: repeat(3, 1fr) !important;
                    gap: 3px !important;
                }

                .stat {
                    padding: 3px !important;
                }

                .stat-number {
                    font-size: 0.6rem !important;
                }

                .stat-label {
                    font-size: 0.48rem !important;
                }

                /* Nettoyage des marges */
                .grid-p1,
                .grid-p2,
                .grid-p3,
                .grid-promo,
                .grid-stats {
                    margin: 0 !important;
                    padding: 0 !important;
                }

                .grid-p3 {
                    margin-top: 0 !important;
                    margin-bottom: 0 !important;
                }
            }
            /* =====================================================
   📱 MOBILE — Décaler l'image + le cadre bleu à gauche
   ===================================================== */
@media (max-width: 575.98px) {

    /* 🔵 déplacer le bloc complet (image + plaque bleue) */
    .about-right .about-media {
        transform: translateX(-40px) !important; /* ⇦ valeur à modifier pour le bloc complet */
        position: relative !important;
    }

    /* 🖼️ déplacer l'image */
    .about-right .about-image-box img {
        transform: translateX(-40px) !important;  /* ⇦ valeur à modifier pour l'image */
        width: calc(100% + 40px) !important;      /* évite espace blanc */
    }

    /* 🔷 déplacer la plaque bleue */
    .about-right .navy-plate {
        transform: translateX(-5px) !important;  /* ⇦ valeur à modifier pour la plaque bleue */
    }
}

        </style>

@endsection