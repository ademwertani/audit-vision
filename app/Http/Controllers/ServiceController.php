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
        $banner = Banner::latest()->first();

        $heroBannerImg = $banner && $banner->image
            ? asset('storage/' . ltrim($banner->image, '/'))
            : asset('img/default-banner.jpg');

        // Charger aussi la catégorie si tu l’affiches sur la page liste
        $services = Service::with('category')->get();

        return view('pages.service', compact('services', 'heroBannerImg'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        $banner = Banner::latest()->first();

        $heroBannerImg = $banner && $banner->image
            ? asset('storage/' . ltrim($banner->image, '/'))
            : asset('img/default-banner.jpg');

        // Si la vue a besoin de la catégorie :
        $service->load('category');

        return view('pages.service-show', compact('service', 'heroBannerImg'));
    }

    /* Les autres méthodes ne sont pas utilisées sur le front
       (create/store/edit/update/destroy) et restent vides par défaut. */

    public function create() { /* not used on front */ }

    public function store(Request $request) { /* not used on front */ }

    public function edit(string $id) { /* not used on front */ }

    public function update(Request $request, string $id) { /* not used on front */ }

    public function destroy(string $id) { /* not used on front */ }
}
