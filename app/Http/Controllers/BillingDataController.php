<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\BillingData;

class BillingDataController extends Controller
{
    public function index()
    {
        $billing_datas = BillingData::with('order')->get();
        return response()->json($billing_datas);
    }

    public function show($id)
    {
        $billing_data = BillingData::with('order')->find($id);
        return response()->json($billing_data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required',
            'document_type' => 'required|size:2',
            'document_number' => 'required|size:11',
            'denomination' => 'required|max:200',
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $billing_data = new BillingData;
            $billing_data->order_id = $request->order_id;
            $billing_data->document_type = $request->document_type;
            $billing_data->document_number = $request->document_number;
            $billing_data->denomination = $request->denomination;
            $billing_data->save();
            
            return response()->json([
                'status' => 'register_ok',
                'message' => 'Se ha creado correctamente',
                'data' => $billing_data
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
            'document_type' => 'required|size:2',
            'document_number' => 'required|size:11',
            'denomination' => 'required|max:200',
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $billing_data = BillingData::find($request->id);
            $billing_data->order_id = $request->order_id;
            $billing_data->document_type = $request->document_type;
            $billing_data->document_number = $request->document_number;
            $billing_data->denomination = $request->denomination;
            $billing_data->update();
            
            return response()->json([
                'status' => 'updated_ok',
                'message' => 'Se ha modificado correctamente',
                'data' => $billing_data
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
