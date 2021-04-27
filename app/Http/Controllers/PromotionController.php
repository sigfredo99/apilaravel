<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Promotion;
use App\Models\PromotionDetail;


class PromotionController extends Controller
{
    public function index()
    {
        $arrayPromotions = [];
        $promotions = Promotion::all();
        foreach($promotions as $promotion)
        {
            $arrayProduct = []; 
            $details = PromotionDetail::where('promotion_id',$promotion->promotion_id)->get();
            foreach($details as $detail)
            {
                array_push($arrayProduct, $detail->product::with(['category','restaurant'])->find($detail->product->product_id));
            }
            $promotion->products = $arrayProduct;
            array_push($arrayPromotions, $promotion);
        }
        return response()->json($arrayPromotions);
    }

    public function show($id)
    {
        $promotion = Promotion::find($id);
        return response()->json($promotion);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'name' => 'required',
            'price' => 'required',
            'status' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $promotion = new Promotion;
            $promotion->code = $request->code;
            $promotion->start_date = $request->start_date;
            $promotion->end_date = $request->end_date;
            $promotion->name = $request->name;
            $promotion->description = $request->description;
            $promotion->image = $request->image;
            $promotion->price = $request->price;
            $promotion->status = $request->status;
            $promotion->save();
            
            return response()->json([
                'status' => 'register_ok',
                'message' => 'Se ha creado correctamente',
                'data' => $promotion
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
            'code' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'name' => 'required',
            'price' => 'required',
            'status' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $promotion = Promotion::find($request->id);
            $promotion->code = $request->code;
            $promotion->start_date = $request->start_date;
            $promotion->end_date = $request->end_date;
            $promotion->name = $request->name;
            $promotion->description = $request->description;
            $promotion->image = $request->image;
            $promotion->price = $request->price;
            $promotion->status = $request->status;
            $promotion->update();
            
            return response()->json([
                'status' => 'updated_ok',
                'message' => 'Se ha modificado correctamente',
                'data' => $promotion
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
