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
                {{-- LEFT: Big donut visual --}}
                <div class="col-lg-6">
                    <div class="about-donut-wrap">
                        <div class="about-donut">
                            <div class="about-donut__inner"></div>
                        </div>
                    </div>
                </div>

                {{-- RIGHT: Copy with statistics --}}
                <div class="col-lg-6">
                    <div class="eyebrow">
                        <span>Welcome to Aisla Nova</span>
                        <i aria-hidden="true"></i>
                    </div>

                    <h1 class="display-5 fw-bold mb-4" style="color: var(--dark);">
                        Energize Society<br>Reliable Energy
                    </h1>

                    <p class="lead text-muted mb-4">
                        Leading renewable energy solutions provider that is revolutionising and redefining the way sustainable energy sources are harnessed across the world. Present in 18 countries across Asia, Australia, Europe, Africa and the Americas.
                    </p>

                    {{-- Statistics --}}
                    <div class="row mb-4">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle me-3" style="width: 50px; height: 50px; background: var(--warning); display: flex; align-items: center; justify-content: center;">
                                    <span class="fw-bold text-white">18+</span>
                                </div>
                                <div>
                                    <h5 class="mb-0" style="color: var(--dark);">18+</h5>
                                    <small class="text-muted">Countries</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle me-3" style="width: 50px; height: 50px; background: var(--warning); display: flex; align-items: center; justify-content: center;">
                                    <span class="fw-bold text-white">12M</span>
                                </div>
                                <div>
                                    <h5 class="mb-0" style="color: var(--dark);">12M</h5>
                                    <small class="text-muted">Customers</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="#" class="btn rounded-pill px-4 py-3 fw-semibold" style="background: var(--accent); color: #fff;">
                        Plus de détails
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- =============== FEATURE CARDS (Updated with yellow accents) =============== --}}
    <div class="container-fluid py-5 my-5" style="background: var(--light);">
        <div class="container">
            <div class="row g-4">
                @for($i = 1; $i <= 3; $i++)
                <div class="col-md-4 wow fadeIn" data-wow-delay=".{{ $i * 2 - 1 }}s">
                    <div class="card h-100 border-0 shadow-sm">
                        <div style="height: 8px; background: var(--warning);"></div>
                        <div class="card-body p-4" style="background: var(--muted);">
                            <div class="placeholder-content text-center text-white">
                                <h5 class="mb-3">Feature {{ $i }}</h5>
                                <p class="mb-0">Feature description goes here</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </div>

    {{-- =============== CLEAN ENERGY SECTION =============== --}}
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
                    <div class="text-center">
                        <div class="rounded" style="height: 300px; background: var(--muted); display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-play-circle fa-4x text-white"></i>
                        </div>
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
            {{-- Header with navigation arrows --}}
            <div class="d-flex justify-content-between align-items-center mb-5">
                <div>
                    <p class="text-uppercase fw-bold mb-2" style="color: var(--accent); font-size: 0.9rem; letter-spacing: 0.1em;">RECENT PROJECTS</p>
                    <h2 class="display-6 fw-bold mb-0" style="color: var(--dark);">Recent Projects</h2>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn rounded-circle d-flex align-items-center justify-content-center" 
                            style="width: 50px; height: 50px; border: 2px solid var(--border); background: transparent;">
                        <i class="fas fa-chevron-left" style="color: var(--muted);"></i>
                    </button>
                    <button class="btn rounded-circle d-flex align-items-center justify-content-center" 
                            style="width: 50px; height: 50px; background: var(--accent); border: none;">
                        <i class="fas fa-chevron-right text-white"></i>
                    </button>
                </div>
            </div>

            {{-- Projects grid --}}
            <div class="row g-4">
                {{-- Featured project card (left) --}}
                <div class="col-lg-6">
                    @if($projects->isNotEmpty())
                    @php $featuredProject = $projects->first(); @endphp
                    <div class="card h-100 border-0 shadow-sm" style="border: 2px solid var(--accent) !important; border-radius: 16px;">
                        <div class="card-body p-4">
                            <span class="badge mb-3" style="background: var(--accent); color: white; font-size: 0.8rem; letter-spacing: 0.05em;">SOLAR ENERGY</span>
                            <h4 class="fw-bold mb-3" style="color: var(--dark);">{{ $featuredProject->name ?? 'Floating Sun Tracker Solar Panel' }}</h4>
                            
                            {{-- Benefits list --}}
                            <ul class="list-unstyled mb-4">
                                <li class="d-flex align-items-center mb-2">
                                    <i class="fas fa-check-circle me-2" style="color: var(--accent);"></i>
                                    <span style="color: var(--muted);">Reduce electricity costs</span>
                                </li>
                                <li class="d-flex align-items-center mb-2">
                                    <i class="fas fa-check-circle me-2" style="color: var(--accent);"></i>
                                    <span style="color: var(--muted);">Increase profits</span>
                                </li>
                                <li class="d-flex align-items-center mb-2">
                                    <i class="fas fa-check-circle me-2" style="color: var(--accent);"></i>
                                    <span style="color: var(--muted);">Generate independence</span>
                                </li>
                            </ul>

                            {{-- Price --}}
                            <div class="mt-auto">
                                <h3 class="fw-bold mb-1" style="color: var(--accent);">$00,00</h3>
                                <small class="text-uppercase" style="color: var(--muted); font-size: 0.75rem; letter-spacing: 0.05em;">YEAR SAVINGS</small>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="card h-100 border-0 shadow-sm" style="border: 2px solid var(--accent) !important; border-radius: 16px;">
                        <div class="card-body p-4">
                            <span class="badge mb-3" style="background: var(--accent); color: white; font-size: 0.8rem; letter-spacing: 0.05em;">SOLAR ENERGY</span>
                            <h4 class="fw-bold mb-3" style="color: var(--dark);">Floating Sun Tracker Solar Panel</h4>
                            
                            <ul class="list-unstyled mb-4">
                                <li class="d-flex align-items-center mb-2">
                                    <i class="fas fa-check-circle me-2" style="color: var(--accent);"></i>
                                    <span style="color: var(--muted);">Reduce electricity costs</span>
                                </li>
                                <li class="d-flex align-items-center mb-2">
                                    <i class="fas fa-check-circle me-2" style="color: var(--accent);"></i>
                                    <span style="color: var(--muted);">Increase profits</span>
                                </li>
                                <li class="d-flex align-items-center mb-2">
                                    <i class="fas fa-check-circle me-2" style="color: var(--accent);"></i>
                                    <span style="color: var(--muted);">Generate independence</span>
                                </li>
                            </ul>

                            <div class="mt-auto">
                                <h3 class="fw-bold mb-1" style="color: var(--accent);">$00,00</h3>
                                <small class="text-uppercase" style="color: var(--muted); font-size: 0.75rem; letter-spacing: 0.05em;">YEAR SAVINGS</small>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Project image placeholders (right) --}}
                <div class="col-lg-6">
                    <div class="row g-3 h-100">
                        @for($i = 0; $i < 3; $i++)
                        <div class="col-4">
                            {{-- Added hover overlay with project name and improved styling --}}
                            <div class="project-image-card position-relative rounded h-100 overflow-hidden" 
                                 style="min-height: 120px; cursor: pointer;">
                                @if($projects->count() > $i + 1)
                                    @php $project = $projects->skip($i + 1)->first(); @endphp
                                    @if($project->image)
                                        <img src="{{ asset('storage/' . $project->image) }}" 
                                             class="img-fluid w-100 h-100 rounded project-image" 
                                             alt="{{ $project->name }}"
                                             style="object-fit: cover; transition: transform 0.3s ease;">
                                        <div class="project-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                                            <h6 class="text-white fw-bold text-center px-2">{{ $project->name }}</h6>
                                        </div>
                                    @else
                                        <div class="d-flex align-items-center justify-content-center h-100 rounded" 
                                             style="background: var(--muted);">
                                            <i class="fas fa-image fa-2x text-white"></i>
                                        </div>
                                        <div class="project-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                                            <h6 class="text-white fw-bold text-center px-2">{{ $project->name }}</h6>
                                        </div>
                                    @endif
                                @else
                                    <div class="d-flex align-items-center justify-content-center h-100 rounded" 
                                         style="background: var(--muted);">
                                        <i class="fas fa-image fa-2x text-white"></i>
                                    </div>
                                    <div class="project-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                                        <h6 class="text-white fw-bold text-center px-2">Project {{ $i + 2 }}</h6>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>

            {{-- Bottom accent circle --}}
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
            <div class="row g-5 justify-content-center">
                <div class="col-lg-6 col-xl-4 wow fadeIn" data-wow-delay=".3s">
                    <div class="blog-item position-relative bg-light rounded">
                        <img src="img/blog-1.jpg" class="img-fluid w-100 rounded-top" alt="">
                        <span class="position-absolute px-4 py-3 bg-primary text-white rounded" style="top: -28px; right: 20px;">Web Design</span>
                        <div class="blog-btn d-flex justify-content-between position-relative px-3" style="margin-top: -75px;">
                            <div class="blog-icon btn btn-secondary px-3 rounded-pill my-auto">
                                <a href="" class="btn text-white">En savoir plus</a>
                            </div>
                            <div class="blog-btn-icon btn btn-secondary px-4 py-3 rounded-pill ">
                                <div class="blog-icon-1">
                                    <p class="text-white px-2">Partager<i class="fa fa-arrow-right ms-3"></i></p>
                                </div>
                                <div class="blog-icon-2">
                                    <a href="" class="btn me-1"><i class="fab fa-facebook-f text-white"></i></a>
                                    <a href="" class="btn me-1"><i class="fab fa-twitter text-white"></i></a>
                                    <a href="" class="btn me-1"><i class="fab fa-instagram text-white"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="blog-content text-center position-relative px-3" style="margin-top: -25px;">
                            <img src="img/admin.jpg" class="img-fluid rounded-circle border border-4 border-white mb-3" alt="">
                            <h5 class="">Par Daniel Martin</h5>
                            <span class="text-secondary">24 March 2023</span>
                            <p class="py-2">Lorem ipsum dolor sit amet elit. Sed efficitur quis purus ut interdum. Aliquam dolor eget urna ultricies tincidunt libero sit amet</p>
                        </div>
                        <div class="blog-coment d-flex justify-content-between px-4 py-2 border bg-primary rounded-bottom">
                            <a href="" class="text-white"><small><i class="fas fa-share me-2 text-secondary"></i>5324 Partages</small></a>
                            <a href="" class="text-white"><small><i class="fa fa-comments me-2 text-secondary"></i>5 Commentaires</small></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-4 wow fadeIn" data-wow-delay=".5s">
                    <div class="blog-item position-relative bg-light rounded">
                        <img src="img/blog-2.jpg" class="img-fluid w-100 rounded-top" alt="">
                        <span class="position-absolute px-4 py-3 bg-primary text-white rounded" style="top: -28px; right: 20px;">Development</span>
                        <div class="blog-btn d-flex justify-content-between position-relative px-3" style="margin-top: -75px;">
                            <div class="blog-icon btn btn-secondary px-3 rounded-pill my-auto">
                                <a href="" class="btn text-white ">En savoir plus</a>
                            </div>
                            <div class="blog-btn-icon btn btn-secondary px-4 py-3 rounded-pill ">
                                <div class="blog-icon-1">
                                    <p class="text-white px-2">Partager<i class="fa fa-arrow-right ms-3"></i></p>
                                </div>
                                <div class="blog-icon-2">
                                    <a href="" class="btn me-1"><i class="fab fa-facebook-f text-white"></i></a>
                                    <a href="" class="btn me-1"><i class="fab fa-twitter text-white"></i></a>
                                    <a href="" class="btn me-1"><i class="fab fa-instagram text-white"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="blog-content text-center position-relative px-3" style="margin-top: -25px;">
                            <img src="img/admin.jpg" class="img-fluid rounded-circle border border-4 border-white mb-3" alt="">
                            <h5 class="">Par Daniel Martin</h5>
                            <span class="text-secondary">23 April 2023</span>
                            <p class="py-2">Lorem ipsum dolor sit amet elit. Sed efficitur quis purus ut interdum. Aliquam dolor eget urna ultricies tincidunt libero sit amet</p>
                        </div>
                        <div class="blog-coment d-flex justify-content-between px-4 py-2 border bg-primary rounded-bottom">
                            <a href="" class="text-white"><small><i class="fas fa-share me-2 text-secondary"></i>5324 Partages</small></a>
                            <a href="" class="text-white"><small><i class="fa fa-comments me-2 text-secondary"></i>5 Commentaires</small></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-4 wow fadeIn" data-wow-delay=".7s">
                    <div class="blog-item position-relative bg-light rounded">
                        <img src="img/blog-3.jpg" class="img-fluid w-100 rounded-top" alt="">
                        <span class="position-absolute px-4 py-3 bg-primary text-white rounded" style="top: -28px; right: 20px;">Mobile App</span>
                        <div class="blog-btn d-flex justify-content-between position-relative px-3" style="margin-top: -75px;">
                            <div class="blog-icon btn btn-secondary px-3 rounded-pill my-auto">
                                <a href="" class="btn text-white ">En savoir plus</a>
                            </div>
                            <div class="blog-btn-icon btn btn-secondary px-4 py-3 rounded-pill ">
                                <div class="blog-icon-1">
                                    <p class="text-white px-2">Partager<i class="fa fa-arrow-right ms-3"></i></p>
                                </div>
                                <div class="blog-icon-2">
                                    <a href="" class="btn me-1"><i class="fab fa-facebook-f text-white"></i></a>
                                    <a href="" class="btn me-1"><i class="fab fa-twitter text-white"></i></a>
                                    <a href="" class="btn me-1"><i class="fab fa-instagram text-white"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="blog-content text-center position-relative px-3" style="margin-top: -25px;">
                            <img src="img/admin.jpg" class="img-fluid rounded-circle border border-4 border-white mb-3" alt="">
                            <h5 class="">Par Daniel Martin</h5>
                            <span class="text-secondary">30 jan 2023</span>
                            <p class="py-2">Lorem ipsum dolor sit amet elit. Sed efficitur quis purus ut interdum. Aliquam dolor eget urna ultricies tincidunt libero sit amet</p>
                        </div>
                        <div class="blog-coments d-flex justify-content-between px-4 py-2 border bg-primary rounded-bottom">
                            <a href="" class="text-white"><small><i class="fas fa-share me-2 text-secondary"></i>5324 Partages</small></a>
                            <a href="" class="text-white"><small><i class="fa fa-comments me-2 text-secondary"></i>5 Commentaires</small></a>
                        </div>
                    </div>
                </div>
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
            <div class="owl-carousel team-carousel wow fadeIn" data-wow-delay=".5s">
                @foreach($team as $member)
                <div class="rounded team-item">
                    <div class="team-content">
                        <div class="team-img-icon">
                            <div class="team-img rounded-circle">
                                <img src="{{ $member->image_url }}" class="img-fluid w-100 rounded-circle" alt="{{ $member->name }}">
                            </div>
                            <div class="team-name text-center py-3">
                                <h4 class="">{{ $member->name }}</h4>
                                <p class="m-0">{{ $member->role }}</p>
                            </div>
                            <div class="team-icon d-flex justify-content-center pb-4">
                                @if($member->linkedin)
                                <a class="btn btn-square btn-secondary text-white rounded-circle m-1" href="{{ $member->linkedin }}" target="_blank">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                @endif
                                <!-- Add other social links if you have them in your model -->
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Team End -->


    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
