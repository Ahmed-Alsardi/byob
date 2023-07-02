<x-app-layout>
    <div class="container mx-auto p-4 mt-20">
        <div class="text-center">
            <h1 class="text-4xl font-bold">Build Your Own Burger</h1>
            <p class="text-xl mt-4">Welcome to our food delivery service!</p>
            <a href="{{ route('burgers.index') }}" class="mt-8 inline-block bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">Order a Burger</a>
        </div>
    </div>
</x-app-layout>
