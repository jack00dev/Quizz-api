<?php

namespace App\Http\Controllers;

use App\Models\Phase;
use Illuminate\Http\Request;

class PhaseController extends Controller
{
    public function index()
    {
        return response()->json(Phase::all(), 200);
    }

    public function store(Request $request)
    {
        $phase = Phase::create($request->only('title', 'description', 'points_per_question'));
        return response()->json($phase, 201);
    }

    public function show($id)
    {
        return response()->json(Phase::with('themes')->findOrFail($id), 200);
    }

    public function update(Request $request, $id)
    {
        $phase = Phase::findOrFail($id);
        $phase->update($request->only('title', 'description', 'points_per_question'));
        return response()->json($phase, 200);
    }

    public function destroy($id)
    {
        Phase::destroy($id);
        return response()->json(null, 204);
    }
}
