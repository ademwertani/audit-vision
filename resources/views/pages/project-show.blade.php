@extends('layouts.app')

@section('title', $project->name . ' | Nos projets')

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5">
        <div class="container text-center py-5">
            <h1 class="display-2 text-white mb-4 animated slideInDown">{{ $project->name }}</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Projets</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $project->name }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Project Details Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-5 wow fadeIn" data-wow-delay=".3s">
                    @if($project->image)
                    <div class="position-relative h-100">
                        <img src="{{ asset('storage/' . $project->image) }}" class="img-fluid rounded" alt="{{ $project->name }}" style="object-fit: cover; height: 100%; width: 100%;">
                    </div>
                    @else
                    <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 100%;">
                        <i class="fa fa-image fa-10x text-primary"></i>
                    </div>
                    @endif
                </div>
                <div class="col-lg-7 wow fadeIn" data-wow-delay=".5s">
                    <div class="h-100">
                        <h2 class="mb-4">{{ $project->name }}</h2>
                        <h5 class="text-primary mb-4">{{ $project->summary }}</h5>
                        <p class="mb-4">{!! nl2br(e($project->description)) !!}</p>

                        <div class="d-flex align-items-center pt-4">
                            <a href="{{ route('projects.index') }}" class="btn btn-primary px-4 me-3">
                                <i class="fas fa-arrow-left me-2"></i> Retour aux projets
                            </a>
                            <a href="#" class="btn btn-outline-primary px-4">
                                <i class="fas fa-phone-alt me-2"></i> Contactez-nous
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Project Details End -->
@endsection
