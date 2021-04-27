<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\OrderDetail;

class OrderDetailController extends Controller
{
    public function index()
    {
        $order_details = OrderDetail::all();
        return response()->json($order_details);
    }

    public function show($id)
    {
        $order_detail = OrderDetail::find($id);
        return response()->json($order_detail);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required',
            'item_code' => 'required',
            'item_description' => 'required',
            'quantity' => 'required',
            'unit_price' => 'required',
            'amount' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $order_detail = new OrderDetail;
            $order_detail->order_id = $request->order_id;
            $order_detail->item_code = $request->item_code;
            $order_detail->item_description = $request->item_description;
            $order_detail->quantity = $request->quantity;
            $order_detail->unit_price = $request->unit_price;
            $order_detail->amount = $request->amount;
            $order_detail->observation = $request->observation;
            $order_detail->save();
            
            return response()->json([
                'status' => 'register_ok',
                'message' => 'Se ha creado correctamente',
                'data' => $order_detail
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
            'order_id' => 'required',
            'item_code' => 'required',
            'item_description' => 'required',
            'quantity' => 'required',
            'unit_price' => 'required',
            'amount' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $order_detail = OrderDetail::find($request->id);
            $order_detail->order_id = $request->order_id;
            $order_detail->item_code = $request->item_code;
            $order_detail->item_description = $request->item_description;
            $order_detail->quantity = $request->quantity;
            $order_detail->unit_price = $request->unit_price;
            $order_detail->amount = $request->amount;
            $order_detail->observation = $request->observation;
            $order_detail->update();
            
            return response()->json([
                'status' => 'updated_ok',
                'message' => 'Se ha modificado correctamente',
                'data' => $order_detail
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
