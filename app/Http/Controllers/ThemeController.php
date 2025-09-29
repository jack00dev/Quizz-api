<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ThemeController extends Controller
{
    public function index()
    {
        return Theme::all();
    }

    public function store(Request $request)
    {
        try {

            $request->validate([
                'title' => 'required|string|max:255',
                'phase_id' => 'required',
            ]);

            $data = $request->all();
            $data["owner_id"] = Auth::id();

            return Theme::create($data);
        } catch (ValidationException $err) {
            return [
                'message' => "Données non valides",
                'error' => $err->errors(),
            ];
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function show($id)
    {
        try {

            $theme = Theme::find($id);

            if (!$theme) {
                return [
                    "message" => "Thème non trouvé !",
                ];
            }

            return $theme;

        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function update(Request $request, $id)
    {

        try {

            $request->validate([
                'title' => 'required|string|max:255',
                'phase_id' => 'required',
            ]);

            $theme = Theme::find($id);

            if (!$theme) {
                return [
                    "message" => "Thème non trouvé !",
                ];
            }

            $theme->update($request->all());

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

    public function destroy($id)
    {
        try {

            $theme = Theme::find($id);

            if (!$theme) {
                return [
                    "message" => "Thème non trouvé !",
                ];
            }

            $theme->delete();

            return [
                "message" => "Suppression effectuée !",
            ];

        } catch (\Throwable $th) {
            return $th;
        }
    }
}