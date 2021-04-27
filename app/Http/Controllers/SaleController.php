<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Sale;

class SaleController extends Controller
{
    public function index()
    {
        //get customer id
        auth()->shouldUse('api_customers');
        $customer_id = \Auth::user()->customer_id;
        $path = url('/').'/admin/invoices/';
        $sales = Sale::with('invoicingFile')->where('customer_id', $customer_id)->where('billing_file', 1)->orderBy('sale_id', 'DESC')->get();
        $sale_array = array();
        foreach ($sales as $sale)
        {
            $sale->invoicingFile->xml_file = $path.$sale->invoicingFile->xml_file;
            $sale->invoicingFile->cdr_file = $path.$sale->invoicingFile->cdr_file;
            $sale->invoicingFile->pdf_file = $path.$sale->invoicingFile->pdf_file;
            array_push($sale_array, $sale);
        }
        return response()->json($sale_array);
    }

    public function show($id)
    {
        $sale = Sale::with(['customer','order'])->find($id);
        return response()->json($sale);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'order_id' => 'required',
            'sale_date' => 'required',
            'sale_hour' => 'required',
            'invoice_type' => 'required',
            'invoice_serie' => 'required',
            'invoice_number' => 'required',
            'address' => 'required',
            'subtotal' => 'required',
            'igv' => 'required',
            'total' => 'required',
            'document_type' => 'required',
            'document_number' => 'required',
            'denomination' => 'required',
            'billing_file' => 'required',
            'status' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $sale = new Sale;
            $sale->customer_id = $request->customer_id;
            $sale->order_id = $request->order_id;
            $sale->sale_date = $request->sale_date;
            $sale->sale_hour = $request->sale_hour;
            $sale->invoice_type = $request->invoice_type;
            $sale->invoice_serie = $request->invoice_serie;
            $sale->invoice_number = $request->invoice_number;
            $sale->address = $request->address;
            $sale->subtotal = $request->subtotal;
            $sale->igv = $request->igv;
            $sale->total = $request->total;
            $sale->document_type = $request->document_type;
            $sale->document_number = $request->document_number;
            $sale->denomination = $request->denomination;
            $sale->billing_file = $request->billing_file;
            $sale->status = $request->status;
            $sale->save();
            
            return response()->json([
                'status' => 'register_ok',
                'message' => 'Se ha creado correctamente',
                'data' => $sale
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
            'customer_id' => 'required',
            'order_id' => 'required',
            'sale_date' => 'required',
            'sale_hour' => 'required',
            'invoice_type' => 'required',
            'invoice_serie' => 'required',
            'invoice_number' => 'required',
            'address' => 'required',
            'subtotal' => 'required',
            'igv' => 'required',
            'total' => 'required',
            'document_type' => 'required',
            'document_number' => 'required',
            'denomination' => 'required',
            'billing_file' => 'required',
            'status' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $sale = Sale::find($request->id);
            $sale->customer_id = $request->customer_id;
            $sale->order_id = $request->order_id;
            $sale->sale_date = $request->sale_date;
            $sale->sale_hour = $request->sale_hour;
            $sale->invoice_type = $request->invoice_type;
            $sale->invoice_serie = $request->invoice_serie;
            $sale->invoice_number = $request->invoice_number;
            $sale->address = $request->address;
            $sale->subtotal = $request->subtotal;
            $sale->igv = $request->igv;
            $sale->total = $request->total;
            $sale->document_type = $request->document_type;
            $sale->document_number = $request->document_number;
            $sale->denomination = $request->denomination;
            $sale->billing_file = $request->billing_file;
            $sale->status = $request->status;
            $sale->update();
            
            return response()->json([
                'status' => 'updated_ok',
                'message' => 'Se ha modificado correctamente',
                'data' => $sale
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
