<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class QuestionController extends Controller
{
    public function index()
    {
        return Question::all();
    }

    public function store(Request $request)
    {
        try {

            $request->validate([
                'content' => 'required|string',
                'theme_id' => 'required',
            ]);

            $data = $request->all();
            $data["owner_id"] = Auth::id();

            return Question::create($data);
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

            $question = Question::find($id);

            if (!$question) {
                return [
                    "message" => "Question non trouvé !",
                ];
            }

            return $question;

        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function update(Request $request, $id)
    {
        try {

            $request->validate([
                'content' => 'required|string',
                'theme_id' => 'required',
            ]);

            $question = Question::find($id);

            if (!$question) {
                return [
                    "message" => "Question non trouvé !",
                ];
            }

            $question->update($request->all());

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

            $question = Question::find($id);

            if (!$question) {
                return [
                    "message" => "Question non trouvé !",
                ];
            }

            $question->delete();

            return [
                "message" => "Suppression effectuée !",
            ];

        } catch (\Throwable $th) {
            return $th;
        }
    }
}