<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\PromotionDetail;

class PromotionDetailController extends Controller
{
    public function index()
    {
        $promotion_details = PromotionDetail::all();
        return response()->json($promotion_details);
    }

    public function show($id)
    {
        $promotion_detail = PromotionDetail::find($id);
        return response()->json($promotion_detail);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'promotion_id' => 'required',
            'restaurant_id' => 'required',
            'product_id' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $promotion_detail = new PromotionDetail;
            $promotion_detail->promotion_id = $request->promotion_id;
            $promotion_detail->restaurant_id = $request->restaurant_id;
            $promotion_detail->product_id = $request->product_id;
            $promotion_detail->save();
            
            return response()->json([
                'status' => 'register_ok',
                'message' => 'Se ha creado correctamente',
                'data' => $promotion_detail
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
            'category_id' => 'required',
            'code' => 'required|size:6',
            'name' => 'required|max:200',
            'price' => 'required',
            'status' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $promotion_detail = PromotionDetail::find($request->id);
            $promotion_detail->promotion_id = $request->promotion_id;
            $promotion_detail->restaurant_id = $request->restaurant_id;
            $promotion_detail->product_id = $request->product_id;
            $promotion_detail->update();
            
            return response()->json([
                'status' => 'updated_ok',
                'message' => 'Se ha modificado correctamente',
                'data' => $promotion_detail
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
