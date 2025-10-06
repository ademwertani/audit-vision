<?php

namespace App\Http\Controllers;
use App\Models\Banner;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
    {
        $banner = \App\Models\Banner::latest()->first();
    $heroBannerImg = $banner && $banner->image
        ? asset('storage/'.ltrim($banner->image,'/'))
        : asset('img/default-banner.jpg');
        $services = Service::all(); // Get all services from database
        return view('pages.service', compact('services','heroBannerImg'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
     public function show(Service $service)
    {
        $banner = \App\Models\Banner::latest()->first();
    $heroBannerImg = $banner && $banner->image
        ? asset('storage/'.ltrim($banner->image,'/'))
        : asset('img/default-banner.jpg');
        return view('pages.service-show', compact('service','heroBannerImg'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
