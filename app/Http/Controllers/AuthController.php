<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request) {

         $response = Http::get('https://');
         if ($response->status() === 200) {
             return $response->json();


         } else {
             return response()->json(['error' => 'API call failed'], 400);
         }


        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('user-token')->plainTextToken;
            return response()->json(['token' => $token]);
        }
        return response()->json(['message' => 'Invalid credentials'], 401);
    }
}
