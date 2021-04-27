<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Ubigeo;

class UbigeoController extends Controller
{
    public function index()
    {
        $ubigeos = Ubigeo::all();
        return response()->json($ubigeos);
    }

    public function show($id)
    {
        $ubigeo = Ubigeo::find($id);
        return response()->json($ubigeo);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ubigeo_code' => 'required|size:6|unique:ubigeo,ubigeo_code',
            'departament' => 'required|max:100',
            'province' => 'required|max:100',
            'district' => 'required|max:100'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $ubigeo = new Ubigeo;
            $ubigeo->ubigeo_code = $request->ubigeo_code;
            $ubigeo->departament = $request->departament;
            $ubigeo->province = $request->province;
            $ubigeo->district = $request->district;
            $ubigeo->save();
            
            return response()->json([
                'status' => 'register_ok',
                'message' => 'Se ha creado correctamente',
                'data' => $ubigeo
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
            'departament' => 'required|max:100',
            'province' => 'required|max:100',
            'district' => 'required|max:100'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $ubigeo = Ubigeo::find($request->id);
            $ubigeo->departament = $request->departament;
            $ubigeo->province = $request->province;
            $ubigeo->district = $request->district;
            $ubigeo->update();
            
            return response()->json([
                'status' => 'updated_ok',
                'message' => 'Se ha modificado correctamente',
                'data' => $ubigeo
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
