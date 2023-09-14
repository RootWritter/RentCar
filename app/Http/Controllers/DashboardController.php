<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $data = [
            'page' => 'Halaman Dashboard',
        ];
        return view('dashboard', $data);
    }
}
