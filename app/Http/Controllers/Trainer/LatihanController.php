<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;

class LatihanController extends Controller
{
    public function index()
    {
        return view('trainer.latihan.index');
    }
}
