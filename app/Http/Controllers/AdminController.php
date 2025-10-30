<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Dashboard Admin
    public function index()
    {
        return view('admin.dashboard'); // pastikan file Blade ada: resources/views/admin/dashboard.blade.php
    }
}
