<?php

namespace App\Http\Controllers;

use App\Models\Stat;
use Illuminate\Http\Request;

class StatController extends Controller
{
    // Score total de l’utilisateur
    public function userTotal($user_id)
    {
        $score = Stat::where('user_id', $user_id)->sum('score');
        $total = Stat::where('user_id', $user_id)->sum('total');

        return response()->json([
            'user_id' => $user_id,
            'score' => $score,
            'total' => $total,
            'percentage' => $total > 0 ? round($score / $total * 100, 2) : 0,
        ]);
    }

    // Score par phase
    public function userByPhase($user_id, $phase_id)
    {
        $stats = Stat::where('user_id', $user_id)
                     ->where('phase_id', $phase_id)
                     ->get();

        $score = $stats->sum('score');
        $total = $stats->sum('total');

        return response()->json([
            'user_id' => $user_id,
            'phase_id' => $phase_id,
            'score' => $score,
            'total' => $total,
            'percentage' => $total > 0 ? round($score / $total * 100, 2) : 0,
        ]);
    }

    // Tous les scores par phases
    public function userAllPhases($user_id)
    {
        $stats = Stat::where('user_id', $user_id)
                     ->with('phase')
                     ->get()
                     ->groupBy('phase_id');

        $phases = $stats->map(function ($group) {
            $score = $group->sum('score');
            $total = $group->sum('total');
            $phase = $group->first()->phase;

            return [
                'phase_id' => $group->first()->phase_id,
                'phase_title' => $phase ? $phase->title : 'Inconnue',
                'score' => $score,
                'total' => $total,
                'percentage' => $total > 0 ? round($score / $total * 100, 2) : 0,
            ];
        })->values();

        return response()->json([
            'user_id' => $user_id,
            'phases' => $phases,
        ]);
    }

    // Tous les scores par thème (bonus)
    public function userAllThemes($user_id)
    {
        $stats = Stat::where('user_id', $user_id)
                     ->with('theme')
                     ->get()
                     ->groupBy('theme_id');

        $themes = $stats->map(function ($group) {
            $score = $group->sum('score');
            $total = $group->sum('total');
            $theme = $group->first()->theme;

            return [
                'theme_id' => $group->first()->theme_id,
                'theme_title' => $theme ? $theme->title : 'Inconnu',
                'score' => $score,
                'total' => $total,
                'percentage' => $total > 0 ? round($score / $total * 100, 2) : 0,
            ];
        })->values();

        return response()->json([
            'user_id' => $user_id,
            'themes' => $themes,
        ]);
    }
}