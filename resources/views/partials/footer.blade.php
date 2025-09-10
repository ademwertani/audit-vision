<!-- ===== FULL FOOTER (HTML + CSS) ===== -->
<style>
  /* ===== AISLA-style footer palette & resets ===== */
  .footer-aisla {
    --footer-bg: #272e77;        /* deep indigo background */
    --accent: #E75A2A;           /* orange button/accent */
    --newsletter: #36A9E1;       /* blue pill bar */
    --ink: #E9EDFF;              /* primary light text */
    --muted: #BFC7FF;            /* muted link text */
  }

  .footer.footer-aisla {
    background: var(--footer-bg) !important;
    color: var(--ink);
    position: relative;
    overflow: hidden;
  }
  .footer-aisla a { color: #fff; text-decoration: none; }
  .footer-aisla a:hover { opacity: .85; }

  /* Section headers with orange underline */
  .footer-aisla .section-title {
    color: #fff;
    margin-bottom: .75rem;
    position: relative;
  }
  .footer-aisla .section-title::after{
    content:"";
    display:block;
    width:56px;height:3px;
    background: var(--accent);
    border-radius: 2px;
    margin-top:8px;
  }

  /* Make .text-secondary orange only inside footer */
  .footer-aisla .text-secondary { color: var(--accent) !important; }

  /* Social buttons: white circular */
  .footer-aisla .btn-square{
    width:42px;height:42px; border:0;
    display:inline-flex;align-items:center;justify-content:center;
    background:#ffffff; color:#1a225a; box-shadow:none;
  }
  .footer-aisla .btn-square i{ color:#1a225a !important; }
  .footer-aisla .btn-square:hover{ transform: translateY(-1px); }

  /* Useful links list */
  .footer-aisla .short-link a{
    display:flex; align-items:center;
    font-weight: 500;
  }
  .footer-aisla .short-link i{ color: var(--accent) !important; }

  /* Contact items with orange circular icons */
  .footer-aisla .contact-list{ list-style:none; padding-left:0; margin:0; }
  .footer-aisla .contact-item{
    display:flex; align-items:center; gap:.75rem; margin-bottom:.75rem;
  }
  .footer-aisla .contact-item .icon{
    width:36px;height:36px;border-radius:50%;
    background: var(--accent); color:#fff;
    display:inline-flex; align-items:center; justify-content:center;
    flex: 0 0 36px;
  }

  /* Divider & bottom links */
  .footer-aisla hr{ border-color: rgba(255,255,255,.15); }
  .footer-aisla .footer-links a{ color: var(--muted); margin-left:1rem; }
  .footer-aisla .footer-links a:first-child{ margin-left:0; }

  /* ===== Newsletter pill EXACTLY like screenshot ===== */
  .footer-aisla .newsletter-bar{
    background: var(--newsletter);
    border-radius: 9999px; /* full pill */
    padding: 14px 18px;
    gap: 18px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .footer-aisla .nl-left{
    display:flex; align-items:center; gap:14px; flex:0 0 auto;
  }
  .footer-aisla .newsletter-badge{
    width: 48px; height: 48px; border-radius: 50%;
    background: #fff; display:flex; align-items:center; justify-content:center;
  }
  .footer-aisla .newsletter-badge i{ font-size:20px; color:#2d8fc9; }
  .footer-aisla .newsletter-title{
    color:#fff; font-weight:700; font-size:22px; letter-spacing:.2px; margin:0;
  }

  .footer-aisla .newsletter-form{
    flex:1 1 auto; display:flex; align-items:center; gap:16px;
    margin-left: 12px;
  }
  .footer-aisla .newsletter-input{
    flex:1 1 auto; height:48px; border:0; background:#fff;
    border-radius:9999px; padding:0 22px; outline:none;
  }
  .footer-aisla .newsletter-input::placeholder{ color:#7b8aa6; }
  .footer-aisla .newsletter-btn{
    height:48px; padding:0 26px; border:0;
    border-radius:9999px; background: var(--accent); color:#fff; font-weight:700;
    white-space: nowrap;
  }

  /* Larger proportions on md+ (closer to reference) */
  @media (min-width: 768px){
    .footer-aisla .newsletter-bar{ padding:18px 22px; gap:22px; }
    .footer-aisla .newsletter-badge{ width:52px; height:52px; }
    .footer-aisla .newsletter-title{ font-size:24px; }
    .footer-aisla .newsletter-input, .footer-aisla .newsletter-btn{ height:56px; }
  }
  /* Mobile stacking */
  @media (max-width: 767.98px){
    .footer-aisla .newsletter-bar{ border-radius:18px; flex-direction: column; align-items: stretch; }
    .footer-aisla .newsletter-form{ width:100%; margin-left:0; }
  }
</style>

<div class="container-fluid footer footer-aisla wow fadeIn" data-wow-delay=".3s">
  <div class="container pt-5 pb-4">

    <div class="row g-5">
      <!-- Brand + about (ORIGINAL CONTENT KEPT) -->
      <div class="col-lg-4 col-md-6">
        <a href="{{ url('/') }}">
          <h1 class="text-white fw-bold d-block">Eco<span class="text-secondary">Call</span></h1>
        </a>
        <p class="mt-4 text-light">
          Eco Call est un centre de formation dédié aux métiers de la relation client, spécialisé dans les solutions de call center innovantes.
        </p>
        <div class="d-flex">
          <a href="#" class="btn-light nav-fill btn btn-square rounded-circle me-2"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="btn-light nav-fill btn btn-square rounded-circle me-2"><i class="fab fa-instagram"></i></a>
          <a href="#" class="btn-light nav-fill btn btn-square rounded-circle"><i class="fab fa-linkedin-in"></i></a>
        </div>
      </div>

      <!-- Contact information (added to match reference) -->
      <div class="col-lg-4 col-md-6">
        <h4 class="section-title">Informations de contact</h4>
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

      <!-- Useful links (ORIGINAL LINKS KEPT) -->
      <div class="col-lg-2 col-md-6">
        <h4 class="section-title">Liens utiles</h4>
        <div class="mt-4 d-flex flex-column short-link">
          <a href="{{ url('/about') }}" class="mb-2 text-white"><i class="fas fa-angle-right me-2"></i>À propos</a>
          <a href="{{ url('/formation') }}" class="mb-2 text-white"><i class="fas fa-angle-right me-2"></i>Nos Formations</a>
          <a href="{{ url('/services') }}" class="mb-2 text-white"><i class="fas fa-angle-right me-2"></i>Nos Services</a>
          <a href="{{ url('/contact') }}" class="mb-2 text-white"><i class="fas fa-angle-right me-2"></i>Contact</a>
        </div>
      </div>

      <!-- Second links column (to mirror reference) -->
      <div class="col-lg-2 col-md-6">
        <h4 class="section-title">Ressources</h4>
        <div class="mt-4 d-flex flex-column short-link">
          <a href="#" class="mb-2 text-white"><i class="fas fa-angle-right me-2"></i>Management de la Qualité</a>
          <a href="#" class="mb-2 text-white"><i class="fas fa-angle-right me-2"></i>Santé & Sécurité</a>
          <a href="#" class="mb-2 text-white"><i class="fas fa-angle-right me-2"></i>Environnement</a>
        </div>
      </div>
    </div>

    <!-- Newsletter pill (exactly like the screenshot) -->
    <div class="newsletter-bar mt-5">
      <div class="nl-left">
        <span class="newsletter-badge"><i class="far fa-envelope"></i></span>
        <p class="newsletter-title mb-0">Subscribe To Our Newsletter.</p>
      </div>

      <form class="newsletter-form" action="#" method="post">
        <input type="email" class="newsletter-input" placeholder="Enter Your Email Address..." required>
        <button type="submit" class="newsletter-btn">Subscribe</button>
      </form>
    </div>

    <hr class="text-light mt-5 mb-4">

    <!-- Bottom row -->
    <div class="row align-items-center gy-3">
      <div class="col-lg-6 text-center text-lg-start">
        <span class="text-light">© Eco Call, Tous droits réservés.</span>
      </div>
      <div class="col-lg-6 text-center text-lg-end">
        <span class="footer-links">
          <a href="#">Privacy Policy</a>
          <a href="#">Terms & Conditions</a>
          <a href="{{ url('/about') }}">About Us</a>
        </span>
        <span class="text-light d-block d-md-inline ms-md-3">Conçu par <a href="#" class="text-secondary">Votre Équipe</a></span>
      </div>
    </div>
  </div>
</div>
<!-- ===== END FULL FOOTER ===== -->
