<!-- ===== FULL FOOTER (HTML + CSS) ===== -->
<style>
  /* ===== AISLA-style footer palette & resets ===== */
  .footer-aisla {
    --footer-bg: #242958;
    /* fond bleu foncé */
    --accent: #7CAE2A;
    /* vert accent */
    --newsletter: #36A9E1;
    /* bleu newsletter */
    --ink: #E9EDFF;
    /* texte principal clair */
    --muted: #BFC7FF;
    /* texte atténué */
  }

  .footer.footer-aisla {
    background: var(--footer-bg) !important;
    color: var(--ink);
    position: relative;
    overflow: hidden;
  }

  .footer-aisla a {
    color: #fff;
    text-decoration: none;
  }

  .footer-aisla a:hover {
    opacity: .85;
  }

  /* Titres de section avec soulignement vert */
  .footer-aisla .section-title {
    color: #fff;
    margin-bottom: .75rem;
    position: relative;
  }

  .footer-aisla .section-title::after {
    content: "";
    display: block;
    width: 56px;
    height: 3px;
    background: var(--accent);
    border-radius: 2px;
    margin-top: 8px;
  }

  /* Texte secondaire vert uniquement dans le footer */
  .footer-aisla .text-secondary {
    color: var(--accent) !important;
  }

  /* Boutons réseaux sociaux : cercles blancs */
  .footer-aisla .btn-square {
    width: 42px;
    height: 42px;
    border: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #ffffff;
    color: #1a225a;
    box-shadow: none;
  }

  .footer-aisla .btn-square i {
    color: #1a225a !important;
  }

  .footer-aisla .btn-square:hover {
    transform: translateY(-1px);
  }

  /* Liens utiles */
  .footer-aisla .short-link a {
    display: flex;
    align-items: center;
    font-weight: 500;
  }

  .footer-aisla .short-link i {
    color: var(--accent) !important;
  }

  /* Liste de contact avec icônes vertes circulaires */
  .footer-aisla .contact-list {
    list-style: none;
    padding-left: 0;
    margin: 0;
  }

  .footer-aisla .contact-item {
    display: flex;
    align-items: center;
    gap: .75rem;
    margin-bottom: .75rem;
  }

  .footer-aisla .contact-item .icon {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: var(--accent);
    color: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 36px;
  }

  /* Séparateurs & bas de page */
  .footer-aisla hr {
    border-color: rgba(255, 255, 255, 0.15);
  }

  .footer-aisla .about-text {
    color: #E9EDFF;
    font-size: 0.95rem;
    line-height: 1.6;
    margin-top: 0rem;
    opacity: 0.9;
  }

  .footer-aisla .footer-links a {
    color: var(--muted);
    margin-left: 1rem;
  }

  .footer-aisla .logo-navbar {
    max-height: 520px;
    margin-bottom: 2rem;
    display: block;
  }

  .footer-aisla .col-lg-4.col-md-6 {
    margin-top: 10px;
  }

  .footer-aisla .footer-links a:first-child {
    margin-left: 0;
  }

  .footer-aisla .social-icons .btn-square {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    transition: transform .15s ease, opacity .15s ease;
  }

  .footer-aisla .social-icons .btn-square:hover {
    transform: translateY(-2px);
    opacity: .9;
  }

  /* ===== Barre newsletter (à styliser selon besoin) ===== */
</style>

<div class="container-fluid footer footer-aisla wow fadeIn" data-wow-delay=".3s">
  <div class="container pt-5 pb-4">

    <div class="row g-5">
      <!-- Logo + présentation -->
      <div class="col-lg-4 col-md-6">
        <a href="{{ url('/') }}">
          <img src="{{ asset('img/newl.png') }}" alt="France Expert Isolation" class="logo-navbar">
        </a>
        <p class="about-text">
          Chez France Expert Isolation, nous croyons au <br>
          pouvoir des énergies renouvelables pour <br>
          construire un avenir plus durable.
        </p>

        <div class="social-icons mt-3">
          <a href="https://www.facebook.com/tonpage" class="btn-square rounded-circle me-2" aria-label="Facebook"
            target="_blank" rel="noopener">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a href="https://www.instagram.com/tonprofil" class="btn-square rounded-circle me-2" aria-label="Instagram"
            target="_blank" rel="noopener">
            <i class="fab fa-instagram"></i>
          </a>
          <a href="https://www.youtube.com/@ta-chaine" class="btn-square rounded-circle me-2" aria-label="YouTube"
            target="_blank" rel="noopener">
            <i class="fab fa-youtube"></i>
          </a>
          <a href="https://www.linkedin.com/company/ta-page" class="btn-square rounded-circle" aria-label="LinkedIn"
            target="_blank" rel="noopener">
            <i class="fab fa-linkedin-in"></i>
          </a>
        </div>
      </div>

      <!-- Liens utiles -->
      <div class="col-lg-2 col-md-6">
        <h4 class="section-title">Services</h4>
        <div class="mt-4 d-flex flex-column short-link">
          <a href="{{ url('/about') }}" class="mb-2 text-white"><i class="fas fa-angle-right me-2"></i>À propos</a>
          <a href="{{ url('/formation') }}" class="mb-2 text-white"><i class="fas fa-angle-right me-2"></i>Nos formations</a>
          <a href="{{ url('/services') }}" class="mb-2 text-white"><i class="fas fa-angle-right me-2"></i>Nos services</a>
          <a href="{{ url('/contact') }}" class="mb-2 text-white"><i class="fas fa-angle-right me-2"></i>Contact</a>
        </div>
      </div>

      <!-- Coordonnées -->
      <div class="col-lg-3 col-md-6">
        <h4 class="section-title">Contact</h4>
        <ul class="contact-list mt-4">
          <li class="contact-item">
            <span class="icon"><i class="fas fa-phone"></i></span>
            <a href="tel:+000000000">+33184808124 · 01 84 80 81 24</a>
          </li>
          <li class="contact-item">
            <span class="icon"><i class="fas fa-envelope"></i></span>
            <a href="mailto:contact@ecocall.tn">contact@ecocall.tn</a>
          </li>
          <li class="contact-item">
            <span class="icon"><i class="fas fa-map-marker-alt"></i></span>
            <span>171 Rue de Bezons, 78420 Carrières-sur-Seine, France</span>
          </li>
        </ul>
      </div>

      <!-- Newsletter -->
      <div class="footer-newsletter">
        <h4 class="newsletter-title">Newsletter</h4>
        <p class="newsletter-text">
          Abonnez-vous à notre newsletter pour rester <br>
          informé des dernières actualités, conseils <br>
          et tendances du secteur.
        </p>
        <form class="newsletter-form" action="#" method="post">
          <input type="email" class="newsletter-input" placeholder="Votre e-mail" required>
          <button type="submit" class="newsletter-btn">
            <i class="fas fa-arrow-right"></i>
          </button>
        </form>
      </div>

      <hr class="text-light mt-5 mb-4">
      <!-- Bas de page -->
      <div class="row align-items-center gy-3">
        <div class="col-lg-6 text-center text-lg-start">
          <span class="text-light">Copyright © 2025 France Expert Isolation</span>
        </div>
      </div>
    </div>

  </div>
  <!-- ===== FIN DU FOOTER ===== -->
</div>
