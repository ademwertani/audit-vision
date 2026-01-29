@extends('layouts.app')

@section('title', 'Audit Vision - Accueil')

@section('content')

@php
    // Préparer les slides à partir des bannières
    $slides = $banners->map(function ($b) {
        return [
            'title'   => $b->title,
            'summary' => $b->summary,
            'image'   => !empty($b->image)
                ? asset('storage/' . ltrim($b->image, '/'))
                : asset('img/green.png'),
        ];
    });

    $firstSlide = $slides->first();

    // Préparer les vidéos (titre + description + url + embed_url)
    $videos = $videos ?? collect();

    $videoSlides = $videos->map(function ($v) {
        $url = $v->url ?? '';
        $videoId = null;

        if ($url) {
            $parts = parse_url($url);

            // cas https://www.youtube.com/watch?v=XXXX
            if (!empty($parts['query'])) {
                parse_str($parts['query'], $q);
                if (!empty($q['v'])) {
                    $videoId = $q['v'];
                }
            }

            // cas https://youtu.be/XXXX
            if (!$videoId && !empty($parts['host']) && str_contains($parts['host'], 'youtu') && !empty($parts['path'])) {
                $path = trim($parts['path'], '/');
                if ($path && strlen($path) >= 8) {
                    $videoId = $path;
                }
            }
        }

        $embedUrl = $videoId ? 'https://www.youtube.com/embed/' . $videoId : '';

        return [
            'title'       => $v->title ?? '',
            'description' => $v->description ?? '',
            'url'         => $url,
            'embed_url'   => $embedUrl,
        ];
    });

    $firstVideo = $videoSlides->first();
@endphp

{{-- ================= HERO BANDEAU (bannières dynamiques) ================= --}}


{{-- =============== QUI SOMMES-NOUS ? =============== --}}
<section class="qs-av py-5">
    <div class="container">
        <div class="qs-inner mx-auto">
            <h2 class="qs-title">Qui Sommes-Nous ?</h2>

            <p class="qs-text">
                AuditVision est un bureau d’études indépendant en génie énergétique, implanté en France, dédié à l’accompagnement des acteurs du tertiaire,
                de l’habitat collectif, des collectivités territoriales et du secteur industriel.
            </p>

            <p class="qs-text">
                Le cabinet intervient à chaque étape des projets d’amélioration de la performance énergétique, environnementale et économique des bâtiments et des procédés,
                en intégrant pleinement les exigences réglementaires, les contraintes techniques et les enjeux stratégiques liés à la transition énergétique et à la décarbonation.
            </p>

            <p class="qs-text qs-text--bold">
                L’approche d’AuditVision s’appuie sur :
            </p>

            <p class="qs-text">
                • une expertise technique approfondie en génie énergétique,<br>
                • une parfaite maîtrise des cadres réglementaires français et européens,<br>
                • une vision globale orientée performance énergétique durable et réduction de l’empreinte carbone.
            </p>

            <p class="qs-text">
                AuditVision se positionne comme un partenaire de confiance, capable de transformer les obligations réglementaires et énergétiques
                en véritables leviers de performance, de compétitivité et de durabilité pour ses clients.
            </p>

            <div class="qs-btn-wrap">
                <a href="{{ url('/about') }}" class="btn qs-btn">Your More</a>
            </div>
        </div>
    </div>
</section>

{{-- =============== MÉTHODOLOGIES =============== --}}
<section class="method-av py-5">
    <div class="container">
        <div class="method-inner mx-auto text-center">

            <h2 class="method-title">Méthodologies</h2>
            <p class="method-subtitle">
                Notre approche rigoureuse garantit des audits fiables, objectifs et conformes aux standards réglementaires.
            </p>

            <div class="method-image-wrap">
                <img 
                    src="{{ asset('img/www.jpeg') }}" 
                    alt="Méthodologies Audit Vision" 
                    class="method-img">
            </div>

        </div>
    </div>
</section>

