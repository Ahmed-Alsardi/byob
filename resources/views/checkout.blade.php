<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-4xl font-bold mb-4">Checkout</h1>

        <div class="bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4">Order Summary</h2>

            <div class="w-full mx-auto mb-6 flex justify-center items-center flex-wrap">
                @foreach($burgers as $burger)
                    <x-burger-card :index="$loop->index" :burger="$burger"/>
                @endforeach
            </div>

            <div class="mb-6">
                <p class="text-lg font-semibold">Location:</p>
                <p>City: {{ $location['city'] }}</p>
                <p>Street: {{ $location['street'] }}</p>
                <p>House Number: {{ $location['house_number'] }}</p>
            </div>

            <form method="POST" action="{{route('checkout.store')}}">
                @csrf
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">Pay Now</button>
            </form>
        </div>
    </div>
</x-app-layout>
