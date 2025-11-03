<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- Pastikan ini ada
use App\Models\User; // <-- Pastikan ini ada

class DashboardController extends Controller
{
    /**
     * Tampilkan Dashboard Trainer
     */
    public function index()
    {
        // Ambil satu member pertama milik trainer
        // Logika @php Anda kita pindahkan ke sini
        $firstMember = User::where('trainer_id', Auth::id())->first();

        // Kirim variabel $firstMember ke view
        return view('trainer.dashboard', [
            'firstMember' => $firstMember
        ]);
    }
}
