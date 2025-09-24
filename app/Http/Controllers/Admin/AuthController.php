<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // public function tokenLogin()
    // {
    //     return [
    //         "message" => "Authentification requise pour avoir un token valide.",
    //     ];
    // }


    // public function login(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'email' => 'required|email'
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'error' => $validator->errors()
    //         ], 422);
    //     }

    //     $user = User::where('email', $request->email)->first();

    //     if (!$user) {
    //         $user = User::create([
    //             'email' => $request->email,
    //             'name' => ''
    //         ]);

    //         $user->tokens()->delete();
    //         Auth::login($user);

    //         $token = $user->createToken($user->id)->plainTextToken;

    //         return response()->json([
    //             'user' => $user,
    //             'is_new' => true,
    //             'token' => $token
    //         ]);
    //     }

    //     $user->tokens()->delete();
    //     Auth::login($user);
    //     $token = $user->createToken($user->id)->plainTextToken;

    //     return response()->json([
    //         'user' => $user,
    //         'is_new' => false,
    //         'token' => $token
    //     ]);
    // }

    // public function update(Request $request, string $id)
    // {
    //     try {
    //         $user = User::findOrFail($id);
    //         $user->update($request->only('name', 'email'));
    //         return response()->json(['message' => "Profil modifié avec succès", $user], 200);
    //     } catch (\Throwable $th) {
    //         //throw $th;
    //     }
    // }

    // public function logout(Request $request)
    // {
    //     try {
    //         $user = Auth::user();

    //         $user->tokens()->delete();
    //         Auth::logout();

    //         return [
    //             'message' => "Déconnexion réussie.",
    //         ];
    //     } catch (ValidationException $err) {
    //     } catch (\Throwable $th) {
    //         return [
    //             'message' => "Déconnexion réussie.",
    //         ];
    //     }
    // }

}




