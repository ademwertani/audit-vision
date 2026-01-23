@extends('layouts.app')

@section('title', 'Contactez-nous')

@section('content')
    <!-- Fact Start -->
    <div class="container-fluid bg-secondary py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 wow fadeIn" data-wow-delay=".1s">
                    <div class="d-flex counter">
                        <h1 class="me-3 text-primary counter-value">99</h1>
                        <h5 class="text-white mt-1">Success in getting happy customer</h5>
                    </div>
                </div>
                <div class="col-lg-3 wow fadeIn" data-wow-delay=".3s">
                    <div class="d-flex counter">
                        <h1 class="me-3 text-primary counter-value">25</h1>
                        <h5 class="text-white mt-1">Thousands of successful business</h5>
                    </div>
                </div>
                <div class="col-lg-3 wow fadeIn" data-wow-delay=".5s">
                    <div class="d-flex counter">
                        <h1 class="me-3 text-primary counter-value">120</h1>
                        <h5 class="text-white mt-1">Total clients who love EcoCall</h5>
                    </div>
                </div>
                <div class="col-lg-3 wow fadeIn" data-wow-delay=".7s">
                    <div class="d-flex counter">
                        <h1 class="me-3 text-primary counter-value">5</h1>
                        <h5 class="text-white mt-1">Stars reviews given by satisfied clients</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fact End -->


    <!-- Contact Start -->
    <div class="container-fluid py-5 mt-5">
        <div class="container py-5">
            <div class="text-center mx-auto pb-5 wow fadeIn" data-wow-delay=".3s" style="max-width: 700px;">
                <h5 class="text-primary">Contactez-nous</h5>
                <h1 class="mb-3">Nous sommes à votre écoute</h1>
                <p class="mb-2">
                    AUDIT VISION – Bureau d’Études Énergétiques<br>
                    38 Avenue Villemain – 75014 Paris<br>
                    SIREN : 982 511 644<br>
                    Assurance RC Pro : Markel Insurance SE, contrat conforme à la qualification OPQIBI 1911
                    et aux normes NF EN 16247-1 et NF EN 16247-2.
                </p>
            </div>

            {{-- Messages flash / erreurs --}}
            @if(session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="contact-detail position-relative p-5">
                <div class="row g-5 mb-5 justify-content-center">
{{-- MAP --}}
<div class="col-lg-6 wow fadeIn" data-wow-delay=".3s">
    <div class="p-5 h-100 rounded contact-map">
        <iframe
            class="rounded w-100 h-100"
            src="https://www.google.com/maps?q=38+Avenue+Villemain+75014+Paris&output=embed"
            style="border:0;"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
</div>

{{-- Adresse --}}
<div class="col-xl-4 col-lg-6 wow fadeIn" data-wow-delay=".5s">
    <div class="d-flex bg-light p-3 rounded">
        <div class="flex-shrink-0 btn-square bg-secondary rounded-circle" style="width: 64px; height: 64px;">
            <i class="fas fa-map-marker-alt text-white"></i>
        </div>
        <div class="ms-3">
            <h4 class="text-primary">Adresse</h4>
            <p class="h5 d-block">
                38 Avenue Villemain – 75014 Paris
            </p>
            <small class="text-muted d-block">
                AUDIT VISION – Bureau d’Études Énergétiques
            </small>
        </div>
    </div>
</div>


                    {{-- Téléphone (à adapter) --}}
                    <div class="col-xl-4 col-lg-6 wow fadeIn" data-wow-delay=".5s">
                        <div class="d-flex bg-light p-3 rounded">
                            <div class="flex-shrink-0 btn-square bg-secondary rounded-circle" style="width: 64px; height: 64px;">
                                <i class="fa fa-phone text-white"></i>
                            </div>
                            <div class="ms-3">
                                <h4 class="text-primary">Téléphone</h4>
                                {{-- ⚠️ Mets ici le vrai numéro --}}
                                <a class="h5" href="tel:+33123456789" target="_blank">+33 1 23 45 67 89</a>
                            </div>
                        </div>
                    </div>

                    {{-- Email (à adapter) --}}
                    <div class="col-xl-4 col-lg-6 wow fadeIn" data-wow-delay=".7s">
                        <div class="d-flex bg-light p-3 rounded">
                            <div class="flex-shrink-0 btn-square bg-secondary rounded-circle" style="width: 64px; height: 64px;">
                                <i class="fa fa-envelope text-white"></i>
                            </div>
                            <div class="ms-3">
                                <h4 class="text-primary">Email</h4>
                                {{-- ⚠️ Mets ici le vrai mail --}}
                                <a class="h5" href="mailto:contact@auditvision.fr" target="_blank">
                                    contact@auditvision.fr
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-5">
                    {{-- MAP --}}
                    <div class="col-lg-6 wow fadeIn" data-wow-delay=".3s">
                        <div class="p-5 h-100 rounded contact-map">
                            <iframe
                                class="rounded w-100 h-100"
                                src="https://www.google.com/maps?q=38%20Avenue%20Villemain%2075014%20Paris&output=embed"
                                style="border:0;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>

                    {{-- FORM --}}
                    <div class="col-lg-6 wow fadeIn" data-wow-delay=".5s">
                        <div class="p-5 rounded contact-form">
                            <form method="POST" action="{{ route('contact.store') }}">
                                @csrf

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <input
                                            type="text"
                                            name="first_name"
                                            class="form-control border-0 py-3 @error('first_name') is-invalid @enderror"
                                            placeholder="Prénom"
                                            value="{{ old('first_name') }}"
                                            required>
                                        @error('first_name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <input
                                            type="text"
                                            name="last_name"
                                            class="form-control border-0 py-3 @error('last_name') is-invalid @enderror"
                                            placeholder="Nom"
                                            value="{{ old('last_name') }}"
                                            required>
                                        @error('last_name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <input
                                            type="email"
                                            name="email"
                                            class="form-control border-0 py-3 @error('email') is-invalid @enderror"
                                            placeholder="Votre Email"
                                            value="{{ old('email') }}"
                                            required>
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <input
                                            type="text"
                                            name="phone"
                                            class="form-control border-0 py-3 @error('phone') is-invalid @enderror"
                                            placeholder="Téléphone (optionnel)"
                                            value="{{ old('phone') }}">
                                        @error('phone')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <input
                                            type="text"
                                            name="company"
                                            class="form-control border-0 py-3 @error('company') is-invalid @enderror"
                                            placeholder="Société (optionnel)"
                                            value="{{ old('company') }}">
                                        @error('company')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <input
                                            type="text"
                                            name="city"
                                            class="form-control border-0 py-3 @error('city') is-invalid @enderror"
                                            placeholder="Ville (optionnel)"
                                            value="{{ old('city') }}">
                                        @error('city')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <input
                                            type="text"
                                            name="subject"
                                            class="form-control border-0 py-3 @error('subject') is-invalid @enderror"
                                            placeholder="Sujet de votre demande"
                                            value="{{ old('subject') }}">
                                        @error('subject')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <textarea
                                            name="message"
                                            rows="6"
                                            class="w-100 form-control border-0 py-3 @error('message') is-invalid @enderror"
                                            placeholder="Votre message..."
                                            required>{{ old('message') }}</textarea>
                                        @error('message')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-12 text-start mt-2">
                                        <button class="btn bg-primary text-white py-3 px-5" type="submit">
                                            Envoyer le message
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->
@endsection
