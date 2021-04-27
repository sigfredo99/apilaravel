<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\UserRestaurant;

class UserRestaurantController extends Controller
{
    public function index()
    {
        $user_restaurants = UserRestaurant::with(['restaurant','user'])->get();
        return response()->json($user_restaurants);
    }

    public function show($id)
    {
        $user_restaurant = UserRestaurant::with(['restaurant','user'])->find($id);
        return response()->json($user_restaurant);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'restaurant_id' => 'required',
            'user_id' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $user_restaurant = new UserRestaurant;
            $user_restaurant->restaurant_id = $request->restaurant_id;
            $user_restaurant->user_id = $request->user_id;
            $user_restaurant->save();
            
            return response()->json([
                'status' => 'register_ok',
                'message' => 'Se ha creado correctamente',
                'data' => $user_restaurant
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
            'restaurant_id' => 'required',
            'user_id' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $user_restaurant = UserRestaurant::find($request->id);
            $user_restaurant->restaurant_id = $request->restaurant_id;
            $user_restaurant->user_id = $request->user_id;
            $user_restaurant->update();
            
            return response()->json([
                'status' => 'updated_ok',
                'message' => 'Se ha modificado correctamente',
                'data' => $user_restaurant
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
