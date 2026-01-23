@php
    use App\Models\Banner;
    use Illuminate\Support\Str;

    // Récupérer jusqu’à 4 bannières (title / image)
    $banners = Banner::orderByDesc('created_at')
        ->take(4)
        ->get();

    // Fallback si aucune bannière
    if ($banners->isEmpty()) {
        $banners = collect([
            (object)[
                'title' => 'Notre blog',
                'image' => 'img/placeholder-hero.png',
            ]
        ]);
    }

    // Première bannière pour l’affichage initial
    $firstBanner = $banners->first();

    // Image du hero (avec gestion URL absolue / stockage local)
    $heroImg = $firstBanner->image
        ? (Str::startsWith($firstBanner->image, ['http://','https://'])
            ? $firstBanner->image
            : asset('storage/' . ltrim($firstBanner->image, '/')))
        : asset('img/placeholder-hero.png');

    // Titre
    $heroTitle = $firstBanner->title ?: 'Notre blog';

    // Payload propre pour le JS
    $bannersPayload = $banners->map(function ($b) {
        $imgPath = $b->image
            ? (Str::startsWith($b->image, ['http://','https://'])
                ? $b->image
                : asset('storage/' . ltrim($b->image, '/')))
            : asset('img/placeholder-hero.png');

        return [
            'title' => $b->title ?: 'Notre blog',
            'image' => $imgPath,
        ];
    })->values();

    $bannersJson = $bannersPayload->toJson();
@endphp

<style>
/* =========================================================
   France Isolation – Header global compact
   (même design que le blog mais plus petit)
   ========================================================= */
   
.page-blog{
  --navy:#242958;
  --navyDark:#1d2760;
  --sky:#7CAE2A;
  --accent:#7CAE2A;
  --ink:#020617;
  --muted:#6b7280;
  --card:#ffffff;
  --ring:#dbe6ff;
  --shadow-lg:0 24px 48px rgba(15,23,42,.18);
  --shadow:0 10px 18px rgba(15,23,42,.10);
}
.page-blog *{box-sizing:border-box}

/* ---------- TYPO (Epilogue pour le hero) ---------- */
@import url('https://fonts.googleapis.com/css2?family=Epilogue:wght@400;600;800;900&display=swap');
.page-blog .pb-title,
.page-blog .pb-sub{
  font-family: "Epilogue", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif !important;
  color:#fff !important;
}

/* =========================================================
   HERO – version plus petite / classe
   ========================================================= */
.pb-hero{
  position: relative;
  color:#fff;

  /* ✅ Hauteur FIXE pour tous les headers */
  height: 540px;                 /* tu peux mettre 320 / 360 / 400 selon ce que tu aimes */
  padding: 0;                     /* la hauteur ne dépend plus du padding */

  overflow: hidden;
  z-index: 1;

  /* pour centrer le contenu verticalement */
  display:flex;
  align-items:center;

  background-color:#0b172f;
  background-image:
      linear-gradient(
        90deg,
        rgba(11,23,47,0.90) 0%,
        rgba(11,23,47,0.84) 26%,
        rgba(11,23,47,0.50) 50%,
        rgba(11,23,47,0.18) 69%,
        rgba(76,181,72,0.20) 100%
      ),
      var(--hero-bg-img, none);

  /* 🔒 Même comportement pour TOUTES les images */
  background-size: cover !important;
  background-position: center center !important;
  background-repeat: no-repeat;

  transition: background-image 1.2s ease-in-out;
}

/* --- halo global --- */
.pb-hero::before{
  content:"";
  position:absolute;
  inset:-25%;
  background:
    radial-gradient(180% 220% at -12% 4%,
      rgba(42,103,210,0.78) 0%,
      rgba(42,103,210,0.40) 32%,
      rgba(42,103,210,0.10) 60%,
      transparent 100%),
    radial-gradient(190% 240% at 120% 12%,
      rgba(124,174,42,0.95) 0%,
      rgba(124,174,42,0.62) 26%,
      rgba(124,174,42,0.24) 55%,
      transparent 100%),
    radial-gradient(120% 180% at 88% 55%,
      rgba(124,174,42,0.30) 0%,
      rgba(124,174,42,0.08) 40%,
      transparent 90%);
  mix-blend-mode: soft-light;
  opacity:.97;
  z-index:1;
  pointer-events:none;
}