{{-- =============== BLOG (CARDS COMME LA MAQUETTE) =============== --}}
@if($blogs->isNotEmpty())
<section class="home-blog py-5">
    <div class="container">
        {{-- Titre + pill verte --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
            <h2 class="home-blog-title mb-0">Blog</h2>
            <a href="{{ route('blog.index') }}" class="home-blog-pill">
                Voir tous les articles
            </a>
        </div>

        <div class="row g-4">
            @foreach($blogs as $blog)
                <div class="col-12 col-sm-6 col-lg-3">
                    <article class="home-blog-card">
                        {{-- Image --}}
                        <a href="{{ route('blog.show', $blog->slug) }}" class="home-blog-thumb-link">
                            @if(!empty($blog->image))
                                <div class="home-blog-thumb has-image">
                                    <img src="{{ asset('storage/' . ltrim($blog->image, '/')) }}"
                                         alt="{{ $blog->title }}">
                                </div>
                            @else
                                <div class="home-blog-thumb placeholder"></div>
                            @endif
                        </a>

                        {{-- Contenu carte --}}
                        <div class="home-blog-body">
                            <div class="home-blog-tag">LOREM IPSU</div>

                            <h3 class="home-blog-card-title">
                                <a href="{{ route('blog.show', $blog->slug) }}">
                                    {{ $blog->title }}
                                </a>
                            </h3>

                            @php
                                $excerpt = $blog->summary ?? $blog->excerpt ?? null;
                                if (!$excerpt && !empty($blog->content)) {
                                    $excerpt = \Illuminate\Support\Str::limit(strip_tags($blog->content), 80);
                                } elseif ($excerpt) {
                                    $excerpt = \Illuminate\Support\Str::limit($excerpt, 80);
                                }
                            @endphp

                            @if(!empty($excerpt))
                                <p class="home-blog-card-excerpt">{{ $excerpt }}</p>
                            @endif

                            <a href="{{ route('blog.show', $blog->slug) }}" class="home-blog-more">
                                Your More
                            </a>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- =============== ACTUALITÉ (NOUVEAUTÉ DE DOMAINE) =============== --}}
@if($videoSlides->isNotEmpty())
<section class="news-av py-5">
    <div class="container">
        {{-- Titre de section --}}
        <div class="text-center mb-5">
            <h2 class="news-title">Actualité ( Nouveauté De Domaine )</h2>
        </div>

        <div class="row align-items-center">
            {{-- Texte --}}
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h3 class="news-video-title" id="videoTitle">
                    {{ $firstVideo['title'] ?? '' }}
                </h3>
                <p class="news-video-desc" id="videoDescription">
                    {{ $firstVideo['description'] ?? '' }}
                </p>
            </div>

            {{-- Vidéo --}}
            <div class="col-lg-6">
                @if(!empty($firstVideo['embed_url']))
                    <div class="news-video-frame">
                        <iframe
                            id="videoIframe"
                            src="{{ $firstVideo['embed_url'] }}"
                            title="YouTube video player"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen
                        ></iframe>
                    </div>
                @else
                    <div class="news-video-box">
                        <div class="news-video-placeholder"></div>
                        <div class="news-video-play">
                            <i class="fas fa-play"></i>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Petits points indicateurs --}}
        <div class="news-dots text-center mt-4">
            @foreach($videoSlides as $idx => $v)
                <span class="news-dot {{ $idx === 0 ? 'active' : '' }}" data-index="{{ $idx }}"></span>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- =============== PROJETS (UNE GAMME COMPLÈTE DE PRESTATION) =============== --}}
@if($projects->isNotEmpty())
<section class="projects-av py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="projects-title">Une Gamme complète de prestation</h2>
        </div>

        <div class="projects-list">
            @foreach($projects as $index => $project)
                <div class="project-row row align-items-center mb-4 mb-lg-5">
                    {{-- Image : gauche / droite en alternance --}}
                    <div class="col-lg-6 {{ $index % 2 === 1 ? 'order-lg-2' : '' }}">
                        <div class="project-image-wrapper">
                            @if($project->image)
                                <img
                                    src="{{ asset('storage/' . $project->image) }}"
                                    alt="{{ $project->name }}"
                                    class="project-image img-fluid">
                            @else
                                <div class="project-image placeholder d-flex align-items-center justify-content-center">
                                    <span class="text-muted">Aucune image</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Texte --}}
                    <div class="col-lg-6 {{ $index % 2 === 1 ? 'order-lg-1' : '' }}">
                        <div class="project-text">
                            <h3 class="project-name">{{ $project->name }}</h3>
                            <p class="project-summary">{{ $project->summary }}</p>
                            <a href="{{ route('projects.show', $project) }}" class="btn project-btn">
                                Lire la suite
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif


