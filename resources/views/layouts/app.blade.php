<!DOCTYPE html>
<html lang="fr">
<head>
  <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>@yield('title', 'Audit vision - Energize Society Reliable Energy')</title>
  <meta name="keywords" content="renewable energy, solar, electrical services, energy solutions">
  <meta name="description"
    content="Audit vision - Leading renewable energy solutions provider revolutionizing sustainable energy sources worldwide.">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Saira:wght@500;600;700;800&display=swap"
    rel="stylesheet">
  <!-- Icons (une seule fois) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Libs -->
  <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
  <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
  <!-- CSS site -->
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/base.css') }}" rel="stylesheet">
  <link href="{{ asset('css/topbar.css') }}" rel="stylesheet">
  <link href="{{ asset('css/navbar.css') }}" rel="stylesheet">
  <link href="{{ asset('css/hero.css') }}" rel="stylesheet">
  <link href="{{ asset('css/sections.css') }}" rel="stylesheet">
</head>
<body>
  @include('partials.spinner')
  @include('partials.navbar')
  @include('partials.page-header')

  <main>
    @yield('content')
  </main>
  @include('partials.chatbot-widget')
  @include('partials.footer')
  <!-- JavaScript Libraries -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('lib/wow/wow.min.js') }}"></script>
  <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
  <script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
  <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
  <!-- Template Javascript -->
  <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>