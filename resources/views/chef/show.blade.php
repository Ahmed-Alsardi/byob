<x-auth-app-layout>
    <div class="flex justify-center items-center mt-20">
        <div>
            <p class="text-xl font-bold">Chef: {{$chef->name}}</p>
            <p class="text-xl font-bold">Email: {{$chef->email}}</p>
            <p class="text-green-500">Available: {{$chef->isAvailable() ? 'Yes' : 'No'}}</p>
            @if($chef->unavailable_until > now())
                <p class="text-red-500">Unavailable until: {{$chef->unavailable_until}}</p>
            @endif
            <p>Number of orders: {{$chef->orders->count()}}</p>
            @if($chef->orders->count() > 0)
                <p>Orders:</p>
                @foreach($chef->orders as $order)
                    <a class="bg-gray-400 text-white px-4 py-1 rounded shadow-2xl" href="{{route('order.show', $order)}}">{{$order->id}}: {{$order->burgers->count()}} Burgers</a>
                @endforeach
            @endif
            <div class="flex mt-8">
                <form class="mr-4" action="{{route('chef.delete', $chef)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="bg-red-500 text-white px-4 py-1 rounded shadow-2xl" type="submit">Delete</button>
                </form>
            <a class="bg-blue-500 text-white px-4 py-1 rounded shadow-2xl" href="{{route('chef.edit', $chef)}}">Edit</a>
            </div>
        </div>
    </div>
</x-auth-app-layout>