{{-- =============== PARTENAIRES (NOS PARTENAIRES) =============== --}}
@if($partners->isNotEmpty())
<style>
/* =========================================================
   SECTION PARTENAIRES – Version blanche & clean
   ========================================================= */
/* ===============================
   MÉTHODOLOGIES – AuditVision
   =============================== */
.method-av {
    padding-top: 70px;
    padding-bottom: 70px;
}

.method-title {
    font-size: 38px;
    font-weight: 800;
    text-align: center;
    margin-bottom: 16px;
    color: #0b172f;
}

.method-subtitle {
    font-size: 18px;
    text-align: center;
    max-width: 680px;
    margin: 0 auto 40px;
    color: #4a5568;
}

.method-image-wrap {
    max-width: 920px;
    margin: 0 auto;
    border-radius: 26px;
    overflow: hidden;
    box-shadow: 0 18px 40px rgba(15, 23, 42, 0.12);
}

.method-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transform: scale(1.04);
    transition: transform 0.6s ease;
}

/* Hover effect (subtle zoom) */
.method-image-wrap:hover .method-img {
    transform: scale(1.10);
}

.partners-av{
    padding: 60px 0 70px;
    background:#ffffff; /* SECTION BLANCHE */
}

/* Titre clean */
.partners-title{
    font-family: "Epilogue", system-ui, -apple-system, Segoe UI, Roboto, Arial;
    font-weight: 800;
    font-size: clamp(24px, 3vw, 32px);
    color: #0f172a;
}

