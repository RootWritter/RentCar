<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\RentData;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function car(Request $request)
    {
        if ($request->ajax()) {
            $model = Car::query();
            return datatables()->of($model)->addIndexColumn()->addColumn('action', function ($row) {
                $actionBtn = "<a class='btn btn-icon waves-effect btn-warning' href='javascript:;' onclick='edit(" . $row['id'] . ")'><i class='fa fa-edit''></i></a> ";
                $actionBtn .= "<a class='btn btn-icon waves-effect btn-danger' href='javascript:;' onclick='hapus(" . $row['id'] . ")'><i class='fa fa-trash''></i></a>";
                return $actionBtn;
            })->rawColumns(['action', 'status'])->make(true);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Cannot Access Direct >.<'
            ], 403);
        }
    }
    public function getCar(Request $request)
    {
        return Car::where('id', $request['id'])->first();
    }
    public function rentData(Request $request)
    {
        if ($request->ajax()) {
            $model = RentData::join('cars', 'rent_data.car_id', '=', 'cars.id')->join('users', 'rent_data.user_id', '=', 'users.id')->get(['rent_data.*', 'cars.brand', 'cars.model', 'cars.price as car_price', 'cars.return', 'users.name']);
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
}
