<?php

namespace App\Http\Controllers\Gateway;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\UserOrder;
use Illuminate\Http\Request;

class FakePayController extends Controller
{
    public function checkout($orderId)
    {
        $order = UserOrder::findOrFail($orderId);

        return view('Payments.fakepay_checkout', compact('order'));
    }


    public function process(Request $request)
    {
        $order = UserOrder::findOrFail($request->order_id);

        $transactionId = 'FP' . rand(100000, 999999);

        Payment::create([
            'order_id' => $order->id,
            'gateway' => 'fakepay',
            'transaction_id' => $transactionId,
            'amount' => $order->amount,
            'status' => 'success'
        ]);

        $order->update([
            'payment_status' => 'paid'
        ]);

        return redirect('/payment/success');
    }
}
