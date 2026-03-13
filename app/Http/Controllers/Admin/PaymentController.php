<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Payment;
use App\Models\UserOrder;
use Illuminate\Http\Request;
use Stripe;

class PaymentController extends Controller
{

    public function paymentPage($order_id)
    {
        $order = UserOrder::findOrFail($order_id);

        return view('Payments.payment', compact('order'));
    }

    public function paymentSuccess($order_id)
    {
        $order = UserOrder::findOrFail($order_id);
        $payment = Payment::where('order_id', $order_id)->first();
        if ($payment->status == 'success') {
            $order->update([
                'payment_status' => 'paid',
                'order_status' => 'processing'
                ]);
            
            return redirect('/payment-result?status=already_paid&order=' . $order_id);
        }
        Payment::where('order_id', $order_id)->update([
            'status' => 'success',
            'transaction_id' => uniqid('TXN_')
        ]);

        $order->update([
            'payment_status' => 'paid',
            'order_status' => 'processing'
        ]);

        Cart::where('user_id', $order->user_id)->delete();
        $payment = Payment::where('order_id', $order_id)->first();

        if ($payment->status == 'success') {
            return redirect('/payment-result?status=already_paid&order=' . $order_id);
        }
        return redirect('/payment-result?status=success&order=' . $order_id);
    }

    public function paymentFail($order_id)
    {
        $order = UserOrder::findOrFail($order_id);

        Payment::where('order_id', $order_id)->update([
            'status' => 'failed'
        ]);

        $order->update([
            'payment_status' => 'failed',
            'order_status' => 'cancelled'
        ]);

        return redirect('/payment-result?status=failed&order=' . $order_id);
    }

    public function paymentResult(Request $request)
    {
        $order_id = $request->order;
        $status = $request->status;

        $order = UserOrder::find($order_id);

        if (!$order) {
            return "Order not found";
        }

        // update order status
        if ($status == 'success' || $status == 'already_paid' ) {
            $order->order_status = 'paid';
        } else {
            $order->order_status = 'failed';
        }

        $order->save();

        return view('Payments.payment-result', [
            'status' => $status,
            'order' => $order
        ]);
    }
}
