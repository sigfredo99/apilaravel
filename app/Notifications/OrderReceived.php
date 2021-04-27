<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Channels\FCMChannel;
use App\Channels\Messages\FCMMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderReceived extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return [FCMChannel::class];
    }

    public function toFCM($notifiable)
    {
        $serverKey = config('appm21.fcm.serverKey');
        $recipients = array($notifiable->token_notification);
        $order = $this->order;
        $title = 'Tiene un nuevo Pedido';
        $body = 'Hola '.$notifiable->name.', tiene un nuevo Pedido de S/'.$order->total;
        return (new FCMMessage($serverKey))
            ->to($recipients)
            ->priority('high')
            ->timeToLive(0)
            ->data([
                'order_id' => $order->order_id,
            ])
            ->notification([
                'title' => $title,
                'body' => $body,
            ]);
    }
}
