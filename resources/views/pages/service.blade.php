@extends('layouts.app')

@section('title', 'Nos Services')

@section('content')
@php
  // Image du header (fournie par ton controller) + fallback
  $heroBannerImg = isset($heroBannerImg) && $heroBannerImg
      ? $heroBannerImg
      : asset('img/placeholder-hero.png');
@endphp

<style>
/* =========================================================
   France Isolation – Services Index (unified skin)
   (Header identique au design "Service details")
   ========================================================= */
.page-services{
  --navy:#7CAE2A;
  --navyDark:#7CAE2A;
  --sky:#7CAE2A;
  --accent:#7CAE2A;
  --ink:#0f172a;
  --muted:#6b7280;
  --card:#ffffff;
  --ring:#dbe6ff;
  --shadow-lg:0 24px 48px rgba(16,24,40,.12);
  --shadow:0 10px 18px rgba(0,0,0,.08);
}
.page-services *{box-sizing:border-box}

/* ---------- HERO (split : texte + image qui dépasse) ---------- */
.sx-hero{
  position: relative;
  background: var(--navy);
  color:#fff;
  padding: var(--sx-hero-pad, 140px) 0;   /* hauteur bande */
  overflow: visible;                      /* ne pas couper l’image */
  z-index: 5;
}

/* Voile vert au-dessus de l'image, sous le texte */
.sx-hero::after{
  content:"";
  position:absolute; inset:0;
  background: var(--navy);
  z-index: 2; /* sous le texte, au-dessus de l’image */
  pointer-events:none;
}

/* Conteneur texte au-dessus */
.sx-hero__inner{ position:relative; z-index:3; }

/* “Split” : espace sous le hero pour loger l’image qui déborde */
.sx-hero--split{
  --sx-img-drop: 200px;                  /* ↓ descend, ↑ remonte */
  margin-bottom: var(--sx-img-drop);
}

/* Police Epilogue pour le titre + sous-titre */
@import url('https://fonts.googleapis.com/css2?family=Epilogue:wght@400;600;800;900&display=swap');
.page-services .sx-title,
.page-services .sx-sub{
  font-family: "Epilogue", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif !important;
  color:#fff !important;
}

/* Tailles (mêmes principes que Service details) */
.page-services .sx-title{
  font-size: clamp(44px, 6.5vw, 80px) !important;
  line-height: 1.05 !important;
  font-weight: 900 !important;
  margin:0 0 10px;
}
.page-services .sx-sub{
  font-size: clamp(18px, 1.8vw, 24px) !important;
  line-height: 1.7 !important;
  opacity:.98 !important;
  margin:0;
}

/* Déplacement fin du bloc texte (optionnel) via variables */
.sx-hero__copy{
  position: relative;
  transform: translate(var(--sx-copy-x, 0), var(--sx-copy-y, 0)); /* +x droite / +y bas */
  will-change: transform;
}

/* === HERO image: taille/position FIGÉES + 4 coins arrondis (comme service details) === */
.sx-hero__media{
  position: absolute;
  right: var(--sx-img-right, 24px);
  bottom: calc(-1 * var(--sx-img-drop, 200px));
  width: var(--sx-img-w, 620px);        /* largeur cadre */
  height: var(--sx-img-h, 380px);       /* hauteur cadre */
  border-radius: var(--sx-img-radius, 22px);
  overflow: hidden;                      /* masque coins arrondis */
  background: transparent;               /* pas de fond */
  z-index: 1;                            /* sous le voile */
}
.sx-hero__media img{
  width:100%;
  height:100%;
  display:block;
  object-fit: cover;                     /* remplit le cadre */
  border:0; box-shadow:none !important; filter:none !important; transform:none !important;
}

