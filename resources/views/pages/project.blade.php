@extends('layouts.app')

@section('title', 'Nos projets')

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5">
        <div class="container text-center py-5">
            <h1 class="display-2 text-white mb-4 animated slideInDown">Projets</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                    <li class="breadcrumb-item"><a href="#">Pages</a></li>
                    <li class="breadcrumb-item" aria-current="page">Projets</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->
     
    <!-- Fact Start -->
    <div class="container-fluid bg-secondary py-5">
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
    </div>
    <!-- Fact End -->

    <!-- Project Start -->
    <div class="container-fluid project py-5 my-5">
        <div class="container py-5">
            <div class="text-center mx-auto pb-5 wow fadeIn" data-wow-delay=".3s" style="max-width: 600px;">
                <h5 class="text-primary">Nos projets</h5>
                <h1>Nos projets récemment réalisés</h1>
            </div>
            <div class="row g-5">
                @forelse($projects as $project)
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay=".{{ $loop->index % 3 * 0.2 + 0.3 }}s">
                    <div class="project-item">
                        <div class="project-img" style="height: 250px; overflow: hidden;">
                            @if($project->image)
                                <img src="{{ asset('storage/' . $project->image) }}" class="img-fluid w-100 h-100 object-fit-cover rounded" alt="{{ $project->name }}" style="object-position: center;">
                            @else
                                <img src="{{ asset('img/default-project.jpg') }}" class="img-fluid w-100 h-100 object-fit-cover rounded" alt="Default Project Image" style="object-position: center;">
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
                @empty
                <p class="lead">Aucun projet disponible pour le moment.</p>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Project End -->
@endsection
