<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function index()
    {
        return response()->json(Theme::with('phase')->get(), 200);
    }

    public function store(Request $request)
    {
        $theme = Theme::create($request->only('title', 'phase_id'));
        return response()->json($theme, 201);
    }

    public function show($id)
    {
        return response()->json(Theme::with('questions')->findOrFail($id), 200);
    }

    public function update(Request $request, $id)
    {
        $theme = Theme::findOrFail($id);
        $theme->update($request->only('title', 'phase_id'));
        return response()->json($theme, 200);
    }

    public function destroy($id)
    {
        Theme::destroy($id);
        return response()->json(null, 204);
    }
}