<!-- ===== FULL FOOTER (HTML + CSS) ===== -->
<style>
  /* ===== AISLA-style footer palette & resets ===== */
  .footer-aisla {
    --footer-bg: #242958;
    /* deep indigo background */
    --accent: #7CAE2A;
    /* orange button/accent */
    --newsletter: #36A9E1;
    /* blue pill bar */
    --ink: #E9EDFF;
    /* primary light text */
    --muted: #BFC7FF;
    /* muted link text */
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

  /* Section headers with orange underline */
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

  /* Make .text-secondary orange only inside footer */
  .footer-aisla .text-secondary {
    color: var(--accent) !important;
  }

  /* Social buttons: white circular */
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

  /* Useful links list */
  .footer-aisla .short-link a {
    display: flex;
    align-items: center;
    font-weight: 500;
  }

  .footer-aisla .short-link i {
    color: var(--accent) !important;
  }

  /* Contact items with orange circular icons */
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

  /* Divider & bottom links */
  .footer-aisla hr {
    border-color: rgba(255, 255, 255, 0.15);
  }

  .footer-aisla .about-text {
    color: #E9EDFF;
    /* même couleur que newsletter-text */
    font-size: 0.95rem;
    /* ou la même taille que newsletter-text */
    line-height: 1.6;
    /* lisibilité */
    margin-top: 0rem;
    opacity: 0.9;
    /* même effet léger */
  }

  .footer-aisla .footer-links a {
    color: var(--muted);
    margin-left: 1rem;
  }

  .footer-aisla .logo-navbar {
    max-height: 520px;
    /* agrandir le logo (ajuste la valeur selon ton besoin) */
    margin-bottom: 2rem;
    /* réduit l’espace entre logo et texte */
    display: block;
  }

  .footer-aisla .col-lg-4.col-md-6 {
    margin-top: 10px;
    /* remonte légèrement le bloc entier */
  }

  .footer-aisla .footer-links a:first-child {
    margin-left: 0;
  }

  /* ===== Newsletter pill EXACTLY like screenshot ===== */
</style>

<div class="container-fluid footer footer-aisla wow fadeIn" data-wow-delay=".3s">
  <div class="container pt-5 pb-4">

    <div class="row g-5">
      <!-- Brand + about -->
      <div class="col-lg-4 col-md-6">
        <a href="{{ url('/') }}">
          <img src="{{ asset('img/newl.png') }}" alt="EcoCall Logo" class="logo-navbar">
        </a>
        <p class="about-text">
          At Mentary, we believe in the <br> power of renewable energy to <br>create a more sustainable <br>future.
        </p>
      </div>


      <!-- Useful links -->
      <div class="col-lg-2 col-md-6">
        <h4 class="section-title">Services</h4>
        <div class="mt-4 d-flex flex-column short-link">
          <a href="{{ url('/about') }}" class="mb-2 text-white"><i class="fas fa-angle-right me-2"></i>À propos</a>
          <a href="{{ url('/formation') }}" class="mb-2 text-white"><i class="fas fa-angle-right me-2"></i>Nos
            Formations</a>
          <a href="{{ url('/services') }}" class="mb-2 text-white"><i class="fas fa-angle-right me-2"></i>Nos
            Services</a>
          <a href="{{ url('/contact') }}" class="mb-2 text-white"><i class="fas fa-angle-right me-2"></i>Contact</a>
        </div>
      </div>


      <!-- Contact info -->
      <div class="col-lg-3 col-md-6">
        <h4 class="section-title">Contact Info</h4>
        <ul class="contact-list mt-4">
          <li class="contact-item">
            <span class="icon"><i class="fas fa-phone"></i></span>
            <a href="tel:+000000000">01234 525 407 · 01234 525 407</a>
          </li>
          <li class="contact-item">
            <span class="icon"><i class="fas fa-envelope"></i></span>
            <a href="mailto:contact@ecocall.tn">contact@ecocall.tn</a>
          </li>
          <li class="contact-item">
            <span class="icon"><i class="fas fa-map-marker-alt"></i></span>
            <span>12/7 new town, 245x Street, Tunis, Tunisie</span>
          </li>
        </ul>
      </div>
      <!-- Newsletter section (footer) -->
      <div class="footer-newsletter">
        <h4 class="newsletter-title">Newsletter</h4>
        <p class="newsletter-text"> Subscribe to our newsletter to stay <br> up-to-date with the latest news,<br> tips,
          and
          trends in the industry </p>
        <form class="newsletter-form" action="#" method="post"> <input type="email" class="newsletter-input"
            placeholder="Your Email" required> <button type="submit" class="newsletter-btn"> <i
              class="fas fa-arrow-right"></i> </button> </form>
      </div>

      <hr class="text-light mt-5 mb-4">
      <!-- Bottom row -->
      <div class="row align-items-center gy-3">
        <div class="col-lg-6 text-center text-lg-start">
          <span class="text-light">Copyright © 2025 France expert isolation</span>
        </div>
      </div>
    </div>

  </div>
  <!-- ===== END FULL FOOTER ===== -->