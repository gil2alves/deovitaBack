<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only(['name_user', 'password']);

        try {
            if (!$token = auth('api')->attempt($credentials)) {
                throw new \Exception('Usuário ou senha incorreto');
            }

            $user = auth('api')->user();

            return response()->json([
                'token' => $token,
                'user' => [
                    'name' => $user->name,
                    'name_user' => $user->name_user,
                    'group_id' => $user->group_id,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }


    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Logout realizado com sucesso!']);
    }


    public function refresh()
    {
        $token = JWTAuth::refresh();
        return response()->json(['token' => $token]);
    }

    public function me()
    {
        $user = auth('api')->user();

        return response()->json([
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
    }
}
