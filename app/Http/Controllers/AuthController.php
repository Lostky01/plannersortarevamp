<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web', ['except' => ['login', 'register', 'loginmenu', 'registermenu']]);
    }

    public function loginmenu() {
        return view('loginmenu');
    }

    public function registermenu() {
        return view('registermenu');
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email'=> 'required|email|unique:users',
            'password'=> 'required|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('login-page')->with('success', 'Registration successful! Please log in.');
    }

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');
    
        if (! $token = auth()->attempt($credentials)) {
            return redirect()->back()->withErrors(['error' => 'Unauthorized']);
        }
    
        // Simpan data user ke session
        $user = auth()->user();
        session(['user' => $user]);
    
        return redirect()->route('index');
    }
    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('index')->with('success', 'Successfully logged out');
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
