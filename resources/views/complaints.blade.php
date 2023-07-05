<x-auth-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-4xl font-bold mb-4">Complaints Page</h1>

        <div class="bg-white p-4 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4">All Complaints</h2>

            @foreach ($complaints as $complaint)
                <div class="flex items-center justify-around mb-4">
                    <a href="{{ route('complaint.show', $complaint['id']) }}"
                       class="text-blue-500 hover:underline">Complaint: {{ $complaint['id'] }}</a>
                    <a href="{{ route('order.show', $complaint['order_id']) }}"
                       class="text-blue-500 hover:underline">Order: {{ $complaint['order_id'] }}</a>
                </div>
            @endforeach
        </div>
    </div>
</x-auth-app-layout>
