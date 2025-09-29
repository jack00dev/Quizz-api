<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Stat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AnswerController extends Controller
{
    public function index()
    {
        return Answer::all();
    }

    public function store(Request $request)
    {

        try {

            $request->validate([
                'user_id' => 'required|exists:users,id',
                'phase_id' => 'required|exists:phases,id',
                'theme_id' => 'required|exists:themes,id',
                'question_id' => 'required|exists:questions,id',
                'option_id' => 'required|exists:options,id',
            ]);

            $data = $request->all();
            $data["owner_id"] = Auth::id();

            return Answer::create($data);
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

            $answer = Answer::find($id);

            if (!$answer) {
                return [
                    "message" => "Réponse non trouvé !",
                ];
            }

            return $answer;

        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function update(Request $request, $id)
    {
        try {

            $request->validate([
                'user_id' => 'required|exists:users,id',
                'phase_id' => 'required|exists:phases,id',
                'theme_id' => 'required|exists:themes,id',
                'question_id' => 'required|exists:questions,id',
                'option_id' => 'required|exists:options,id',
            ]);

            $answer = Answer::find($id);

            if (!$answer) {
                return [
                    "message" => "Réponse non trouvé !",
                ];
            }

            $answer->update($request->all());

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

    public function getUserAnswers($user_id)
    {
        $answers = Answer::where('user_id', $user_id)->get();

        if ($answers->isEmpty()) {
            // Retourner un tableau vide plutôt qu’un message
            return response()->json([], 200);
        }

        return response()->json($answers, 200);
    }



    public function destroy($id)
    {
        try {

            $answer = Answer::find($id);

            if (!$answer) {
                return [
                    "message" => "Réponse non trouvé !",
                ];
            }

            $answer->delete();

            return [
                "message" => "Suppression effectuée !",
            ];

        } catch (\Throwable $th) {
            return $th;
        }
    }
}