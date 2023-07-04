<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Order Receipt</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<h2>Order Receipt</h2>

<p>Dear {{ $customer_name }},</p>

<p>Thank you for your order! Here are the details:</p>

<h3>Burgers:</h3>
<ul>
    @foreach($burgers as $burger)
        <x-burger-card :index="$loop->index" :burger="$burger"/>
    @endforeach
</ul>

<div class="mb-6">
    <p class="text-lg font-semibold">Location:</p>
    <p>City: {{ $order['city'] ?? "...." }}</p>
    <p>Street: {{ $order['street'] ?? "...." }}</p>
    <p>House Number: {{ $order['house_number'] ?? "...." }}</p>
</div>

<p><strong>Total Price:</strong> ${{ $total_price }}</p>

<p>If you have any questions or concerns, please feel free to contact us.</p>

<p>Thank you!</p>
</body>
</html>
