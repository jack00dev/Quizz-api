<?php

namespace App\Http\Controllers;

use App\Models\Phase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PhaseController extends Controller
{
    // Liste toutes les phases
    public function index()
    {
        return Phase::all();
    }

    // Crée une nouvelle phase
    public function store(Request $request)
    {
        try {

            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'points_per_question' => 'required|integer|min:0',
                'niveau' => 'in:débutant,intermédiaire,avancé',
            ]);

            $data = $request->all();
            $data["owner_id"] = Auth::id();

            return Phase::create($data);
        } catch (ValidationException $err) {
            return [
                'message' => "Données non valides",
                'error' => $err->errors(),
            ];
        } catch (\Throwable $th) {
            return $th;
        }
    }

    // Affiche une phase spécifique avec ses thèmes
    public function show($id)
    {
        try {

            $phase = Phase::find($id);

            if (!$phase) {
                return [
                    "message" => "Phase non trouvé !",
                ];
            }

            return $phase;

        } catch (\Throwable $th) {
            return $th;
        }
    }

    // Met à jour une phase existante
    public function update(Request $request, $id)
    {
        try {

            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'points_per_question' => 'required|integer|min:0',
                'niveau' => 'in:débutant,intermédiaire,avancé',
            ]);

            $phase = Phase::find($id);

            if (!$phase) {
                return [
                    "message" => "Phase non trouvé !",
                ];
            }

            $phase->update($request->all());

            return [
                "message" => "Mise à jour effectuée !",
            ];
        } catch (ValidationException $err) {
            return [
                'message' => "Données non valides",
                'error' => $err->errors(),
            ];
        } catch (\Throwable $th) {
            return $th;
        }
    }

    // Supprime une phase
    public function destroy($id)
    {
        try {

            $phase = Phase::find($id);

            if (!$phase) {
                return [
                    "message" => "Phase non trouvé !",
                ];
            }

            $phase->delete();

            return [
                "message" => "Suppression effectuée !",
            ];

        } catch (\Throwable $th) {
            return $th;
        }
    }
}