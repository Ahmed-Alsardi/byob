@props(['index' => null])

@if ($index === null)
    <h2 class="font-bold mb-2">Burger</h2>
@else
    <h2 class="font-bold mb-2">Burger {{ $index + 1 }}</h2>
@endif

<div>
    <label for="bread{{ $index }}" class="font-bold">Bread:</label>
    <select id="bread{{ $index }}" name="burgers[{{ $index }}][bread]" class="block mt-1 mb-4 w-full p-2 border-gray-300 border rounded-md">
        <option value="white">White</option>
        <option value="brown">Brown</option>
    </select>
</div>

<div>
    <label for="meat{{ $index }}" class="font-bold">Meat:</label>
    <select id="meat{{ $index }}" name="burgers[{{ $index }}][meat]" class="block mt-1 mb-4 w-full p-2 border-gray-300 border rounded-md">
        <option value="meat">Meat</option>
        <option value="chicken">Chicken</option>
    </select>
</div>

<div>
    <label class="font-bold">Sides:</label>
    <div class="mt-1 mb-4">
        <label class="flex items-center">
            <input type="checkbox" name="burgers[{{ $index }}][sides][]" value="tomato" class="mr-2">
            Tomato
        </label>
        <label class="flex items-center">
            <input type="checkbox" name="burgers[{{ $index }}][sides][]" value="onion" class="mr-2">
            Onion
        </label>
        <label class="flex items-center">
            <input type="checkbox" name="burgers[{{ $index }}][sides][]" value="lettuce" class="mr-2">
            Lettuce
        </label>
        <label class="flex items-center">
            <input type="checkbox" name="burgers[{{ $index }}][sides][]" value="ketchup" class="mr-2">
            Ketchup
        </label>
        <label class="flex items-center">
            <input type="checkbox" name="burgers[{{ $index }}][sides][]" value="garlic" class="mr-2">
            Garlic
        </label>
        <label class="flex items-center">
            <input type="checkbox" name="burgers[{{ $index }}][sides][]" value="mayo" class="mr-2">
            Mayo
        </label>
    </div>
</div>