/* ---------- Section head / toolbar / grid (inchangés) ---------- */
.sx-wrap{padding:70px 0 40px}
.sx-head{text-align:center;max-width:820px;margin:0 auto 18px}
.sx-kicker{color:var(--sky);font-weight:800;text-transform:uppercase;letter-spacing:.12em;font-size:.85rem}
.sx-h1{color:var(--ink);font-weight:800;line-height:1.14;margin:8px 0 0}
.sx-tag{color:var(--muted)}

.sx-toolbar{display:flex;gap:12px;align-items:center;justify-content:center;flex-wrap:wrap;margin:14px 0 24px}
.sx-search{max-width:520px;width:100%;position:relative}
.sx-search input{
  width:100%; border:1px solid #eef2f6; border-radius:999px; padding:.7rem 1rem .7rem 2.4rem; background:#fff; outline:0;
  transition:border-color .2s ease, box-shadow .2s ease;
}
.sx-search input:focus{ border-color:var(--ring); box-shadow:0 0 0 .2rem rgba(49,180,235,.15) }
.sx-search .fa-search{ position:absolute; left:12px; top:50%; transform:translateY(-50%); opacity:.7 }
#sxCount{color:#64748b}

.svc-grid{display:grid;grid-template-columns:repeat(12,1fr);gap:24px}
.svc-col{grid-column:span 4}
@media (max-width: 991.98px){.svc-col{grid-column:span 6}}
@media (max-width: 575.98px){.svc-col{grid-column:span 12}}

