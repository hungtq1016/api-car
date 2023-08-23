<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'remember_token' => Str::random(36),
            ]);
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json(
                [
                    'status_code' => 201,
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'message' => 'Đăng ký thành công',
                    'metadata' => $user,
                ],
                201
            );
        } catch (\Throwable $th) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Có lỗi xảy ra thử lại sao ít phút!',
                'error' => $th,
            ]);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'email|required',
                'password' =>  'required'
            ]);

            $credentials = request(['email', 'password']);

            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Có lỗi xảy ra thử lại sao ít phút!'
                ]);
            }
            $user = User::where('email', $request->email)->first();

            if (!Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Lỗi Đăng Nhập');
            }
            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json([
                'status_code' => 200,
                'access_token' => $token,
                'token_type' => 'Bearer',
                'message' => 'Đăng nhập thành công',
                'metadata' => $user
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Có lỗi xảy ra thử lại sao ít phút!',
                'error' => $th,
            ]);
        }
    }
}
