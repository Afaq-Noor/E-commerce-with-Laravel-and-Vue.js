<!DOCTYPE html>
<html>
<head>
    <title>Payment Result</title>
</head>
<body>

@if($status == 'success' || $status == 'already_paid')

<h2 style="color:green;">Payment Successful ✅</h2>

@else

<h2 style="color:red;">Payment Failed ❌</h2>

@endif

<p>Order ID : {{ $order->id }}</p>
<p>Total Price : {{ $order->total_value }}</p>
<p>Order Status : {{ $order->order_status }}</p>
<a href="/Checkout" class="btn" style="background-color: #008CBA; color: white; 
padding: 15px 32px; border: none; border-radius: 25px ; text-decoration: none; 
cursor: pointer;">Go Back</a>
</body>
</html>