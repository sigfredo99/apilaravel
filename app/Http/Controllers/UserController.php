<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function show($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'last_name' => 'required',
            'cell_phone' => 'required',
            'email' => 'required',
            'password' => 'required',
            'user_type' => 'required',
            'status' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $user = new User;
            $user->name = $request->name;
            $user->last_name = $request->last_name;
            $user->cell_phone = $request->cell_phone;
            $user->email = strtolower($request->email);
            $user->password = bcrypt($request->password);
            $user->user_type = $request->user_type;
            $user->status = $request->status;
            $user->save();
            
            return response()->json([
                'status' => 'register_ok',
                'message' => 'Se ha creado correctamente',
                'data' => $user
            ], 201);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'status' => 'register_error',
                'message' => 'Algo salió mal. Inténtalo de nuevo más tarde'
            ], 500);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'last_name' => 'required',
            'cell_phone' => 'required',
            'email' => 'required',
            'password' => 'required',
            'user_type' => 'required',
            'status' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $user = User::find($request->id);
            $user->name = $request->name;
            $user->last_name = $request->last_name;
            $user->cell_phone = $request->cell_phone;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->remember_token = $request->remember_token;
            $user->user_type = $request->user_type;
            $user->status = $request->status;
            $user->update();
            
            return response()->json([
                'status' => 'updated_ok',
                'message' => 'Se ha modificado correctamente',
                'data' => $user
            ]);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'status' => 'updated_error',
                'message' => 'Algo salió mal. Inténtalo de nuevo más tarde'
            ], 500);
        }
    }

    public function remove()
    {
        return response()->json([]);
    }
}
