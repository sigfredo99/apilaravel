<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Address;


class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::with(['customer','ubigeo'])->get();
        return response()->json($addresses);
    }

    public function show($id)
    {
        $address = Address::with(['customer','ubigeo'])->find($id);
        return response()->json($address);
    }

    public function store(Request $request)
    {
        auth()->shouldUse('api_customers');
        $user = \Auth::user();
        $validator = Validator::make($request->all(), [
            'ubigeo_id' => 'required',
            'address_type' => 'required|max:100',
            'address' => 'required|max:200',
            'reference' => 'max:200'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $address = new Address;
            $address->customer_id = $user->customer_id;
            $address->address_type = $request->address_type;
            $address->address = $request->address;
            $address->reference = $request->reference;
            $address->ubigeo_id = $request->ubigeo_id;
            $address->status = 1;
            $address->save();
            
            return response()->json([
                'status' => 'register_ok',
                'message' => 'Se ha creado correctamente',
                'data' => $address
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
        auth()->shouldUse('api_customers');
        $user = \Auth::user();

        $validator = Validator::make($request->all(), [
            'ubigeo_id' => 'required',
            'address_type' => 'required|max:100',
            'address' => 'required|max:200',
            'reference' => 'max:200',
            'status' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $address = Address::find($request->id);
            $address->customer_id = $user->customer_id;
            $address->address_type = $request->address_type;
            $address->address = $request->address;
            $address->reference = $request->reference;
            $address->ubigeo_id = $request->ubigeo_id;
            $address->status = $request->status;
            $address->update();
            
            return response()->json([
                'status' => 'updated_ok',
                'message' => 'Se ha modificado correctamente',
                'data' => $address
            ]);
        }
        catch(\Exception $e)
        {
            return $e;
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
