<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\RentData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    public function rentCar(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = Auth()->user();
            $validation = $this->validate($request, [
                'brand' => 'required',
                'model' => 'required',
                'est_rent' => 'required',
                'date_start_rent' => 'required'
            ]);
            $checkCar = Car::where([
                ['brand', $validation['brand']],
                ['id', $validation['model']],
                ['return', 1]
            ])->first();
            if (!$checkCar) throw new \ErrorException('Mobil yang dicari tidak ada / tidak tersedia');
            $checkRentData = RentData::where([
                ['car_id', $checkCar['id']],
            ])->whereNotNull('date_end_rent')->count();
            if ($checkRentData) throw new \ErrorException('Tidak dapat mengambil data Status Mobil');
            $data = [
                'car_id' => $checkCar['id'],
                'user_id' => $user['id'],
                'date_start_rent' => $validation['date_start_rent'],
                'price' => $checkCar['price'] * $validation['est_rent'],
                'est_rent' => $validation['est_rent'],
                'price_correction' => 0,
                'return' => 0
            ];
            Car::where('id', $checkCar['id'])->update([
                'return' => 0
            ]);
            $insert = RentData::create($data);
            if (!$insert) throw new \ErrorException('Terjadi Kesalahan');
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Berhasil Menyewa Mobil',
            ]);
        } catch (\ErrorException $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
