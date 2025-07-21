<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string',
        ],[
            'email.required'    => 'Vui lòng nhập địa chỉ email.',
            'email.email'       => 'Email không đúng định dạng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.string'   => 'Mật khẩu phải là một chuỗi ký tự.',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error($validator->errors()->first(), 422);
        }
        $response = Http::asForm()->post(config('services.passport.login_endpoint'), [
            'grant_type'    => 'password',
            'client_id'     => config('services.passport.client_id'),
            'client_secret' => config('services.passport.client_secret'),
            'username'      => $request->email,
            'password'      => $request->password,
            'scope'         => '*',
        ]);

        if ($response->failed()) {
            return ApiResponse::error('Sai tài khoản hoặc mật khẩu', 401);
        }

        $data = $response->json();
        $user = User::where('email', $request->email)->first();

        return ApiResponse::success([
            'access_token'  => $data['access_token'],
            'refresh_token' => $data['refresh_token'] ?? null,
            'token_type'    => $data['token_type'],
            'expires_in'    => $data['expires_in'],
            'user'          => $user,
        ], 'Đăng nhập thành công', 200);
    }
}
