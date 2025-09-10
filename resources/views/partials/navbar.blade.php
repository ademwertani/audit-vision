@php
use Illuminate\Support\Str;
@endphp

<div class="container-fluid bg-primary">
    <div class="container">
        <nav class="navbar navbar-dark navbar-expand-lg py-0">
            <a href="{{ url('/') }}" class="navbar-brand">
                @if($about && $about->logo)
             <img src="{{ asset('storage/about/' . basename($about->logo)) }}" alt="EcoCall Logo" style="height: 100px;">
                @else
                    <h1 class="text-white fw-bold d-block">Eco<span class="text-secondary">Call</span></h1>
                @endif
            </a>
            <button type="button" class="navbar-toggler me-0" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse bg-transparent" id="navbarCollapse">
                <div class="navbar-nav ms-auto mx-xl-auto p-0">
                    <!-- Home -->
                    <a href="{{ url('/') }}" class="nav-item nav-link {{ Request::is('/') ? 'active' : '' }}">Accueil</a>

                    <!-- About -->
                    <a href="{{ url('/about') }}" class="nav-item nav-link {{ Request::is('about') ? 'active' : '' }}">À propos</a>

                    <!-- Services -->
                    <div class="nav-item dropdown">
                        <a href="{{ url('/services') }}" class="nav-link dropdown-toggle {{ Request::is('services') || Request::is('services/*') ? 'active' : '' }}" data-bs-toggle="dropdown">Services</a>
                        <div class="dropdown-menu rounded">
                            @foreach($services as $service)
                                <a href="{{ route('services.show', $service->id) }}" class="dropdown-item {{ Request::is('services/'.$service->id) ? 'active' : '' }}">
                                    {{ $service->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Projects -->
                    <a href="{{ route('projects.index') }}" class="nav-item nav-link {{ Request::is('projects') || Request::is('projects/*') ? 'active' : '' }}">Projets</a>

                    <!-- Pages Dropdown -->
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle {{ Request::is('blog') || Request::is('team') || Request::is('testimonials') || Request::is('404') ? 'active' : '' }}" data-bs-toggle="dropdown">Pages</a>
                        <div class="dropdown-menu rounded">
                            <a href="{{ url('/blog') }}" class="dropdown-item {{ Request::is('blog') ? 'active' : '' }}">Notre Blog</a>
                            <a href="{{ url('/team') }}" class="dropdown-item {{ Request::is('team') ? 'active' : '' }}">Notre Équipe</a>
                            <a href="{{ url('/testimonials') }}" class="dropdown-item {{ Request::is('testimonials') ? 'active' : '' }}">Témoignages</a>
                            <a href="{{ url('/404') }}" class="dropdown-item {{ Request::is('404') ? 'active' : '' }}">Page 404</a>
                        </div>
                    </div>

                    <!-- Contact -->
                    <a href="{{ url('/contact') }}" class="nav-item nav-link {{ Request::is('contact') ? 'active' : '' }}">Contact</a>
                </div>
            </div>

            <!-- Additional Info -->
            <div class="d-none d-xl-flex flex-shrink-0">
                <div id="phone-tada" class="d-flex align-items-center justify-content-center me-4">
                    <a href="tel:{{ $about->phone ?? '' }}" class="position-relative animated tada infinite">
                        <i class="fa fa-phone-alt text-white fa-2x"></i>
                        <div class="position-absolute" style="top: -7px; left: 20px;">
                            <span><i class="fa fa-comment-dots text-secondary"></i></span>
                        </div>
                    </a>
                </div>
                <div class="d-flex flex-column pe-4 border-end">
                    <span class="text-white-50">Des questions&nbsp;?</span>
                    <span class="text-secondary">
                        Appelez&nbsp;: {{ $about->phone ?? '+ 0123 456 7890' }}
                    </span>
                </div>
                
            </div>
        </nav>
    </div>
</div>