<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function car(Request $request)
    {
        try {
            if ($request['action'] == "add") {
                $validate = $this->validate($request, [
                    'brand' => 'required',
                    'model' => 'required',
                    'number_plate' => 'required',
                    'price' => 'required'
                ]);
                $insert = Car::create($validate);
                if (!$insert) throw new \ErrorException('Gagal Menambahkan Data');
                $message = "Berhasil Menambahkan Data";
            } else if ($request['action'] == "edit") {
                $validate = $this->validate($request, [
                    'brand' => 'required',
                    'model' => 'required',
                    'number_plate' => 'required',
                    'price' => 'required'
                ]);
                $update = Car::where('id', $request['id'])->update($validate);
                if (!$update) throw new \ErrorException('Gagal Mengupdate Data');
                $message = "Berhasil Mengupdate Data";
            } else if ($request['action'] == "hapus") {
                $delete = Car::where('id', $request['id'])->delete();
                if (!$delete) throw new \ErrorException('Gagal Menghapus Data');
                $message = "Berhasil Menghapus Data";
            }

            return response()->json([
                'status' => true,
                'message' => $message,
            ]);
        } catch (\ErrorException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
