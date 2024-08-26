<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller {
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $user = User::where('email', $request->email)->first();
        if (! $user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }
    
    $token = $user->createToken('token-name')->plainTextToken;
    
        return response()->json(['token' => $token]);
    }
    public function logout() {
        Auth::logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
    public function user() {
        return response()->json(['user' => Auth::user()]);
    }
}