/* Bande colorée sous le titre */
.partners-title::after{
    content:"";
    display:block;
    margin:10px auto 0;
    width:60px;
    height:3px;
    border-radius:999px;
    background:linear-gradient(90deg,#7CAE2A,#4f46e5);
}

/* Orbit */
.partners-orbit{
    margin-top: 48px;
    display:flex;
    justify-content:center;
    align-items:flex-end;
    gap:22px;
    flex-wrap:wrap;
}

/* ========== ANIMATIONS ========== */
@keyframes partnerEnter {
    from {
        opacity:0;
        transform: translateY(20px) scale(0.9);
    }
    to {
        opacity:1;
        transform: translateY(0) scale(1);
    }
}

@keyframes partnerLogoFloat {
    0%   { transform: scale(1); }
    50%  { transform: scale(1.02); }
    100% { transform: scale(1); }
}
.partner-card:hover{
    transform: translateY(-5px) scale(1.03);
}
.partner-card{
    background:#ffffff;
    border-radius:26px;
    overflow:hidden;
    position:relative;

    max-width: 280px;
    width: 100%;
    aspect-ratio: 4/3;

    padding: 12px;   /* 🔥 image légèrement plus petite */

    display:flex;
    align-items:center;
    justify-content:center;

    opacity:0;
    transform: translateY(20px) scale(0.9);
    animation: partnerEnter 0.7s ease forwards;

    transition: transform .25s ease;
}

/* Image légèrement plus petite */
.partner-card img{
    width:100%;
    height:100%;
    object-fit:contain;   /* 🔥 garde la taille plus petite */
    border-radius:20px;   /* léger arrondi interne */
    animation: partnerLogoFloat 4s ease-in-out infinite;
}
/* 4 cartes sur le premier rang + 4 sur le second */
.partners-two-rows{
    display: grid;
    grid-template-columns: repeat(4, 1fr); /* 🔥 4 في كل صف */
    gap: 26px;
    width: 100%;
    margin: 0 auto;
}

/* Card blanche propre */
.partner-card{
    background: #ffffff;
    border-radius: 26px;
    overflow: hidden;
    border: 1px solid #e5e7eb;

    aspect-ratio: 4/3; /* même taille pour tous */
    padding: 18px;     /* الصورة أصغر داخل الكرت */

    display: flex;
    align-items: center;
    justify-content: center;

    transition: transform .25s ease;
}

/* Hover léger */
.partner-card:hover{
    transform: scale(1.05);
}

/* Image plus petite à l'intérieur */
.partner-card img{
    width: 100%;
    height: 100%;
    object-fit: contain; /* 🔥 الصورة تبقى petite */
    border-radius: 20px;
}

/* Responsive */
@media (max-width: 992px){
    .partners-two-rows{
        grid-template-columns: repeat(3, 1fr);
    }
}
@media (max-width: 768px){
    .partners-two-rows{
        grid-template-columns: repeat(2, 1fr);
    }
}
@media (max-width: 480px){
    .partners-two-rows{
        grid-template-columns: repeat(1, 1fr);
    }
}

/* ========== ARC (positions) ========== */
.partner-card.pos-center{ margin-top:0; z-index:3; }
.partner-card.pos-l1,
.partner-card.pos-r1{ margin-top:12px; z-index:2; }
.partner-card.pos-l2,
.partner-card.pos-r2{ margin-top:22px; z-index:1; }

/* ========== Animation staggée ========== */
.partners-orbit .partner-card:nth-child(1){ animation-delay:0s; }
.partners-orbit .partner-card:nth-child(2){ animation-delay:.07s; }
.partners-orbit .partner-card:nth-child(3){ animation-delay:.14s; }
.partners-orbit .partner-card:nth-child(4){ animation-delay:.21s; }
.partners-orbit .partner-card:nth-child(5){ animation-delay:.28s; }

/* Responsive */
@media(max-width:768px){
    .partner-card{
        max-width: 180px;
    }
}
</style>



<section class="partners-av py-5"> 
    <div class="container">
        <h2 class="partners-title text-center mb-5">Nos Partenaires</h2>

        <div class="partners-two-rows">
            @foreach($partners->take(8) as $partner)
                <div class="partner-card">
                    <img src="{{ asset('storage/' . ltrim($partner->logo, '/')) }}"
                         alt="{{ $partner->name }}">
                </div>
            @endforeach
        </div>
    </div>
</section>


@endif
<section id="home-end">
    {{-- contenu de fin de page : formulaire contact, CTA, etc. --}}
</section>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Si on arrive sur la home avec l’ancre #home-end
    if (window.location.hash === '#home-end') {
        const target = document.getElementById('home-end');
        if (!target) return;

        // petit délai pour laisser le header / layout se charger
        setTimeout(function () {
            const headerOffset = 110; // hauteur de ton header sticky (à ajuster)
            const elementPosition = target.getBoundingClientRect().top + window.pageYOffset;
            const offsetPosition = elementPosition - headerOffset;

            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
        }, 300);
    }
});
</script>

