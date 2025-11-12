<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;

class LaporanController extends Controller
{
    public function index()
    {
        return view('trainer.laporan.index');
    }
}
