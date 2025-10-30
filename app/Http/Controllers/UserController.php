<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    // Dashboard User
    public function index()
    {
        return view('user.dashboard'); // resources/views/user/dashboard.blade.php
    }
}
