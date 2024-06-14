<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\HasApiTokens;

class LoginController extends Controller
{
    use HasApiTokens;

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        //mock sucesso
        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
        ]);
        if ($user && Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
            ]);
        }
        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);

        // erro ao createToken(verificar phpversion ou passport)
        // $credentials = $request->only(['email', 'password']);
        // Log::info('Credentials:', $credentials); log
        // if (Auth::attempt($credentials)) {
        //     $token = Auth::user()->Auth::createToken('auth_token')->plainTextToken;
        //     return response()->json(['access_token' => $token]);
        // } else {
        //     // dump('fora if');
        //     // Log::debug('Request data:', Auth::attempt($credentials));
        //     return response()->json(['error' => 'Invalid credentials'], 401);
        // }
    }
}
