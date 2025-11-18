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
     * Sumber: Academy of Nutrition and Dietetics (2016) - Personalized Nutrition
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
        // Sumber: Thomas et al. (2016) - Nutrition and Athletic Performance
        if ($user->target_fitness) {
            $query->where(function ($q) use ($user) {
                $q->where('target_fitness', $user->target_fitness)
                    ->orWhereNull('target_fitness');
            });
        }

        // Filter berdasarkan daily calorie target
        // Sumber: Helms et al. (2014) - Evidence-based recommendations for bodybuilding
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
     * Sumber: Institute of Medicine (2002) - Dietary Reference Intakes
     */
    private function calculateNutritionTargets($user, $fitnessProfile)
    {
        // Jika ada fitness profile dengan target kalori, gunakan itu
        if ($fitnessProfile && $fitnessProfile->daily_calorie_target) {
            $calories = $fitnessProfile->daily_calorie_target;

            // Sesuaikan makronutrien berdasarkan goal
            // Sumber: Helms et al. (2014) - Bodybuilding contest preparation
            if ($fitnessProfile->goal_id) {
                $goalBasedRatios = [
                    // goal_id => [protein%, carbs%, fat%]
                    1 => [0.35, 0.45, 0.20], // Muscle Gain - Helms et al. 2014
                    2 => [0.40, 0.35, 0.25], // Fat Loss - Wycherley et al. 2012
                    3 => [0.30, 0.50, 0.20], // Maintenance - IOM 2002
                    4 => [0.25, 0.55, 0.20], // Endurance - Thomas et al. 2016
                ];

                $ratios = $goalBasedRatios[$fitnessProfile->goal_id] ?? [0.30, 0.45, 0.25];
            } else {
                $ratios = [0.30, 0.45, 0.25]; // Default ratios - IOM 2002
            }

            return [
                'calories' => $calories,
                'protein' => round(($calories * $ratios[0]) / 4),  // 4 kcal/g protein
                'carbs' => round(($calories * $ratios[1]) / 4),    // 4 kcal/g carbs
                'fat' => round(($calories * $ratios[2]) / 9),      // 9 kcal/g fat
                'water_intake' => $this->calculateWaterIntake($user, $fitnessProfile),
                'hydrogen_level' => 7.0, // Neutral pH
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
     * Sumber: Institute of Medicine (2005) - Water Intake Recommendations
     * Sumber: Sawka et al. (2005) - Human Water Needs
     */
    private function calculateWaterIntake($user, $fitnessProfile)
    {
        $baseWater = 2000; // 2L dasar - IOM 2005

        // Sesuaikan berdasarkan berat badan (35ml per kg) - Armstrong 2007
        if ($user->weight) {
            $baseWater = $user->weight * 35; // 35ml/kg - Armstrong 2007
        }

        // Sesuaikan berdasarkan activity level - Sawka et al. 2005
        if ($fitnessProfile && $fitnessProfile->activity_level) {
            $activityMultipliers = [
                'light' => 1.0,   // Sedentary
                'moderate' => 1.2, // Light activity
                'heavy' => 1.5    // Heavy activity
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
     * Sumber: Heydenreich et al. (2017) - Adaptive Nutrition Monitoring
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

        // 🔹 Hitung selisih (defisit/surplus) - Das et al. 2009
        $deficits = [
            'calories' => $targets['calories'] - ($dailyNutri->total_calories ?? 0),
            'protein' => $targets['protein'] - ($dailyNutri->total_protein ?? 0),
            'carbs' => $targets['carbs'] - ($dailyNutri->total_carbs ?? 0),
            'fat' => $targets['fat'] - ($dailyNutri->total_fat ?? 0),
            'water_intake' => $targets['water_intake'] - ($dailyNutri->total_water ?? 0),
        ];

        // 🔹 Rekomendasi otomatis berdasarkan profil
        $suggestions = $this->generateRecommendations($deficits, $fitnessProfile);

        // 🔹 Rekomendasi berdasarkan hydrogen level - WHO 2007
        $avgHydrogen = $dailyNutri->avg_hydrogen ?? 7.0;
        if ($avgHydrogen < 6.5) {
            $suggestions[] = 'pH air minum Anda terlalu asam (pH <6.5). Pertimbangkan air dengan pH lebih tinggi.';
        } elseif ($avgHydrogen > 8.5) {
            $suggestions[] = 'pH air minum Anda terlalu basa (pH >8.5). Sesuaikan dengan kebutuhan tubuh.';
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
     * Sumber: Academy of Nutrition and Dietetics (2016) - Personalized Nutrition Counseling
     */
    private function generateRecommendations($deficits, $fitnessProfile)
    {
        $suggestions = [];

        // Rekomendasi berdasarkan activity level - Thomas et al. 2016
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

        // Rekomendasi berdasarkan defisit nutrisi - Heydenreich et al. 2017
        // Threshold berdasarkan penelitian tentang defisit nutrisi yang signifikan
        if ($deficits['protein'] > 15) { // >15g defisit protein
            $suggestions[] = 'Tambahkan protein seperti ayam dada, telur rebus, atau whey protein.';
        }
        if ($deficits['carbs'] > 30) { // >30g defisit karbohidrat
            $suggestions[] = 'Tambahkan karbo sehat seperti nasi merah, oats, atau kentang rebus.';
        }
        if ($deficits['fat'] > 10) { // >10g defisit lemak
            $suggestions[] = 'Tambahkan lemak sehat seperti alpukat, kacang almond, atau minyak zaitun.';
        }
        if ($deficits['calories'] > 300) { // >300kcal defisit
            $suggestions[] = 'Kalorimu defisit, tambahkan porsi makan atau camilan sehat.';
        }
        if ($deficits['water_intake'] > 500) { // >500ml defisit air
            $suggestions[] = 'Asupan air masih kurang, minum lebih banyak air putih atau infused water.';
        }

        return $suggestions;
    }

    /* ----------------------------------------------------------
     * ⚙️ PERHITUNGAN MAKANAN & ADAPTASI
     * ---------------------------------------------------------- */

    /**
     * 🔥 Hitung kebutuhan kalori dengan Harris-Benedict Equation
     * Sumber: Harris & Benedict (1918) - A Biometric Study of Human Basal Metabolism
     * Sumber: Roza & Shizgal (1984) - Harris Benedict equation reevaluated
     * Sumber: Garthe et al. (2011) - Weight-loss rates in elite athletes
     */
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

        // 🔹 Rumus Harris-Benedict (1918) - Revised by Roza & Shizgal (1984)
        $bmr = $gender === 'male'
            ? (88.362 + (13.397 * $weight) + (4.799 * $height) - (5.677 * $age))
            : (447.593 + (9.247 * $weight) + (3.098 * $height) - (4.330 * $age));

        // Sesuaikan BMR berdasarkan activity level - Mifflin et al. 1990
        $activityMultipliers = [
            'light' => 1.375,   // Sedentary/office work
            'moderate' => 1.55, // Light exercise 1-3 days/week  
            'heavy' => 1.725    // Hard exercise 6-7 days/week
        ];

        $activityMultiplier = $fitnessProfile && isset($activityMultipliers[$fitnessProfile->activity_level])
            ? $activityMultipliers[$fitnessProfile->activity_level]
            : 1.55; // Default: moderately active

        $calories = $bmr * $activityMultiplier;

        // 🔹 Penyesuaian berdasarkan progress aktual - Das et al. 2009
        if ($progress) {
            $avgConsumed = $progress->calories_consumed ?? 0;
            if ($avgConsumed > $calories * 1.1) { // >10% over consumption
                $calories *= 0.95; // Reduce 5% - adaptive decrease
            } elseif ($avgConsumed < $calories * 0.85) { // <85% of target
                $calories *= 1.05; // Increase 5% - adaptive increase
            }
        }

        // 🔹 Adjust berdasarkan goal fitness - Garthe et al. 2011, Murphy & Koehler 2022
        return match ($user->target_fitness) {
            'fat_loss' => round($calories * 0.85),    // 15% deficit untuk fat loss
            'muscle_gain' => round($calories * 1.15), // 15% surplus untuk muscle gain
            default => round($calories),              // Maintenance
        };
    }

    /**
     * 🥩 Hitung kebutuhan makronutrien
     * Sumber: Institute of Medicine (2002) - Macronutrient Distribution Ranges
     * Sumber: Helms et al. (2014) - Bodybuilding nutrition
     * Sumber: Wycherley et al. (2012) - High-protein diets for weight loss
     */
    private function calculateMacros($calories, $fitnessProfile = null)
    {
        // Sesuaikan rasio makro berdasarkan goal dari fitness profile
        if ($fitnessProfile && $fitnessProfile->goal_id) {
            $goalBasedRatios = [
                1 => [0.35, 0.45, 0.20], // Muscle Gain - tinggi protein (Helms et al. 2014)
                2 => [0.40, 0.35, 0.25], // Fat Loss - tinggi protein, rendah karbo (Wycherley et al. 2012)
                3 => [0.30, 0.50, 0.20], // Maintenance - seimbang (IOM 2002)
                4 => [0.25, 0.55, 0.20], // Endurance - tinggi karbo (Thomas et al. 2016)
            ];

            $ratios = $goalBasedRatios[$fitnessProfile->goal_id] ?? [0.30, 0.45, 0.25];
        } else {
            $ratios = [0.30, 0.45, 0.25]; // Default ratios - Acceptable Macronutrient Distribution Ranges (IOM 2002)
        }

        return [
            'calories' => round($calories),
            'protein' => round(($calories * $ratios[0]) / 4),  // 4 kcal per gram protein
            'carbs' => round(($calories * $ratios[1]) / 4),    // 4 kcal per gram carbs
            'fat' => round(($calories * $ratios[2]) / 9),      // 9 kcal per gram fat
            'water_intake' => $this->calculateWaterIntake(Auth::user(), $fitnessProfile),
            'hydrogen_level' => 7.0, // Neutral pH - optimal for human consumption
        ];
    }
}
