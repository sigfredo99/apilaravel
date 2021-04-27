<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Models\BillingData;
use App\Notifications\OrderReceived;

class OrderController extends Controller
{    
    public function index()
    {
        auth()->shouldUse('api_customers');
        $customer_id = \Auth::user()->customer_id;
        $orders = Order::with(['customer', 'paymentMethod'])->where('customer_id', $customer_id)->orderBy('order_id', 'desc')->get();
        return response()->json($orders);
    }

    public function show($id)
    {
        auth()->shouldUse('api_customers');
        $customer_id = \Auth::user()->customer_id;
        $order = Order::with(['customer', 'paymentMethod'])->where('customer_id', $customer_id)->find($id);
        return response()->json($order);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment_method_id' => 'required',
            'cell_phone' => 'required',
            'address' => 'required',
            'total' => 'required',
            'items' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        $billing_status = 0;

        try
        {
            //get customer id
            auth()->shouldUse('api_customers');
            $customer_id = \Auth::user()->customer_id;

            if($request->has('billing_status')) $billing_status = $request->billing_status;

            // new order
            $order = new Order;
            $order->customer_id = $customer_id;
            $order->payment_method_id = $request->payment_method_id;
            $order->order_date = date('Y-m-d');
            $order->order_hour = date('H:i:s');
            $order->cell_phone = $request->cell_phone;
            $order->address = $request->address;
            $order->reference = $request->reference;
            $order->subtotal = round(($request->total / 1.18), 2);
            $order->igv = round(($order->subtotal * 0.18), 2);
            $order->total = $request->total;
            $order->current_status = 1; // nuevo
            $order->payment_status = 0;
            $order->billing_status = $billing_status;
            $order->sale_status = 0;
            $order->command_status = 0;
            if($order->save())
            {
                foreach($request->items as $item)
                {
                    $item = (object) $item;
                    $orderDetail = new OrderDetail;
                    $orderDetail->order_id = $order->order_id;
                    $orderDetail->item_code = $item->item_code;
                    $orderDetail->item_description = $item->item_description;
                    $orderDetail->quantity = $item->quantity;
                    $orderDetail->unit_price = $item->unit_price;
                    $orderDetail->amount = $orderDetail->quantity * $orderDetail->unit_price;
                    $orderDetail->observation = $item->observation;
                    $orderDetail->item_type = $item->item_type;
                    $orderDetail->save();
                }

                $orderStatus = new OrderStatus;
                $orderStatus->order_id = $order->order_id;
                $orderStatus->status = 1; // 1 Nuevo | 2 Aceptado | 3 En Preparación | 4 Empaquetado y Enviado | 5 Completado
                $orderStatus->order_date = date('Y-m-d');
                $orderStatus->order_hour = date('H:i:s');
                $orderStatus->reason = 'Tu Pedido ha sido recibido';
                $orderStatus->save();

                // save if billing data
                if($billing_status){
                    $billingData = new BillingData;
                    $billingData->order_id = $order->order_id;
                    $billingData->invoice_type = $request->invoice_type; // 03 Boleta de Venta | 01 Factura
                    $billingData->document_type = $request->document_type; // 06 RUC | 01 DNI
                    $billingData->document_number = $request->document_number;
                    $billingData->denomination = $request->denomination;
                    $billingData->save();
                }

                /* notification */
                $this->sendNotification($order);

                //websocket
                event(new \App\Events\OrderReceived($order->order_id));
            }
            
            return response()->json([
                'status' => 'register_ok',
                'message' => 'Se ha creado correctamente',
                'data' => $order
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

    //send notification
    private function sendNotification($order)
    {
        $users = \App\User::where('user_type', 2)->get();
        foreach($users as $user)
        {
            $user->notify(new OrderReceived($order));
        }
    }
}
