<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\Restaurant;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\Address;
use App\Models\Sale;
use App\Models\Favorite;


class UtilsController extends Controller
{
    public function getCategoryProducts(Request $request)
    {
        $products = Product::with(['category','restaurant'])->where('category_id','=',$request->id)->get();

        return response()->json($products);
    }

    public function getRestaurantCategories(Request $request)
    {
        $products = Category::with('restaurant')->where('restaurant_id','=',$request->id)->get();

        return response()->json($products);
    }

    public function getCustomer(Request $request)
    {
        auth()->shouldUse('api_customers');
        $user = \Auth::user();

        return response()->json($user);

    }

    public function getCustomerAddress(Request $request)
    {
        auth()->shouldUse('api_customers');
        $user = \Auth::user();
        $addresses = Address::with(['ubigeo'])->where('customer_id','=',$user->customer_id)->where('status','=',1)->orderBy('address_id')->get();

        return response()->json($addresses);

    }

    public function search(Request $request)
    {   
        try
        {
        /*Se buscan registros en la base de datos, de las diferentes tablas*/
        $category = Category::query()
        ->where('name', 'ilike', '%' . $request->search_value . '%')->with('restaurant')->get();
        $product = Product::query()
        ->where('name', 'ilike', '%' . $request->search_value . '%')->with(['category','restaurant'])->get();
        $restaurant = Restaurant::query()
        ->where('name', 'ilike', '%' . $request->search_value . '%')->get();
        $promotion = Promotion::query()
        ->where('name', 'ilike', '%' . $request->search_value . '%')->get();
        /*Se retorna los datos obtenidos*/
        return response()->json([
            'categories' => $category,
            'products' => $product,
            'restaurants' => $restaurant,
            'promotions' => $promotion

        ], 200,
        ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
        JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'categories' => [],
                'products' => [],
                'restaurants' => [],
                'promotions' => []
    
            ], 500,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE);
        }
    }

    public function getCustomerFavorites()
    {
        auth()->shouldUse('api_customers');
        $customer_id = \Auth::user()->customer_id;
        
        $list_favorites = array();
        $favorites = Favorite::where('customer_id', '=', $customer_id)->get();
        foreach($favorites as $favorite){
            $product = Product::with(['category','restaurant'])->where('product_id','=',$favorite->product_id)->first();

            array_push($list_favorites,[
                'favorite_id'=>$favorite->favorite_id,
                'product'=>$product
            ]);
        }
        
        return response()->json($list_favorites);
    }

    public function getCustomerNotifications() 
    {
        auth()->shouldUse('api_customers');
        $customer_id = \Auth::user()->customer_id;
        $notifications = \App\Models\Notification::where('customer_id', '=', $customer_id)->get();
        return response()->json($notifications);
    }

    public function deleteCustomerNotifications($id) 
    {
        try
        {
            $notification = \App\Models\Notification::findOrFail($id);
            $notification->delete();
            
            return response()->json([
                'status' => 'delete_ok',
                'message' => 'Se ha eliminado correctamente'
            ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'status' => 'delete_error',
                'message' => 'Algo salió mal. Inténtalo de nuevo más tarde'
            ], 500);
        }
    }

    public function deleteAllCustomerNotifications() 
    {
        try
        {
            auth()->shouldUse('api_customers');
            $customer_id = \Auth::user()->customer_id;
            $notifications = \App\Models\Notification::where('customer_id', $customer_id)->get();
            foreach($notifications as $notification)
            {
                $notification->delete();
            }
            
            return response()->json([
                'status' => 'delete_ok',
                'message' => 'Se han eliminado correctamente'
            ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'status' => 'delete_error',
                'message' => 'Algo salió mal. Inténtalo de nuevo más tarde'
            ], 500);
        }
    }
}
