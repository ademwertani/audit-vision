{{-- ================== UNIFIED HEADER ================== --}}
@php
  $about = $about ?? (object) [];
  $social = $social ?? (object) [];
@endphp
<header class="header-aisla bg-white shadow-sm sticky-top">
  <div class="container-fluid">
    <nav class="navbar navbar-expand-lg navbar-light py-1">
      {{-- Logo totalement à gauche et plus grand --}}
      <a href="{{ url('/') }}" class="navbar-brand me-auto d-flex align-items-center gap-2">
        @if(!empty($about->logo))
          <img src="{{ asset('storage/' . ltrim($about->logo, '/')) }}" alt="France Isolation" class="ms-0 logo-navbar">
        @else
          <img src="{{ asset('/img/lo.png') }}" alt="France Isolation" class="ms-0 logo-navbar">
        @endif
      </a>

      {{-- Toggler mobile --}}
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapseNew"
        aria-controls="navbarCollapseNew" aria-expanded="false" aria-label="Basculer la navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      {{-- Liens + Boutons --}}
      <div class="collapse navbar-collapse" id="navbarCollapseNew">
        {{-- Liens centrés --}}
        <ul class="navbar-nav mx-auto align-items-lg-center gap-3">
          <li class="nav-item">
            <a href="{{ url('/') }}" class="nav-link {{ Request::is('/') ? 'active' : '' }}">Accueil</a>
          </li>

         <li class="nav-item dropdown services-dd position-relative">
  <a href="{{ route('services.index') }}"
     class="nav-link {{ Request::is('services') || Request::is('services/*') ? 'active' : '' }}"
     data-bs-toggle="dropdown" aria-expanded="false">
    Services
  </a>

  @if(!empty($navCategories) && count($navCategories))
    <div class="dropdown-menu services-level1 p-2 border-0 shadow-lg">
      <ul class="list-unstyled m-0">
        @foreach($navCategories as $cat)
          <li class="dropdown-submenu position-relative">
            <!-- Lien catégorie (ouvre le sous-menu) -->
            <a href="{{ route('services.index') }}?category={{ $cat->id }}"
               class="dropdown-item d-flex justify-content-between align-items-center"
               @click.prevent
               data-bs-toggle="submenu">
              <span>{{ $cat->name }}</span>
              <span class="caret ms-2" aria-hidden="true">›</span>
            </a>

            <!-- Sous-menu Services -->
            <ul class="dropdown-menu submenu p-2 shadow">
              @forelse($cat->services as $srv)
                <li>
                  <a class="dropdown-item" href="{{ route('services.show', $srv->id) }}">
                    {{ $srv->name }}
                  </a>
                </li>
              @empty
                <li><span class="dropdown-item text-muted">Aucun service</span></li>
              @endforelse
            </ul>
          </li>
        @endforeach
      </ul>
    </div>
  @endif
</li>

<style>
  /* Menu niveau 1 (liste des catégories) */
.header-aisla .services-level1 {
  min-width: 280px;
}

/* L’élément qui contient la catégorie + son sous-menu */
.header-aisla .dropdown-submenu > a.dropdown-item {
  position: relative;
  padding-right: 1.5rem;
}

/* Petite flèche */
.header-aisla .dropdown-submenu .caret {
  font-size: .9rem;
  opacity: .6;
}

/* Sous-menu (services) – caché par défaut */
.header-aisla .dropdown-submenu .submenu {
  display: none;
  position: absolute;
  top: 0;
  left: 100%;          /* s’ouvre à droite du menu 1 */
  min-width: 260px;
  margin-left: .25rem;
  border: 0;
}

/* Desktop : ouvrir au survol */
@media (min-width: 992px) {
  .header-aisla .services-dd:hover > .dropdown-menu { display: block; }
  .header-aisla .dropdown-submenu:hover > .submenu {
    display: block;
  }
}

/* Mobile : quand .show est ajoutée par JS */
.header-aisla .dropdown-submenu .submenu.show {
  display: block;
  position: static;    /* empilé sous la catégorie sur mobile */
  margin: .25rem 0 .5rem 0;
  box-shadow: none;
}

/* Un peu d’air */
.header-aisla .submenu .dropdown-item { white-space: normal; }

.mega-services { min-width: 720px; }
.mega-services .dropdown-item { white-space: normal; }
/* Ouverture au survol desktop (tu l’as déjà) */
@media (min-width: 992px) {
  .header-aisla .services-dd:hover > .dropdown-menu,
  .header-aisla .services-dd .dropdown-menu:hover {
    display: block; opacity:1; visibility:visible;
  }
}

