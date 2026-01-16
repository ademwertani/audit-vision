<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificatController extends Controller
{
    public function index()
    {
        $certificats = Certificat::latest()->paginate(10);
        return view('admin.certificats.index', compact('certificats'));
    }

    public function create()
    {
        return view('admin.certificats.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'pdf_file' => 'required|file|mimes:pdf|max:5000',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('certificats/images', 'public');
        }

        $data['pdf_file'] = $request->file('pdf_file')->store('certificats/pdfs', 'public');

        Certificat::create($data);

        return redirect()->route('admin.certificats.index')->with('success', 'Certificat ajouté.');
    }

    public function edit(Certificat $certificat)
    {
        return view('admin.certificats.edit', compact('certificat'));
    }

    public function update(Request $request, Certificat $certificat)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'pdf_file' => 'nullable|file|mimes:pdf|max:5000',
        ]);

        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($certificat->image) {
                Storage::delete('public/' . $certificat->image);
            }

            $data['image'] = $request->file('image')->store('certificats/images', 'public');
        }

        if ($request->hasFile('pdf_file')) {
            // Supprimer l'ancien fichier PDF si nécessaire
            if ($certificat->pdf_file) {
                Storage::delete('public/' . $certificat->pdf_file);
            }

            $data['pdf_file'] = $request->file('pdf_file')->store('certificats/pdfs', 'public');
        }

        $certificat->update($data);

        return redirect()->route('admin.certificats.index')->with('success', 'Certificat mis à jour.');
    }

    public function destroy(Certificat $certificat)
    {
        // Supprimer l'image et le fichier PDF du stockage
        if ($certificat->image) {
            Storage::delete('public/' . $certificat->image);
        }

        if ($certificat->pdf_file) {
            Storage::delete('public/' . $certificat->pdf_file);
        }

        $certificat->delete();

        return back()->with('success', 'Certificat supprimé.');
    }
}
