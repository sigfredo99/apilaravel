<?php
/*------------------------------------------------------------------------
  \file         JWTCustomerController
  \author       Luis Angel Moreno Mulluni
  \email        anngel.morenno@gmail.com
  \ver          0.5
  \date         01-11-2020
  \brief        Controlador para gestionar la autenticacion del usuario en la plataforma cliente
 -------------------------------------------------------------------------*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Config;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Customer;

class JWTCustomerController extends Controller
{
    public function __construct()
    {
        auth()->shouldUse('api_customers');
    }
    
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
            'name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|string|email|max:255|unique:customers',
            'cell_phone' => 'required|string|max:50',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        $user = Customer::create([
            'name' => $request->get('name'),
            'last_name' => $request->get('last_name'),
            'email' => strtolower($request->get('email')),
            'cell_phone' => $request->get('cell_phone'),
            'password' => bcrypt($request->get('password')),
            'status' => 1
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string|min:6',
            'new_password' => 'required|string|min:6',
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            if(Hash::check($request->current_password, \Auth::user()->password))
            {
                $user = \Auth::user();
                $user->password = bcrypt($request->new_password);
                $user->update();

                return response()->json([
                    'status' => 'success',
                    'message' => 'La contraseña ha sido cambiada correctamente.'
                ], 200);
            }

            return response()->json([
                'status' => 'failed',
                'message' => 'Contraseña actual es incorrecta.'
            ], 500);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'status' => 'failed',
                'message' => 'Algo salió mal Inténtelo de nuevo más tarde.'
            ], 500);
        }
    }

    public function fcmToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fcm_token' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $user = \Auth::user();
            $user->token_notification = $request->fcm_token;
            $user->update();

            return response()->json([
                'status' => 'success',
                'message' => 'El Token ha sido almacenado correctamente.'
            ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'status' => 'failed',
                'message' => 'Algo salió mal Inténtelo de nuevo más tarde.'
            ], 500);
        }
    }
}
