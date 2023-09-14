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
            $model = RentData::query();
            return datatables()->of($model)->addIndexColumn()->addColumn('action', function ($row) {
                $actionBtn = "<a class='btn btn-icon waves-effect btn-warning' href='javascript:;' onclick='return(" . $row['id'] . ")'><i class='fa fa-history''></i></a> ";
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
