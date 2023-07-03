<div class="flex justify-center items-center w-80">
    <h2 class="font-bold text-center w-1/2">Burger {{$burgerIndex + 1}}</h2>
    <div class="flex flex-col justify-center items-center w-1/2 text-center">
        <div>
            <label for="bread{{$burgerIndex}}" class="font-bold">Bread:</label>
            <select id="bread{{$burgerIndex}}" name="burgers[{{$burgerIndex}}][bread]" class="block mt-1 mb-4 w-full p-2 border-gray-300 border rounded-md">
                @foreach($breads as $bread)
                    <option value="{{$bread->name}}">{{$bread->name}}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="meat{{$burgerIndex}}" class="font-bold">Meat:</label>
            <select id="meat{{$burgerIndex}}" name="burgers[{{$burgerIndex}}][meat]" class="block mt-1 mb-4 w-full p-2 border-gray-300 border rounded-md">
                @foreach($meats as $meat)
                    <option value="{{$meat->name}}">{{$meat->name}}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="font-bold">Sides:</label>
            <div class="mt-1 mb-4">
                @foreach($sides as $side)
                    <label class="flex items-center">
                        <input type="checkbox" name="burgers[{{$burgerIndex}}][sides][]" value="{{$side->name}}" class="mr-2">
                        {{ $side->name }}
                    </label>
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="border-t border-gray-300 my-4"></div>
