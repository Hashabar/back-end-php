<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\HasApiTokens;

class LoginController extends Controller
{
    use HasApiTokens;

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        // if (!Auth::attempt($credentials)) {
        //     return response()->json(['error' => 'Invalid credentials'], 401);
        // }

        // $user = Auth::user();
        // $token = $user->Auth::createToken('auth_token')->plainTextToken;

        // return response()->json(['token' => $token]);
        if (Auth::attempt($credentials)) {
            // User authenticated successfully
            // Create a token for the user
            dump('dentro if');
            Log::debug('Request data:', Auth::attempt($credentials));
            $token = Auth::user()->Auth::createToken('auth_token')->plainTextToken;

            return response()->json(['access_token' => $token]);
        } else {
            // Invalid credentials
            dump('fora if');
            Log::debug('Request data:', Auth::attempt($credentials));
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    }
}
