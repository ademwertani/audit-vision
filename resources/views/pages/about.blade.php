@extends('layouts.app')

@section('title', 'À propos de nous')

@section('content')
    <!-- En-tête de Page Début -->
    <div class="container-fluid page-header py-5">
        <div class="container text-center py-5">
            <h1 class="display-2 text-white mb-4 animated slideInDown">À propos de nous</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                    <li class="breadcrumb-item"><a href="#">Pages</a></li>
                    <li class="breadcrumb-item active" aria-current="page">À propos</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- En-tête de Page Fin -->

    <!-- Statistiques Début -->
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
                        <h5 class="text-white mt-1">Formations professionnelles dispensées</h5>
                    </div>
                </div>
                <div class="col-lg-3 wow fadeIn" data-wow-delay=".5s">
                    <div class="d-flex counter">
                        <h1 class="me-3 text-primary counter-value">120</h1>
                        <h5 class="text-white mt-1">Collaborateurs formés avec succès</h5>
                    </div>
                </div>
                <div class="col-lg-3 wow fadeIn" data-wow-delay=".7s">
                    <div class="d-flex counter">
                        <h1 class="me-3 text-primary counter-value">5</h1>
                        <h5 class="text-white mt-1">Étoiles de satisfaction moyenne</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Statistiques Fin -->

    <!-- À propos Début -->
    <div class="container-fluid py-5 my-5">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-5 col-md-6 col-sm-12 wow fadeIn" data-wow-delay=".3s">
                    <div class="h-100 position-relative">
                        <img src="img/about-1.jpg" class="img-fluid w-75 rounded" alt="" style="margin-bottom: 25%;">
                        <div class="position-absolute w-75" style="top: 25%; left: 25%;">
                            <img src="img/about-2.jpg" class="img-fluid w-100 rounded" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-6 col-sm-12 wow fadeIn" data-wow-delay=".5s">
                    <h5 class="text-primary">Qui sommes-nous ?</h5>
                    <h1 class="mb-4">EcoCall, votre partenaire en formation et relation client</h1>
                    <p>EcoCall est un centre de formation et de services dédié à l'excellence dans le domaine du call center. Nous accompagnons les entreprises et les particuliers dans le développement de leurs compétences en relation client, gestion des appels, communication commerciale et outils CRM.</p>
                    <p class="mb-4">Grâce à des formateurs expérimentés et des modules adaptés aux exigences du marché, nous garantissons une montée en compétence rapide et efficace. Notre objectif est de professionnaliser les métiers de la relation client à travers une pédagogie moderne et des cas pratiques réels.</p>
                    <a href="{{ url('/formation') }}" class="btn btn-secondary rounded-pill px-5 py-3 text-white">Voir nos formations</a>
                </div>
            </div>
        </div>
    </div>
    <!-- À propos Fin -->

    <!-- Équipe Début -->
    <div class="container-fluid pb-5 mb-5 team">
        <div class="container pb-5">
            <div class="text-center mx-auto pb-5 wow fadeIn" data-wow-delay=".3s" style="max-width: 600px;">
                <h5 class="text-primary">Notre équipe</h5>
                <h1>Rencontrez nos formateurs experts</h1>
            </div>
            <div class="owl-carousel team-carousel wow fadeIn" data-wow-delay=".5s">
                <!-- Exemple membre d'équipe -->
                <div class="rounded team-item">
                    <div class="team-content">
                        <div class="team-img-icon">
                            <div class="team-img rounded-circle">
                                <img src="img/team-1.jpg" class="img-fluid w-100 rounded-circle" alt="Photo membre équipe">
                            </div>
                            <div class="team-name text-center py-3">
                                <h4>Ahmed Ben Salem</h4>
                                <p class="m-0">Formateur en télécommunication</p>
                            </div>
                            <div class="team-icon d-flex justify-content-center pb-4">
                                <a class="btn btn-square btn-secondary text-white rounded-circle m-1" href="#"><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square btn-secondary text-white rounded-circle m-1" href="#"><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square btn-secondary text-white rounded-circle m-1" href="#"><i class="fab fa-instagram"></i></a>
                                <a class="btn btn-square btn-secondary text-white rounded-circle m-1" href="#"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Répéter pour autres membres si nécessaire -->
            </div>
        </div>
    </div>
    <!-- Équipe Fin -->
@endsection