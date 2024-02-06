<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //AdminLogin
    public function loginWeb(Request $request)
    {
        return view('auth.login');
    }
    public function postLogin(Request $request)
    {
        $credentials = $request->only('name', 'password');
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect('/dashboard/home')->with('success', 'Berhasil Login sebagai' . ' ' . Auth::guard('admin')->user()->name);
        } else {
            return redirect()->back()->with('   ', 'Login Gagal, Email atau password salah');
        }
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6|max:20',
            ]);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
            return $this->postSuccessResponse('User Registration Success', $user);
        } catch (\Throwable $th) {
            return $this->failedResponse($th->getMessage(), null, 500);
        };
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|min:6|max:20',
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return $this->failedResponse('Email not registered', null, 400);
            }
            if (!password_verify($request->password, $user->password)) {
                return $this->failedResponse('Incorrect password', null, 400);
            }
            $token = $user->createToken('authToken')->plainTextToken;

            return $this->postSuccessResponse('Login Success', [
                'user' => $user,
                'token' => $token
            ]);
        } catch (\Throwable $th) {
            return $this->failedResponse($th->getMessage(), null, 500);
        }
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->postSuccessResponse('Logout Success', $request->user());
    }

    public function loggedOut(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
