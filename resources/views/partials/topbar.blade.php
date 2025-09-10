<div class="container-fluid bg-dark py-2 d-none d-md-flex">
    <div class="container">
        <div class="d-flex justify-content-between topbar">
            <div class="top-info">
                @if($about->location)
                <small class="me-3 text-white-50">
                    <a href="#"><i class="fas fa-map-marker-alt me-2 text-secondary"></i></a> {{ $about->location }}
                </small>
                @endif
                @if($about->email)
                <small class="me-3 text-white-50">
                    <a href="mailto:{{ $about->email }}"><i class="fas fa-envelope me-2 text-secondary"></i></a> {{ $about->email }}
                </small>
                @endif
            </div>
            <div id="note" class="text-secondary d-none d-xl-flex">
                @if($about->summary)
                <small>{{ Str::limit($about->summary, 50) }}</small>
                @else
                <small>Isolation avec eco call</small>
                @endif
            </div>
            <div class="top-link">
                @if($social->facebook)
                <a href="{{ $social->facebook }}" target="_blank" class="bg-light nav-fill btn btn-sm-square rounded-circle">
                    <i class="fab fa-facebook-f text-primary"></i>
                </a>
                @endif
                
                @if($social->instagram)
                <a href="{{ $social->instagram }}" target="_blank" class="bg-light nav-fill btn btn-sm-square rounded-circle">
                    <i class="fab fa-instagram text-primary"></i>
                </a>
                @endif
                @if($social->linkedin)
                <a href="{{ $social->linkedin }}" target="_blank" class="bg-light nav-fill btn btn-sm-square rounded-circle me-0">
                    <i class="fab fa-linkedin-in text-primary"></i>
                </a>
                @endif
            </div>
        </div>
    </div>
</div>