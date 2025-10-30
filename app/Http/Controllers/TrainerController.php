<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrainerController extends Controller
{
    // Dashboard Trainer
    public function index()
    {
        return view('trainer.dashboard'); // resources/views/trainer/dashboard.blade.php
    }
}
