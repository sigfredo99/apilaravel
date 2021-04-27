<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category','restaurant'])->get();
        return response()->json($products);
    }

    public function show($id)
    {
        
        $product = Product::with(['category','restaurant'])->find($id);
        return response()->json($product);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'restaurant_id' => 'required',
            'code' => 'required|size:6|unique:products,code',
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
            $product = new Product;
            $product->category_id = $request->category_id;
            $product->restaurant_id = $request->restaurant_id;
            $product->code = $request->code;
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->image = $request->image;
            $product->status = $request->status;
            $product->save();
            
            return response()->json([
                'status' => 'register_ok',
                'message' => 'Se ha creado correctamente',
                'data' => $product
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
            'restaurant_id' => 'required',
            'code' => 'required|size:6|unique:products,code',
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
            $product = Product::find($request->id);
            $product->category_id = $request->category_id;
            $product->code = $request->code;
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->image = $request->image;
            $product->status = $request->status;
            $product->update();
            
            return response()->json([
                'status' => 'updated_ok',
                'message' => 'Se ha modificado correctamente',
                'data' => $product
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
