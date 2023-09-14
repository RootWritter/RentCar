<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\RentData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::guard('admin')->user();
        $getCar = Car::get();
        $count = 0;
        $dataCar = array();
        foreach ($getCar as $car) {
            $checkRentData = RentData::where('car_id', $car['id'])->whereNotNull('date_end_rent')->count();
            if (!$checkRentData) {
                $count++;
            }
        }
        $data = [
            'page' => 'Halaman Dashboard',
            'total_rent' => RentData::count(),
            'remaining_car' => $count,
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