</style>


          <style>
            /* Ouvre au survol (desktop) */
            @media (min-width: 992px) {
              .header-aisla .services-dd:hover > .dropdown-menu,
              .header-aisla .services-dd .dropdown-menu:hover{
                display: block;
                opacity: 1;
                visibility: visible;
              }
            }
            /* N'affecte que le dropdown de 1er niveau, pas les sous-menus */
.header-aisla .navbar .dropdown > .dropdown-menu {
  position: absolute !important;
  top: 100% !important;
  left: 0 !important;
  right: auto !important;
  transform: none !important;
  margin: 0 !important;
  z-index: 1050;
}

            .nav-caret { line-height: 1; }
            /* Pont invisible anti-flicker */
            .header-aisla .services-dd { position: relative; }
            .header-aisla .services-dd::after{
              content: "";
              position: absolute;
              left: 0; right: 0;
              top: 100%;
              height: 10px;
            }
            /* Autorise l'état "ouvert" via une classe (contrôlée en JS) */
.header-aisla .services-dd.open > .dropdown-menu { display:block; }

/* Agrandis le "pont" anti-flicker entre la colonne des catégories et le sous-menu */
.header-aisla .dropdown-submenu::after {
  content: "";
  position: absolute;
  top: -8px;               /* protège aussi les bords haut/bas */
  right: -18px;            /* plus large = plus tolérant */
  width: 18px;
  height: calc(100% + 16px);
}

/* Colle légèrement le sous-menu à la gauche (chevauchement) pour éliminer le petit vide */
.header-aisla .dropdown-submenu .submenu {
  left: calc(100% - 8px);  /* au lieu de 100% ou 100%-2px */
  z-index: 1060;
}

          </style>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const dd = document.querySelector('.header-aisla .services-dd');
  if (!dd) return;

  const level1 = dd.querySelector('.services-level1');
  const submenus = dd.querySelectorAll('.dropdown-submenu .submenu');
  let closeTimer = null;

  function openDD() {
    clearTimeout(closeTimer);
    dd.classList.add('open');
  }
  function scheduleClose() {
    clearTimeout(closeTimer);
    closeTimer = setTimeout(() => dd.classList.remove('open'), 180); // délai anti-flicker
  }

  // Ouvre dès qu'on entre dans le menu (ou sur "Services")
  dd.addEventListener('mouseenter', openDD);
  // Ferme avec délai quand on sort de tout le bloc dropdown
  dd.addEventListener('mouseleave', scheduleClose);

  // Pendant qu'on est sur la colonne catégories ou un sous-menu, empêcher la fermeture
  if (level1) {
    level1.addEventListener('mouseenter', openDD);
    level1.addEventListener('mouseleave', scheduleClose);
  }
  submenus.forEach(sm => {
    sm.addEventListener('mouseenter', openDD);
    sm.addEventListener('mouseleave', scheduleClose);
  });

  // Active le panneau correspondant à la catégorie survolée (comme avant)
  const links = dd.querySelectorAll('.cat-link');
  const panels = dd.querySelectorAll('.services-panel');
  function activate(panelId){
    links.forEach(l => l.classList.toggle('active', l.dataset.panel === panelId));
    panels.forEach(p => p.classList.toggle('active', p.id === panelId));
  }
  links.forEach(l => {
    l.addEventListener('mouseenter', () => { openDD(); activate(l.dataset.panel); });
    l.addEventListener('click', (e) => { e.preventDefault(); openDD(); activate(l.dataset.panel); });
  });
});
</script>

          <li class="nav-item">
            <a href="{{ route('projects.index') }}"
              class="nav-link {{ Request::is('projects*') ? 'active' : '' }}">Projets</a>
          </li>

          <li class="nav-item">
            <a href="{{ route('blog.index') }}" class="nav-link {{ Request::is('blog*') ? 'active' : '' }}">Blog</a>
          </li>

          <li class="nav-item">
            <a href="{{ url('/about') }}" class="nav-link {{ Request::is('about') ? 'active' : '' }}">À propos</a>
          </li>

          <li class="nav-item">
            <a href="{{ url('/contact') }}" class="nav-link {{ Request::is('contact') ? 'active' : '' }}">Contact</a>
          </li>
        </ul>

        {{-- Boutons alignés à droite --}}
        <div class="d-flex gap-3 ms-lg-3 mt-3 mt-lg-0">
          <a href="{{ url('contact') }}" class="btn btn-contact">Contactez-nous</a>
          @if(!request()->is('quote'))
            <a href="{{ url('quote') }}" class="btn btn-outline-contact quote-btn">
              Demander un devis
            </a>
          @endif
        </div>
      </div>
    </nav>
  </div>
</header>
