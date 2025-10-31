<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\NutritionPlan;
use App\Models\User;
use App\Models\Notification;
use Carbon\Carbon;

class UserNutritionController extends Controller
{
    /**
     * 📊 Tampilkan menu nutrisi harian/mingguan lengkap dengan makronutrien
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil rencana nutrisi berdasarkan target fitness
        $nutritions = NutritionPlan::where('target_fitness', $user->target_fitness)
            ->orWhereNull('target_fitness')
            ->orderBy('day_of_week', 'asc')
            ->get();

        // Hitung kebutuhan kalori & makronutrien user
        $calorieNeeds = $this->calculateCalories($user);
        $macroNeeds = $this->calculateMacros($calorieNeeds);

        // 🔹 Data untuk grafik mingguan
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $chartData = [
            'protein' => [],
            'carbs' => [],
            'fat' => [],
        ];

        foreach ($days as $day) {
            $chartData['protein'][] = $nutritions->where('day_of_week', $day)->sum('protein');
            $chartData['carbs'][] = $nutritions->where('day_of_week', $day)->sum('carbs');
            $chartData['fat'][] = $nutritions->where('day_of_week', $day)->sum('fat');
        }

        return view('user.nutrition.index', compact('nutritions', 'calorieNeeds', 'macroNeeds', 'chartData', 'days'));
    }

    /**
     * 📋 Form tambah menu nutrisi custom (opsional untuk user premium)
     */
    public function create()
    {
        return view('user.nutrition.create');
    }

    /**
     * 💾 Simpan menu nutrisi baru (misal: custom plan dari user)
     */
    public function store(Request $request)
    {
        $request->validate([
            'meal_name' => 'required|string|max:255',
            'calories' => 'required|numeric|min:0',
            'protein' => 'required|numeric|min:0',
            'carbs' => 'required|numeric|min:0',
            'fat' => 'required|numeric|min:0',
            'day_of_week' => 'required|string',
        ]);

        $user = Auth::user();

        NutritionPlan::create([
            'user_id' => $user->id,
            'meal_name' => $request->meal_name,
            'calories' => $request->calories,
            'protein' => $request->protein,
            'carbs' => $request->carbs,
            'fat' => $request->fat,
            'day_of_week' => $request->day_of_week,
            'target_fitness' => $user->target_fitness ?? null,
        ]);

        return redirect()->route('user.nutrition.index')->with('success', 'Menu nutrisi berhasil ditambahkan!');
    }

    /**
     * ✏️ Edit menu nutrisi user
     */
    public function edit($id)
    {
        $nutrition = NutritionPlan::findOrFail($id);
        return view('user.nutrition.edit', compact('nutrition'));
    }

    /**
     * 🔁 Update data nutrisi
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'meal_name' => 'required|string|max:255',
            'calories' => 'required|numeric|min:0',
            'protein' => 'required|numeric|min:0',
            'carbs' => 'required|numeric|min:0',
            'fat' => 'required|numeric|min:0',
            'day_of_week' => 'required|string',
        ]);

        $nutrition = NutritionPlan::findOrFail($id);
        $nutrition->update($request->only(['meal_name', 'calories', 'protein', 'carbs', 'fat', 'day_of_week']));

        return redirect()->route('user.nutrition.index')->with('success', 'Menu nutrisi berhasil diperbarui!');
    }

    /**
     * ❌ Hapus menu nutrisi
     */
    public function destroy($id)
    {
        $nutrition = NutritionPlan::findOrFail($id);
        $nutrition->delete();

        return redirect()->route('user.nutrition.index')->with('success', 'Menu nutrisi berhasil dihapus!');
    }

    /**
     * ⚙️ Hitung kebutuhan kalori berdasarkan BB, TB, usia, dan target fitness
     */
    private function calculateCalories(User $user)
    {
        $weight = $user->weight ?? 70; // kg
        $height = $user->height ?? 170; // cm
        $age = $user->age ?? 25;
        $gender = $user->gender ?? 'male';

        // Rumus Harris-Benedict
        $bmr = ($gender === 'male')
            ? (88.362 + (13.397 * $weight) + (4.799 * $height) - (5.677 * $age))
            : (447.593 + (9.247 * $weight) + (3.098 * $height) - (4.330 * $age));

        // Faktor aktivitas ringan default
        $calories = $bmr * 1.55;

        // Penyesuaian berdasarkan target
        return match ($user->target_fitness) {
            'fat_loss' => round($calories * 0.85),
            'muscle_gain' => round($calories * 1.15),
            default => round($calories),
        };
    }

    /**
     * 🍗 Hitung kebutuhan makronutrien (protein, karbo, lemak)
     */
    private function calculateMacros($calories)
    {
        // Rasio umum makronutrien (% dari total kalori)
        return [
            'protein' => round(($calories * 0.30) / 4), // gram
            'carbs' => round(($calories * 0.45) / 4),   // gram
            'fat' => round(($calories * 0.25) / 9),     // gram
        ];
    }

    /**
     * 🔔 Kirim notifikasi pengingat nutrisi & protein harian
     */
    public function sendDailyReminder()
    {
        $users = User::all();

        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'title' => 'Nutrition Reminder 🍽️',
                'message' => 'Jangan lupa penuhi target protein dan nutrisi harianmu hari ini!',
                'type' => 'reminder',
                'read_status' => false,
            ]);
        }

        return response()->json(['message' => 'Nutrition reminders sent!']);
    }
}
