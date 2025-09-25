@extends('layouts.app')
@section('title', 'Aisla Nova - Energize Society Reliable Energy')
@section('content')
    {{-- =============== HERO (Updated to match Figma design) =============== --}}
    @php
        $hero = optional($banners)->first();
        $heroTitle = trim($hero->title ?? '') ?: "Energize Society\nReliable Energy";
        $heroSummary = trim($hero->summary ?? '') ?: 'Practical renewable energy technology that reduces costs and helps the environment';
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
                            Get Started
                        </a>
                        <a href="{{ url('/video') }}" class="btn btn-dark-ghost rounded-pill px-4 py-3">
                            <i class="fas fa-play me-2"></i> Watch Full Video
                        </a>
                    </div>
                </div>
            </div>
        </div>
        {{-- Flèches navigation --}}
        <button class="hero-arrow hero-arrow-left">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="hero-arrow hero-arrow-right">
            <i class="fas fa-chevron-right"></i>
        </button>
        <div class="hero-curve" aria-hidden="true"></div>
    </div>
    <script>
        const banners = @json($bannerData);
        let currentIndex = 0;
        function updateHero(index) {
            const heroTitle = document.querySelector('.hero-title');
            const heroSub = document.querySelector('.hero-sub');
            document.querySelector('.hero-aisla').style.setProperty(
                '--hero-bg-img',
                `url('${banners[index].image}')`
            );
            heroTitle.innerHTML = banners[index].title.replace(/\n/g, "<br>");
            heroSub.textContent = banners[index].summary;
        }
        document.querySelector('.hero-arrow-left').addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + banners.length) % banners.length;
            updateHero(currentIndex);
        });
        document.querySelector('.hero-arrow-right').addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % banners.length;
            updateHero(currentIndex);
        });
    </script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    {{-- Section après le Hero --}}
    <section class="after-hero-text py-5">
        <div class="container">
            <h2 class="big-title">
                <div class="text-green text-start">Leading the Way in</div>
                <div class="text-darkblue text-center">Solar Energy Solutions</div>
            </h2>
        </div>
    </section>
    <!-- Projects Start -->
    <div class="container-fluid py-5 mb-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex gap-2">
                    <button class="btn rounded-circle d-flex align-items-center justify-content-center project-prev"
                        style="width: 50px; height: 50px; border: 2px solid var(--border); background: transparent;">
                        <i class="fas fa-chevron-left" style="color: var(--muted);"></i>
                    </button>
                    <button class="btn rounded-circle d-flex align-items-center justify-content-center project-next"
                        style="width: 50px; height: 50px; background: var(--accent); border: none;">
                        <i class="fas fa-chevron-right text-white"></i>
                    </button>
                </div>
            </div>
            @if($projects->isNotEmpty())
                <div class="owl-carousel project-carousel">
                    @foreach($projects as $project)
                        <div class="project-item">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <h4 class="fw-bold mb-2" style="color: var(--dark);">{{ $project->name }}</h4>
                                    @if($project->summary)
                                        <p class="mb-0" style="color: var(--muted);">{{ $project->summary }}</p>
                                    @endif
                                </div>
                                @if($project->image)
                                    <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->name }}">
                                @else
                                    <div class="d-flex align-items-center justify-content-center bg-secondary" style="flex:1;">
                                        <i class="fas fa-image fa-2x text-white"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <!-- Projects End -->
    {{-- =============== FEATURE CARDS (Updated with yellow accents) =============== --}}
    <div class="container-fluid py-5 my-5" style="background: var(--light);">
        <div class="container services-section">
            @php $serviceChunks = $services->chunk(3); @endphp
            <div class="position-relative">
                @foreach($serviceChunks as $chunkIndex => $chunk)
                    <div class="service-slide row g-4 {{ $chunkIndex === 0 ? '' : 'd-none' }}">
                        @foreach($chunk as $service)
                            <div class="col-md-4 wow fadeIn" data-wow-delay=".{{ ($loop->index + 1) * 2 - 1 }}s">
                                <a href="{{ route('services.show', $service->id) }}" class="text-decoration-none text-dark"
                                    style="display:block;">
                                    <div class="card h-100 border-0 shadow-sm overflow-hidden service-card"
                                        style="transition: transform .2s; background-color: {{ $service->image ? '#fff' : '#555555' }};">
                                        @if($service->image)
                                            <img src="{{ asset('storage/' . ltrim($service->image, '/')) }}" alt="{{ $service->name }}"
                                                class="w-100" style="height: 200px; object-fit: cover;">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center" style="height: 200px;">
                                                <i class="fas fa-image fa-3x text-white-50"></i>
                                            </div>
                                        @endif
                                        <div class="card-body p-4 text-center" style="background: transparent; padding-top: 80px;">
                                            <h5 class="service-name-block">{{ $service->name }}</h5>
                                            <p class="mb-0 text-muted">
                                                {{ \Illuminate\Support\Str::limit($service->description, 60, '...') }}
                                            </p>
                                            <div class="mt-3">
                                                <span class="text-dark fw-bold">
                                                    Créé le : {{ $service->created_at->format('d/m/Y') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
            @if($services->count() > 3)
                <div class="d-flex align-items-center mt-4">
                    <button class="btn btn-warning btn-sm services-prev">Previous</button>
                    <div class="services-progress flex-grow-1 mx-3"
                        style="position:relative; height:4px; background:rgba(0,0,0,0.1); overflow:hidden;">
                        <div class="services-progress-bar"
                            style="position:absolute; top:0; left:0; height:100%; width:0; background:var(--warning); transition:width .3s;">
                        </div>
                    </div>
                    <button class="btn btn-warning btn-sm services-next">Next</button>
                </div>
            @endif
        </div>
    </div>
    </div>
    {{-- =============== CLEAN ENERGY SECTION =============== --}}
    <div class="container-fluid py-5 my-5">
        <div class="container">
            <div class="text-center mb-5">
                <!-- Nouveau titre orangé souligné -->
                <h6 style="color: #b90606; font-size: 1rem; letter-spacing: 1px; text-align: center;">
                    Solutions <span style="border-bottom: 2px solid #b90606;">of Solar</span> Energy
                </h6>
            </div>
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
                        <div class="container-fluid py-5 my-5">
                            <div class="container">
                                <div class="text-center mb-5">
                                    <h2 class="display-5 fw-bold mb-3" style="color: var(--dark);">
                                        Produce Your Own Clean Save<br>Ourthe Environment
                                    </h2>
                                </div>
                                <div class="row g-4 align-items-center">
                                    <!-- LEFT image -->
                                    <div class="col-lg-3 d-flex flex-column justify-content-center align-items-center">
                                        <img src="/img/bat.png" alt="Battery" class="mb-3 uniform-img">
                                        <h5 class="uniform-title">Battery Storage Solutions</h5>
                                        <p class="uniform-text">We fully utilise the latest corporate renewable energy technology to
                                            generate significant energy.</p>
                                    </div>
                                    <!-- VIDEO -->
                                    <div class="col-lg-6">
                                        <div class="ratio ratio-16x9">
                                            <iframe src="{{ $embed }}" title="YouTube video" allowfullscreen></iframe>
                                        </div>
                                    </div>
                                    <!-- RIGHT image -->
                                    <div class="col-lg-3 d-flex flex-column justify-content-center align-items-center">
                                        <img src="/img/wrd.png" alt="Solar" class="mb-3 uniform-img">
                                        <h5 class="uniform-title">Commercial Solar Energy</h5>
                                        <p class="uniform-text">We fully utilise the latest corporate renewable energy technology to
                                            generate significant energy.</p>
                                    </div>
                                </div>
                                <!-- ROW BELOW VIDEO -->
                                <div class="row g-4 mt-4 text-center">
                                    <div class="col-lg-4 col-md-6">
                                        <img src="/img/ssun.png" alt="Boost Green Credentials" class="mb-3 uniform-img">
                                        <h5 class="uniform-title">Boost Green Credentials</h5>
                                        <p class="uniform-text">We fully utilise the latest corporate renewable energy technology to
                                            generate significant energy.</p>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <img src="/img/vent.png" alt="Industrial Solar Energy" class="mb-3 uniform-img">
                                        <h5 class="uniform-title">Industrial Solar Energy</h5>
                                        <p class="uniform-text">We fully utilise the latest corporate renewable energy technology to
                                            generate significant energy.</p>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <img src="/img/sun.png" alt="Scale Technologies" class="mb-3 uniform-img">
                                        <h5 class="uniform-title">Scale With New Technologies</h5>
                                        <p class="uniform-text">We fully utilise the latest corporate renewable energy technology to
                                            generate significant energy.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- STYLES -->
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
                                    /* équivalent Bootstrap text-muted */
                                }
                            </style>
                        </div>
                    @endif
                @endif
                <style>
                    .project-item .card {
                        border: 2px solid rgb(255, 115, 0);
                        /* bordure rouge */
                        border-radius: 10px;
                        overflow: hidden;
                        display: flex;
                        /* layout horizontal */
                        flex-direction: row;
                        width: 600px;
                        /* plus grand */
                        height: 250px;
                        margin-right: 15px;
                    }
                    .project-item .card-body {
                        flex: 2;
                        /* texte prend 2/3 de la largeur */
                        padding: 20px;
                        display: flex;
                        flex-direction: column;
                        justify-content: center;
                    }
                    .project-item img {
                        flex: 1;
                        /* image prend 1/3 de la largeur */
                        height: 100%;
                        object-fit: cover;
                    }
                    .project-carousel .owl-stage-outer {
                        padding-right: 20px;
                        /* voir partiellement la prochaine carte */
                    }
                    /* Optionnel : réduire le texte si trop long */
                    .project-item .card-body p {
                        overflow: hidden;
                        text-overflow: ellipsis;
                        display: -webkit-box;
                        -webkit-line-clamp: 5;
                        /* nombre de lignes max */
                        -webkit-box-orient: vertical;
                    }
                </style>
                <!-- Team Start -->
                <div class="container-fluid py-5 mb-5 team" style="background-color: #FAFAFA;">
                    <div class="container">
                        <!-- Header -->
                        <div class="text-center mx-auto pb-5" style="max-width: 600px;">
                            <h5 class="fw-bold" style="color: #fe5716;">OUR CREATIVE TEAM</h5>
                            <h1>Meet Our Experts</h1>
                        </div>
                        <!-- Carousel / Members -->
                        <div class="wow fadeIn" data-wow-delay=".5s">
                            <div id="team-container" class="row g-4">
                                <!-- Exemple de membre (sera remplacé par tes données dynamiques) -->
                                <div class="col-12 team-member d-flex align-items-center p-4">
                                    <!-- Image ronde -->
                                    <div class="flex-shrink-0">
                                        <img src="https://via.placeholder.com/200" alt="Membre"
                                            class="img-fluid rounded-circle"
                                            style="width:200px; height:200px; object-fit:cover;">
                                    </div>
                                </div>
                                <!-- Navigation -->
                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <button id="team-prev"
                                        class="btn btn-outline-secondary rounded-pill px-4">Précédent</button>
                                    <div class="flex-grow-1 mx-3 progress" style="height:5px;">
                                        <div id="team-progress" class="progress-bar bg-secondary" role="progressbar"></div>
                                    </div>
                                    <button id="team-next"
                                        class="btn btn-outline-secondary rounded-pill px-4">Suivant</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Team End -->
                    <!-- Blog Start -->
                    <div class="container-fluid blog py-5 mb-5">
                        <div class="container">
                            <div class="text-center mx-auto pb-5 wow fadeIn" data-wow-delay=".3s" style="max-width: 600px;">
                                <h5 class="text-uppercase fw-bold"
                                    style="color:#F1A601 ; font-size: 1.1rem; letter-spacing: 1px;">
                                    Blog & Updates
                                </h5>
                                <h1 class="fw-bold">Recent News</h1>
                            </div>
                            <div class="row g-4 justify-content-center">
                                @forelse($blogs->slice(0, 4) as $index => $blog)
                                    <div class="col-12 col-md-6"> <!-- 2 cartes par ligne sur md+ -->
                                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                                            @if($index === 0 || $index === 3) <!-- 1er et 4eme blog -->
                                                @if($blog->image)
                                                    <img src="{{ asset('storage/' . $blog->image) }}" class="w-100"
                                                        style="border-radius: 1rem;">
                                                @endif
                                            @else
                                                <img src="{{ asset('storage/' . $blog->image) }}" class="w-100"
                                                    style="border-radius: 1rem;">
                                            @endif
                                            <div class="card-body" style="border-radius: 1rem;">
                                                <p class="text-uppercase small text-muted fw-semibold mb-2">Design Process</p>
                                                <h5 class="fw-bold">{{ $blog->title }}</h5>
                                                <p class="text-muted">
                                                    {{ Str::limit(strip_tags($blog->content), 100) }}
                                                </p>
                                                <div class="d-flex align-items-center mt-3">
                                                    <span class="badge px-3 py-2 rounded-pill"
                                                        style="background-color: #F1A601; color: #000;">
                                                        {{ $blog->created_at->format('F d, Y') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center">Aucun article pour le moment.</p>
                                @endforelse
                            </div>
                            <div class="text-center mt-5">
                                <a href="{{ route('blog.index') }}" class="btn btn-danger px-4 py-2 rounded-pill">
                                    View All News
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Blog End -->
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
                                                            <!-- Avatar avec cercle -->
                                                            <div class="team-photo position-relative me-3">
                                                                <div class="circle-border">
                                                                    <img src="${member.image_url}" class="img-fluid rounded-circle" alt="${member.name}">
                                                                </div>
                                                            </div>
                                                            <!-- Infos -->
                                                            <div class="team-info flex-grow-1">
                                                                <h4 class="fw-bold mb-1">${member.name}</h4>
                                                                <p class="mb-2" style="color: #fe5716;">${member.role}</p>
                                                            </div>
                                                        </div>
                                                    `;
                                            teamContainer.appendChild(col);
                                        });
                                        // Pagination + Progress bar
                                        teamPage = data.current_page;
                                        const totalPages = data.last_page;
                                        teamPrev.disabled = teamPage === 1;
                                        teamNext.disabled = teamPage === totalPages;
                                        teamProgress.style.width = (teamPage / totalPages * 100) + '%';
                                    });
                            }
                            teamPrev.addEventListener('click', () => loadTeam(teamPage - 1));
                            teamNext.addEventListener('click', () => loadTeam(teamPage + 1));
                            loadTeam();
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
                            donut.querySelector('.hero-nav.next').addEventListener('click', () => goTo(index + 1));
                            donut.querySelector('.hero-nav.prev').addEventListener('click', () => goTo(index - 1));
                            dotsContainer.addEventListener('click', e => {
                                if (e.target.classList.contains('dot')) {
                                    goTo(parseInt(e.target.dataset.index, 10));
                                }
                            });
                        });
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
                            /* Garder padding vertical, réduire/annuler le padding horizontal */
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
                            /* Services / cartes : supprimer largeurs fixes */
                            .services-section .card {
                                width: 100% !important;
                            }
                            .services-section img {
                                max-width: 100%;
                                height: auto;
                            }
                            /* Projects : ta carte faisait 600px de large -> 100% sur mobile */
                            .project-item .card {
                                width: 100% !important;
                                height: auto !important;
                            }
                            .project-item img {
                                height: 180px !important;
                                object-fit: cover;
                            }
                            /* Bloc CONTACT (zone bleue) : l'image absolue débordait */
                            .container-fluid[style*="background: var(--primary)"] img[alt="Contact Image"] {
                                position: static !important;
                                width: 70vw !important;
                                max-width: 320px !important;
                                margin: 16px auto 0 !important;
                            }
                            /* Image sous la zone bleue + marge négative */
                            img[alt="Image sous zone bleue"] {
                                width: 100% !important;
                                height: auto !important;
                            }
                            .text-center[style*="margin-top: -190px"] {
                                margin-top: 0 !important;
                            }
                            /* Icônes/visuels autour de la vidéo */
                            .uniform-img {
                                width: 96px !important;
                                height: 96px !important;
                                object-fit: contain;
                            }
                            /* Éviter tous débordements horizontaux restants */
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
@endsection