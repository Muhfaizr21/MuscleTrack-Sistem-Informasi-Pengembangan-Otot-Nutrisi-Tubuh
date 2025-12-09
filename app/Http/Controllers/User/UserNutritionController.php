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

        // 🔹 Hitung target nutrisi berdasarkan berat badan dan aktivitas user
        $nutritionTargets = $this->calculateNutritionTargets($user, $fitnessProfile);

        // 🔹 Hitung kebutuhan kalori & makro user
        $calorieNeeds = $this->calculateCalories($user, $latestProgress, $fitnessProfile);
        $macroNeeds = $this->calculateMacros($calorieNeeds, $user, $fitnessProfile);

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

        return $query->orderBy('meal_name')->get();
    }

    /**
     * 🎯 Hitung target nutrisi berdasarkan berat badan dan aktivitas user
     * Sumber: Berdasarkan jurnal ilmiah yang telah dirujuk
     */
    private function calculateNutritionTargets($user, $fitnessProfile)
    {
        $weight = $user->weight ?? 70; // Berat badan default 70kg
        $height = $user->height ?? 170; // Tinggi badan default 170cm
        $age = $user->age ?? 30; // Usia default 30 tahun
        $gender = $user->gender ?? 'male';
        $goal = $fitnessProfile->goal_id ?? 3;

        // 1. Mifflin-St Jeor Equation (Mifflin et al., 1990)
        $bmr = $gender === 'male'
            ? (10 * $weight) + (6.25 * $height) - (5 * $age) + 5
            : (10 * $weight) + (6.25 * $height) - (5 * $age) - 161;

        // 2. TDEE dengan activity multiplier (FAO/WHO/UNU, 2001)
        $activityLevel = $fitnessProfile->activity_level ?? 'moderate';
        $activityMultipliers = [
            'light' => 1.375,     // PAL 1.4-1.69
            'moderate' => 1.55,   // PAL 1.7-1.99
            'heavy' => 1.725,     // PAL 2.0-2.4
        ];

        $tdee = $bmr * ($activityMultipliers[$activityLevel] ?? 1.55);

        // 3. Goal-based adjustments sesuai penelitian
        // Garthe et al. (2011), Helms et al. (2014), Wycherley et al. (2012)
        $goalMultipliers = [
            1 => 1.05, // Muscle Gain: +5% (300-500 kkal surplus)
            2 => 0.92, // Fat Loss: -8% (≈500 kkal defisit)
            3 => 1.00, // Maintenance: tetap
            4 => 1.05, // Endurance: +5%
        ];

        $dailyCalories = $tdee * ($goalMultipliers[$goal] ?? 1.00);

        // 4. Minimum calories protection (Thomas et al., 2016)
        $minimumCalories = $gender === 'male' ? 1500 : 1200;
        $dailyCalories = max(round($dailyCalories), $minimumCalories);

        // 5. Protein berdasarkan berat badan dan goal
        // Morton et al. (2018), Helms et al. (2014), Wycherley et al. (2012)
        $proteinPerKg = match ($goal) {
            1 => 2.0,  // Muscle Gain: 2.0-2.2 g/kg
            2 => 2.2,  // Fat Loss: 2.0-2.4 g/kg (lebih tinggi untuk kenyang)
            3 => 1.6,  // Maintenance: 1.6-1.8 g/kg
            4 => 1.6,  // Endurance: 1.4-1.6 g/kg
            default => 1.8,
        };

        $protein = round($weight * $proteinPerKg);

        // 6. Lemak: 20-35% dari kalori (IOM, 2002)
        $fatPercentage = match ($goal) {
            1 => 0.23, // Muscle Gain: 23%
            2 => 0.28, // Fat Loss: 28% (lebih tinggi untuk kenyang)
            3 => 0.25, // Maintenance: 25%
            4 => 0.25, // Endurance: 25%
            default => 0.25,
        };

        $fatGrams = round(($dailyCalories * $fatPercentage) / 9);

        // 7. Karbohidrat: sisanya dari total kalori
        $proteinCalories = $protein * 4;
        $fatCalories = $fatGrams * 9;
        $remainingCalories = $dailyCalories - $proteinCalories - $fatCalories;
        $carbs = round($remainingCalories / 4);

        // 8. Hitung kebutuhan air berdasarkan berat badan (Armstrong, 2007)
        $waterIntake = $this->calculateWaterIntake($user, $fitnessProfile);

        return [
            'calories' => $dailyCalories,
            'protein' => $protein,
            'carbs' => max($carbs, 0), // Pastikan tidak negatif
            'fat' => $fatGrams,
            'water_intake' => $waterIntake,
            'hydrogen_level' => 7.0, // Netral pH
        ];
    }

    /**
     * 💧 Hitung kebutuhan air berdasarkan berat badan
     * Sumber: Armstrong (2007) - 35ml per kg berat badan
     */
    private function calculateWaterIntake($user, $fitnessProfile)
    {
        $weight = $user->weight ?? 70;

        // Dasar: 35ml per kg berat badan (Armstrong, 2007)
        $baseWater = $weight * 35;

        // Sesuaikan berdasarkan aktivitas (Sawka et al., 2005)
        if ($fitnessProfile && $fitnessProfile->activity_level) {
            $activityMultipliers = [
                'light' => 1.1,    // +10%
                'moderate' => 1.3, // +30%
                'heavy' => 1.5,    // +50%
            ];

            $baseWater *= ($activityMultipliers[$fitnessProfile->activity_level] ?? 1.0);
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
        $suggestions = $this->generateRecommendations($deficits, $fitnessProfile, $user);

        // 🔹 Rekomendasi berdasarkan hydrogen level
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
     */
    private function generateRecommendations($deficits, $fitnessProfile, $user)
    {
        $suggestions = [];
        $weight = $user->weight ?? 70;
        $goal = $fitnessProfile->goal_id ?? 3;

        // Threshold berdasarkan penelitian
        $calorieThreshold = 500; // Garthe et al. (2011): 500-750 kkal
        $proteinThreshold = 20;  // 20g defisit protein signifikan
        $waterThreshold = 500;   // 500ml defisit air signifikan

        // Rekomendasi berdasarkan berat badan
        if ($weight > 90) {
            $suggestions[] = 'Dengan berat badan di atas 90kg, fokuskan pada protein berkualitas tinggi dan kontrol porsi karbohidrat.';
        } elseif ($weight < 55) {
            $suggestions[] = 'Dengan berat badan di bawah 55kg, pastikan asupan kalori cukup untuk menjaga berat badan sehat.';
        }

        // Rekomendasi berdasarkan goal
        if ($goal == 2 && $deficits['calories'] < -500) {
            $suggestions[] = '⚠️ Defisit kalori terlalu besar (>500 kkal). Pertahankan defisit 500 kkal/hari untuk hasil optimal (Garthe et al., 2011).';
        }

        // Protein recommendation
        $proteinTarget = round($weight * match ($goal) {
            1 => 2.0,
            2 => 2.2,
            3 => 1.6,
            4 => 1.6,
            default => 1.8
        });

        if ($deficits['protein'] > $proteinThreshold) {
            $suggestions[] = "Target protein Anda {$proteinTarget}g/hari. Tambahkan sumber protein seperti telur, ayam, ikan, atau tempe.";
        }

        // Carbohydrate recommendation
        if ($deficits['carbs'] > 50) {
            $suggestions[] = 'Asupan karbohidrat masih kurang. Tambahkan karbo kompleks seperti nasi merah, oats, atau ubi.';
        }

        // Fat recommendation
        if ($deficits['fat'] > 15) {
            $suggestions[] = 'Tambahkan lemak sehat seperti alpukat, kacang-kacangan, atau minyak zaitun.';
        }

        // Calorie recommendation
        if ($deficits['calories'] > $calorieThreshold) {
            $suggestions[] = 'Kalori harian masih kurang. Pertimbangkan tambah porsi makan atau camilan sehat.';
        }

        // Water recommendation
        if ($deficits['water_intake'] > $waterThreshold) {
            $waterTarget = $this->calculateWaterIntake($user, $fitnessProfile);
            $suggestions[] = "Target air minum Anda {$waterTarget}ml per hari. Minum lebih banyak air putih sepanjang hari.";
        }

        return $suggestions;
    }

    /* ----------------------------------------------------------
     * ⚙️ PERHITUNGAN MAKANAN & ADAPTASI
     * ---------------------------------------------------------- */

    /**
     * 🔥 Hitung kebutuhan kalori untuk rata-rata orang
     * Sumber: Mifflin-St Jeor Equation dengan koreksi ilmiah
     */
    private function calculateCalories(User $user, $progress = null, $fitnessProfile = null)
    {
        $weight = $user->weight ?? 70;
        $height = $user->height ?? 170;
        $age = $user->age ?? 30;
        $gender = $user->gender ?? 'male';
        $goal = $fitnessProfile->goal_id ?? 3;

        // Mifflin-St Jeor Equation (1990)
        $bmr = $gender === 'male'
            ? (10 * $weight) + (6.25 * $height) - (5 * $age) + 5
            : (10 * $weight) + (6.25 * $height) - (5 * $age) - 161;

        // Activity multiplier berdasarkan aktivitas harian (FAO/WHO/UNU, 2001)
        $activityLevel = $fitnessProfile->activity_level ?? 'moderate';
        $activityMultipliers = [
            'light' => 1.375,     // Sedikit atau tidak berolahraga
            'moderate' => 1.55,   // Olahraga ringan 3-5 hari/minggu
            'heavy' => 1.725,     // Olahraga berat 6-7 hari/minggu
        ];

        $calories = $bmr * ($activityMultipliers[$activityLevel] ?? 1.55);

        // Goal-based adjustments (Garthe et al., 2011; Helms et al., 2014)
        $goalMultipliers = [
            1 => 1.05, // Muscle Gain: +5%
            2 => 0.92, // Fat Loss: -8%
            3 => 1.00, // Maintenance
            4 => 1.05, // Endurance: +5%
        ];

        $calories *= ($goalMultipliers[$goal] ?? 1.00);

        // Minimum calories protection (Thomas et al., 2016)
        $minimumCalories = $gender === 'male' ? 1500 : 1200;
        $calories = max($calories, $minimumCalories);

        // Adaptive adjustment berdasarkan progress (Das et al., 2009)
        if ($progress && $progress->calories_consumed) {
            // Jika konsumsi aktual berbeda >15% dari target, sesuaikan 5%
            $diffRatio = $progress->calories_consumed / $calories;
            if ($diffRatio > 1.15 || $diffRatio < 0.85) {
                $adjustment = $diffRatio > 1.15 ? 1.05 : 0.95;
                $calories *= $adjustment;
            }
        }

        return round($calories);
    }

    /**
     * 🥩 Hitung kebutuhan makronutrien untuk rata-rata orang
     * Berdasarkan berat badan dan standar gizi umum
     */
    private function calculateMacros($calories, $user, $fitnessProfile = null)
    {
        $weight = $user->weight ?? 70;
        $goal = $fitnessProfile->goal_id ?? 3;

        // Protein: berdasarkan berat badan dan goal
        // Morton et al. (2018), Helms et al. (2014), Wycherley et al. (2012)
        $proteinPerKg = match ($goal) {
            1 => 2.0, // Muscle gain: lebih tinggi
            2 => 2.2, // Fat loss: lebih tinggi untuk kenyang
            3 => 1.6, // Maintenance: standar
            4 => 1.6, // Endurance: sedikit lebih rendah
            default => 1.8,
        };

        $protein = round($weight * $proteinPerKg);

        // Lemak: 20-35% dari kalori (IOM, 2002)
        $fatPercentage = match ($goal) {
            1 => 0.23, // Muscle Gain: 23%
            2 => 0.28, // Fat Loss: 28%
            3 => 0.25, // Maintenance: 25%
            4 => 0.25, // Endurance: 25%
            default => 0.25,
        };

        $fat = round(($calories * $fatPercentage) / 9);

        // Karbohidrat: sisanya
        $proteinCalories = $protein * 4;
        $fatCalories = $fat * 9;
        $remainingCalories = $calories - $proteinCalories - $fatCalories;
        $carbs = round($remainingCalories / 4);

        // Air: berdasarkan berat badan (Armstrong, 2007)
        $waterIntake = $this->calculateWaterIntake($user, $fitnessProfile);

        return [
            'calories' => round($calories),
            'protein' => $protein,
            'carbs' => max($carbs, 0), // Pastikan tidak negatif
            'fat' => $fat,
            'water_intake' => $waterIntake,
            'hydrogen_level' => 7.0,
        ];
    }
}
