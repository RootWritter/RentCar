<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $data = [
            'page' => 'Halaman Dashboard',
            'user' => auth()->guard('admin')->user()
        ];
        return view('admin.dashboard', $data);
    }
    public function car()
    {
        $data = [
            'page' => 'Halaman Data Mobil',
            'user' => auth()->guard('admin')->user()
        ];
        return view('admin.car', $data);
    }
    public function rent()
    {
        $data = [
            'page' => 'Halaman Data Penyewa',
            'user' => auth()->guard('admin')->user()
        ];
        return view('admin.rent_data', $data);
    }
}
