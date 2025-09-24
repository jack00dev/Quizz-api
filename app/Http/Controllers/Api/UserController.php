<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    public function tokenLogin()
    {
        return [
            "message" => "Authentification requise pour avoir un token valide.",
        ];
    }
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => "required",
                'email' => "required|email|unique:users",
            ]);

            $user = User::create($request->all());
            $token = $user->createToken($user->id)->plainTextToken;

            Auth::login($user);


            return response()->json([
                'user' => $user,
                'token' => $token,
            ], 201);
        } catch (ValidationException $err) {
            return [
                'message' => "Données non valides",
                'error' => $err->errors(),
            ];
        } catch (\Throwable $th) {
            return $th;
        }
        // $user = User::create($request->only('name', 'email'));
        // return response()->json($user, 201);
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors()
                ], 422);
            }

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                $user = User::create([
                    'email' => $request->email,
                    'name' => ''
                ]);

                $user->tokens()->delete();
                Auth::login($user);

                $token = $user->createToken($user->id)->plainTextToken;

                return response()->json([
                    'user' => $user,
                    'is_new' => true,
                    'token' => $token
                ], 200);
            }

            $user->tokens()->delete();
            Auth::login($user);

            $token = $user->createToken($user->id)->plainTextToken;

            return response()->json([
                'user' => $user,
                'is_new' => false,
                'token' => $token
            ], 200);
        } catch (ValidationException $err) {
            return [
                'message' => "Email non valides",
                'error' => $err->errors(),
            ];
        } catch (\Throwable $th) {
            return $th;
        }

    }

    public function index()
    {
        return response()->json(User::all(), 200);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user, 200);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->only('name', 'email'));
        return response()->json($user, 200);
    }

    public function logout(Request $request)
    {
        try {
            $user = Auth::user();

            $user->tokens()->delete();
            Auth::logout();

            return [
                'message' => "Déconnexion réussie.",
            ];
        } catch (ValidationException $err) {
        } catch (\Throwable $th) {
            return [
                'message' => "Déconnexion réussie.",
            ];
        }
    }
}