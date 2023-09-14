<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
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
}
