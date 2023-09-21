<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuthenReosurce;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'email','unique:users,email'],
                'password' =>  ['required', 'confirmed', Password::min(8)],
                'name' => ['required'],
                'phone' => ['required'],
                'address' => ['required'],
            ]);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'phone' => $request->phone,
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
                    'data' => $user,
                    'error' => false
                ],
                201
            );
        } catch (\Throwable $th) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Có lỗi xảy ra thử lại sao ít phút!',
                'error' => true,
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
                    'message' => 'Email hoặc mật khẩu sai',
                    'error' => true,
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
                'error'=>false,
                'token_type' => 'Bearer',
                'message' => 'Đăng nhập thành công',
                'data' => new AuthenReosurce($user)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Có lỗi xảy ra thử lại sao ít phút!',
                'error' => true,
            ]);
        }
    }
}
