<?php
/*------------------------------------------------------------------------
  \file         JWTUserController
  \author       William Arturo Huillca Umpiri
  \email        Wilhuillcau@upt.pe
  \ver          0.5
  \date         30-10-2020
  \target       CU014_AutentificarUsuario
  \brief        Controlador para gestionar la autenticacion del usuario en la plataforma web
 -------------------------------------------------------------------------*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;

class JWTUserController extends Controller
{
    public function getAuthenticatedUser()
    {
        if(!$user = JWTAuth::parseToken()->authenticate())
        {
            return response()->json([
                'status' => 'user_not_found',
                'message' => 'Usuario no encontrado',
            ], 404);
        }
        
        return response()->json($user);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try
        {
            if(!$jwtToken = JWTAuth::attempt($credentials))
            {
                return response()->json([
                    'status' => 'invalid_credentials',
                    'message' => 'Correo electrónico o contraseña no válidos',
                ], 401);
            }
        }
        catch(JWTException $e)
        {
            return response()->json([
                'status' => 'could_not_create_token',
                'message' => 'No se pudo crear el token',
            ], 500);
        }
        
        return response()->json([
            'status' => 'login_success',
            'token' => $jwtToken
        ]);
    }

    public function logout(Request $request)
    {
        JWTAuth::invalidate($request->bearerToken());
        return  response()->json([
            'status' => 'logout_success',
            'message' => 'Cierre de sesión exitoso'
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }
}
