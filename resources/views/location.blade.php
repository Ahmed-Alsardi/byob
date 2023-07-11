<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-4xl font-bold mb-4">Get User Location</h1>
        <form method="POST" action="{{ route('location.store') }}" class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
            @csrf
            <div class="mb-4">
                <label for="city" class="block text-gray-700 font-bold mb-2">City:</label>
                <input type="text" id="city" name="city" class="w-full p-2 border border-gray-300 rounded-md" value="{{$location['city']}}" required>
            </div>

            <div class="mb-4">
                <label for="street" class="block text-gray-700 font-bold mb-2">Street:</label>
                <input type="text" id="street" name="street" class="w-full p-2 border border-gray-300 rounded-md" value="{{ $location['street']}}" required>
            </div>

            <div class="mb-4">
                <label for="house_number" class="block text-gray-700 font-bold mb-2">House Number:</label>
                <input type="number" id="house_number" name="house_number" class="w-full p-2 border border-gray-300 rounded-md" value="{{ $location['house_number']}}" required>
            </div>

            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">Submit</button>
        </form>
    </div>
</x-app-layout>
