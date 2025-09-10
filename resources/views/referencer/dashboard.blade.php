@extends('layouts.app')

@section('title', 'Referencer Dashboard - HighTech')

@section('content')
<div class="container-fluid py-5 bg-primary hero-header">
    <div class="container py-5">
        <div class="row justify-content-center py-5">
            <div class="col-lg-10 pt-lg-5 mt-lg-5 text-center">
                <h1 class="display-4 text-white mb-3 animated slideInDown">Referencer Dashboard</h1>
            </div>
        </div>
    </div>
</div>

<div class="container-xxl py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body p-5 text-center">
                        <i class="fas fa-user-tie fa-5x text-primary mb-4"></i>
                        <h3 class="mb-3">Welcome, Referencer!</h3>
                        <p class="mb-4">You have access to referencer-specific features</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection