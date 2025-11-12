<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\NutritionPlan;
use App\Models\ProgressLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserNutritionController extends Controller
{
    /**
     * 📊 Halaman utama nutrisi — tampilkan menu, target, grafik, dan rekomendasi
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $selectedDay = $request->get('day', 'Senin');

        // 🔹 Progress terakhir user (untuk adaptasi kalori)
        $latestProgress = ProgressLog::where('user_id', $user->id)
            ->latest('log_date')
            ->first();

        // 🔹 Ambil menu nutrisi user (atau default dari admin)
        $nutritions = NutritionPlan::where(function ($q) use ($user) {
            $q->where('user_id', $user->id)
                ->orWhere(function ($q2) use ($user) {
                    $q2->whereNull('user_id')
                        ->where(function ($q3) use ($user) {
                            $q3->where('target_fitness', $user->target_fitness)
                                ->orWhereNull('target_fitness');
                        });
                });
        })
            ->where('day_of_week', $selectedDay)
            ->orderBy('meal_name')
            ->get();

        // 🔹 Hitung rata-rata target admin (fallback jika belum ada)
        $adminPlans = NutritionPlan::whereNull('user_id')
            ->where(function ($q) use ($user) {
                $q->where('target_fitness', $user->target_fitness)
                    ->orWhereNull('target_fitness');
            })
            ->get();

        $adminTargets = [
            'calories' => round($adminPlans->avg('calories') ?: 2000),
            'protein' => round($adminPlans->avg('protein') ?: 150),
            'carbs' => round($adminPlans->avg('carbs') ?: 250),
            'fat' => round($adminPlans->avg('fat') ?: 70),
        ];

        // 🔹 Hitung kebutuhan kalori & makro user
        $calorieNeeds = $this->calculateCalories($user, $latestProgress);
        $macroNeeds = $this->calculateMacros($calorieNeeds);

        // 🔹 Total harian dari menu hari terpilih
        $dailyTotals = [
            'calories' => $nutritions->sum('calories'),
            'protein' => $nutritions->sum('protein'),
            'carbs' => $nutritions->sum('carbs'),
            'fat' => $nutritions->sum('fat'),
        ];

        // 🔹 Data untuk chart nutrisi
        $chartData = [
            'labels' => ['Kalori', 'Protein', 'Karbo', 'Lemak'],
            'values' => [
                $dailyTotals['calories'],
                $dailyTotals['protein'],
                $dailyTotals['carbs'],
                $dailyTotals['fat'],
            ],
        ];

        return view('user.nutrition.index', compact(
            'nutritions',
            'adminTargets',
            'calorieNeeds',
            'macroNeeds',
            'latestProgress',
            'chartData',
            'days',
            'selectedDay',
            'dailyTotals'
        ));
    }

    /* ----------------------------------------------------------
     * 🧩 CRUD OPERASI
     * ---------------------------------------------------------- */

    public function create()
    {
        return view('user.nutrition.create');
    }

    public function edit($id)
    {
        $nutrition = NutritionPlan::where('user_id', Auth::id())->findOrFail($id);

        return view('user.nutrition.edit', compact('nutrition'));
    }

    public function store(Request $request)
    {
        return $this->saveNutrition($request);
    }

    public function update(Request $request, $id)
    {
        $nutrition = NutritionPlan::where('user_id', Auth::id())->findOrFail($id);

        return $this->saveNutrition($request, $nutrition);
    }

    /* ----------------------------------------------------------
     * 💾 PRIVATE — Simpan dan Analisis Nutrisi
     * ---------------------------------------------------------- */

    private function saveNutrition(Request $request, ?NutritionPlan $nutrition = null)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'meal_name' => 'required|string|max:100',
            'calories' => 'required|numeric|min:1',
            'protein' => 'required|numeric|min:0',
            'carbs' => 'required|numeric|min:0',
            'fat' => 'required|numeric|min:0',
            'day_of_week' => 'required|string',
            'type' => 'nullable|string',
        ]);

        // 🔹 Simpan / update
        $nutrition
            ? $nutrition->update($validated)
            : $nutrition = NutritionPlan::create(array_merge($validated, [
                'user_id' => $user->id,
                'target_fitness' => $user->target_fitness,
            ]));

        // 🔹 Hitung total harian user
        $dailyNutri = NutritionPlan::where('user_id', $user->id)
            ->where('day_of_week', $validated['day_of_week'])
            ->selectRaw('SUM(calories) as total_calories, SUM(protein) as total_protein, SUM(carbs) as total_carbs, SUM(fat) as total_fat')
            ->first();

        // 🔹 Ambil rata-rata target admin
        $adminTargets = NutritionPlan::whereNull('user_id')
            ->where(function ($q) use ($user) {
                $q->where('target_fitness', $user->target_fitness)
                    ->orWhereNull('target_fitness');
            })
            ->selectRaw('AVG(calories) as calories, AVG(protein) as protein, AVG(carbs) as carbs, AVG(fat) as fat')
            ->first();

        // 🔹 Hitung selisih (defisit/surplus)
        $deficits = [
            'calories' => ($adminTargets->calories ?? 2000) - ($dailyNutri->total_calories ?? 0),
            'protein' => ($adminTargets->protein ?? 150) - ($dailyNutri->total_protein ?? 0),
            'carbs' => ($adminTargets->carbs ?? 250) - ($dailyNutri->total_carbs ?? 0),
            'fat' => ($adminTargets->fat ?? 70) - ($dailyNutri->total_fat ?? 0),
        ];

        // 🔹 Rekomendasi makanan otomatis
        $suggestions = [];
        if ($deficits['protein'] > 10) {
            $suggestions[] = 'Tambahkan protein seperti ayam dada, telur rebus, atau whey protein.';
        }
        if ($deficits['carbs'] > 20) {
            $suggestions[] = 'Tambahkan karbo sehat seperti nasi merah, oats, atau kentang rebus.';
        }
        if ($deficits['fat'] > 5) {
            $suggestions[] = 'Tambahkan lemak sehat seperti alpukat, kacang almond, atau minyak zaitun.';
        }
        if ($deficits['calories'] > 200) {
            $suggestions[] = 'Kalorimu defisit, tambahkan porsi makan siang atau camilan sehat.';
        }

        $message = $suggestions
            ? implode(' ', $suggestions)
            : 'Asupan harianmu sudah mendekati target 🎯. Pertahankan pola makanmu hari ini!';

        // 🔔 Kirim notifikasi adaptif
        Notification::create([
            'user_id' => $user->id,
            'title' => 'Rekomendasi Makanan Tambahan 🍱',
            'message' => $message,
            'type' => 'reminder',
            'read_status' => false,
        ]);

        return redirect()
            ->route('user.nutrition.index')
            ->with('success', ($nutrition->wasRecentlyCreated
                ? 'Menu berhasil ditambahkan! '
                : 'Menu berhasil diperbarui! ').$message);
    }

    /* ----------------------------------------------------------
     * ⚙️ PERHITUNGAN MAKANAN & ADAPTASI
     * ---------------------------------------------------------- */

    private function calculateCalories(User $user, $progress = null)
    {
        $weight = $user->weight ?? 70;
        $height = $user->height ?? 170;
        $age = $user->age ?? 25;
        $gender = $user->gender ?? 'male';

        // 🔹 Rumus Harris-Benedict
        $bmr = $gender === 'male'
            ? (88.362 + (13.397 * $weight) + (4.799 * $height) - (5.677 * $age))
            : (447.593 + (9.247 * $weight) + (3.098 * $height) - (4.330 * $age));

        $calories = $bmr * 1.55; // Aktivitas moderat

        // 🔹 Penyesuaian berdasar progress
        if ($progress) {
            $avgConsumed = $progress->calories_consumed ?? 0;
            if ($avgConsumed > $calories * 1.1) {
                $calories *= 0.95;
            } elseif ($avgConsumed < $calories * 0.85) {
                $calories *= 1.05;
            }
        }

        return match ($user->target_fitness) {
            'fat_loss' => round($calories * 0.85),
            'muscle_gain' => round($calories * 1.15),
            default => round($calories),
        };
    }

    private function calculateMacros($calories)
    {
        return [
            'calories' => round($calories),
            'protein' => round(($calories * 0.30) / 4),
            'carbs' => round(($calories * 0.45) / 4),
            'fat' => round(($calories * 0.25) / 9),
        ];
    }
}
