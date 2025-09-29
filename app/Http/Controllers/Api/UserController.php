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

    

    public function index()
    {
        return User::all();
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        User::where('id', $id)->update([
            "name" => $request->name,
            "email" => $request->email,
        ]);

        return response()->json([
            'message' => "Utilisateur modifié avec succès",
        ], 200);
    }

    public function destroy(string $id)
    {
        User::find($id)->delete();
        return response()->json([
            "message" => "Suppression réussie"
        ], 200);
    }  
}