<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stat;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StatController extends Controller
{
    public function index()
    {
        $stats = Stat::ordered()->get();
        return view('admin.stats.index', compact('stats'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'label'          => ['required','string','max:80'],
            'slug'           => ['nullable','string','max:80', 'unique:stats,slug'],
            'value'          => ['required','integer','min:0'],
            'is_accent'      => ['sometimes','boolean'],
            'display_order'  => ['nullable','integer','min:-1000','max:1000'],
        ]);
        $data['is_accent'] = (bool) ($data['is_accent'] ?? false);
        $data['display_order'] = $data['display_order'] ?? 0;

        Stat::create($data);

        return back()->with('success','Stat créée.');
    }

    public function update(Request $request, Stat $stat)
    {
        $data = $request->validate([
            'label'          => ['required','string','max:80'],
            'slug'           => ['nullable','string','max:80', Rule::unique('stats','slug')->ignore($stat->id)],
            'value'          => ['required','integer','min:0'],
            'is_accent'      => ['sometimes','boolean'],
            'display_order'  => ['nullable','integer','min:-1000','max:1000'],
        ]);
        $data['is_accent'] = (bool) ($data['is_accent'] ?? false);
        $data['display_order'] = $data['display_order'] ?? 0;

        $stat->update($data);

        return back()->with('success','Stat mise à jour.');
    }

    public function destroy(Stat $stat)
    {
        $stat->delete();
        return back()->with('success','Stat supprimée.');
    }
}
