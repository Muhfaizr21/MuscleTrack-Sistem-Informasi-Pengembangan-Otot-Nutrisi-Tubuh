<?php

namespace App\Http\Controllers;

class TrainerController extends Controller
{
    // Dashboard Trainer
    public function index()
    {
        return view('trainer.dashboard'); // resources/views/trainer/dashboard.blade.php
    }
}
