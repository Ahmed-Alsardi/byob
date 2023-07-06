<x-auth-app-layout>

    <div class="container mx-auto p-4">
        <h1 class="text-4xl font-bold mb-4">Chefs Page</h1>

        <div class="bg-white p-4 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4">All Chefs</h2>

            @foreach ($chefs as $chef)
                <div class="flex items-center justify-around mb-4">
                    <a href="{{ route('chef.show', $chef) }}"
                       class="text-blue-500 hover:underline">{{ $chef->name }}: {{$chef->isAvailable() ? 'Available' : 'Not available'}} </a>
                </div>
            @endforeach
            <a href="{{route('chef.create')}}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Create new chef</a>
        </div>
    </div>
</x-auth-app-layout>