/* --- vague du bas --- */
.pb-hero::after{
  content:"";
  position:absolute;
  left:0;right:0;bottom:-1px;
  height:40px;
  background:
    radial-gradient(130% 140% at 80% 0%,
      rgba(124,174,42,0.30) 0%,
      rgba(124,174,42,0.10) 30%,
      rgba(124,174,42,0.0) 70%);
  opacity:.50;
  z-index:1;
  pointer-events:none;
}

/* contenu texte */
.pb-hero__inner{
  position: relative;
  z-index: 2;
}

.pb-hero__copy{
  position: relative;
  transform: translate(var(--pb-copy-x, 8px), var(--pb-copy-y, -8px));
  max-width: 620px;
}

/* panneau “verre” derrière le texte */
.pb-hero__copy::before{
  content:"";
  position:absolute;
  inset:-20px -32px -22px -32px;
  background:
    linear-gradient(135deg,
      rgba(15,23,42,0.94),
      rgba(15,23,42,0.78));
  border-radius:26px;
  backdrop-filter: blur(9px);
  -webkit-backdrop-filter: blur(9px);
  box-shadow:0 24px 80px rgba(15,23,42,0.70);
  z-index:-1;
}

/* tailles de titre/sous-titre – compactes */
.pb-title{
  font-size: clamp(36px, 4.8vw, 60px);
  line-height: 1.05;
  font-weight: 900;
  margin: 0 0 10px;
  transition: opacity .4s ease, transform .4s ease;
}
.pb-sub{
  font-size: clamp(16px, 1.6vw, 21px);
  line-height: 1.7;
  opacity: .98;
  margin: 0;
  transition: opacity .4s ease, transform .4s ease;
}

.pb-hero__media{display:none !important;}

@media (max-width: 992px){
  .pb-hero{
    padding:120px 0 70px;
    background-position: 45% center;
  }
  .pb-hero__copy{
    max-width: 100%;
  }
  .pb-hero__copy::before{
    inset:-18px -18px -18px -18px;
  }
}
@media (max-width: 575.98px){
  .pb-hero{
    padding:110px 0 60px;
    background-position: 50% center;
  }
  .pb-title{
    font-size: clamp(28px, 7vw, 34px);
  }
}

/* petites classes pour animation de texte */
.pb-fade-out{
  opacity:0;
  transform:translateY(6px);
}
.pb-fade-in{
  opacity:1;
  transform:translateY(0);
}
</style>

<section class="page-blog">
  <header class="pb-hero"
          style="
            --pb-hero-pad: 140px;
            --pb-copy-x: 8px;
            --pb-copy-y: -8px;
            --hero-bg-img: url('{{ $heroImg }}');
          ">
    <div class="container pb-hero__inner">
      <div class="pb-hero__copy">
        <h1 class="pb-title">{{ $heroTitle }}</h1>
      </div>
    </div>
  </header>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Données envoyées depuis PHP
    const banners = {!! $bannersJson !!};

    if (!banners.length) return;

    const hero    = document.querySelector('.pb-hero');
    const titleEl = document.querySelector('.pb-title');

    if (!hero || !titleEl) return;

    let index = 0;

    const applyBanner = (b) => {
        // background image
        hero.style.setProperty('--hero-bg-img', `url('${b.image}')`);

        // animation texte (petit fade)
        titleEl.classList.add('pb-fade-out');

        setTimeout(() => {
            titleEl.textContent = b.title || 'Notre blog';

            titleEl.classList.remove('pb-fade-out');
            titleEl.classList.add('pb-fade-in');

            setTimeout(() => {
                titleEl.classList.remove('pb-fade-in');
            }, 400);
        }, 250);
    };

    // rotation toutes les 3 secondes
    setInterval(() => {
        index = (index + 1) % banners.length;
        applyBanner(banners[index]);
    }, 3000);
});
</script>
