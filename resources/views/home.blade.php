@extends('layouts.app')

@section('title', 'Eco Call - Accueil')

@section('content')

    {{-- =============== HERO (Aisla Nova style, dynamic) =============== --}}
    @php
    $hero = optional($banners)->first();
    $heroTitle = trim($hero->title ?? '') ?: "Energize Society\nReliable Energy";
    $heroSummary = trim($hero->summary ?? '') ?: 'Practical renewable energy technology that reduces costs and helps the environment';
    $heroImg = !empty($hero?->image) ? asset('storage/' . ltrim($hero->image, '/')) : asset('img/default-banner.jpg');
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
            <a href="{{ url('/contact') }}" class="btn btn-accent rounded-pill px-4 py-3">Request a Quote</a>

            {{-- Static dots for the look --}}
            <div class="hero-dots mt-4" aria-hidden="true">
                <span class="dot active"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span>
            </div>
            </div>
        </div>

        {{-- Right donut visual; the image is applied inline to avoid CSS-var issues --}}
        <div class="col-lg-6 d-none d-lg-flex justify-content-center">
            <div class="hero-donut" data-index="0" data-banners='@json($banners)'>
            <div class="donut-arc"></div>
            <div class="donut-image"></div>
            <button class="hero-nav prev"><i class="fas fa-chevron-left"></i></button>
            <button class="hero-nav next"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
        </div>
    </div>
    </div>
    {{-- =============== /HERO =============== --}}

    <!-- Fact Start -->
    <!-- <div class="container-fluid bg-secondary py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 wow fadeIn" data-wow-delay=".1s">
                    <div class="d-flex counter">
                        <h1 class="me-3 text-primary counter-value">99</h1>
                        <h5 class="text-white mt-1">Clients satisfaits</h5>
                    </div>
                </div>
                <div class="col-lg-3 wow fadeIn" data-wow-delay=".3s">
                    <div class="d-flex counter">
                        <h1 class="me-3 text-primary counter-value">25</h1>
                        <h5 class="text-white mt-1">Des milliers d'entreprises prospères</h5>
                    </div>
                </div>
                <div class="col-lg-3 wow fadeIn" data-wow-delay=".5s">
                    <div class="d-flex counter">
                        <h1 class="me-3 text-primary counter-value">120</h1>
                        <h5 class="text-white mt-1">Clients qui aiment EcoCall</h5>
                    </div>
                </div>
                <div class="col-lg-3 wow fadeIn" data-wow-delay=".7s">
                    <div class="d-flex counter">
                        <h1 class="me-3 text-primary counter-value">5</h1>
                        <h5 class="text-white mt-1">Avis 5 étoiles donnés par des clients satisfaits</h5>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- Fact End -->


<!-- About (Aisla Nova / Donut style) -->
<section class="about-aisla py-5 my-5">
  <div class="container pt-4 pt-lg-5">
    <div class="row g-5 align-items-center">

      {{-- LEFT: Big donut visual --}}
      <div class="col-lg-6">
        <div class="about-donut-wrap">
          <div class="about-donut">
            {{-- Inner disc (kept gray like the reference) --}}
            <div class="about-donut__inner"></div>
          </div>
        </div>
      </div>

      {{-- RIGHT: Copy --}}
      <div class="col-lg-6">
        {{-- eyebrow + small rule --}}
        <div class="eyebrow">
          <span>Welcome to Aisla Nova</span>
          <i aria-hidden="true"></i>
        </div>

        <h1 class="display-5 fw-bold mb-3">
          {{ $about->heading ?: 'Energize Society<br>Reliable Energy' }}
        </h1>

        <p class="lead text-muted mb-4">
          {{ $about->summary ?: "Leading renewable energy solutions provider that is revolutionising and redefining the way sustainable energy sources are harnessed across the world. Present in 18 countries across Asia, Australia, Europe, Africa and the Americas." }}
        </p>

        {{-- Contact bits (optional) --}}
        <ul class="about-list list-unstyled mb-4">
          @if(!empty($about->location))
            <li><i class="fas fa-map-marker-alt"></i> {{ $about->location }}</li>
          @endif
          @if(!empty($about->phone))
            <li><i class="fas fa-phone-alt"></i> {{ $about->phone }}</li>
          @endif
          @if(!empty($about->email))
            <li><i class="fas fa-envelope"></i> {{ $about->email }}</li>
          @endif
        </ul>

        <a href="#" class="btn btn-success rounded-pill px-4 py-3 fw-semibold">
          Plus de détails
        </a>
      </div>

    </div>
  </div>
