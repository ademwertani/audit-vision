<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 3);
        $teams = Team::paginate($perPage);
        return response()->json($teams);
    }
}
