@extends('layouts.app')

@section('title', 'Aisla Nova - Energize Society Reliable Energy')

@section('content')

    {{-- =============== HERO (Updated to match Figma design) =============== --}}
    @php
    $hero = optional($banners)->first();
    $heroTitle = trim($hero->title ?? '') ?: "Energize Society\nReliable Energy";
    $heroSummary = trim($hero->summary ?? '') ?: 'Practical renewable energy technology that reduces costs and helps the environment';
    $heroImg = !empty($hero?->image) ? asset('storage/' . ltrim($hero->image, '/')) : asset('img/default-banner.jpg');
    $bannerData = $banners->map(fn($b) => [
        'title' => $b->title,
        'summary' => $b->summary,
        'image' => !empty($b->image) ? asset('storage/' . ltrim($b->image, '/')) : asset('img/default-banner.jpg'),
    ]);
    @endphp

    <div class="hero-aisla">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                {{-- Left copy --}}
                <div class="col-lg-6">
                    <div class="hero-copy">
                        <span class="tag text-accent fw-bold d-inline-block mb-2">Aisla Nova</span>
                        <h1 class="hero-title">{!! nl2br(e($heroTitle)) !!}</h1>
                        <p class="hero-lead">{{ $heroSummary }}</p>
                        <a href="{{ url('/contact') }}" class="btn btn-accent rounded-pill px-4 py-3">Get Started</a>

                        {{-- Progress indicator --}}
                        <div class="hero-dots mt-4" aria-hidden="true"></div>
                        <div class="hero-progress mt-2" aria-hidden="true">
                            <div class="hero-progress-bar"></div>
                        </div>
                    </div>
                </div>

                {{-- Right donut visual --}}
                <div class="col-lg-6 d-none d-lg-flex justify-content-center">
                    <div class="hero-donut" data-index="0" data-banners='@json($bannerData)'>
                        <div class="donut-arc"></div>
                        <div class="donut-image" style="background-image: url('{{ $heroImg }}');"></div>
                        <button class="hero-nav prev"><i class="fas fa-chevron-left"></i></button>
                        <button class="hero-nav next"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

 

    {{-- =============== ABOUT SECTION (Updated with statistics) =============== --}}
    <section class="about-aisla py-5 my-5">
        <div class="container pt-4 pt-lg-5">
            <div class="row g-5 align-items-center">
                {{-- LEFT: Logo inside circular frame --}}
                <div class="col-lg-6">
                    <div class="about-donut-wrap">
                        <div class="about-donut">
                            @if($about?->logo)
                                <img src="{{ asset('storage/' . $about->logo) }}" alt="Aisla Nova logo">
                            @endif
                        </div>
                    </div>
                </div>

                {{-- RIGHT: Copy --}}
                <div class="col-lg-6">
                    <div class="eyebrow">
                        <span>Welcome to Aisla Nova</span>
                        <i aria-hidden="true"></i>
                    </div>

                    <h1 class="display-5 fw-bold mb-4">
                        {!! nl2br(e($about->heading ?? '')) !!}
                    </h1>

                    <p class="lead text-muted mb-4">
                        {{ $about->summary ?? '' }}
                    </p>

                    <a href="#" class="btn btn-accent rounded-pill px-4 py-3 fw-semibold">
                        Plus de détails
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- =============== FEATURE CARDS (Updated with yellow accents) =============== --}}
    <div class="container-fluid py-5 my-5" style="background: var(--light);">
        <div class="container services-section">
            @php $serviceChunks = $services->chunk(3); @endphp
            <div class="position-relative">
                @foreach($serviceChunks as $chunkIndex => $chunk)
                <div class="service-slide row g-4 {{ $chunkIndex === 0 ? '' : 'd-none' }}">
                    @foreach($chunk as $service)
                    <div class="col-md-4 wow fadeIn" data-wow-delay=".{{ ($loop->index + 1) * 2 - 1 }}s">
                        <div class="card h-100 border-0 shadow-sm overflow-hidden" style="transition: transform .2s;">
                            <div style="height: 8px; background: var(--warning);"></div>
                            @if($service->image)
                            <img src="{{ asset('storage/' . ltrim($service->image, '/')) }}" alt="{{ $service->name }}" class="w-100" style="height: 200px; object-fit: cover;">
                            @else
                            <div class="d-flex align-items-center justify-content-center bg-secondary" style="height: 200px;">
                                <i class="fas fa-image fa-3x text-white-50"></i>
                            </div>
                            @endif
                            <div class="card-body p-4 text-center" style="background: var(--muted);">
                                <h5 class="mb-3 text-white">{{ $service->name }}</h5>
                                <p class="mb-0 text-white-50">{{ $service->summary }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endforeach
            </div>
            @if($services->count() > 3)
            <div class="d-flex align-items-center mt-4">
                <button class="btn btn-warning btn-sm services-prev">Previous</button>
                <div class="services-progress flex-grow-1 mx-3" style="position:relative; height:4px; background:rgba(0,0,0,0.1); overflow:hidden;">
                    <div class="services-progress-bar" style="position:absolute; top:0; left:0; height:100%; width:0; background:var(--warning); transition:width .3s;"></div>
                </div>
                <button class="btn btn-warning btn-sm services-next">Next</button>
            </div>
            @endif
        </div>
    </div>

    {{-- =============== CLEAN ENERGY SECTION =============== --}}
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
                    <h2 class="display-5 fw-bold mb-3" style="color: var(--dark);">Produce Your Own Clean Save<br>Ourthe Environment</h2>
                </div>

                <div class="row g-4 align-items-center">
                    <div class="col-lg-3">
                        <div class="text-center">
                            <i class="fas fa-leaf fa-3x mb-3" style="color: var(--secondary);"></i>
                            <h5 style="color: var(--dark);">Eco-Friendly Solutions</h5>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="ratio ratio-16x9">
                            <iframe src="{{ $embed }}" title="YouTube video" allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="text-center">
                            <i class="fas fa-recycle fa-3x mb-3" style="color: var(--secondary);"></i>
                            <h5 style="color: var(--dark);">Sustainable Energy</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endif

    {{-- =============== CONTACT SECTION (Updated with blue background) =============== --}}
    <div class="container-fluid py-5 my-5" style="background: var(--primary);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="display-5 fw-bold text-white mb-3">Get In Touch To Discuss<br>How We Can Help You</h2>
                    <p class="text-white-50 mb-4">Ready to start your renewable energy journey? Contact our experts today.</p>
                    <a href="{{ url('/contact') }}" class="btn rounded-pill px-4 py-3 fw-semibold" style="background: var(--accent); color: #fff;">
                        Contact Us
                    </a>
                </div>
                <div class="col-lg-4 text-center">
                    <div class="rounded-circle mx-auto" style="width: 200px; height: 200px; background: var(--muted); display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-user fa-4x text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Projects Start -->
    <div class="container-fluid py-5 mb-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <p class="text-uppercase fw-bold mb-2" style="color: var(--accent); font-size: 0.9rem; letter-spacing: 0.1em;">RECENT PROJECTS</p>
                    <h2 class="display-6 fw-bold mb-0" style="color: var(--dark);">Recent Projects</h2>
                </div>
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
                    <div class="card h-100 border-0 shadow-sm">
                        @if($project->image)
                        <img src="{{ asset('storage/' . $project->image) }}" class="card-img-top" alt="{{ $project->name }}" style="height:250px; object-fit:cover;">
                        @else
                        <div class="d-flex align-items-center justify-content-center bg-secondary" style="height:250px;">
                            <i class="fas fa-image fa-2x text-white"></i>
                        </div>
                        @endif
                        <div class="card-body">
                            <h4 class="fw-bold mb-2" style="color: var(--dark);">{{ $project->name }}</h4>
                            @if($project->summary)
                            <p class="mb-0" style="color: var(--muted);">{{ $project->summary }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="progress mt-4" style="height:4px; background: var(--border);">
                <div class="progress-bar" id="project-progress" style="width:0; background: var(--accent);"></div>
            </div>
            @else
            <p class="text-center" style="color: var(--muted);">No projects available.</p>
            @endif

            <div class="text-center mt-5">
                <div class="rounded-circle mx-auto" style="width: 60px; height: 60px; background: var(--warning);"></div>
            </div>
        </div>
    </div>
    <!-- Projects End -->

    <!-- Blog Start -->
    <div class="container-fluid blog py-5 mb-5">
        <div class="container">
            <div class="text-center mx-auto pb-5 wow fadeIn" data-wow-delay=".3s" style="max-width: 600px;">
                <h5 class="text-primary">Notre blog</h5>
                <h1>Derniers articles et actualités</h1>
            </div>
            <div class="row g-4 justify-content-center">
                @forelse($blogs as $blog)
                    <div class="col-md-6 col-lg-4">
                        <article class="card h-100 border-0 shadow-sm">
                            @if($blog->image)
                                <img src="{{ asset('storage/' . $blog->image) }}" class="card-img-top" alt="{{ $blog->title }}">
                            @endif
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $blog->title }}</h5>
                                <p class="card-text">{{ Str::limit(strip_tags($blog->content), 100) }}</p>
                            </div>
                            <div class="card-footer bg-transparent border-0 text-center pb-4">
                                <a href="{{ route('blog.show', $blog->slug) }}" class="btn btn-primary rounded-pill">Lire la suite</a>
                            </div>
                        </article>
                    </div>
                @empty
                    <p class="text-center">Aucun article pour le moment.</p>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Blog End -->

    <!-- Team Start -->
    <div class="container-fluid py-5 mb-5 team">
        <div class="container">
            <div class="text-center mx-auto pb-5 wow fadeIn" data-wow-delay=".3s" style="max-width: 600px;">
                <h5 class="text-primary">Notre équipe</h5>
                <h1>Rencontrez notre équipe d'experts</h1>
            </div>
            <div class="wow fadeIn" data-wow-delay=".5s">
                <div id="team-container" class="row g-4"></div>
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <button id="team-prev" class="btn btn-secondary rounded-pill">Précédent</button>
                    <div class="flex-grow-1 mx-3 progress" style="height:5px;">
                        <div id="team-progress" class="progress-bar bg-secondary" role="progressbar"></div>
                    </div>
                    <button id="team-next" class="btn btn-secondary rounded-pill">Suivant</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Team End -->


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
                            col.className = 'col-md-4';
                            col.innerHTML = `
                <div class="rounded team-item">
                    <div class="team-content">
                        <div class="team-img-icon">
                            <div class="team-img rounded-circle">
                                <img src="${member.image_url}" class="img-fluid w-100 rounded-circle" alt="${member.name}">
                            </div>
                            <div class="team-name text-center py-3">
                                <h4>${member.name}</h4>
                                <p class="m-0">${member.role}</p>
                            </div>
                            <div class="team-icon d-flex justify-content-center pb-4">
                                ${member.linkedin ? `<a class="btn btn-square btn-secondary text-white rounded-circle m-1" href="${member.linkedin}" target="_blank"><i class="fab fa-linkedin-in"></i></a>` : ''}
                            </div>
                        </div>
                    </div>
                </div>`;
                            teamContainer.appendChild(col);
                        });
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

@endsection
