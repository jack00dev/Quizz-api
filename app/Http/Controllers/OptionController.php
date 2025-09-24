<?php

namespace App\Http\Controllers;

use App\Models\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function index()
    {
        return response()->json(Option::all(), 200);
    }

    public function store(Request $request)
    {
        $option = Option::create($request->only('text', 'is_correct', 'question_id'));
        return response()->json($option, 201);
    }

    public function show($id)
    {
        return response()->json(Option::findOrFail($id), 200);
    }

    public function update(Request $request, $id)
    {
        $option = Option::findOrFail($id);
        $option->update($request->only('text', 'is_correct', 'question_id'));
        return response()->json($option, 200);
    }

    public function destroy($id)
    {
        Option::destroy($id);
        return response()->json(null, 204);
    }
}