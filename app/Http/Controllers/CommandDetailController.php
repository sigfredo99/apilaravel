<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\CommandDetail;

class CommandDetailController extends Controller
{
    public function index()
    {
        $command_details = CommandDetail::all();
        return response()->json($command_details);
    }

    public function show($id)
    {
        $command_detail = CommandDetail::find($id);
        return response()->json($command_detail);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'command_id' => 'required',
            'item_code' => 'required',
            'item_description' => 'required',
            'quantity' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $command_detail = new CommandDetail;
            $command_detail->command_id = $request->command_id;
            $command_detail->item_code = $request->item_code;
            $command_detail->item_description = $request->item_description;
            $command_detail->quantity = $request->quantity;
            $command_detail->save();
            
            return response()->json([
                'status' => 'register_ok',
                'message' => 'Se ha creado correctamente',
                'data' => $command_detail
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
            $command_detail = CommandDetail::find($request->id);
            $command_detail->command_id = $request->command_id;
            $command_detail->item_code = $request->item_code;
            $command_detail->item_description = $request->item_description;
            $command_detail->quantity = $request->quantity;
            $command_detail->update();
            
            return response()->json([
                'status' => 'updated_ok',
                'message' => 'Se ha modificado correctamente',
                'data' => $command_detail
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
