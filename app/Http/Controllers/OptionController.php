<?php

namespace App\Http\Controllers;

use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class OptionController extends Controller
{
    public function index()
    {
        return Option::all();
    }

    public function store(Request $request)
    {

        try {

            $request->validate([
                'text' => 'required|string',
                'is_correct' => 'required|boolean',
                'question_id' => 'required',
            ]);

            $data = $request->all();
            $data["owner_id"] = Auth::id();

            return Option::create($data);
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

            $option = Option::find($id);

            if (!$option) {
                return [
                    "message" => "Option non trouvé !",
                ];
            }

            return $option;

        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function update(Request $request, $id)
    {
        try {

            $request->validate([
                'text' => 'required|string',
                'is_correct' => 'required|boolean',
                'question_id' => 'required',
            ]);

            $option = Option::find($id);

            if (!$option) {
                return [
                    "message" => "Option non trouvé !",
                ];
            }

            $option->update($request->all());

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

            $option = Option::find($id);

            if (!$option) {
                return [
                    "message" => "Option non trouvé !",
                ];
            }

            $option->delete();

            return [
                "message" => "Suppression effectuée !",
            ];

        } catch (\Throwable $th) {
            return $th;
        }
    }
}