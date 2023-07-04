<x-auth-app-layout>

    <div class="bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Order Summary</h2>

        <div class="w-full mx-auto mb-6 flex justify-center items-center flex-wrap">
            @foreach($order->burgersView() as $burger)
                <x-burger-card :index="$loop->index" :burger="$burger"/>
            @endforeach
        </div>

        <div class="mb-6">
            <p class="text-lg font-semibold">Location:</p>
            <p>City: {{ $order['city'] ?? "...." }}</p>
            <p>Street: {{ $order['street'] ?? "...." }}</p>
            <p>House Number: {{ $order['house_number'] ?? "...." }}</p>
        </div>
    </div>
</x-auth-app-layout>