{{-- =============== CONTACT & PLAN D'ACCÈS =============== --}}
<section class="contact-map-av py-5" id="contact-map">
    <div class="container">
        <div class="row g-4 align-items-stretch">
            {{-- Formulaire à gauche --}}
            <div class="col-lg-6">
                <div class="contact-map-card h-100">
                    <h2 class="contact-map-title">Demande d'étude</h2>
                    <p class="contact-map-text">
                        AUDIT VISION – Bureau d’Études Énergétiques<br>
                        38 Avenue Villemain – 75014 Paris<br>
                        SIREN : 982 511 644<br>
                    </p>

                    {{-- Formulaire --}}
                    <form method="POST" action="{{ route('contact.store') }}">
                        @csrf

                        <div class="row g-3">
                            {{-- Raison Sociale --}}
                            <div class="col-md-12">
                                <input type="text" name="company_name" class="form-control contact-input"
                                       placeholder="Raison Sociale" required>
                            </div>

                            {{-- Numéro SIRET --}}
                            <div class="col-md-12">
                                <input type="text" name="siret" class="form-control contact-input"
                                       placeholder="Numéro de SIRET (14 chiffres)" pattern="\d{14}" required>
                            </div>

                            {{-- E-mail --}}
                            <div class="col-md-6">
                                <input type="email" name="email" class="form-control contact-input"
                                       placeholder="E-mail" required>
                            </div>
                            {{-- Téléphone --}}
                            <div class="col-md-6">
                                <input type="text" name="phone" class="form-control contact-input"
                                       placeholder="Téléphone">
                            </div>

                            {{-- Sujet --}}
                            <div class="col-12">
                                <select name="subject" class="form-select contact-input">
                                    <option value="">Sélectionnez un sujet</option>
                                    <option value="etude_eclairage_interieur">Étude d'éclairage intérieur</option>
                                    <option value="bilan_thermique_hp_flottante">Bilan thermique HP flottante</option>
                                    <option value="etude_energetique_batiment_tertiaire">Étude énergétique bâtiment tertiaire</option>
                                    <option value="visite_thermique_dimensionnement">Visite thermique sur dimensionnement</option>
                                </select>
                            </div>

                            {{-- Message --}}
                            <div class="col-12">
                                <textarea name="message" rows="4"
                                          class="form-control contact-textarea"
                                          placeholder="Votre message..." required></textarea>
                            </div>

                            {{-- Bouton d'envoi --}}
                            <div class="col-12 mt-2">
                                <button type="submit" class="btn contact-map-btn">
                                    Envoyer
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Carte à droite --}}
            <div class="col-lg-6">
                <div class="contact-map-wrapper h-100">
                    <div class="contact-map-iframe-wrap">
                        <iframe
                            src="https://www.google.com/maps?q=38%20Avenue%20Villemain%2075014%20Paris&output=embed"
                            width="100%"
                            height="100%"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ================== SCRIPTS ================== --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ----- HERO -----
    const slides = @json($slides);
    if (slides.length) {
        let index = 0;
        const titleEl   = document.getElementById('heroTitle');
        const summaryEl = document.getElementById('heroSummary');
        const imgEl     = document.getElementById('heroImage');

        function renderHero(i) {
            const s = slides[i];
            if (titleEl)   titleEl.textContent   = s.title   || '';
            if (summaryEl) summaryEl.textContent = s.summary || '';
            if (imgEl)     imgEl.src             = s.image;
        }

        if (slides.length > 1) {
            setInterval(function () {
                index = (index + 1) % slides.length;
                renderHero(index);
            }, 2000);
        }
    }

    // ----- VIDEOS -----
    const videos = @json($videoSlides ?? []);
    if (videos.length) {
        let vIndex = 0;

        const vTitle = document.getElementById('videoTitle');
        const vDesc  = document.getElementById('videoDescription');
        const iframe = document.getElementById('videoIframe');
        const dots   = document.querySelectorAll('.news-dot');

        function renderVideo(i) {
            const v = videos[i];
            if (!v) return;

            if (vTitle) vTitle.textContent = v.title || '';
            if (vDesc)  vDesc.textContent  = v.description || '';

            if (iframe && v.embed_url) {
                iframe.src = v.embed_url;
            }

            dots.forEach(d => d.classList.remove('active'));
            const active = document.querySelector('.news-dot[data-index="'+ i +'"]');
            if (active) active.classList.add('active');
        }

        if (videos.length > 1) {
            setInterval(function () {
                vIndex = (vIndex + 1) % videos.length;
                renderVideo(vIndex);
            }, 3000);
        }

        dots.forEach(dot => {
            dot.addEventListener('click', function () {
                const i = parseInt(this.dataset.index, 10);
                if (!isNaN(i)) {
                    vIndex = i;
                    renderVideo(vIndex);
                }
            });
        });
    }
});
</script>

{{-- ================== STYLES ================== --}}
<style>
/* ---------- HERO VISUEL ---------- */
.hero-av__visual {
    position: relative;
    width: 360px;
    height: 360px;
    margin-left: 40px;
}

.hero-av__circle {
    position: relative;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: #d6d6d6;
    overflow: hidden;
    z-index: 2;
    transform: translateX(10px);
}

.hero-av__circle img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.hero-extra-img {
    position: absolute;
    top: 10px;
    right: -90px;
    width: 100%;
    height: 100%;
    z-index: 1;
}

.hero-extra-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* ---------- HERO ---------- */
.hero-av {
    background: #94C02A;
    color: #ffffff;
    padding: 60px 0;
}

.hero-av__title {
    font-size: 2.4rem;
    font-weight: 700;
    line-height: 1.2;
    margin-bottom: 16px;
    color: #ffffff !important;
}

.hero-av__summary {
    font-size: 1.05rem;
    line-height: 1.6;
    max-width: 520px;
    color: #000000 !important;
}

