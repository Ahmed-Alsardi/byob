<x-auth-app-layout>
    <div class="flex justify-center items-center w-2/5 mx-auto mt-20">
        <form class="w-full" method="POST" action="{{ route('customization.store') }}">
            @csrf

            <div class="mb-4">
                <label for="category" class="block text-gray-700 font-semibold mb-2">Category</label>
                <select name="category" id="category" class="form-select w-full" required>
                    <option value="">Select a category</option>
                    <option value="meat">Meat</option>
                    <option value="bread">Bread</option>
                    <option value="side">Side</option>
                </select>
                @error('category')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-semibold mb-2">Name</label>
                <input type="text" name="name" id="name" class="form-input w-full" value="{{old('name')}}" required>
                @error('name')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                    Create Customization
                </button>
            </div>
        </form>
    </div>
</x-auth-app-layout>
