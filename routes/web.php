<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;

// Route::get('/', function () {
//     $users = User::all();
//     // echo csrf_token();
//     return response()->json($users);
// });

// Route::post('/create', function (
//     Request $request
// ) {
//     $user = new User();
//     $user->name = $request::input('name');
//     $user->email = $request::input('email');
//     $user->password = bcrypt($request::input('password'));
//     $user->save();
//     return response()->json($user);
// });

// Route::patch('/update/{id}', function (
//     Request $request,
//     $id
// ) {
//     $user = User::find($id);
//     if (!$user) {
//         return response()->json(['message' => 'User not found'], 404);
//     }
//     $user->name = $request::input('name') ?? $user->name;
//     $user->email = $request::input('email') ?? $user->email;
//     $user->password = bcrypt($request::input('password')) ?? $user->password;
//     $user->save();
//     return response()->json($user);
// });

// Route::delete('/delete/{id}', function (
//     $id
// ) {
//     $user = User::find($id);
//     if (!$user) {
//         return response()->json(['message' => 'User not found'], 404);
//     }
//     $user->delete();
//     return response()->json(['message' => 'User deleted']);
// });