.hero-av__buttons .btn {
    border-radius: 999px;
    padding: 10px 24px;
    font-weight: 500;
}

.hero-btn-primary {
    background: #28327d;
    color: #fff;
    border: none;
}

.hero-btn-primary:hover {
    background: #1f265f;
    color: #fff;
}

.hero-btn-outline {
    border: 1px solid #fff;
    color: #fff;
    background: transparent;
}

.hero-btn-outline:hover {
    background: #fff;
    color: #28327d;
}

/* ---------- QUI SOMMES-NOUS ---------- */
.qs-av {
    background: #f5f7fb;
}

.qs-inner {
    max-width: 900px;
    text-align: center;
}

.qs-title {
    font-size: 2rem;
    font-weight: 700;
    color: #0b2340;
    margin-bottom: 24px;
}

.qs-text {
    font-size: 0.95rem;
    line-height: 1.7;
    color: #1f2937;
    margin-bottom: 12px;
}

.qs-text--bold {
    font-weight: 700;
}

.qs-btn-wrap {
    margin-top: 28px;
}

.qs-btn {
    background: #7CAE2A;
    color: #ffffff;
    border-radius: 999px;
    padding: 10px 32px;
    font-weight: 500;
    text-decoration: none;
}

.qs-btn:hover {
    background: #6aa227;
    color: #ffffff;
}

/* ---------- CERTIFICATIONS ---------- */
.certif-av {
    background: #f8fafc;
}

.certif-title {
    font-size: 2rem;
    font-weight: 700;
    color: #7CAE2A;
}

.certif-left-title {
    font-size: 1.6rem;
    font-weight: 700;
    color: #0b2340;
    margin-bottom: 1rem;
}

.certif-left-text {
    font-size: 0.95rem;
    color: #4b5563;
    line-height: 1.7;
    margin-bottom: 1.4rem;
}

.certif-left-btn {
    display: inline-block;
    background: #7CAE2A;
    color: #ffffff;
    border-radius: 999px;
    padding: 0.6rem 1.8rem;
    font-size: 0.9rem;
    font-weight: 500;
    text-decoration: none;
    border: none;
    transition: background 0.18s ease, transform 0.18s ease, box-shadow 0.18s ease;
}

.certif-left-btn:hover {
    background: #6aa227;
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 14px 28px rgba(124, 174, 42, 0.35);
}

/* Carte à droite */
.certif-card {
    background: #ffffff;
    border-radius: 26px;
    padding: 24px 26px;
    box-shadow: 0 24px 50px rgba(15, 23, 42, 0.12);
}

.certif-logo-wrap {
    flex: 0 0 200px;
    max-width: 220px;
}

.certif-logo-img {
    width: 100%;
    height: auto;
    border-radius: 18px;
    object-fit: contain;
    background: #ffffff;
}

.certif-card-text {
    flex: 1;
}

.certif-card-title {
    font-size: 1.4rem;
    font-weight: 600;
    color: #0b2340;
    margin-bottom: 0.6rem;
}

.certif-card-desc {
    font-size: 0.95rem;
    color: #4b5563;
    line-height: 1.6;
    margin-bottom: 0.9rem;
}

.certif-card-link {
    font-size: 0.85rem;
    color: #28327d;
    text-decoration: none;
    font-weight: 500;
}

.certif-card-link:hover {
    text-decoration: underline;
}

/* ---------- ACTUALITÉ / VIDÉO ---------- */
.news-av {
    background: #ffffff;
}

.news-title {
    font-size: 2rem;
    font-weight: 700;
    color: #0b2340;
}

.news-video-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #0b2340;
    margin-bottom: 1rem;
}

.news-video-desc {
    font-size: 0.95rem;
    line-height: 1.7;
    color: #4b5563;
}

/* iframe vidéo */
.news-video-frame {
    position: relative;
    width: 100%;
    max-width: 520px;
    margin-left: auto;
    margin-right: auto;
}

.news-video-frame iframe {
    width: 100%;
    aspect-ratio: 16 / 9;
    border-radius: 8px;
    border: none;
    background: #000;
}

/* fallback bloc gris (si pas d'embed_url) */
.news-video-box {
    position: relative;
    display: block;
    width: 100%;
    max-width: 520px;
    margin-left: auto;
    margin-right: auto;
}

