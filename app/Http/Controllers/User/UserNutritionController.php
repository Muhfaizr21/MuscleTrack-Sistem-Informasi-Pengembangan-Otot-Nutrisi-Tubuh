<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\NutritionPlan;
use App\Models\User;
use App\Models\ProgressLog;
use App\Models\Notification;
use Carbon\Carbon;

class UserNutritionController extends Controller
{
    /**
     * 📊 Tampilkan nutrisi harian + perbandingan dengan data admin + rekomendasi otomatis
     */
    public function index()
    {
        $user = Auth::user();

        $latestProgress = ProgressLog::where('user_id', $user->id)
            ->orderByDesc('log_date')
            ->first();

        $nutritions = NutritionPlan::where(function ($q) use ($user) {
            $q->where('user_id', $user->id)->orWhereNull('user_id');
        })
            ->where(function ($q) use ($user) {
                $q->where('target_fitness', $user->target_fitness)
                    ->orWhereNull('target_fitness');
            })
            ->orderBy('day_of_week', 'asc')
            ->get();

        $adminPlans = NutritionPlan::whereNull('user_id')
            ->where(function ($q) use ($user) {
                $q->where('target_fitness', $user->target_fitness)
                    ->orWhereNull('target_fitness');
            })
            ->get();

        $adminTargets = $adminPlans->isNotEmpty()
            ? [
                'calories' => round($adminPlans->avg('calories') ?? 2000),
                'protein'  => round($adminPlans->avg('protein') ?? 150),
                'carbs'    => round($adminPlans->avg('carbs') ?? 250),
                'fat'      => round($adminPlans->avg('fat') ?? 70),
            ]
            : [
                'calories' => 2000,
                'protein'  => 150,
                'carbs'    => 250,
                'fat'      => 70,
            ];

        $calorieNeeds = $this->calculateCalories($user, $latestProgress);
        $macroNeeds   = $this->calculateMacros($calorieNeeds);

        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $chartData = [
            'protein'  => [],
            'carbs'    => [],
            'fat'      => [],
            'calories' => [],
        ];

        foreach ($days as $day) {
            $chartData['protein'][]  = $nutritions->where('day_of_week', $day)->sum('protein');
            $chartData['carbs'][]    = $nutritions->where('day_of_week', $day)->sum('carbs');
            $chartData['fat'][]      = $nutritions->where('day_of_week', $day)->sum('fat');
            $chartData['calories'][] = $nutritions->where('day_of_week', $day)->sum('calories');
        }

        $this->sendAdaptiveNutritionTip($user, $latestProgress, $calorieNeeds);

        return view('user.nutrition.index', compact(
            'nutritions',
            'adminTargets',
            'calorieNeeds',
            'macroNeeds',
            'chartData',
            'days',
            'latestProgress'
        ));
    }

    /**
     * 🥗 Form input makanan harian user
     */
    public function create()
    {
        return view('user.nutrition.create');
    }

    /**
     * ✏️ Form edit makanan harian user
     */
    public function edit($id)
    {
        $user = Auth::user();
        $nutrition = NutritionPlan::where('user_id', $user->id)->findOrFail($id);

        return view('user.nutrition.edit', compact('nutrition'));
    }

    /**
     * 💾 Simpan menu baru user + rekomendasi makanan tambahan
     */
    public function store(Request $request)
    {
        return $this->saveNutrition($request);
    }

