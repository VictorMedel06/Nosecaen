<?php

namespace App\Http\Controllers\Operario;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('operario.dashboard');
    }
}