.news-video-placeholder {
    width: 100%;
    padding-top: 56.25%;
    background: #d1d5db;
    border-radius: 8px;
}

.news-video-play {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.news-video-play i {
    width: 56px;
    height: 56px;
    border-radius: 999px;
    background: #28327d;
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

/* Petits points indicateurs */
.news-dots .news-dot {
    display: inline-block;
    width: 10px;
    height: 10px;
    border-radius: 999px;
    margin: 0 4px;
    background: #d1d5db;
    cursor: pointer;
    transition: all 0.2s ease;
}

.news-dots .news-dot.active {
    background: #28327d;
    width: 18px;
}

/* ---------- PROJETS / GAMME DE PRESTATION ---------- */
.projects-av {
    background: #f5f7fb;
}

.projects-title {
    font-size: 2rem;
    font-weight: 700;
    color: #0b2340;
}

.project-image-wrapper {
    border-radius: 40px;   /* arrondi comme la maquette */
    overflow: hidden;
}

.project-image {
    width: 100%;
    height: 260px;
    object-fit: cover;
}

.project-text {
    padding: 12px 0;
}

.project-name {
    font-size: 1.3rem;
    font-weight: 600;
    color: #0b2340;
    margin-bottom: 0.75rem;
}

.project-summary {
    font-size: 0.95rem;
    color: #4b5563;
    line-height: 1.6;
    margin-bottom: 1rem;
}

.project-btn {
    background: #7CAE2A;
    color: #ffffff;
    border-radius: 999px;
    padding: 8px 22px;
    font-size: 0.9rem;
    font-weight: 500;
    text-decoration: none;
    border: none;
}

.project-btn:hover {
    background: #6aa227;
    color: #ffffff;
}

/* ---------- BLOG HOME (CARDS) ---------- */
.home-blog {
    background: #f5f7fb;
}

/* Titre + bouton */
.home-blog-title {
    font-size: 2.2rem;
    font-weight: 700;
    color: #28327d;
}

/* Bouton "Voir tous les articles" – sans shadow */
.home-blog-pill {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.55rem 2.5rem;
    border-radius: 999px;
    background: #7CAE2A;
    color: #ffffff;
    font-size: 0.95rem;
    font-weight: 500;
    text-decoration: none;
    border: none;
    transition: background 0.2s ease, transform 0.2s ease;
}
.home-blog-pill:hover {
    background: #6aa227;
    color: #ffffff;
    transform: translateY(-1px);
}

/* Cartes */
.home-blog-card {
    background: #ffffff;
    border-radius: 18px;
    border: 1px solid #e5e7eb;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    height: 100%;
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
}

.home-blog-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 35px rgba(15, 23, 42, 0.08);
    border-color: #d1d5db;
}

/* Image */
.home-blog-thumb-link {
    display: block;
    overflow: hidden;
    border-radius: 18px 18px 0 0;
}

.home-blog-thumb {
    width: 100%;
    aspect-ratio: 4 / 3;
    background: #d1d5db;
    display: block;
}

.home-blog-thumb.has-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.3s ease;
}

/* zoom léger au hover */
.home-blog-card:hover .home-blog-thumb.has-image img {
    transform: scale(1.05);
}

/* Corps de la carte */
.home-blog-body {
    padding: 1.25rem 1.5rem 1.4rem;
    text-align: center;
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
    flex: 1;
}

/* Petit label vert */
.home-blog-tag {
    display: inline-block;
    padding: 0.25rem 1.25rem;
    border-radius: 999px;
    background: #7CAE2A;
    color: #ffffff;
    font-size: 0.7rem;
    font-weight: 600;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    margin-bottom: 0.35rem;
}

/* Titre */
.home-blog-card-title {
    font-size: 1rem;
    font-weight: 600;
    color: #28327d;
    margin-bottom: 0.2rem;
}

.home-blog-card-title a {
    color: inherit;
    text-decoration: none;
}

.home-blog-card-title a:hover {
    text-decoration: underline;
}

/* Extrait */
.home-blog-card-excerpt {
    font-size: 0.85rem;
    color: #6b7280;
    margin-bottom: 0.4rem;
}

