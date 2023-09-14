<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        $data = [
            'page' => 'Masuk',
        ];
        return view('auth.login', $data);
    }
    public function register()
    {
        $data = [
            'page' => 'Registrasi',
        ];
        return view('auth.register', $data);
    }
    public function authenticate(Request $request)
    {
        try {
            $validate = $this->validate($request, [
                'email' => 'required',
                'password' => 'required'
            ], [
                'email.required' => 'Kolom Alamat Email dibutuhkan',
                'password.required' => 'Kolom Password dibutuhkan'
            ]);
            $login = Auth::attempt($validate, true);
            if (!$login) throw new \ErrorException('Tidak dapat memverifikasi data anda, silahkan coba lagi');
            return response()->json([
                'status' => true,
                'message' => 'Login Berhasil',
            ]);
        } catch (\ErrorException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
    public function store(Request $request)
    {
        try {
            $validate = $this->validate($request, [
                'name' => 'required',
                'email' => 'required',
                'password' => 'required',
                'address' => 'required',
                'phone' => 'required',
                'drive_license_number' => 'required'
            ], [
                'name.required' => 'Kolom Nama Lengkap dibutuhkan',
                'email.required' => 'Kolom Alamat Email dibutuhkan',
                'password.required' => 'Kolom Password dibutuhkan',
                'address.required' => 'Kolom Alamat dibutuhkan',
                'phone.required' => 'Kolom Nomor Telepon dibutuhkan',
                'drive_license_number.required' => 'Kolom Nomor SIM dibutuhkan',
            ]);

            $validate['password'] = Hash::make($validate['password']);
            $insert = User::create($validate);
            if (!$insert) throw new \ErrorException('Pendaftaran Gagal');
            return response()->json([
                'status' => true,
                'message' => 'Registrasi Berhasil',
            ]);
        } catch (\ErrorException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
