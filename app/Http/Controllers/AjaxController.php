<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\RentData;
use Carbon\Carbon;
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
    public function returnCar(Request $request)
    {
        DB::beginTransaction();
        try {
            $validate = $this->validate($request, [
                'id' => 'required',
                'number_plate' => 'required'
            ]);
            $checkSewa = RentData::where('id', $validate['id'])->first();
            $now = Carbon::now();
            $start = new Carbon($checkSewa['date_start_rent']);
            $diff =  $start->diffInDays($now);
            $car = Car::where('id', $checkSewa['car_id'])->first();
            $priceCorrection = $car['price'] * ($diff + 1);
            RentData::where('id', $checkSewa['id'])->update([
                'date_end_rent' => Carbon::now()->format('Y-m-d'),
                'price_correction' => $priceCorrection,
            ]);
            Car::where('id', $car['id'])->update([
                'return' => 1,
            ]);
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Berhasil Mengembalikan Mobil',
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
