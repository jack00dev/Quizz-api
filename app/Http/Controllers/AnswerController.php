<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Stat;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function index()
    {
        return response()->json(Answer::with(['user', 'question', 'option'])->get(), 200);
    }

    public function store(Request $request)
    {
        $answer = Answer::create($request->only('user_id', 'question_id', 'option_id'));

        // Vérifier si la réponse est correcte
        $option = $answer->option;
        $phase = $answer->question->theme->phase;

        if ($option->is_correct) {
            // Chercher la stat de l’utilisateur pour cette phase
            $stat = Stat::firstOrCreate(
                ['user_id' => $answer->user_id, 'phase_id' => $phase->id],
                ['score' => 0]
            );

            // Ajouter les points
            $stat->score += $phase->points_per_question;
            $stat->save();
        }

        return response()->json($answer, 201);
    }

    public function show($id)
    {
        return response()->json(Answer::with(['user', 'question', 'option'])->findOrFail($id), 200);
    }

    public function update(Request $request, $id)
    {
        $answer = Answer::findOrFail($id);
        $answer->update($request->only('user_id', 'question_id', 'option_id'));
        return response()->json($answer, 200);
    }

    public function destroy($id)
    {
        Answer::destroy($id);
        return response()->json(null, 204);
    }
}