    /**
     * 🔁 Update menu yang sudah ada
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $nutrition = NutritionPlan::where('user_id', $user->id)->findOrFail($id);

        return $this->saveNutrition($request, $nutrition);
    }

    /**
     * 🧠 Fungsi gabungan untuk store & update
     */
    private function saveNutrition(Request $request, NutritionPlan $nutrition = null)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'meal_name'   => 'required|string|max:100',
            'calories'    => 'required|numeric|min:1',
            'protein'     => 'required|numeric|min:0',
            'carbs'       => 'required|numeric|min:0',
            'fat'         => 'required|numeric|min:0',
            'day_of_week' => 'required|string',
            'type'        => 'nullable|string',
        ]);

        if ($nutrition) {
            $nutrition->update($validated);
        } else {
            $nutrition = NutritionPlan::create(array_merge($validated, [
                'user_id' => $user->id,
                'target_fitness' => $user->target_fitness,
            ]));
        }

        // 🔹 Hitung total harian
        $dailyNutri = NutritionPlan::where('user_id', $user->id)
            ->where('day_of_week', $validated['day_of_week'])
            ->selectRaw('SUM(calories) as total_calories, SUM(protein) as total_protein, SUM(carbs) as total_carbs, SUM(fat) as total_fat')
            ->first();

        $adminTargets = NutritionPlan::whereNull('user_id')
            ->where(function ($q) use ($user) {
                $q->where('target_fitness', $user->target_fitness)
                    ->orWhereNull('target_fitness');
            })
            ->selectRaw('AVG(calories) as calories, AVG(protein) as protein, AVG(carbs) as carbs, AVG(fat) as fat')
            ->first();

        $deficits = [
            'calories' => ($adminTargets->calories ?? 2000) - ($dailyNutri->total_calories ?? 0),
            'protein'  => ($adminTargets->protein ?? 150) - ($dailyNutri->total_protein ?? 0),
            'carbs'    => ($adminTargets->carbs ?? 250) - ($dailyNutri->total_carbs ?? 0),
            'fat'      => ($adminTargets->fat ?? 70) - ($dailyNutri->total_fat ?? 0),
        ];

        // 🔹 Rekomendasi makanan
        $suggestions = [];
        if ($deficits['protein'] > 10) $suggestions[] = "Tambah asupan protein seperti ayam dada, telur rebus, atau whey protein.";
        if ($deficits['carbs'] > 20) $suggestions[] = "Tambahkan sumber karbo seperti nasi merah, oats, atau kentang rebus.";
        if ($deficits['fat'] > 5) $suggestions[] = "Perbanyak lemak sehat seperti alpukat, kacang almond, atau minyak zaitun.";
        if ($deficits['calories'] > 200) $suggestions[] = "Kalorimu masih defisit, bisa tambahkan porsi makan siang atau camilan sehat.";

        $message = $suggestions
            ? implode(" ", $suggestions)
            : "Nutrisi harianmu sudah mendekati target 🎯. Pertahankan pola makanmu hari ini!";

        // 🔔 Notifikasi aman ke DB
        Notification::create([
            'user_id'     => $user->id,
            'title'       => 'Rekomendasi Makanan Tambahan 🍱',
            'message'     => $message,
            'type'        => 'reminder', // ✅ gunakan tipe yang valid di enum
            'read_status' => false,
        ]);

        return redirect()
            ->route('user.nutrition.index')
            ->with(
                'success',
                $nutrition->wasRecentlyCreated
                    ? 'Menu berhasil ditambahkan! ' . $message
                    : 'Menu berhasil diperbarui! ' . $message
            );
    }

    private function calculateCalories(User $user, $progress = null)
    {
        $weight = $user->weight ?? 70;
        $height = $user->height ?? 170;
        $age    = $user->age ?? 25;
        $gender = $user->gender ?? 'male';

        $bmr = $gender === 'male'
            ? (88.362 + (13.397 * $weight) + (4.799 * $height) - (5.677 * $age))
            : (447.593 + (9.247 * $weight) + (3.098 * $height) - (4.330 * $age));

        $calories = $bmr * 1.55;

        if ($progress) {
            $avgConsumed = $progress->calories_consumed ?? 0;
            if ($avgConsumed > $calories * 1.1) $calories *= 0.95;
            elseif ($avgConsumed < $calories * 0.85) $calories *= 1.05;
        }

        return match ($user->target_fitness) {
            'fat_loss'    => round($calories * 0.85),
            'muscle_gain' => round($calories * 1.15),
            default       => round($calories),
        };
    }

    private function calculateMacros($calories)
    {
        return [
            'calories' => round($calories),
            'protein'  => round(($calories * 0.30) / 4),
            'carbs'    => round(($calories * 0.45) / 4),
            'fat'      => round(($calories * 0.25) / 9),
        ];
    }

    private function sendAdaptiveNutritionTip(User $user, $progress, $calorieNeeds)
    {
        if (!$progress) return;

        $protein  = $progress->protein_consumed ?? 0;
        $calories = $progress->calories_consumed ?? 0;
        $message  = null;

        if ($protein < ($calorieNeeds * 0.25) / 4) {
            $message = "Asupan protein kamu rendah hari ini 🍗 — tambah telur, ayam, atau whey protein.";
        } elseif ($calories < $calorieNeeds * 0.9) {
            $message = "Kamu sedikit defisit kalori hari ini 🔥. Pastikan tetap makan cukup agar tubuh tidak drop.";
        } elseif ($calories > $calorieNeeds * 1.1) {
            $message = "Kalori kamu sedikit berlebih 🍔 — kurangi karbo sederhana dan perbanyak sayuran hijau.";
        }

        if ($message) {
            Notification::create([
                'user_id'     => $user->id,
                'title'       => 'Rekomendasi Nutrisi Harian 🍽️',
                'message'     => $message,
                'type'        => 'reminder',
                'read_status' => false,
            ]);
        }
    }
}
