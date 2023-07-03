<div class="bg-gray-100 p-4 rounded-lg shadow-md m-4 w-1/4">
    <h1 class="text-gray-700 font-semibold text-2xl mb-6 mt-4">Burger: {{$index + 1}}</h1>
    <div class="mb-4">
        <p class="text-lg font-semibold">Meat:</p>
        <p>{{ $burger['meat'] }}</p>
    </div>

    <div class="mb-4">
        <p class="text-lg font-semibold">Bread:</p>
        <p>{{ $burger['bread'] }}</p>
    </div>

    <div class="mb-4">
        <p class="text-lg font-semibold">Sides:</p>
        <ul class="flex justify-center items-center">
            @foreach ($burger['sides'] as $side)
            <li class="px-2">{{ $side }}</li>
            @endforeach
        </ul>
    </div>
</div>
