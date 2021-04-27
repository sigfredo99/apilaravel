<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
------Middleware desde las rutas------
Route::middleware('jwt.customer')->group(function(){  ......... });
------Middleware desde el constructor del controlador--------
public function __construct()
    {
        $this->middleware('nombre del middlware');
    }
*/

//API v1
Route::prefix('v1')->group(function () {
   
    //auth
    Route::prefix('auth')->group(function () {
        //users
        Route::get('users', 'JWTUserController@getAuthenticatedUser')->middleware('jwt.users');
        Route::post('users', 'JWTUserController@authenticate');
        // Route::post('customers/logout', 'JWTUserController@logout');
        Route::post('users/register', 'JWTUserController@register');

        //customers
        Route::get('customers', 'JWTCustomerController@getAuthenticatedUser')->middleware('jwt.customers');
        Route::post('customers', 'JWTCustomerController@authenticate');
        Route::post('customers/logout', 'JWTCustomerController@logout')->middleware('jwt.customers');
        Route::post('customers/register', 'JWTCustomerController@register');
        Route::post('customers/change-password', 'JWTCustomerController@changePassword')->middleware('jwt.customers');
        Route::post('customers/fcm-token', 'JWTCustomerController@fcmToken')->middleware('jwt.customers');
    });

    //restaurants
    Route::prefix('restaurants')->group(function () {
        Route::get('/', 'RestaurantController@index');
        Route::get('{id}', 'RestaurantController@show');
        Route::post('/', 'RestaurantController@store');
        Route::put('{id}', 'RestaurantController@update');
        Route::patch('{id}', 'RestaurantController@update');
        Route::delete('{id}', 'RestaurantController@destroy');
    });

    //categories
    Route::prefix('categories')->group(function () {
        Route::get('/', 'CategoryController@index');
        Route::get('{id}', 'CategoryController@show');
        Route::post('/', 'CategoryController@store');
        Route::put('{id}', 'CategoryController@update');
        Route::patch('{id}', 'CategoryController@update');
        Route::delete('{id}', 'CategoryController@destroy');
    });

    //products
    Route::prefix('products')->group(function () {
        Route::get('/', 'ProductController@index');
        Route::get('{id}', 'ProductController@show');
        Route::post('/', 'ProductController@store');
        Route::put('{id}', 'ProductController@update');
        Route::patch('{id}', 'ProductController@update');
        Route::delete('{id}', 'ProductController@destroy');
    });

    //promotions
    Route::prefix('promotions')->group(function () {
        Route::get('/', 'PromotionController@index');
        Route::get('{id}', 'PromotionController@show');
        Route::post('/', 'PromotionController@store');
        Route::put('{id}', 'PromotionController@update');
        Route::patch('{id}', 'PromotionController@update');
        Route::delete('{id}', 'PromotionController@destroy');
    });


    //ubigeo
    Route::prefix('ubigeo')->group(function () {
        Route::get('/', 'UbigeoController@index');
        Route::get('{id}', 'UbigeoController@show');
        Route::post('/', 'UbigeoController@store');
        Route::put('{id}', 'UbigeoController@update');
        Route::patch('{id}', 'UbigeoController@update');
        Route::delete('{id}', 'UbigeoController@destroy');
    });

    //favorites
    Route::prefix('favorites')->group(function () {
        Route::get('/', 'FavoriteController@index');
        Route::get('{id}', 'FavoriteController@show');
        Route::post('/', 'FavoriteController@store')->middleware('jwt.customers');;
        Route::put('{id}', 'FavoriteController@update');
        Route::patch('{id}', 'FavoriteController@update');
        Route::delete('{id}', 'FavoriteController@remove')->middleware('jwt.customers');;
    });

    //promotion_detail
    Route::prefix('promotion_details')->group(function () {
        Route::get('/', 'PromotionDetailController@index');
        Route::get('{id}', 'PromotionDetailController@show');
        Route::post('/', 'PromotionDetailController@store');
        Route::put('{id}', 'PromotionDetailController@update');
        Route::patch('{id}', 'PromotionDetailController@update');
        Route::delete('{id}', 'PromotionDetailController@destroy');
    });    

    //addresses
    Route::prefix('addresses')->group(function () {
        Route::get('/', 'AddressController@index');
        Route::get('{id}', 'AddressController@show');
        Route::post('/', 'AddressController@store')->middleware('jwt.customers');
        Route::put('{id}', 'AddressController@update')->middleware('jwt.customers');
        Route::patch('{id}', 'AddressController@update');
        Route::delete('{id}', 'AddressController@destroy');
    });

    //opinions
    Route::prefix('opinions')->group(function () {
        Route::get('/', 'OpinionController@index');
        Route::get('{id}', 'OpinionController@show');
        Route::post('/', 'OpinionController@store')->middleware('jwt.customers');
        Route::put('{id}', 'OpinionController@update');
        Route::patch('{id}', 'OpinionController@update');
        Route::delete('{id}', 'OpinionController@destroy');
    });

    //customers
    Route::prefix('customers')->group(function () {
        Route::get('/', 'CustomerController@index');
        Route::get('{id}', 'CustomerController@show');
        Route::post('/', 'CustomerController@store');
        Route::put('{id}', 'CustomerController@update');
        Route::patch('{id}', 'CustomerController@update');
        Route::delete('{id}', 'CustomerController@destroy');
    });

    //invoicing_file
    Route::prefix('invoicing_file')->group(function () {
        Route::get('/', 'InvoicingFileController@index');
        Route::get('{id}', 'InvoicingFileController@show');
        Route::post('/', 'InvoicingFileController@store');
        Route::put('{id}', 'InvoicingFileController@update');
        Route::patch('{id}', 'InvoicingFileController@update');
        Route::delete('{id}', 'InvoicingFileController@destroy');
    });    

    //sales
    Route::prefix('sales')->group(function () {
        Route::get('/', 'SaleController@index')->middleware('jwt.customers'); //use sale info;
        Route::get('{id}', 'SaleController@show');
        Route::post('/', 'SaleController@store');
        Route::put('{id}', 'SaleController@update');
        Route::patch('{id}', 'SaleController@update');
        Route::delete('{id}', 'SaleController@destroy');
    });    

    //sale_details
    Route::prefix('sale_details')->group(function () {
        Route::get('/', 'SaleDetailController@index');
        Route::get('{id}', 'SaleDetailController@show');
        Route::post('/', 'SaleDetailController@store');
        Route::put('{id}', 'SaleDetailController@update');
        Route::patch('{id}', 'SaleDetailController@update');
        Route::delete('{id}', 'SaleDetailController@destroy');
    }); 

    //payment_methods
    Route::prefix('payment_methods')->group(function () {
        Route::get('/', 'PaymentMethodController@index');
        Route::get('{id}', 'PaymentMethodController@show');
        Route::post('/', 'PaymentMethodController@store');
        Route::put('{id}', 'PaymentMethodController@update');
        Route::patch('{id}', 'PaymentMethodController@update');
        Route::delete('{id}', 'PaymentMethodController@destroy');
    });     

    //order_status
    Route::prefix('order_status')->group(function () {
        Route::get('/', 'OrderStatusController@index');
        Route::get('{id}', 'OrderStatusController@show');
        Route::post('/', 'OrderStatusController@store');
        Route::put('{id}', 'OrderStatusController@update');
        Route::patch('{id}', 'OrderStatusController@update');
        Route::delete('{id}', 'OrderStatusController@destroy');
    });     

    //orders
    Route::prefix('orders')->group(function () {
        Route::get('/', 'OrderController@index')->middleware('jwt.customers');
        Route::get('{id}', 'OrderController@show')->middleware('jwt.customers');
        Route::post('/', 'OrderController@store')->middleware('jwt.customers'); //use order store
    });      

    //order_details
    Route::prefix('order_details')->group(function () {
        Route::get('/', 'OrderDetailController@index');
        Route::get('{id}', 'OrderDetailController@show');
        Route::post('/', 'OrderDetailController@store');
        Route::put('{id}', 'OrderDetailController@update');
        Route::patch('{id}', 'OrderDetailController@update');
        Route::delete('{id}', 'OrderDetailController@destroy');
    });  

    //billing_data
    Route::prefix('billing_data')->group(function () {
        Route::get('/', 'BillingDataController@index');
        Route::get('{id}', 'BillingDataController@show');
        Route::post('/', 'BillingDataController@store');
        Route::put('{id}', 'BillingDataController@update');
        Route::patch('{id}', 'BillingDataController@update');
        Route::delete('{id}', 'BillingDataController@destroy');
    });  

    //command
    Route::prefix('command')->group(function () {
        Route::get('/', 'CommandController@index');
        Route::get('{id}', 'CommandController@show');
        Route::post('/', 'CommandController@store');
        Route::put('{id}', 'CommandController@update');
        Route::patch('{id}', 'CommandController@update');
        Route::delete('{id}', 'CommandController@destroy');
    });      

    //command_details
    Route::prefix('command_details')->group(function () {
        Route::get('/', 'CommandDetailController@index');
        Route::get('{id}', 'CommandDetailController@show');
        Route::post('/', 'CommandDetailController@store');
        Route::put('{id}', 'CommandDetailController@update');
        Route::patch('{id}', 'CommandDetailController@update');
        Route::delete('{id}', 'CommandDetailController@destroy');
    });          

    //users
    Route::prefix('users')->group(function () {
        Route::get('/', 'UserController@index');
        Route::get('{id}', 'UserController@show');
        Route::post('/', 'UserController@store');
        Route::put('{id}', 'UserController@update');
        Route::patch('{id}', 'UserController@update');
        Route::delete('{id}', 'UserController@destroy');
    });     

    //user_restaurants
    Route::prefix('user_restaurants')->group(function () {
        Route::get('/', 'UserRestaurantController@index');
        Route::get('{id}', 'UserRestaurantController@show');
        Route::post('/', 'UserRestaurantController@store');
        Route::put('{id}', 'UserRestaurantController@update');
        Route::patch('{id}', 'UserRestaurantController@update');
        Route::delete('{id}', 'UserRestaurantController@destroy');
    });  

    //utils
    Route::prefix('utils')->group(function () {
        Route::get('/', 'UtilsController@search');
        Route::get('categoryProducts', 'UtilsController@getCategoryProducts');
        Route::get('restaurantCategories', 'UtilsController@getRestaurantCategories');
        Route::get('getCustomer', 'UtilsController@getCustomer')->middleware('jwt.customers');
        Route::get('getCustomerAddress', 'UtilsController@getCustomerAddress')->middleware('jwt.customers');
        Route::get('customer-favorites', 'UtilsController@getCustomerFavorites')->middleware('jwt.customers');
        Route::get('customer-notifications', 'UtilsController@getCustomerNotifications')->middleware('jwt.customers');
        Route::delete('customer-notifications/{id}', 'UtilsController@deleteCustomerNotifications')->middleware('jwt.customers');
        Route::delete('customer-notifications-all', 'UtilsController@deleteAllCustomerNotifications')->middleware('jwt.customers');
    });  
});
