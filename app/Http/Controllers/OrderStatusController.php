<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\OrderStatus;

class OrderStatusController extends Controller
{
    public function index(Request $request)
    {
        $orders_status = OrderStatus::where('order_id','=',$request->id)->orderBy('status')->get();
        return response()->json($orders_status);
    }

    public function show($id)
    {
        $order_status = OrderStatus::find($id);
        return response()->json($order_status);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required',
            'status' => 'required',
            'order_date' => 'required',
            'order_hour' => 'required',
            'reason' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $order_status = new OrderStatus;
            $order_status->order_id = $request->order_id;
            $order_status->status = $request->status;
            $order_status->order_date = $request->order_date;
            $order_status->order_hour = $request->order_hour;
            $order_status->reason = $request->reason;
            $order_status->save();
            
            return response()->json([
                'status' => 'register_ok',
                'message' => 'Se ha creado correctamente',
                'data' => $order_status
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
            'status' => 'required',
            'order_date' => 'required',
            'order_hour' => 'required',
            'reason' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $order_status = OrderStatus::find($request->id);
            $order_status->order_id = $request->order_id;
            $order_status->status = $request->status;
            $order_status->order_date = $request->order_date;
            $order_status->order_hour = $request->order_hour;
            $order_status->reason = $request->reason;
            $order_status->update();
            
            return response()->json([
                'status' => 'updated_ok',
                'message' => 'Se ha modificado correctamente',
                'data' => $order_status
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
