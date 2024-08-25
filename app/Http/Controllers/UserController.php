<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller {
    public function index() {
        $users = User::all();
        return response()->json($users);
    }
    public function create(Request $request) {
        $user = new User();
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ], [
            'name.required' => 'O nome é obrigatório',
            'email.required' => 'O e-mail é obrigatório',
            'email.email' => 'O e-mail deve ser um e-mail válido',
            'email.unique' => 'Este e-mail já está em uso',
            'password.required' => 'A senha é obrigatória'
        ]);
        $user->name = $request::input('name');
        $user->email = $request::input('email');
        $user->password = bcrypt($request::input('password'));
        $user->save();
        return response()->json($user);
    }
    public function update(Request $request, $id) {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $user->name = $request->input('name') ?? $user->name;
        $user->email = $request->input('email') ?? $user->email;
        $user->password = bcrypt($request->input('password')) ?? $user->password;
        $user->save();
        return response()->json($user);
    }
    public function delete($id) {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }
}
