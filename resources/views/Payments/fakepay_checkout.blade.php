<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h2>FakePay Gateway Sandbox</h2>

    <p>Order ID: {{ $order->id }}</p>
    <p>Amount: {{ $order->amount }}</p>

    <form method="POST" action="/fakepay/process">
        @csrf
        <input type="hidden" name="order_id" value="{{ $order->id }}">

        <button type="submit">Confirm Payment</button>
    </form>

    <a href="/payment/cancel">Cancel Payment</a>
</body>

</html>
