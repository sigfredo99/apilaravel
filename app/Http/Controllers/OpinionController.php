<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Opinion;

class OpinionController extends Controller
{
    public function index(Request $request)
    {
        $list_opinions= array();
        
        $opinions = Opinion::with(['customer'])->where('product_id','=',$request->id)->get();
       
foreach ($opinions as $opinion) {
    $opinion_date = strtotime($opinion->opinion_date);
     
    $date_array = explode("-",$opinion->opinion_date);
    $date_string = $date_array[0]."-".$date_array[2]."-".$date_array[1];
$newDate = date($date_string, $opinion_date); 
$now = strtotime(date("Y-m-d")); // or your date as well
$your_date = strtotime($newDate);
$datediff = $now - $your_date;

$days_between = round($datediff / (60 * 60 * 24));
   array_push($list_opinions, [
    'opinion_id'=>$opinion->opinion_id, 
     'score'=>$opinion->score, 
      'comment'=>$opinion->comment, 
      'opinion_date'=> $days_between,
    'customer'=>$opinion->customer, 
]);
  
 }
 $array = collect($list_opinions)->sortByDesc('opinion_id')->values()->all();


 return response()->json($array);

    }

    public function show($id)
    {
        $opinion = Opinion::with(['product','customer'])->find($id);
        return response()->json($opinion);
    }

    public function store(Request $request)
    {
        auth()->shouldUse('api_customers');
        $customer_id = \Auth::user()->customer_id;

        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'score' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $opinion = new Opinion;
            $opinion->customer_id = $customer_id;
            $opinion->product_id = $request->product_id;
            $opinion->score = $request->score;
            $opinion->comment = $request->comment;
            $opinion->opinion_date = date("d-m-Y H:i");  
            $opinion->save();
            
            return response()->json([
                'status' => 'register_ok',
                'message' => 'Se ha creado correctamente',
                'data' => $opinion
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
            'customer_id' => 'required',
            'product_id' => 'required',
            'score' => 'required',
            'opinion_date' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        try
        {
            $opinion = Opinion::find($request->id);
            $opinion->customer_id = $request->customer_id;
            $opinion->product_id = $request->product_id;
            $opinion->score = $request->score;
            $opinion->comment = $request->comment;
            $opinion->opinion_date = $request->opinion_date;
            $opinion->update();
            
            return response()->json([
                'status' => 'updated_ok',
                'message' => 'Se ha modificado correctamente',
                'data' => $opinion
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