.card-svc{
  background:var(--card); border:1px solid #eef2f6; border-radius:18px; overflow:hidden;
  box-shadow:var(--shadow); height:100%; display:flex; flex-direction:column;
  transition: transform .22s ease, box-shadow .22s ease, border-color .22s ease;
}
.card-svc:hover{ transform: translateY(-6px); box-shadow:0 14px 36px rgba(0,0,0,.08); border-color:#dbe6ff }

.thumb{aspect-ratio: 16/11; background:#f2f4f8; overflow:hidden}
.thumb img{width:100%;height:100%;object-fit:cover;display:block}

.body{padding:16px 16px 18px}
.title{margin:0 0 6px;font-weight:800;font-size:1.1rem;color:#0f172a}
.sum{margin:0 0 12px;color:#64748b;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;min-height:3.8em}

.btn-accent{
  background:var(--accent); color:#fff; border:none; font-weight:800;
  padding:10px 14px; border-radius:14px;
}
.btn-accent:hover{ filter:brightness(.98) }

.svc-empty{background:#f8fafc;border:1px dashed #e5e7eb;border-radius:16px;padding:24px;text-align:center;color:#64748b}

/* Mobile : l’image passe sous le texte */
@media (max-width: 992px){
  .sx-hero--split{ --sx-img-drop: 40px; }
  .sx-hero__media{
    position: static; right:auto; bottom:auto; width:100%;
    height: var(--sx-img-h-mobile, 280px); margin-top:18px;
  }
}
</style>

<section class="page-services">

  {{-- HERO — même principe que Service details --}}
  <header class="sx-hero sx-hero--split"
          style="
            --sx-hero-pad: 180px;   /* hauteur du bandeau */
            --sx-img-drop: 240px;   /* dépassement vers le bas */
            --sx-img-right: 24px;   /* plus grand => plus à gauche */
            --sx-img-w: 620px;      /* largeur cadre image */
            --sx-img-h: 380px;      /* hauteur cadre image */
            --sx-img-radius: 22px;  /* arrondi 4 coins */
            --sx-copy-x: 8px;       /* ajuste finement le texte en X */
            --sx-copy-y: -8px;      /* ajuste finement le texte en Y */
          ">
    <div class="container sx-hero__inner">
      <div class="sx-hero__copy">
        <h1 class="sx-title">Services</h1>
        <p class="sx-sub">Des services conçus spécifiquement pour votre entreprise.</p>
      </div>

      {{-- Image de header (taille/position figées + coins arrondis) --}}
      <figure class="sx-hero__media">
        <img src="{{ $heroBannerImg }}" alt="Image de couverture des services">
      </figure>
    </div>
  </header>

  {{-- LISTE --}}
  <div class="sx-wrap">
    <div class="container">

      <div class="sx-head">
        <div class="sx-kicker">Nos services</div>
        <h2 class="sx-h1">Des services conçus spécifiquement pour votre entreprise</h2>
        <p class="sx-tag mt-1">Parcourez et cliquez sur une carte pour voir les détails complets.</p>
      </div>

      {{-- Barre d’outils --}}
      <div class="sx-toolbar">
        <div class="sx-search">
          <i class="fa fa-search"></i>
          <input id="sxQuery" type="search" placeholder="Rechercher par nom ou mots-clés…" aria-label="Rechercher des services">
        </div>
        <div id="sxCount" aria-live="polite"></div>
      </div>

      {{-- Grille --}}
      @if($services->count())
        <div class="svc-grid">
          @foreach($services as $service)
            @php
              $img = $service->image;
              $src = \Illuminate\Support\Str::startsWith($img, ['http://','https://','/','storage/'])
                    ? asset($img)
                    : asset('storage/'.$img);
              $delay = ($loop->index % 6) * 0.1;
            @endphp
            <article class="svc-col wow fadeInUp"
                     data-wow-delay="{{ number_format($delay,1) }}s"
                     data-name="{{ \Illuminate\Support\Str::of($service->name)->lower() }}"
                     data-summary="{{ \Illuminate\Support\Str::of($service->summary)->lower() }}">
              <div class="card-svc">
                @if($service->image)
                  <div class="thumb">
                    <img src="{{ $src }}" alt="{{ $service->name }}" loading="lazy">
                  </div>
                @else
                  <div class="thumb d-flex align-items-center justify-content-center">
                    <i class="fa fa-image fa-2x text-muted"></i>
                    <span class="visually-hidden">Image du service indisponible</span>
                  </div>
                @endif

                <div class="body">
                  <h3 class="title">{{ $service->name }}</h3>
                  @if(!empty($service->summary))
                    <p class="sum">{{ $service->summary }}</p>
                  @endif
                  <a href="{{ route('services.show', $service->id) }}" class="btn btn-accent">
                    Voir plus
                  </a>
                </div>
              </div>
            </article>
          @endforeach
        </div>

        {{-- Pagination (si LengthAwarePaginator) --}}
        @if(method_exists($services, 'links'))
          <div class="mt-4 d-flex justify-content-center">
            {{ $services->links() }}
          </div>
        @endif
      @else
        <div class="svc-empty">
          <p class="h5 mb-1">Aucun service disponible pour le moment.</p>
          <p class="mb-0">Revenez bientôt ou <a href="{{ url('/contact') }}">contactez-nous</a> pour une demande sur mesure.</p>
        </div>
      @endif

    </div>
  </div>

</section>

{{-- Mini-filtre client --}}
<script>
  (function(){
    const q = document.getElementById('sxQuery');
    const items = Array.from(document.querySelectorAll('.svc-grid > .svc-col'));
    const count = document.getElementById('sxCount');
    if(!q || !items.length) return;

    const updateCount = (n) => {
      const total = items.length;
      count.textContent = n===total || !q.value.trim()
        ? ''
        : `${n} résultat${n!==1?'s':''} sur ${total}`;
    };

    const filter = () => {
      const term = (q.value || '').trim().toLowerCase();
      let visible = 0;
      items.forEach(el=>{
        const name = el.getAttribute('data-name') || '';
        const sum  = el.getAttribute('data-summary') || '';
        const show = !term || name.includes(term) || sum.includes(term);
        el.style.display = show ? '' : 'none';
        if(show) visible++;
      });
      updateCount(visible);
    };

    q.addEventListener('input', filter);
    updateCount(items.length);
  })();
</script>
@endsection
