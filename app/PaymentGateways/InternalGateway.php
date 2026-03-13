<?php

namespace App\PaymentGateways;

use App\Models\Payment;

class InternalGateway extends BaseGateway
{

    public function pay($order)
    {
        Payment::UpdateOrCreate([
            'order_id' => $order->id,
            'gateway' => 'INTERNAL',
            'amount' => $order->total_value,
            'status' => 'pending'
        ] , [
            'order_id' => $order->id,
            'gateway' => 'INTERNAL',
            'amount' => $order->total_value,
            'status' => 'pending'
        ]);

        return route('payment.page', $order->id);

    }

}