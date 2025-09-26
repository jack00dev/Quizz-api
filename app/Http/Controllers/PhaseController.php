<?php

namespace App\Http\Controllers;

use App\Models\Phase;
use Illuminate\Http\Request;

class PhaseController extends Controller
{
    // Liste toutes les phases
    public function index()
    {
        return response()->json(Phase::all(), 200);
    }

    // Crée une nouvelle phase
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'points_per_question' => 'required|integer|min:0',
            'niveau' => 'in:débutant,intermédiaire,avancé',
        ]);

        $phase = Phase::create($validated);
        return response()->json($phase, 201);
    }

    // Affiche une phase spécifique avec ses thèmes
    public function show($id)
    {
        $phase = Phase::with('themes')->findOrFail($id);
        return response()->json($phase, 200);
    }

    // Met à jour une phase existante
    public function update(Request $request, $id)
    {
        $phase = Phase::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'points_per_question' => 'sometimes|required|integer|min:0',
            'niveau' => 'in:débutant,intermédiaire,avancé',
        ]);

        $phase->update($validated);
        return response()->json($phase, 200);
    }

    // Supprime une phase
    public function destroy($id)
    {
        Phase::destroy($id);
        return response()->json(null, 204);
    }
}