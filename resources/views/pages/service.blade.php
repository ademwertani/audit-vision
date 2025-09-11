@extends('layouts.app')

@section('title', 'Our Services')

@section('content')
<style>
/* =========================================================
   Aisla Nova – Services Index (unified skin)
   Scoped to this page only.
   ========================================================= */
.page-services{
  --navy:#2f3582;
  --navyDark:#1d2760;
  --sky:#31b4eb;
  --accent:#ff6b35;
  --ink:#0f172a;
  --muted:#6b7280;
  --card:#ffffff;
  --ring:#dbe6ff;
  --shadow-lg:0 24px 48px rgba(16,24,40,.12);
  --shadow:0 10px 18px rgba(0,0,0,.08);
}
.page-services *{box-sizing:border-box}

/* ---------- HERO (left-aligned + long pill breadcrumb) ---------- */
.sx-hero{
  background:var(--navy); color:#fff; padding:78px 0 92px; position:relative;
}
.sx-hero .sx-hgroup{max-width:1100px;margin:0 auto;padding:0 12px}
.sx-title{font-size:48px;line-height:1.08;font-weight:800;margin:0 0 10px}
@media (min-width:992px){ .sx-title{font-size:56px} }
.sx-hero h1,.sx-hero .sx-title,.sx-hero p,.sx-hero .sx-sub{color:#fff !important}
.sx-sub{max-width:680px;font-size:15px;line-height:1.7;margin:0;opacity:.95}

/* breadcrumb pill */
.sx-bread-wrap{position:absolute;left:0;right:0;bottom:-28px;display:flex;justify-content:center}
.sx-bread{
  width:min(1180px, calc(100% - 48px));
  background:var(--sky); height:46px; border-radius:9999px;
  display:flex; align-items:center; gap:18px; padding:0 22px;
  font-weight:700; box-shadow:0 10px 18px rgba(3,102,140,.12);
  color:#fff !important;
}
.sx-bread a,.sx-bread span{color:#fff !important}
.sx-bread .sep{color:rgba(255,255,255,.85) !important}
.sx-bread .home-ico{display:inline-grid;place-items:center;width:26px;height:26px;border-radius:50%;
  background:rgba(255,255,255,.22);color:#fff !important;font-size:12px}

/* ---------- Section head ---------- */
.sx-wrap{padding:70px 0 40px}
.sx-head{text-align:center;max-width:820px;margin:0 auto 18px}
.sx-kicker{color:var(--sky);font-weight:800;text-transform:uppercase;letter-spacing:.12em;font-size:.85rem}
.sx-h1{color:var(--ink);font-weight:800;line-height:1.14;margin:8px 0 0}
.sx-tag{color:var(--muted);}

/* ---------- Toolbar (search) ---------- */
.sx-toolbar{display:flex;gap:12px;align-items:center;justify-content:center;flex-wrap:wrap;margin:14px 0 24px}
.sx-search{max-width:520px;width:100%;position:relative}
.sx-search input{
  width:100%; border:1px solid #eef2f6; border-radius:999px; padding:.7rem 1rem .7rem 2.4rem; background:#fff; outline:0;
  transition:border-color .2s ease, box-shadow .2s ease;
}
.sx-search input:focus{ border-color:var(--ring); box-shadow:0 0 0 .2rem rgba(49,180,235,.15) }
.sx-search .fa-search{ position:absolute; left:12px; top:50%; transform:translateY(-50%); opacity:.7 }
#sxCount{color:#64748b}

/* ---------- Services grid ---------- */
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
  padding:10px 14px; border-radius:14px; box-shadow:0 10px 18px rgba(255,107,53,.2);
}
.btn-accent:hover{ filter:brightness(.98) }

/* Empty state */
.svc-empty{background:#f8fafc;border:1px dashed #e5e7eb;border-radius:16px;padding:24px;text-align:center;color:#64748b}
</style>

<section class="page-services">

  {{-- HERO --}}
  <header class="sx-hero">
    <div class="sx-hgroup container">
      <h1 class="sx-title">Services</h1>
      <p class="sx-sub">Services built specifically for your business.</p>
    </div>

    {{-- Long rounded breadcrumb pill --}}
    <div class="sx-bread-wrap">
      <div class="sx-bread">
        <span class="home-ico"><i class="fa fa-home"></i></span>
        <a href="{{ url('/') }}">Home</a>
        <span class="sep">|</span>
        <span>Services</span>
      </div>
    </div>
  </header>

  {{-- LIST --}}
  <div class="sx-wrap">
    <div class="container">

      <div class="sx-head">
        <div class="sx-kicker">Our services</div>
        <h2 class="sx-h1">Services Built Specifically For Your Business</h2>
        <p class="sx-tag mt-1">Browse and click any card to see full details.</p>
      </div>

      {{-- Toolbar --}}
      <div class="sx-toolbar">
        <div class="sx-search">
          <i class="fa fa-search"></i>
          <input id="sxQuery" type="search" placeholder="Search by name or keywords…" aria-label="Search services">
        </div>
        <div id="sxCount" aria-live="polite"></div>
      </div>

      {{-- Grid --}}
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
                    <span class="visually-hidden">Service image placeholder</span>
                  </div>
                @endif

                <div class="body">
                  <h3 class="title">{{ $service->name }}</h3>
                  @if(!empty($service->summary))
                    <p class="sum">{{ $service->summary }}</p>
                  @endif
                  <a href="{{ route('services.show', $service->id) }}" class="btn btn-accent">
                    Read More
                  </a>
                </div>
              </div>
            </article>
          @endforeach
        </div>

        {{-- Pagination (if using LengthAwarePaginator) --}}
        @if(method_exists($services, 'links'))
          <div class="mt-4 d-flex justify-content-center">
            {{ $services->links() }}
          </div>
        @endif
      @else
        <div class="svc-empty">
          <p class="h5 mb-1">No services available yet.</p>
          <p class="mb-0">Please check back soon or <a href="{{ url('/contact') }}">contact us</a> for a custom request.</p>
        </div>
      @endif

    </div>
  </div>

</section>

{{-- Minimal client-side search (keeps your WOW.js intact) --}}
<script>
  (function(){
    const q = document.getElementById('sxQuery');
    const items = Array.from(document.querySelectorAll('.svc-grid > .svc-col'));
    const count = document.getElementById('sxCount');
    if(!q || !items.length) return;

    const updateCount = (n) => {
      const total = items.length;
      count.textContent = n===total ? '' : `${n} result${n!==1?'s':''} of ${total}`;
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
