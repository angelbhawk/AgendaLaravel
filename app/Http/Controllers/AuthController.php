<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {

        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            return response([
                "message" => "tus credenciales no son correctas",
            ], 422);
        }

        $user = Auth::user();

        if ($user) {
            Log::info('User authenticated: ' . $user->email);
        } else {
            Log::info('User not authenticated');
        }


        $token = $user->createToken("main")->plainTextToken;

        return response(compact("user", "token"));
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'image' => 'nullable|image|max:2048', // Validar que sea una imagen y un tamaño máximo
        ]);

        // Subir la imagen si está presente
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/users', 'public');
        }

        // Crear el usuario
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'image_path' => $imagePath,
        ]);

        $token = $user->createToken("main")->plainTextToken;

        return response(compact("user", "token"));
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();
        return response("", 204);
    }
}
