<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\RentData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
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
            'total_rent' => RentData::where('user_id', $user['id'])->count(),
            'remaining_car' => $count,
            'filter_brand' => Car::select('brand')->groupBy('brand')->get()
        ];
        return view('dashboard', $data);
    }
    public function rentData()
    {
        $data = [
            'page' => 'Halaman Riwayat Penyewaan',
        ];
        return view('rent_data', $data);
    }
}
