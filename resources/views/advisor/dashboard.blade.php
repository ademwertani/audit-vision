@extends('layouts.app')

@section('title', 'Advisor Dashboard - HighTech')

@section('content')
<div class="container-fluid py-5 bg-primary hero-header">
    <div class="container py-5">
        <div class="row justify-content-center py-5">
            <div class="col-lg-10 pt-lg-5 mt-lg-5 text-center">
                <h1 class="display-4 text-white mb-3 animated slideInDown">Advisor Dashboard</h1>
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
                        <i class="fas fa-chalkboard-teacher fa-5x text-primary mb-4"></i>
                        <h3 class="mb-3">Welcome, Advisor!</h3>
                        <p class="mb-4">You have access to advisor-specific features</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection