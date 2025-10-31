<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\BodyMetric;
use App\Models\WorkoutPlan;
use App\Models\NutritionPlan;
use App\Models\ProgressLog;
use App\Models\NewsArticle;
use App\Models\TrainerChat;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $progress = BodyMetric::where('user_id', $user->id)
            ->orderBy('recorded_at')
            ->get(['recorded_at', 'weight', 'muscle_mass']);

        $proteinNeed = $user->weight ? round($user->weight * 1.6, 1) : null;

        $workouts = WorkoutPlan::where('user_id', $user->id)->get();
        $nutritions = NutritionPlan::where('user_id', $user->id)->get();

        $weekLogs = ProgressLog::where('user_id', $user->id)
            ->whereBetween('log_date', [now()->startOfWeek(), now()->endOfWeek()])
            ->get();

        $articles = NewsArticle::latest()->take(5)->get();

        $chats = TrainerChat::where('user_id', $user->id)
            ->orderBy('timestamp', 'desc')
            ->take(5)
            ->get();


        return view('user.dashboard', compact(
            'user',
            'progress',
            'proteinNeed',
            'workouts',
            'nutritions',
            'weekLogs',
            'articles',
            'chats'
        ));
    }
}
