<?php

namespace App\Listeners;

use App\Events\OrderReceived;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

class OrderReceivedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrderReceived  $event
     * @return void
     */
    public function handle(OrderReceived $event)
    {
        try
        {
            //$order = \App\Models\Order::find($event->order_id);
            $context = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => false
                    ]
                ];
            $client = new Client(new Version2X('https://ws-m21.herokuapp.com', [
                'context' => $context
            ]));
            $client->initialize();
            $client->emit('orders', array('order_id' => $event->order_id));
            $client->close();
        }
        catch(Exception $e) {
            return $e;
        }
    }
}
