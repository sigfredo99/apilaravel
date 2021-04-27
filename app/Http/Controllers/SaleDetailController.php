<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\SaleDetail;

class SaleDetailController extends Controller
{
    public function index()
    {
        $sale_details = SaleDetail::all();
        return response()->json($sale_details);
    }

    public function show($id)
    {
        $sale_detail = SaleDetail::find($id);
        return response()->json($sale_detail);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sale_id' => 'required',
            'item_code' => 'required',
            'item_description' => 'required',
            'quantity' => 'required',
            'unit_value' => 'required',
            'unit_price' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $sale_detail = new SaleDetail;
            $sale_detail->sale_id = $request->sale_id;
            $sale_detail->item_code = $request->item_code;
            $sale_detail->item_description = $request->item_description;
            $sale_detail->quantity = $request->quantity;
            $sale_detail->unit_value = $request->unit_value;
            $sale_detail->unit_price = $request->unit_price;
            $sale_detail->save();
            
            return response()->json([
                'status' => 'register_ok',
                'message' => 'Se ha creado correctamente',
                'data' => $sale_detail
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
            'sale_id' => 'required',
            'item_code' => 'required',
            'item_description' => 'required',
            'quantity' => 'required',
            'unit_value' => 'required',
            'unit_price' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $sale_detail = SaleDetail::find($request->id);
            $sale_detail->sale_id = $request->sale_id;
            $sale_detail->item_code = $request->item_code;
            $sale_detail->item_description = $request->item_description;
            $sale_detail->quantity = $request->quantity;
            $sale_detail->unit_value = $request->unit_value;
            $sale_detail->unit_price = $request->unit_price;
            $sale_detail->update();
            
            return response()->json([
                'status' => 'updated_ok',
                'message' => 'Se ha modificado correctamente',
                'data' => $sale_detail
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
