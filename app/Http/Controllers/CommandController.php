<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Command;
use App\Models\CommandDetail;

class CommandController extends Controller
{
    public function index()
    {
        $commands = Command::with('order','restaurant')->get();
        return response()->json($commands);
    }

    public function show($id)
    {
        $command = Command::with('order','restaurant')->find($id);
        return response()->json($command);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required',
            'restaurant_id' => 'required',
            'command_date' => 'required',
            'command_hour' => 'required',
            
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $command = new Command;
            $command->order_id = $request->order_id;
            $command->restaurant_id = $request->restaurant_id;
            $command->command_date = $request->command_date;
            $command->command_hour = $request->command_hour;
              
            foreach($request->detail as $item)
            {
                    /* Command_Detail */
                    $command_detail = new CommandDetail;
                    $command_detail->command_id = $command->command_id;
                    $command_detail->item_code = $item->item_code;
                    $command_detail->item_description = $item->item_description;
                    $command_detail->quantity = $item->quantity;
                    $command_detail->save();
            }
            
            $command->save();     

            return response()->json([
                'status' => 'register_ok',
                'message' => 'Se ha creado correctamente',
                'data' => $command
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
            $command = Command::find($request->id);
            $command->order_id = $request->order_id;
            $command->restaurant_id = $request->restaurant_id;
            $command->command_date = $request->command_date;
            $command->command_hour = $request->command_hour;
            $command->update();
            
            return response()->json([
                'status' => 'updated_ok',
                'message' => 'Se ha modificado correctamente',
                'data' => $command
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
