<x-auth-app-layout>

    <div class="bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Order Summary</h2>

        <div class="w-full mx-auto mb-6 flex justify-center items-center flex-wrap">
            @foreach($order->burgersView() as $burger)
                <x-burger-card :index="$loop->index" :burger="$burger"/>
            @endforeach
        </div>
        <p class="text-2xl font-bold">Total Price: {{$order["total_price"]}}</p>

        <div class="mb-6">
            <p class="text-lg font-semibold">Location:</p>
            <p>City: {{ $order['city'] ?? "...." }}</p>
            <p>Street: {{ $order['street'] ?? "...." }}</p>
            <p>House Number: {{ $order['house_number'] ?? "...." }}</p>
        </div>
        @if(auth()->id() == $order->chef_id)
            <div class="flex justify-center items-center">
                <form action="{{route('order.complete', $order)}}" method="POST">
                    @csrf
                    <input type="submit" value="Complete"
                           class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                </form>
            </div>
        @endif
    </div>
</x-auth-app-layout>
