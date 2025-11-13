<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\NutritionPlan;
use App\Models\ProgressLog;
use App\Models\User;
use App\Models\UserFitnessProfile;
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

        // 🔹 Dapatkan profil kebugaran user (jika ada)
        $fitnessProfile = UserFitnessProfile::where('user_id', $user->id)->first();

        // 🔹 Progress terakhir user (untuk adaptasi kalori)
        $latestProgress = ProgressLog::where('user_id', $user->id)
            ->latest('log_date')
            ->first();

        // 🔹 Ambil menu nutrisi user (atau rekomendasi berdasarkan profil kebugaran)
        $nutritions = $this->getNutritionRecommendations($user, $fitnessProfile, $selectedDay);

        // 🔹 Hitung target nutrisi berdasarkan profil kebugaran atau default
        $nutritionTargets = $this->calculateNutritionTargets($user, $fitnessProfile);

        // 🔹 Hitung kebutuhan kalori & makro user
        $calorieNeeds = $this->calculateCalories($user, $latestProgress, $fitnessProfile);
        $macroNeeds = $this->calculateMacros($calorieNeeds, $fitnessProfile);

        // 🔹 Total harian dari menu hari terpilih
        $dailyTotals = [
            'calories' => $nutritions->sum('calories'),
            'protein' => $nutritions->sum('protein'),
            'carbs' => $nutritions->sum('carbs'),
            'fat' => $nutritions->sum('fat'),
            'water_intake' => $nutritions->sum('water_intake'),
            'hydrogen_level' => $nutritions->avg('hydrogen_level'),
        ];

        // 🔹 Data untuk chart nutrisi
        $chartData = [
            'labels' => ['Kalori', 'Protein', 'Karbo', 'Lemak', 'Air'],
            'values' => [
                $dailyTotals['calories'],
                $dailyTotals['protein'],
                $dailyTotals['carbs'],
                $dailyTotals['fat'],
                $dailyTotals['water_intake'] / 100, // Scale down untuk chart
            ],
        ];

        return view('user.nutrition.index', compact(
            'nutritions',
            'nutritionTargets',
            'calorieNeeds',
            'macroNeeds',
            'latestProgress',
            'chartData',
            'days',
            'selectedDay',
            'dailyTotals',
            'fitnessProfile'
        ));
    }

    /**
     * 🎯 Dapatkan rekomendasi nutrisi berdasarkan profil kebugaran
     */
    private function getNutritionRecommendations($user, $fitnessProfile, $selectedDay)
    {
        // Jika user sudah punya menu sendiri, tampilkan
        $userNutritions = NutritionPlan::where('user_id', $user->id)
            ->where('day_of_week', $selectedDay)
            ->get();

        if ($userNutritions->isNotEmpty()) {
            return $userNutritions;
        }

        // Jika tidak, berikan rekomendasi berdasarkan profil kebugaran
        $query = NutritionPlan::whereNull('user_id')
            ->where('day_of_week', $selectedDay);

        // Filter berdasarkan target fitness user
        if ($user->target_fitness) {
            $query->where(function ($q) use ($user) {
                $q->where('target_fitness', $user->target_fitness)
                    ->orWhereNull('target_fitness');
            });
        }

        // Filter berdasarkan activity level dari fitness profile
        if ($fitnessProfile && $fitnessProfile->activity_level) {
            $calorieAdjustments = [
                'light' => 0.9,      // -10% untuk aktivitas ringan
                'moderate' => 1.0,   // normal untuk aktivitas sedang
                'heavy' => 1.15      // +15% untuk aktivitas berat
            ];

            if (isset($calorieAdjustments[$fitnessProfile->activity_level])) {
                $adjustment = $calorieAdjustments[$fitnessProfile->activity_level];
                // Akan disesuaikan di frontend atau melalui query khusus
            }
        }

        // Filter berdasarkan daily calorie target
        if ($fitnessProfile && $fitnessProfile->daily_calorie_target) {
            if ($fitnessProfile->daily_calorie_target > 2500) {
                // High calorie target - muscle gain focus
                $query->whereIn('target_fitness', ['muscle_gain', 'bulking']);
            } elseif ($fitnessProfile->daily_calorie_target < 1800) {
                // Low calorie target - fat loss focus
                $query->whereIn('target_fitness', ['fat_loss', 'cutting']);
            }
        }

        return $query->orderBy('meal_name')->get();
    }

    /**
     * 🎯 Hitung target nutrisi berdasarkan profil kebugaran
     */
    private function calculateNutritionTargets($user, $fitnessProfile)
    {
        // Jika ada fitness profile dengan target kalori, gunakan itu
        if ($fitnessProfile && $fitnessProfile->daily_calorie_target) {
            $calories = $fitnessProfile->daily_calorie_target;

            // Sesuaikan makronutrien berdasarkan goal
            if ($fitnessProfile->goal_id) {
                $goalBasedRatios = [
                    // goal_id => [protein%, carbs%, fat%]
                    1 => [0.35, 0.45, 0.20], // Muscle Gain
                    2 => [0.40, 0.35, 0.25], // Fat Loss
                    3 => [0.30, 0.50, 0.20], // Maintenance
                    4 => [0.25, 0.55, 0.20], // Endurance
                ];

                $ratios = $goalBasedRatios[$fitnessProfile->goal_id] ?? [0.30, 0.45, 0.25];
            } else {
                $ratios = [0.30, 0.45, 0.25]; // Default ratios
            }

            return [
                'calories' => $calories,
                'protein' => round(($calories * $ratios[0]) / 4),
                'carbs' => round(($calories * $ratios[1]) / 4),
                'fat' => round(($calories * $ratios[2]) / 9),
                'water_intake' => $this->calculateWaterIntake($user, $fitnessProfile),
                'hydrogen_level' => 7.0,
            ];
        }

        // Fallback ke target default berdasarkan data admin
        $adminPlans = NutritionPlan::whereNull('user_id')
            ->where(function ($q) use ($user) {
                $q->where('target_fitness', $user->target_fitness)
                    ->orWhereNull('target_fitness');
            })
            ->get();

        return [
            'calories' => round($adminPlans->avg('calories') ?: 2000),
            'protein' => round($adminPlans->avg('protein') ?: 150),
            'carbs' => round($adminPlans->avg('carbs') ?: 250),
            'fat' => round($adminPlans->avg('fat') ?: 70),
            'water_intake' => $this->calculateWaterIntake($user, $fitnessProfile),
            'hydrogen_level' => round($adminPlans->avg('hydrogen_level') ?: 7.0, 1),
        ];
    }

    /**
     * 💧 Hitung kebutuhan air berdasarkan profil
     */
    private function calculateWaterIntake($user, $fitnessProfile)
    {
        $baseWater = 2000; // 2L dasar

        // Sesuaikan berdasarkan berat badan (35ml per kg)
        if ($user->weight) {
            $baseWater = $user->weight * 35;
        }

        // Sesuaikan berdasarkan activity level
        if ($fitnessProfile && $fitnessProfile->activity_level) {
            $activityMultipliers = [
                'light' => 1.0,
                'moderate' => 1.2,
                'heavy' => 1.5
            ];

            if (isset($activityMultipliers[$fitnessProfile->activity_level])) {
                $baseWater *= $activityMultipliers[$fitnessProfile->activity_level];
            }
        }

        return round($baseWater);
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

    public function destroy($id)
    {
        $nutrition = NutritionPlan::where('user_id', Auth::id())->findOrFail($id);
        $nutrition->delete();

        return redirect()
            ->route('user.nutrition.index')
            ->with('success', 'Menu berhasil dihapus!');
    }

    /* ----------------------------------------------------------
     * 💾 PRIVATE — Simpan dan Analisis Nutrisi
     * ---------------------------------------------------------- */

    private function saveNutrition(Request $request, ?NutritionPlan $nutrition = null)
    {
        $user = Auth::user();
        $fitnessProfile = UserFitnessProfile::where('user_id', $user->id)->first();

        $validated = $request->validate([
            'meal_name' => 'required|string|max:100',
            'calories' => 'required|numeric|min:1',
            'protein' => 'required|numeric|min:0',
            'carbs' => 'required|numeric|min:0',
            'fat' => 'required|numeric|min:0',
            'water_intake' => 'nullable|numeric|min:0',
            'hydrogen_level' => 'nullable|numeric|min:0|max:14',
            'day_of_week' => 'required|string',
            'type' => 'nullable|string',
        ]);

        // 🔹 Set default values jika kosong
        $validated['water_intake'] = $validated['water_intake'] ?? 0;
        $validated['hydrogen_level'] = $validated['hydrogen_level'] ?? 7.0;

        // 🔹 Simpan / update
        $nutrition
            ? $nutrition->update($validated)
            : $nutrition = NutritionPlan::create(array_merge($validated, [
                'user_id' => $user->id,
                'target_fitness' => $user->target_fitness,
            ]));

        // 🔹 Analisis dan berikan rekomendasi
        $this->analyzeAndRecommend($user, $fitnessProfile, $validated['day_of_week']);

        return redirect()
            ->route('user.nutrition.index', ['day' => $validated['day_of_week']])
            ->with('success', ($nutrition->wasRecentlyCreated
                ? 'Menu berhasil ditambahkan! '
                : 'Menu berhasil diperbarui! ') . 'Sistem akan memberikan rekomendasi berdasarkan progres Anda.');
    }

    /**
     * 📊 Analisis nutrisi dan berikan rekomendasi
     */
    private function analyzeAndRecommend($user, $fitnessProfile, $dayOfWeek)
    {
        // 🔹 Hitung total harian user
        $dailyNutri = NutritionPlan::where('user_id', $user->id)
            ->where('day_of_week', $dayOfWeek)
            ->selectRaw('SUM(calories) as total_calories, SUM(protein) as total_protein, SUM(carbs) as total_carbs, SUM(fat) as total_fat, SUM(water_intake) as total_water, AVG(hydrogen_level) as avg_hydrogen')
            ->first();

        // 🔹 Dapatkan target berdasarkan profil
        $targets = $this->calculateNutritionTargets($user, $fitnessProfile);

        // 🔹 Hitung selisih (defisit/surplus)
        $deficits = [
            'calories' => $targets['calories'] - ($dailyNutri->total_calories ?? 0),
            'protein' => $targets['protein'] - ($dailyNutri->total_protein ?? 0),
            'carbs' => $targets['carbs'] - ($dailyNutri->total_carbs ?? 0),
            'fat' => $targets['fat'] - ($dailyNutri->total_fat ?? 0),
            'water_intake' => $targets['water_intake'] - ($dailyNutri->total_water ?? 0),
        ];

        // 🔹 Rekomendasi otomatis berdasarkan profil
        $suggestions = $this->generateRecommendations($deficits, $fitnessProfile);

        // 🔹 Rekomendasi berdasarkan hydrogen level
        $avgHydrogen = $dailyNutri->avg_hydrogen ?? 7.0;
        if ($avgHydrogen < 6.5) {
            $suggestions[] = 'pH air minum Anda terlalu asam. Pertimbangkan air dengan pH lebih tinggi.';
        } elseif ($avgHydrogen > 8.5) {
            $suggestions[] = 'pH air minum Anda terlalu basa. Sesuaikan dengan kebutuhan tubuh.';
        }

        $message = $suggestions
            ? implode(' ', $suggestions)
            : 'Asupan harianmu sudah mendekati target 🎯. Pertahankan pola makanmu hari ini!';

        // 🔔 Kirim notifikasi adaptif
        Notification::create([
            'user_id' => $user->id,
            'title' => 'Rekomendasi Nutrisi Personal 🍱💧',
            'message' => $message,
            'type' => 'nutrition_tip',
            'read_status' => false,
        ]);
    }

    /**
     * 🎯 Generate rekomendasi berdasarkan defisit dan profil
     */
    private function generateRecommendations($deficits, $fitnessProfile)
    {
        $suggestions = [];

        // Rekomendasi berdasarkan activity level
        if ($fitnessProfile) {
            $activitySuggestions = [
                'light' => 'Karena aktivitas Anda ringan, fokus pada makanan bernutrisi tinggi dengan kalori terkontrol.',
                'moderate' => 'Dengan aktivitas sedang, pastikan asupan karbohidrat cukup untuk energi latihan.',
                'heavy' => 'Aktivitas berat membutuhkan lebih banyak protein dan karbohidrat untuk pemulihan.'
            ];

            if (isset($activitySuggestions[$fitnessProfile->activity_level])) {
                $suggestions[] = $activitySuggestions[$fitnessProfile->activity_level];
            }

            // Rekomendasi berdasarkan deskripsi aktivitas
            if ($fitnessProfile->activity_description) {
                $suggestions[] = "Untuk pekerjaan {$fitnessProfile->activity_description}, perhatikan asupan energi yang konsisten sepanjang hari.";
            }
        }

        // Rekomendasi berdasarkan defisit nutrisi
        if ($deficits['protein'] > 15) {
            $suggestions[] = 'Tambahkan protein seperti ayam dada, telur rebus, atau whey protein.';
        }
        if ($deficits['carbs'] > 30) {
            $suggestions[] = 'Tambahkan karbo sehat seperti nasi merah, oats, atau kentang rebus.';
        }
        if ($deficits['fat'] > 10) {
            $suggestions[] = 'Tambahkan lemak sehat seperti alpukat, kacang almond, atau minyak zaitun.';
        }
        if ($deficits['calories'] > 300) {
            $suggestions[] = 'Kalorimu defisit, tambahkan porsi makan atau camilan sehat.';
        }
        if ($deficits['water_intake'] > 500) {
            $suggestions[] = 'Asupan air masih kurang, minum lebih banyak air putih atau infused water.';
        }

        return $suggestions;
    }

    /* ----------------------------------------------------------
     * ⚙️ PERHITUNGAN MAKANAN & ADAPTASI
     * ---------------------------------------------------------- */

    private function calculateCalories(User $user, $progress = null, $fitnessProfile = null)
    {
        // Jika ada fitness profile dengan target kalori, gunakan itu
        if ($fitnessProfile && $fitnessProfile->daily_calorie_target) {
            return $fitnessProfile->daily_calorie_target;
        }

        $weight = $user->weight ?? 70;
        $height = $user->height ?? 170;
        $age = $user->age ?? 25;
        $gender = $user->gender ?? 'male';

        // 🔹 Rumus Harris-Benedict
        $bmr = $gender === 'male'
            ? (88.362 + (13.397 * $weight) + (4.799 * $height) - (5.677 * $age))
            : (447.593 + (9.247 * $weight) + (3.098 * $height) - (4.330 * $age));

        // Sesuaikan BMR berdasarkan activity level
        $activityMultipliers = [
            'light' => 1.375,
            'moderate' => 1.55,
            'heavy' => 1.725
        ];

        $activityMultiplier = $fitnessProfile && isset($activityMultipliers[$fitnessProfile->activity_level])
            ? $activityMultipliers[$fitnessProfile->activity_level]
            : 1.55;

        $calories = $bmr * $activityMultiplier;

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

    private function calculateMacros($calories, $fitnessProfile = null)
    {
        // Sesuaikan rasio makro berdasarkan goal dari fitness profile
        if ($fitnessProfile && $fitnessProfile->goal_id) {
            $goalBasedRatios = [
                1 => [0.35, 0.45, 0.20], // Muscle Gain - tinggi protein
                2 => [0.40, 0.35, 0.25], // Fat Loss - tinggi protein, rendah karbo
                3 => [0.30, 0.45, 0.25], // Maintenance - seimbang
                4 => [0.25, 0.55, 0.20], // Endurance - tinggi karbo
            ];

            $ratios = $goalBasedRatios[$fitnessProfile->goal_id] ?? [0.30, 0.45, 0.25];
        } else {
            $ratios = [0.30, 0.45, 0.25]; // Default ratios
        }

        return [
            'calories' => round($calories),
            'protein' => round(($calories * $ratios[0]) / 4),
            'carbs' => round(($calories * $ratios[1]) / 4),
            'fat' => round(($calories * $ratios[2]) / 9),
            'water_intake' => $this->calculateWaterIntake(Auth::user(), $fitnessProfile),
            'hydrogen_level' => 7.0,
        ];
    }
}
