<x-auth-app-layout>
    <div class="flex justify-center items-center flex-col mt-20">
        <h1 class="text-gray-700 text-2xl text-center my-4">Burger Customization</h1>
        <ul class="space-y-4">
            <li>
                <p class="text-lg underline text-blue-600 font-semibold">
                    {{ $customization->category }}: {{ $customization->name }}
                </p>
            </li>
        </ul>

        <div class="flex justify-center items-center">
            <a href="{{route('customization.edit', $customization)}}"
               class="mt-8 bg-green-500 hover:bg-green-700 mr-4 text-white font-bold py-2 px-4 rounded">Edit
                Customization</a>
{{--            <form action="{{route('customization.destroy', $customization)}}" method="POST">--}}
{{--                @csrf--}}
{{--                @method('DELETE')--}}
{{--                <button type="submit"--}}
{{--                        class="mt-8 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete--}}
{{--                    Customization--}}
{{--                </button>--}}
{{--            </form>--}}
        </div>
    </div>
</x-auth-app-layout>