</section>
<!-- /About -->



    <!-- Services Start -->
    <div class="container-fluid services py-5 my-5">
        <div class="container py-5">
            <div class="text-center mx-auto pb-5 wow fadeIn" data-wow-delay=".3s" style="max-width: 600px;">
                <h5 class="text-primary">Nos services</h5>
                <h1>Des services conçus spécialement pour votre entreprise</h1>
            </div>
            <div class="row g-5 services-inner">
                @forelse($services as $service)
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay=".{{ $loop->index % 3 }}s">
                    <div class="services-item bg-light rounded">
                        <div class="p-4 text-center services-content">
                            <div class="services-content-icon">
                                @if($service->image)
                                <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" 
                                     class="img-fluid mb-4 rounded" style="max-height: 100px; width: auto;">
                                @else
                                <div class="icon-placeholder mb-4">
                                    <i class="fa fa-code fa-5x text-primary"></i>
                                </div>
                                @endif
                                <h4 class="mb-3">{{ $service->name }}</h4>
                                <p class="mb-4">{{ $service->summary }}</p>
                                <a href="{{ route('services.show', $service->id) }}"
                                   class="btn btn-secondary text-white px-4 py-2 rounded-pill">
                                    En savoir plus
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center">
                    <p class="lead">Aucun service disponible pour le moment.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Services End -->


    <!-- Project Start -->
    <div class="container-fluid project py-5 mb-5">
        <div class="container">
            <div class="text-center mx-auto pb-5 wow fadeIn" data-wow-delay=".3s" style="max-width: 600px;">
                <h5 class="text-primary">Nos projets</h5>
                <h1>Nos projets récemment réalisés</h1>
            </div>
            <div class="row g-5">
                @foreach($projects as $project)
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay=".{{ $loop->index % 3 * 0.2 + 0.3 }}s">
                    <div class="project-item">
                        <div class="project-img" style="height: 250px; overflow: hidden;">
                            @if($project->image)
                                <img src="{{ asset('storage/' . $project->image) }}" 
                                    class="img-fluid w-100 h-100 object-fit-cover rounded" 
                                    alt="{{ $project->name }}"
                                    style="object-position: center;">
                            @else
                                <img src="{{ asset('img/default-project.jpg') }}"
                                    class="img-fluid w-100 h-100 object-fit-cover rounded"
                                    alt="Image de projet par défaut"
                                    style="object-position: center;">
                            @endif
                            <div class="project-content">
                                <a href="{{ route('projects.show', $project->id) }}" class="text-center">
                                    <h4 class="text-secondary">{{ $project->name }}</h4>
                                    <p class="m-0 text-white">{{ $project->summary }}</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Project End -->


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

    <!-- Testimonial Start -->
    <div class="container-fluid testimonial py-5 mb-5">
        <div class="container">
            <div class="text-center mx-auto pb-5 wow fadeIn" data-wow-delay=".3s" style="max-width: 600px;">
                <h5 class="text-primary">Nos témoignages</h5>
                <h1>Ce que disent nos clients&nbsp;!</h1>
            </div>
            <div class="owl-carousel testimonial-carousel wow fadeIn" data-wow-delay=".5s">
                <div class="testimonial-item border p-4">
                    <div class="d-flex align-items-center">
                        <div class="">
                            <img src="img/testimonial-1.jpg" alt="">
                        </div>
                        <div class="ms-4">
                            <h4 class="text-secondary">Nom du client</h4>
                            <p class="m-0 pb-3">Profession</p>
                            <div class="d-flex pe-5">
                                <i class="fas fa-star me-1 text-primary"></i>
                                <i class="fas fa-star me-1 text-primary"></i>
                                <i class="fas fa-star me-1 text-primary"></i>
                                <i class="fas fa-star me-1 text-primary"></i>
                                <i class="fas fa-star me-1 text-primary"></i>
                            </div>
                        </div>
                    </div>
                    <div class="border-top mt-4 pt-3">
                        <p class="mb-0">Lorem ipsum dolor sit amet elit. Sed efficitur quis purus ut interdum aliquam dolor eget urna. Nam volutpat libero sit amet leo cursus, ac viverra eros morbi quis quam mi.</p>
                    </div>
                </div>
                <div class="testimonial-item border p-4">
                    <div class=" d-flex align-items-center">
                        <div class="">
                            <img src="img/testimonial-2.jpg" alt="">
                        </div>
                        <div class="ms-4">
                            <h4 class="text-secondary">Nom du client</h4>
                            <p class="m-0 pb-3">Profession</p>
                            <div class="d-flex pe-5">
                                <i class="fas fa-star me-1 text-primary"></i>
                                <i class="fas fa-star me-1 text-primary"></i>
                                <i class="fas fa-star me-1 text-primary"></i>
                                <i class="fas fa-star me-1 text-primary"></i>
                                <i class="fas fa-star me-1 text-primary"></i>
                            </div>
                        </div>
                    </div>
                    <div class="border-top mt-4 pt-3">
                        <p class="mb-0">Lorem ipsum dolor sit amet elit. Sed efficitur quis purus ut interdum aliquam dolor eget urna. Nam volutpat libero sit amet leo cursus, ac viverra eros morbi quis quam mi.</p>
                    </div>
                </div>
                <div class="testimonial-item border p-4">
                    <div class=" d-flex align-items-center">
                        <div class="">
                            <img src="img/testimonial-3.jpg" alt="">
                        </div>
                        <div class="ms-4">
                            <h4 class="text-secondary">Nom du client</h4>
                            <p class="m-0 pb-3">Profession</p>
                            <div class="d-flex pe-5">
                                <i class="fas fa-star me-1 text-primary"></i>
                                <i class="fas fa-star me-1 text-primary"></i>
                                <i class="fas fa-star me-1 text-primary"></i>
                                <i class="fas fa-star me-1 text-primary"></i>
                                <i class="fas fa-star me-1 text-primary"></i>
                            </div>
                        </div>
                    </div>
                    <div class="border-top mt-4 pt-3">
                        <p class="mb-0">Lorem ipsum dolor sit amet elit. Sed efficitur quis purus ut interdum aliquam dolor eget urna. Nam volutpat libero sit amet leo cursus, ac viverra eros morbi quis quam mi.</p>
                    </div>
                </div>
                <div class="testimonial-item border p-4">
                    <div class=" d-flex align-items-center">
                        <div class="">
                            <img src="img/testimonial-4.jpg" alt="">
                        </div>
                        <div class="ms-4">
                            <h4 class="text-secondary">Nom du client</h4>
                            <p class="m-0 pb-3">Profession</p>
                            <div class="d-flex pe-5">
                                <i class="fas fa-star me-1 text-primary"></i>
                                <i class="fas fa-star me-1 text-primary"></i>
                                <i class="fas fa-star me-1 text-primary"></i>
                                <i class="fas fa-star me-1 text-primary"></i>
                                <i class="fas fa-star me-1 text-primary"></i>
                            </div>
                        </div>
                    </div>
                    <div class="border-top mt-4 pt-3">
                        <p class="mb-0">Lorem ipsum dolor sit amet elit. Sed efficitur quis purus ut interdum aliquam dolor eget urna. Nam volutpat libero sit amet leo cursus, ac viverra eros morbi quis quam mi.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonial End -->


    <!-- Contact Start -->
    <div class="container-fluid py-5 mb-5">
        <div class="container">
            <div class="text-center mx-auto pb-5 wow fadeIn" data-wow-delay=".3s" style="max-width: 600px;">
                <h5 class="text-primary">Get In Touch</h5>
                <h1 class="mb-3">Contact for any query</h1>
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif
            </div>
            <div class="contact-detail position-relative p-5">
                <div class="row g-5 mb-5 justify-content-center">
                    <div class="col-xl-4 col-lg-6 wow fadeIn" data-wow-delay=".3s">
                        <div class="d-flex bg-light p-3 rounded">
                            <div class="flex-shrink-0 btn-square bg-secondary rounded-circle" style="width: 64px; height: 64px;">
                                <i class="fas fa-map-marker-alt text-white"></i>
                            </div>
                            <div class="ms-3">
                                <h4 class="text-primary">Address</h4>
                                <a href="https://goo.gl/maps/Zd4BCynmTb98ivUJ6" target="_blank" class="h5">171 route de bezons 78420 carrières sur Seine</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 wow fadeIn" data-wow-delay=".5s">
                        <div class="d-flex bg-light p-3 rounded">
                            <div class="flex-shrink-0 btn-square bg-secondary rounded-circle" style="width: 64px; height: 64px;">
                                <i class="fa fa-phone text-white"></i>
                            </div>
                            <div class="ms-3">
                                <h4 class="text-primary">Call Us</h4>
                                <a class="h5" href="tel:+330948160487" target="_blank">+33 0948160487</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 wow fadeIn" data-wow-delay=".7s">
                        <div class="d-flex bg-light p-3 rounded">
                            <div class="flex-shrink-0 btn-square bg-secondary rounded-circle" style="width: 64px; height: 64px;">
                                <i class="fa fa-envelope text-white"></i>
                            </div>
                            <div class="ms-3">
                                <h4 class="text-primary">Email Us</h4>
                                <a class="h5" href="mailto:commercial@eco-call.fr" target="_blank">commercial@eco-call.fr</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-5">
                    <div class="col-lg-6 wow fadeIn" data-wow-delay=".3s">
                        <div class="p-5 h-100 rounded contact-map">
                                <iframe class="rounded w-100 h-100"  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2622.102419139038!2d2.1990053!3d48.9134409!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xa5cd521a7a2aeb3%3A0x53a81c81da566b1a!2sEco%20Call!5e0!3m2!1sfr!2stn!4v1753705033700!5m2!1sfr!2stn" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                    <div class="col-lg-6 wow fadeIn" data-wow-delay=".5s">
                        <form method="POST" action="{{ route('contact.store') }}" class="p-5 rounded contact-form">
                                @csrf
                                <div class="mb-4">
                                    <input type="text" class="form-control border-0 py-3" name="name" placeholder="Your Name">
                                </div>
                                <div class="mb-4">
                                    <input type="email" class="form-control border-0 py-3" name="email" placeholder="Your Email">
                                </div>
                                <div class="mb-4">
                                    <input type="text" class="form-control border-0 py-3" name="subject" placeholder="Project">
                                </div>
                                <div class="mb-4">
                                    <textarea class="w-100 form-control border-0 py-3" name="message" rows="6" cols="10" placeholder="Message"></textarea>
                                </div>
                                <div class="text-start">
                                    <button class="btn bg-primary text-white py-3 px-5" type="submit">Send Message</button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->

    <script>
    document.addEventListener("DOMContentLoaded", () => {
    const donut = document.querySelector(".hero-donut");
    const imageDiv = donut.querySelector(".donut-image");
    const banners = JSON.parse(donut.dataset.banners || "[]");

    let index = 0;

    function updateBanner() {
        if (banners.length > 0) {
        const banner = banners[index];
        imageDiv.style.backgroundImage = `url('/storage/${banner.image}')`;
        // on pourrait aussi mettre à jour le texte titre / résumé ici
        }
    }

    donut.querySelector(".hero-nav.prev").addEventListener("click", () => {
        index = (index - 1 + banners.length) % banners.length;
        updateBanner();
    });

    donut.querySelector(".hero-nav.next").addEventListener("click", () => {
        index = (index + 1) % banners.length;
        updateBanner();
    });

    updateBanner();
    });
    </script>


@endsection
