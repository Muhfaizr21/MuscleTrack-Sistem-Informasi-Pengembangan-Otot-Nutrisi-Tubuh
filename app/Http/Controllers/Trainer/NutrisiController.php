<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NutrisiController extends Controller
{
    public function index()
    {
        return view('trainer.nutrisi.index');
    }
}
