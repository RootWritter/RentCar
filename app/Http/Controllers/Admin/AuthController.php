<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        $data = [
            'page' => 'Halaman Login Admin',
        ];
        return view('admin.auth.login', $data);
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
            $login = Auth::guard('admin')->attempt($validate, true);
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
}
