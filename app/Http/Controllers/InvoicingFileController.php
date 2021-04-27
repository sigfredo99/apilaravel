<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\InvoicingFile;

class InvoicingFileController extends Controller
{
    public function index()
    {
        $invoicing_files = InvoicingFile::with('sale')->get();
        return response()->json($invoicing_files);
    }

    public function show($id)
    {
        $invoicing_file = InvoicingFile::with('sale')->find($id);
        return response()->json($invoicing_file);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sale_id' => 'required',
            'xml_file' => 'required',
            'cdr_file' => 'required',
            'pdf_file' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $invoicing_file = new InvoicingFile;
            $invoicing_file->sale_id = $request->sale_id;
            $invoicing_file->xml_file = $request->xml_file;
            $invoicing_file->cdr_file = $request->cdr_file;
            $invoicing_file->pdf_file = $request->pdf_file;
            $invoicing_file->save();
            
            return response()->json([
                'status' => 'register_ok',
                'message' => 'Se ha creado correctamente',
                'data' => $invoicing_file
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
            'xml_file' => 'required',
            'cdr_file' => 'required',
            'pdf_file' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $invoicing_file = InvoicingFile::find($request->id);
            $invoicing_file->sale_id = $request->sale_id;
            $invoicing_file->xml_file = $request->xml_file;
            $invoicing_file->cdr_file = $request->cdr_file;
            $invoicing_file->pdf_file = $request->pdf_file;
            $invoicing_file->update();
            
            return response()->json([
                'status' => 'updated_ok',
                'message' => 'Se ha modificado correctamente',
                'data' => $invoicing_file
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
