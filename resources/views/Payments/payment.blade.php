<!DOCTYPE html>
<html>

<head>
    <title>Test Payment Gateway</title>
</head>

<body>

    <h2>Test Payment Gateway</h2>

    <p>Order ID: {{ $order->id }}</p>
    <p>Total Amount: {{ $order->total_value }}</p>

    <br>

    <a href="{{ route('payment.success', $order->id) }}">
        <button style="padding:10px;background:green;color:white;">
            Simulate Payment Success
        </button>
    </a>

    <br><br>

    <a href="{{ route('payment.fail', $order->id) }}">
        <button style="padding:10px;background:red;color:white;">
            Simulate Payment Failed
        </button>
    </a>

</body>

</html>
