<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Favorite::with(['product','customer'])->get();
        return response()->json($favorites);
    }

    public function show($id)
    {
        $favorite = Favorite::with(['product','customer'])->find($id);
        return response()->json($favorite);
    }

    public function store(Request $request)
    {
        auth()->shouldUse('api_customers');
        $user = \Auth::user();
        $validator = Validator::make($request->all(), [
            'product_id' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $favorite = new Favorite;
            $favorite->product_id = $request->product_id;
            $favorite->customer_id = $user->customer_id;
            $favorite->save();
            
            return response()->json([
                'status' => 'register_ok',
                'message' => 'Se ha creado correctamente',
                'data' => $favorite
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

    public function remove($id) {
        $favorite = Favorite::findOrFail($id);
        if($favorite)
        $favorite->delete(); 
        else
            return response()->json([
                'status' => false,
                'message' => 'Algo salió mal. Inténtalo de nuevo más tarde'
            ], 500);
        return response()->json([
            'status' => true,
            'message' => 'Se ha eliminado correctamente',
            'data' => $favorite
        ], 201);
    }
}
