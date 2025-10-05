<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index() {
        $partners = Partner::latest()->get();
        return view('admin.partners.index', compact('partners'));
    }

    public function create() {
        return view('admin.partners.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'required|image|max:2048',
        ]);

        $data['logo'] = $request->file('logo')->store('partners', 'public');

        Partner::create($data);
        return redirect()->route('admin.partners.index')->with('success', 'Partenaire ajouté.');
    }

    public function edit(Partner $partner) {
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(Request $request, Partner $partner) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('partners', 'public');
        }

        $partner->update($data);
        return redirect()->route('admin.partners.index')->with('success', 'Partenaire mis à jour.');
    }

    public function destroy(Partner $partner) {
        $partner->delete();
        return back()->with('success', 'Partenaire supprimé.');
    }
}
