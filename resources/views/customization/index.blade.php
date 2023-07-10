<x-auth-app-layout>
    <div class="flex justify-center items-center flex-col mt-20">
        <h1 class="text-gray-700 text-2xl text-center my-4">Burger Customizations</h1>
        <ul class="space-y-4">
            @foreach ($customizations as $customization)
                <li>
                    <a href="{{route('customization.show', $customization)}}" class="text-lg underline text-blue-600 font-semibold">
                        {{ $customization->category }}: {{ $customization->name }}
                    </a>
                </li>
            @endforeach
        </ul>

        <a href="{{route('customization.create')}}" class="mt-8 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Create new Customization</a>
    </div>
</x-auth-app-layout>
