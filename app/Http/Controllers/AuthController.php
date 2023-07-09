<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;

class AuthController extends Controller
{

    private function signIn($credentials)
    {
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json(['token' => $token, 'db' => Config::get('database.connections.mysql.database'), 'user' => $user], 200);
        } else {
            return response()->json(['error' => 'Invalid credential'], 400);
        }
    }
    private function signUp($response, $credentials)
    {
        $user =  User::create([
            'name' => $response['user']['name'],
            'email' => $response['user']['email'],
            'user_type' => $response['user']['user_type'],
            'db_name' => $response['user']['db_name'],
            'password' => $credentials['password']
        ]);

        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json(['token' => $token, 'db' => Config::get('database.connections.mysql.database'), 'user' => $user], 200);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $response = Http::post('http://db.cattleglobal.com/sas/public/api/login', $credentials);
        if ($response->status() === 200) {
            // Config::set('database.connections.mysql.database', $response['user']['db_name']);
            // app('db')->purge();
            // $db = $response['user']['db_name'];
            // Cache::rememberForever('userData', function () use ($db) {
            //     return $db;
            // });
            $check =  User::where(['email' => $response['user']['email'], 'db_name' => $response['user']['db_name']])->first();
            if ($check) {
                return $this->signIn($credentials);
            } else {
                return $this->signUp($response, $credentials);
            }
        } else {
            return response()->json(['error' => 'API call failed'], 400);
        }
    }
}
