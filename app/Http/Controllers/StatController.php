<?php

namespace App\Http\Controllers;

use App\Models\Stat;
use Illuminate\Http\Request;

class StatController extends Controller
{
    // Score total de l’utilisateur
    public function userTotal($user_id)
    {
        $total = Stat::where('user_id', $user_id)->sum('score');

        return response()->json([
            'user_id' => $user_id,
            'total_score' => $total
        ]);
    }

    // Score par phase
    public function userByPhase($user_id, $phase_id)
    {
        $stat = Stat::where('user_id', $user_id)
                    ->where('phase_id', $phase_id)
                    ->first();

        return response()->json([
            'user_id' => $user_id,
            'phase_id' => $phase_id,
            'score' => $stat ? $stat->score : 0
        ]);
    }

    // Tous les scores par phases
    public function userAllPhases($user_id)
    {
        $stats = Stat::where('user_id', $user_id)
                    ->with('phase')
                    ->get();

        return response()->json([
            'user_id' => $user_id,
            'phases' => $stats->map(function ($stat) {
                return [
                    'phase_id' => $stat->phase_id,
                    'phase_title' => $stat->phase->title,
                    'score' => $stat->score
                ];
            })
        ]);
    }
}
