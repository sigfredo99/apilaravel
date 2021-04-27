<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return response()->json($customers);
    }

    public function show($id)
    {
        $customer = Customer::with('addresses')->find($id);
        return response()->json($customer);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'last_name' => 'required',
            'cell_phone' => 'required:',
            'email' => 'required',
            'password' => 'required',
            'status' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $customer = new Customer;
            $customer->name = $request->name;
            $customer->last_name = $request->last_name;
            $customer->cell_phone = $request->cell_phone;
            $customer->email = strtolower($request->email);
            $customer->password = bcrypt($request->password);
            $customer->remember_token = $request->remember_token;
            $customer->status = $request->status;
            $customer->save();
            
            return response()->json([
                'status' => 'register_ok',
                'message' => 'Se ha creado correctamente',
                'data' => $customer
            ], 201);
        }
        catch(\Exception $e)
        {
            return $e;
            return response()->json([
                'status' => 'register_error',
                'message' => 'Algo salió mal. Inténtalo de nuevo más tarde'
            ], 500);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'last_name' => 'required',
            'cell_phone' => 'required',
            'email' => 'required',
            'password' => 'required',
            'status' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $customer = Customer::find($request->id);
            $customer->name = $request->name;
            $customer->last_name = $request->last_name;
            $customer->cell_phone = $request->cell_phone;
            $customer->email = $request->email;
            $customer->password = $request->password;
            $customer->remember_token = $request->remember_token;
            $customer->status = $request->status;
            $customer->update();
            
            return response()->json([
                'status' => 'updated_ok',
                'message' => 'Se ha modificado correctamente',
                'data' => $customer
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
