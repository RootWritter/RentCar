<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\RentData;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function getModel(Request $request)
    {
        try {
            $car = Car::where([
                ['brand', $request['brand']],
                ['return', 1]
            ])->get();
            return response()->json([
                'status' => true,
                'message' => 'Berhasil',
                'data' => $car
            ]);
        } catch (\ErrorException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
    public function rentData(Request $request)
    {
        if ($request->ajax()) {
            $model = RentData::join('cars', 'rent_data.car_id', '=', 'cars.id')->where('user_id', auth()->user()['id'])->get(['rent_data.*', 'cars.brand', 'cars.model', 'cars.price as car_price', 'cars.return']);
            return datatables()->of($model)->addIndexColumn()->addColumn('status', function ($row) {
                if (!$row['date_end_rent']) {
                    $color = "warning";
                    $text = "Belum Kembali";
                } else {
                    $color = "success";
                    $text = "Sudah Kembali";
                }
                return "<badge class='badge bg-$color'>$text</badge>";
            })->addColumn('action', function ($row) {
                $actionBtn = "";
                if (!$row['date_end_rent']) {
                    $actionBtn .= "<a class='btn btn-icon waves-effect btn-warning' href='javascript:;' onclick='returnCar(" . $row['id'] . ")'><i class='fa fa-history''></i></a> ";
                }
                return $actionBtn;
            })->rawColumns(['action', 'status'])->make(true);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Cannot Access Direct >.<'
            ], 403);
        }
    }
    public function rentDataHistory(Request $request)
    {
        $data = RentData::join('cars', 'rent_data.car_id', '=', 'cars.id')
            ->where([
                ['user_id', auth()->user()['id']],
                ['rent_data.id', $request['id']]
            ])
            ->first(['rent_data.*', 'cars.brand', 'cars.model', 'cars.price as car_price', 'cars.return']);
        return $data;
    }
}
