<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        return response()->json(Question::with('options')->get(), 200);
    }

    public function store(Request $request)
    {
        $question = Question::create($request->only('content', 'theme_id'));
        return response()->json($question, 201);
    }

    public function show($id)
    {
        return response()->json(Question::with('options')->findOrFail($id), 200);
    }

    public function update(Request $request, $id)
    {
        $question = Question::findOrFail($id);
        $question->update($request->only('content', 'theme_id'));
        return response()->json($question, 200);
    }

    public function destroy($id)
    {
        Question::destroy($id);
        return response()->json(null, 204);
    }
}