<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\NutritionPlan;
use App\Models\Supplement;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NutritionManagementController extends Controller
{
    /**
     * 📋 Halaman Index — Menampilkan SEMUA member dengan overview nutrisi
     */
    public function index()
    {
        $trainer = Auth::user();

        $members = User::where('trainer_id', $trainer->id)
            ->where('role', 'user')
            ->with(['nutritionPlans', 'nutritionPlans.supplements'])
            ->orderBy('name')
            ->get();

        // Hitung stats untuk footer
        $membersWithPlans = $members->filter(function($member) {
            return $member->nutritionPlans->count() > 0;
        })->count();

        $totalPlans = $members->sum(function($member) {
            return $member->nutritionPlans->count();
        });

        $totalSupplements = $members->sum(function($member) {
            return $member->nutritionPlans->sum(function($plan) {
                return $plan->supplements->count();
            });
        });

        $totalCaloriesAll = $members->sum(function($member) {
            return $member->nutritionPlans->sum('calories');
        });

        return view('trainer.nutrition.index', compact(
            'members',
            'membersWithPlans',
            'totalPlans',
            'totalSupplements',
            'totalCaloriesAll'
        ));
    }

    /**
     * 📋 Halaman Show — Menampilkan nutrisi & suplemen member SPESIFIK
     */
    public function show($memberId)
    {
        $trainer = Auth::user();

        $member = User::where('id', $memberId)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        // Ambil nutrition plans dengan supplements
        $nutritionPlans = NutritionPlan::where('user_id', $member->id)
            ->with('supplements')
            ->orderByRaw("FIELD(day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
            ->orderBy('type')
            ->get();

        // Group by day untuk tampilan yang lebih terorganisir
        $plansByDay = $nutritionPlans->groupBy('day_of_week');

        // Supplements sudah di-load melalui eager loading
        $supplements = $nutritionPlans->flatMap->supplements;

        // Hitung total nutrisi per hari
        $dailyTotals = [];
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        foreach ($days as $day) {
            $plans = $plansByDay->get($day, collect());
            $dailyTotals[$day] = [
                'calories' => $plans->sum('calories'),
                'protein' => $plans->sum('protein'),
                'carbs' => $plans->sum('carbs'),
                'fat' => $plans->sum('fat'),
                'meal_count' => $plans->count(),
                'supplement_count' => $plans->sum(fn($plan) => $plan->supplements->count())
            ];
        }

        // Hitung totals keseluruhan
        $overallTotals = [
            'calories' => $nutritionPlans->sum('calories'),
            'protein' => $nutritionPlans->sum('protein'),
            'carbs' => $nutritionPlans->sum('carbs'),
            'fat' => $nutritionPlans->sum('fat'),
            'meal_count' => $nutritionPlans->count(),
            'supplement_count' => $supplements->count()
        ];

        return view('trainer.nutrition.show', compact(
            'member',
            'nutritionPlans',
            'plansByDay',
            'supplements',
            'dailyTotals',
            'overallTotals',
            'days'
        ));
    }

    /**
     * ✏️ Halaman Create/Edit Nutrisi Plan
     */
    public function create($memberId)
    {
        $trainer = Auth::user();

        $member = User::where('id', $memberId)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        $days = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu'
        ];

        $types = [
            'breakfast' => 'Sarapan 🍳',
            'lunch' => 'Makan Siang 🍲',
            'dinner' => 'Makan Malam 🍛',
            'snack' => 'Cemilan 🍎'
        ];

        $targetFitnessOptions = [
            'Bulking' => 'Bulking (Menambah Massa)',
            'Cutting' => 'Cutting (Mengurangi Lemak)',
            'Maintenance' => 'Maintenance (Mempertahankan)',
            'Endurance' => 'Endurance (Daya Tahan)',
            'General' => 'General (Umum)'
        ];

        return view('trainer.nutrition.create', compact(
            'member',
            'days',
            'types',
            'targetFitnessOptions'
        ));
    }

    /**
     * ✏️ Halaman Edit Nutrition Plan tertentu
     */
    public function edit($memberId, $planId)
    {
        $trainer = Auth::user();

        $member = User::where('id', $memberId)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        $nutritionPlan = NutritionPlan::where('user_id', $member->id)
            ->with('supplements')
            ->findOrFail($planId);

        $days = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu'
        ];

        $types = [
            'breakfast' => 'Sarapan 🍳',
            'lunch' => 'Makan Siang 🍲',
            'dinner' => 'Makan Malam 🍛',
            'snack' => 'Cemilan 🍎'
        ];

        $targetFitnessOptions = [
            'Bulking' => 'Bulking (Menambah Massa)',
            'Cutting' => 'Cutting (Mengurangi Lemak)',
            'Maintenance' => 'Maintenance (Mempertahankan)',
            'Endurance' => 'Endurance (Daya Tahan)',
            'General' => 'General (Umum)'
        ];

        return view('trainer.nutrition.edit', compact(
            'member',
            'nutritionPlan',
            'days',
            'types',
            'targetFitnessOptions'
        ));
    }

    /**
     * 💾 Simpan Nutrition Plan baru
     */
    public function store(Request $request, $memberId)
    {
        $trainer = Auth::user();

        $member = User::where('id', $memberId)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        $validated = $request->validate([
            'meal_name' => 'required|string|max:255',
            'day_of_week' => 'required|string|max:20',
            'type' => 'required|in:breakfast,lunch,dinner,snack',
            'calories' => 'required|integer|min:0|max:5000',
            'protein' => 'required|numeric|min:0|max:500',
            'carbs' => 'required|numeric|min:0|max:1000',
            'fat' => 'required|numeric|min:0|max:500',
            'water_intake' => 'nullable|numeric|min:0|max:10',
            'target_fitness' => 'nullable|string|max:100'
        ]);

        DB::transaction(function () use ($member, $trainer, $validated) {
            $nutritionPlan = NutritionPlan::create(array_merge($validated, [
                'user_id' => $member->id
            ]));

            Notification::create([
                'user_id' => $member->id,
                'title' => 'Rencana Nutrisi Baru 🍽️',
                'message' => "Trainer {$trainer->name} telah membuat rencana nutrisi baru: {$nutritionPlan->meal_name}",
                'type' => 'nutrition_tip',
                'read_status' => false,
            ]);
        });

        return redirect()
            ->route('trainer.nutrition.index', ['memberId' => $member->id])
            ->with('success', '✅ Rencana nutrisi berhasil dibuat!');
    }

    /**
     * 💾 Update Nutrition Plan
     */
    public function update(Request $request, $memberId, $planId)
    {
        $trainer = Auth::user();

        $member = User::where('id', $memberId)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        $nutritionPlan = NutritionPlan::where('user_id', $member->id)
            ->findOrFail($planId);

        $validated = $request->validate([
            'meal_name' => 'required|string|max:255',
            'day_of_week' => 'required|string|max:20',
            'type' => 'required|in:breakfast,lunch,dinner,snack',
            'calories' => 'required|integer|min:0|max:5000',
            'protein' => 'required|numeric|min:0|max:500',
            'carbs' => 'required|numeric|min:0|max:1000',
            'fat' => 'required|numeric|min:0|max:500',
            'water_intake' => 'nullable|numeric|min:0|max:10',
            'target_fitness' => 'nullable|string|max:100'
        ]);

        $nutritionPlan->update($validated);

        return redirect()
            ->route('trainer.nutrition.index', ['memberId' => $member->id])
            ->with('success', '✅ Rencana nutrisi berhasil diperbarui!');
    }

    /**
     * 🗑️ Hapus Nutrition Plan
     */
    public function destroy($memberId, $planId)
    {
        $trainer = Auth::user();

        $member = User::where('id', $memberId)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        $nutritionPlan = NutritionPlan::where('user_id', $member->id)
            ->findOrFail($planId);

        // Hapus suplemen terkait terlebih dahulu
        Supplement::where('nutrition_plan_id', $nutritionPlan->id)->delete();

        $nutritionPlan->delete();

        return redirect()
            ->route('trainer.nutrition.index', ['memberId' => $member->id])
            ->with('success', '✅ Rencana nutrisi berhasil dihapus!');
    }

    /**
     * 💊 Tambah rekomendasi suplemen
     */
    public function storeSupplement(Request $request, $memberId)
    {
        $trainer = Auth::user();

        $member = User::where('id', $memberId)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'recommended_dose' => 'required|string|max:255',
            'nutrition_plan_id' => 'required|exists:nutrition_plans,id'
        ]);

        // Validasi kepemilikan nutrition plan
        $nutritionPlan = NutritionPlan::where('id', $validated['nutrition_plan_id'])
            ->where('user_id', $member->id)
            ->firstOrFail();

        DB::transaction(function () use ($member, $trainer, $nutritionPlan, $validated) {
            $supplement = Supplement::create([
                'nutrition_plan_id' => $nutritionPlan->id,
                'name' => $validated['name'],
                'description' => $validated['description'],
                'recommended_dose' => $validated['recommended_dose']
            ]);

            Notification::create([
                'user_id' => $member->id,
                'title' => 'Rekomendasi Suplemen Baru 💊',
                'message' => "Trainer {$trainer->name} merekomendasikan suplemen: {$supplement->name}",
                'type' => 'nutrition_tip',
                'read_status' => false,
            ]);
        });

        return back()->with('success', '💊 Suplemen berhasil ditambahkan!');
    }

    /**
     * 🗑️ Hapus rekomendasi suplemen
     */
    public function destroySupplement($memberId, $supplementId)
    {
        $trainer = Auth::user();

        $member = User::where('id', $memberId)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        $supplement = Supplement::findOrFail($supplementId);

        // Validasi kepemilikan
        $nutritionPlanIds = NutritionPlan::where('user_id', $member->id)->pluck('id');
        if (!$nutritionPlanIds->contains($supplement->nutrition_plan_id)) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus suplemen ini.');
        }

        $supplement->delete();

        return redirect()
            ->route('trainer.nutrition.index', ['memberId' => $member->id])
            ->with('success', '💊 Suplemen berhasil dihapus!');
    }

    /**
     * 📊 Analisis Nutrisi Member - PERBAIKAN: Variabel yang konsisten
     */
    public function analysis($memberId)
    {
        $trainer = Auth::user();

        $member = User::where('id', $memberId)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        // Ambil data nutrition plans dengan supplements
        $nutritionPlans = NutritionPlan::where('user_id', $member->id)
            ->with('supplements')
            ->get();

        // Hitung statistik - PERBAIKAN: Gunakan nama variabel yang konsisten
        $totalCalories = $nutritionPlans->sum('calories');
        $totalProtein = $nutritionPlans->sum('protein');
        $totalCarbs = $nutritionPlans->sum('carbs');
        $totalFat = $nutritionPlans->sum('fat');
        $mealCount = $nutritionPlans->count();
        $supplementCount = $nutritionPlans->sum(fn($plan) => $plan->supplements->count());

        // Hitung averages - PERBAIKAN: Tambahkan averageCalories
        $daysWithData = $nutritionPlans->groupBy('day_of_week')->count() ?: 1;
        $averageCalories = $totalCalories / $daysWithData;
        $averageProtein = $totalProtein / $daysWithData;
        $averageCarbs = $totalCarbs / $daysWithData;
        $averageFat = $totalFat / $daysWithData;

        // Group by day untuk chart
        $caloriesByDay = $nutritionPlans->groupBy('day_of_week')->map->sum('calories');

        // Hitung macro distribution
        $totalMacros = $totalProtein + $totalCarbs + $totalFat;
        $macroDistribution = $totalMacros > 0 ? [
            'protein' => round(($totalProtein / $totalMacros) * 100, 2),
            'carbs' => round(($totalCarbs / $totalMacros) * 100, 2),
            'fat' => round(($totalFat / $totalMacros) * 100, 2),
        ] : ['protein' => 0, 'carbs' => 0, 'fat' => 0];

        return view('trainer.nutrition.analysis', compact(
            'member',
            'nutritionPlans',
            'totalCalories',
            'totalProtein',
            'totalCarbs',
            'totalFat',
            'mealCount',
            'supplementCount',
            'averageCalories', // ✅ PERBAIKAN: Tambahkan variabel ini
            'averageProtein',
            'averageCarbs',
            'averageFat',
            'caloriesByDay',
            'macroDistribution'
        ));
    }

    /**
     * 🔄 Duplicate Nutrition Plan ke hari lain
     */
    public function duplicate(Request $request, $memberId, $planId)
    {
        $trainer = Auth::user();

        $member = User::where('id', $memberId)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        $originalPlan = NutritionPlan::where('user_id', $member->id)
            ->findOrFail($planId);

        $request->validate([
            'target_days' => 'required|array',
            'target_days.*' => 'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday'
        ]);

        $createdCount = 0;
        foreach ($request->target_days as $day) {
            if ($day === $originalPlan->day_of_week) {
                continue;
            }

            NutritionPlan::create([
                'user_id' => $member->id,
                'meal_name' => $originalPlan->meal_name . " (Copy)",
                'day_of_week' => $day,
                'type' => $originalPlan->type,
                'calories' => $originalPlan->calories,
                'protein' => $originalPlan->protein,
                'carbs' => $originalPlan->carbs,
                'fat' => $originalPlan->fat,
                'water_intake' => $originalPlan->water_intake,
                'target_fitness' => $originalPlan->target_fitness,
            ]);
            $createdCount++;
        }

        return redirect()
            ->route('trainer.nutrition.index', ['memberId' => $member->id])
            ->with('success', "✅ Berhasil menduplikasi {$createdCount} rencana nutrisi!");
    }

    /**
     * 📤 Export Nutrition Plan
     */
    public function export($memberId)
    {
        $trainer = Auth::user();

        $member = User::where('id', $memberId)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        return redirect()
            ->route('trainer.nutrition.analysis', ['memberId' => $member->id])
            ->with('info', '🚀 Fitur export akan segera hadir!');
    }

    /**
     * 🔍 Quick Search Members (AJAX endpoint)
     */
    public function searchMembers(Request $request)
    {
        $trainer = Auth::user();

        $searchTerm = $request->get('q');

        $members = User::where('trainer_id', $trainer->id)
            ->where('role', 'user')
            ->where(function($query) use ($searchTerm) {
                $query->where('name', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('email', 'LIKE', "%{$searchTerm}%");
            })
            ->withCount(['nutritionPlans'])
            ->withCount(['supplements'])
            ->orderBy('name')
            ->limit(10)
            ->get()
            ->map(function($member) {
                return [
                    'id' => $member->id,
                    'name' => $member->name,
                    'email' => $member->email,
                    'avatar' => $member->avatar,
                    'nutrition_plans_count' => $member->nutrition_plans_count,
                    'supplements_count' => $member->supplements_count,
                    'profile_url' => route('trainer.nutrition.index', $member->id)
                ];
            });

        return response()->json($members);
    }

    /**
     * 📊 Nutrition Dashboard Overview
     */
    public function dashboard()
    {
        $trainer = Auth::user();

        $members = User::where('trainer_id', $trainer->id)
            ->where('role', 'user')
            ->with(['nutritionPlans', 'nutritionPlans.supplements'])
            ->orderBy('name')
            ->get();

        // Overall statistics - PERBAIKAN: Gunakan nama variabel yang konsisten
        $totalMembers = $members->count();
        $totalPlans = $members->sum(function($member) {
            return $member->nutritionPlans->count();
        });
        $totalSupplements = $members->sum(function($member) {
            return $member->nutritionPlans->sum(function($plan) {
                return $plan->supplements->count();
            });
        });
        $totalCaloriesAll = $members->sum(function($member) {
            return $member->nutritionPlans->sum('calories');
        });

        // Recent activity
        $recentPlans = NutritionPlan::whereIn('user_id', $members->pluck('id'))
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Members with most plans
        $topMembers = $members->sortByDesc(function($member) {
            return $member->nutritionPlans->count();
        })->take(5);

        return view('trainer.nutrition.dashboard', compact(
            'members',
            'totalMembers',
            'totalPlans',
            'totalSupplements',
            'totalCaloriesAll',
            'recentPlans',
            'topMembers'
        ));
    }

    /**
     * 🚀 Bulk Actions untuk Multiple Members
     */
    public function bulkActions(Request $request)
    {
        $trainer = Auth::user();

        $request->validate([
            'action' => 'required|in:duplicate_plan,assign_supplement,export_data',
            'member_ids' => 'required|array',
            'member_ids.*' => 'exists:users,id'
        ]);

        $memberIds = $request->member_ids;
        $action = $request->action;

        // Validasi kepemilikan member
        $validMemberIds = User::where('trainer_id', $trainer->id)
            ->whereIn('id', $memberIds)
            ->pluck('id');

        if ($validMemberIds->count() !== count($memberIds)) {
            return back()->with('error', '❌ Akses ditolak untuk beberapa member.');
        }

        switch ($action) {
            case 'duplicate_plan':
                return back()->with('info', '🚀 Fitur bulk duplicate akan segera hadir!');

            case 'assign_supplement':
                return back()->with('info', '🚀 Fitur bulk assign supplement akan segera hadir!');

            case 'export_data':
                return back()->with('info', '🚀 Fitur bulk export akan segera hadir!');
        }

        return back()->with('error', '❌ Aksi tidak valid.');
    }
}
