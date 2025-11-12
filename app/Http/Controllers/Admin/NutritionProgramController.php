<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NutritionPlan; // Kita pakai Model Anda yang sudah ada
use Illuminate\Http\Request;

class NutritionProgramController extends Controller
{
    /**
     * Menampilkan daftar program nutrisi (HANYA TEMPLATE ADMIN).
     */
    public function index()
    {
        // KUNCI: Kita hanya ambil program master (user_id = NULL)
        $programs = NutritionPlan::whereNull('user_id')
            ->latest()
            ->paginate(10);

        return view('admin.nutrition_programs.index', compact('programs'));
    }

    /**
     * Menampilkan form untuk membuat program baru.
     */
    public function create()
    {
        return view('admin.nutrition_programs.create');
    }

    /**
     * Menyimpan program baru ke database (sebagai template).
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
            'target_fitness' => 'required|string',
            'type' => 'required|in:breakfast,lunch,dinner,snack',
        ]);

        // KUNCI: Buat data baru, tapi pastikan user_id = NULL
        $data = $request->all();
        $data['user_id'] = null; // Ini menandakan sebagai TEMPLATE ADMIN

        NutritionPlan::create($data);

        return redirect()->route('admin.nutrition-programs.index')
            ->with('success', 'Program nutrisi baru berhasil dibuat.');
    }

    /**
     * Menampilkan form untuk mengedit program.
     * Kita gunakan $plan (NutritionPlan) agar konsisten.
     */
    public function edit(NutritionPlan $nutritionProgram)
    {
        // Pastikan admin hanya bisa edit template
        if ($nutritionProgram->user_id !== null) {
            abort(404);
        }

        return view('admin.nutrition_programs.edit', ['plan' => $nutritionProgram]);
    }

    /**
     * Update program di database.
     */
    public function update(Request $request, NutritionPlan $nutritionProgram)
    {
        // Pastikan admin hanya bisa edit template
        if ($nutritionProgram->user_id !== null) {
            abort(404);
        }

        $request->validate([
            'meal_name' => 'required|string|max:255',
            'calories' => 'required|numeric|min:0',
            'protein' => 'required|numeric|min:0',
            'carbs' => 'required|numeric|min:0',
            'fat' => 'required|numeric|min:0',
            'day_of_week' => 'required|string',
            'target_fitness' => 'required|string',
            'type' => 'required|in:breakfast,lunch,dinner,snack',
        ]);

        $data = $request->all();
        $data['user_id'] = null; // Jaga-jaga

        $nutritionProgram->update($data);

        return redirect()->route('admin.nutrition-programs.index')
            ->with('success', 'Program nutrisi berhasil diperbarui.');
    }

    /**
     * Hapus program dari database.
     */
    public function destroy(NutritionPlan $nutritionProgram)
    {
        // Pastikan admin hanya bisa hapus template
        if ($nutritionProgram->user_id !== null) {
            abort(404);
        }

        $nutritionProgram->delete();

        return redirect()->route('admin.nutrition-programs.index')
            ->with('success', 'Program nutrisi berhasil dihapus.');
    }
}