/* Lien "Your More" en bas */
.home-blog-more {
    font-size: 0.8rem;
    color: #28327d;
    text-decoration: none;
    margin-top: auto; /* pousse le lien vers le bas pour des cartes de même hauteur */
}

.home-blog-more:hover {
    text-decoration: underline;
}

/* ---------- PARTENAIRES ---------- */
.partners-av {
    background: #ffffff;
}

.partners-title {
    font-size: 2rem;
    font-weight: 700;
    color: #0b2340;
}

/* conteneur en arc */
.partners-orbit {
    max-width: 900px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    gap: 18px;
}

/* carte logo */



@keyframes partnerEnter {
    from { opacity: 0; transform: translateY(26px) scale(0.88); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
}

/* 🔥 Carte partenaire */






/* animation continue du logo */
@keyframes partnerLogoFloat {
    0%   { transform: translateY(0) scale(1); }
    50%  { transform: translateY(-6px) scale(1.03); }
    100% { transform: translateY(0) scale(1); }
}

/* animation d’apparition */
@keyframes partnerFadeIn {
    from { opacity: 0; transform: scale(0.7) translateY(20px); }
    to   { opacity: 1; transform: scale(1) translateY(0); }
}
/* ---------- CONTACT + MAP ---------- */
.contact-map-av {
    background: #ffffff;
}

.contact-map-card {
    background: #f5f7fb;
    border-radius: 20px;
    padding: 24px 26px;
    box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
}

.contact-map-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: #0b2340;
    margin-bottom: 12px;
}

.contact-map-text {
    font-size: 0.9rem;
    color: #4b5563;
    line-height: 1.6;
    margin-bottom: 18px;
}

.contact-input,
.contact-textarea {
    border-radius: 8px;
    border: 1px solid #d1d5db;
    font-size: 0.9rem;
    padding: 0.55rem 0.9rem;
    background-color: #ffffff;
}

.contact-input:focus,
.contact-textarea:focus {
    border-color: #7CAE2A;
    box-shadow: 0 0 0 0.1rem rgba(124, 174, 42, 0.25);
}

.contact-textarea {
    resize: vertical;
    min-height: 120px;
}

.contact-map-btn {
    background: #7CAE2A;
    color: #ffffff;
    border-radius: 999px;
    padding: 0.55rem 2.4rem;
    font-size: 0.9rem;
    font-weight: 500;
    border: none;
    transition: background 0.2s ease, transform 0.2s ease,
                box-shadow 0.2s ease;
}

.contact-map-btn:hover {
    background: #6aa227;
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 12px 24px rgba(124, 174, 42, 0.25);
}

/* Bloc map */
.contact-map-wrapper {
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 18px 40px rgba(15, 23, 42, 0.12);
    background: #e5e7eb;
}

.contact-map-iframe-wrap {
    position: relative;
    width: 100%;
    height: 100%;
    min-height: 320px;
}

.contact-map-iframe-wrap iframe {
    width: 100%;
    height: 100%;
    display: block;
    border-radius: 20px;
}

/* ---------- Responsive ---------- */
@media (max-width: 991.98px) {
    .hero-av {
        padding: 40px 0;
    }

    .hero-av__visual {
        width: 260px;
        height: 260px;
        margin-left: 0;
    }

    .project-image {
        height: 220px;
    }

    .home-blog-thumb {
        aspect-ratio: 16 / 10;
    }

    .partners-orbit {
        flex-wrap: wrap;
        justify-content: center;
        gap: 16px;
    }

    .certif-card {
        padding: 20px;
    }

    .certif-logo-wrap {
        flex: 0 0 160px;
    }
}

@media (max-width: 575.98px) {
    .hero-av__title {
        font-size: 1.7rem;
    }

    .hero-av__summary {
        font-size: 0.95rem;
    }

    .qs-title,
    .news-title,
    .projects-title,
    .home-blog-title,
    .partners-title,
    .certif-title {
        font-size: 1.6rem;
    }

    .qs-text,
    .news-video-desc,
    .project-summary,
    .home-blog-card-excerpt,
    .certif-left-text,
    .certif-card-desc {
        font-size: 0.9rem;
    }

    .home-blog-pill {
        width: 100%;
        justify-content: center;
    }
}
</style>

@endsection
