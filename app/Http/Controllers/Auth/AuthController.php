<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'phone'    => 'required|string|unique:users,phone',
            'email'    => 'nullable|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'sometimes|in:farmer,buyer',
            'region'   => 'nullable|string',
        ]);

        $user = User::create([
            ...$validated,
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'] ?? 'buyer',
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Inscription réussie',
            'user'    => $user,
            'token'   => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone'    => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('phone', $request->phone)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'phone' => ['Numéro ou mot de passe incorrect.'],
            ]);
        }

        if (! $user->is_active) {
            return response()->json(['message' => 'Compte désactivé.'], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Connexion réussie',
            'user'    => $user,
            'token'   => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken();

        if (method_exists($token, 'delete')) {
            $token->delete();
        }

        return response()->json(['message' => 'Déconnexion réussie']);
    }

    public function me(Request $request)
    {
        return response()->json($request->user()->load('farmer'));
    }
}