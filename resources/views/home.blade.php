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
@if($firstSlide)
<section class="hero-av">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            {{-- Texte à gauche --}}
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h1 class="hero-av__title" id="heroTitle">
                    {{ $firstSlide['title'] }}
                </h1>
                <p class="hero-av__summary" id="heroSummary">
                    {{ $firstSlide['summary'] }}
                </p>

                <div class="hero-av__buttons mt-4 d-flex flex-wrap gap-3">
                    <a href="{{ url('/contact') }}" class="btn hero-btn-primary">
                        Contactez-nous
                    </a>
                    <a href="{{ url('/about') }}" class="btn hero-btn-outline">
                        En savoir plus
                    </a>
                </div>
            </div>

            {{-- Bloc visuel à droite (image automatique + image insérée) --}}
            <div class="col-lg-6 d-flex justify-content-center align-items-center">
                <div class="hero-av__visual">
                    {{-- Image insérée (en dessous) --}}
                    <div class="hero-extra-img">
                        <img src="{{ asset('img/effect.png') }}" alt="Image supplémentaire">
                    </div>

                    {{-- Image automatique (au-dessus) --}}
                    <div class="hero-av__circle">
                        <img src="{{ $firstSlide['image'] }}" alt="Banner visuel" id="heroImage">
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@else
    {{-- Fallback si aucune bannière --}}
    <div class="top-banner">
        <img src="{{ asset('img/green.png') }}" alt="Banner" class="top-banner-img">
    </div>
@endif

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

{{-- =============== PARTENAIRES (NOS PARTENAIRES) =============== --}}
@if($partners->isNotEmpty())
<section class="partners-av py-5">
    <div class="container">
        <h2 class="partners-title text-center mb-5">Nos Partenaires</h2>

        <div class="partners-orbit">
            @foreach($partners->take(5) as $i => $partner)
                @php
                    // positions pour reproduire la forme en arc
                    $posClasses = ['pos-l2', 'pos-l1', 'pos-center', 'pos-r1', 'pos-r2'];
                    $pos = $posClasses[$i] ?? 'pos-center';
                @endphp

                <div class="partner-card {{ $pos }}">
                    <img
                        src="{{ asset('storage/' . ltrim($partner->logo, '/')) }}"
                        alt="{{ $partner->name }}">
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
{{-- =============== NOS CERTIFICATIONS (PREMIÈRE CERTIF) =============== --}}
@if(!empty($certificat))
<section class="certif-av py-5">
    <div class="container">
        {{-- Titre centré --}}
        <h2 class="certif-title text-center mb-5">Nos Certifications</h2>

        <div class="row align-items-center">
            {{-- Texte à gauche --}}
            <div class="col-lg-4 mb-4 mb-lg-0">
                <h3 class="certif-left-title">
                    {{ $certificat->name ?? 'Notre Certification' }}
                </h3>
                <p class="certif-left-text">
                    {{ $certificat->description ?? 'Découvrez notre certification et notre engagement en matière de qualité et de performance énergétique.' }}
                </p>

                @if($certificat->pdf_file)
                    <a href="{{ $certificat->pdf_url }}"
                       target="_blank"
                       class="btn certif-left-btn">
                        Notre Certification
                    </a>
                @endif
            </div>

            {{-- Carte certif à droite --}}
            <div class="col-lg-8">
                <div class="certif-card d-flex flex-column flex-md-row align-items-center gap-4">
                    {{-- Image de la certif --}}
                    <div class="certif-logo-wrap">
                        <img src="{{ $certificat->image_url }}"
                             alt="{{ $certificat->name }}"
                             class="certif-logo-img">
                    </div>

                    {{-- Texte à droite dans la carte --}}
                    <div class="certif-card-text">
                        <h4 class="certif-card-title">
                            {{ $certificat->name }}
                        </h4>
                        <p class="certif-card-desc">
                            {{ $certificat->description }}
                        </p>

                        @if($certificat->pdf_file)
                            <a href="{{ $certificat->pdf_url }}"
                               target="_blank"
                               class="certif-card-link">
                                Voir le document de certification
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endif
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
    box-shadow: 0 10px 20px rgba(124, 174, 42, 0.28);
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
.partner-card {
    background: #e5e7eb;
    border-radius: 26px;
    box-shadow: 0 18px 40px rgba(15, 23, 42, 0.12);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 16px 20px;
    opacity: 0;
    transform: translateY(20px) scale(0.9);
    animation: partnerEnter 0.7s ease forwards;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}

/* tailles pour recréer l'arc (centre plus grand) */
.partner-card.pos-center {
    width: 220px;
    height: 130px;
}

.partner-card.pos-l1,
.partner-card.pos-r1 {
    width: 190px;
    height: 115px;
}

.partner-card.pos-l2,
.partner-card.pos-r2 {
    width: 140px;
    height: 95px;
}

/* animation de décalage (stagger) */
.partners-orbit .partner-card:nth-child(1) { animation-delay: 0.05s; }
.partners-orbit .partner-card:nth-child(2) { animation-delay: 0.12s; }
.partners-orbit .partner-card:nth-child(3) { animation-delay: 0.2s;  }
.partners-orbit .partner-card:nth-child(4) { animation-delay: 0.28s; }
.partners-orbit .partner-card:nth-child(5) { animation-delay: 0.35s; }

@keyframes partnerEnter {
    from { opacity: 0; transform: translateY(26px) scale(0.88); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
}

/* hover effet flottant */
.partner-card:hover {
    transform: translateY(-6px) scale(1.02);
    box-shadow: 0 24px 45px rgba(15, 23, 42, 0.18);
}

/* L'image remplira 100% du cadre */
.partner-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;      /* remplit entièrement le cadre */
    border-radius: 26px;
    animation: partnerLogoFloat 4s ease-in-out infinite;
}

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
