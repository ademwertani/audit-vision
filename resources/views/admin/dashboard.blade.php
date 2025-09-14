@extends('layouts.app')

@section('title', 'Admin Dashboard - HighTech')

@section('content')
<div class="container-fluid py-5 bg-primary hero-header">
    <div class="container py-5">
        <div class="row justify-content-center py-5">
            <div class="col-lg-10 pt-lg-5 mt-lg-5 text-center">
                <h1 class="display-4 text-white mb-3 animated slideInDown">Admin Dashboard</h1>
            </div>
        </div>
    </div>
</div>

<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="bg-light text-center p-4">
                    <i class="fa fa-users fa-3x text-primary mb-3"></i>
                    <h3 class="mb-3">Manage Users</h3>
                    <p>Create, edit and manage all system users</p>
                    <a href="{{ route('users.index') }}" class="btn btn-primary py-2 px-4">Go to Users</a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="bg-light text-center p-4">
                    <i class="fab fa-youtube fa-3x text-primary mb-3"></i>
                    <h3 class="mb-3">Manage YouTube Video</h3>
                    <p>Update the clean energy section video.</p>
                    <a href="{{ route('admin.video.edit') }}" class="btn btn-primary py-2 px-4">Edit Video</a>
                </div>
            </div>

            <!-- Add more dashboard cards as needed -->
        </div>
    </div>
</div>
@endsection