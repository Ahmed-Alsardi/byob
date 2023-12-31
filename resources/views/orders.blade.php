<x-auth-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-4xl font-bold mb-4">Order Page</h1>

        <div class="bg-white p-4 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4">All Orders</h2>
            <div id="orders-container">
                @foreach ($orders as $order)
                    <div class="flex items-center justify-around mb-4">
                        <a href="{{ route('order.show', $order['id']) }}"
                           class="text-blue-500 hover:underline">{{ $order['id'] }}: {{$order->burgers->count()}}
                            Burgers</a>
                        <span class="text-gray-500">{{ $order['total_price'] }}</span>
                        <span class="text-gray-500">{{ $order['status'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('js/orderPooling.js') }}"></script>
    @endpush
{{--    <script src="{{asset('orderPooling.js')}}"></script>--}}
</x-auth-app-layout>
