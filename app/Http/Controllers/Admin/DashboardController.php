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
}
