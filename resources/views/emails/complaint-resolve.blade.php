<!DOCTYPE html>
<html>
<head>
    <title>Complaint Result</title>
</head>
<body>
<h1>Complaint Result</h1>

<p><strong>Complaint ID:</strong> {{ $complaint->id }}</p>
<p><strong>Customer message:</strong> {{ $complaint->customer_message }}</p>
<p><strong>Status:</strong> {{ $order->status }}</p>
<p><strong>Admin message:</strong> {{ $complaint->admin_message }}</p>
<p><strong>Created At:</strong> {{ $complaint->created_at }}</p>

</body>
</html>
