<div>
    <div class="flex justify-center items-center w-80">
        <h2 class="font-bold text-center w-1/2">Burger {{$burgerIndex + 1}}</h2>
        <div class="flex flex-col justify-center items-center w-1/2 text-center">
            <div>
                <label for="bread{{$burgerIndex}}" class="font-bold">Bread:</label>
                <select id="bread{{$burgerIndex}}" name="burgers[{{$burgerIndex}}][bread]"
                        class="block mt-1 mb-4 w-full p-2 border-gray-300 border rounded-md">
                    @foreach($breads as $bread)
                        @if($burger['bread'] === $bread)
                            <option value="{{$bread->name}}" selected>{{$bread->name}}</option>
                        @else
                            <option value="{{$bread->name}}">{{$bread->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div>
                <label for="meat{{$burgerIndex}}" class="font-bold">Meat:</label>
                <select id="meat{{$burgerIndex}}" name="burgers[{{$burgerIndex}}][meat]"
                        class="block mt-1 mb-4 w-full p-2 border-gray-300 border rounded-md">
                    @foreach($meats as $meat)
                        @if($burger['meat'] === $meat)
                            <option value="{{$meat->name}}" selected>{{$meat->name}}</option>
                        @else
                            <option value="{{$meat->name}}">{{$meat->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div>
                <label class="font-bold">Sides:</label>
                <div class="mt-1 mb-4">
                    @foreach($sides as $side)
                        @if(isset($burger['sides']) && in_array($side, $burger['sides']))
                            <label class="flex items-center">
                                <input type="checkbox" checked name="burgers[{{$burgerIndex}}][sides][]"
                                       value="{{$side->name}}"
                                       class="mr-2">
                                {{ $side->name }}
                            </label>
                        @else
                            <label class="flex items-center">
                                <input type="checkbox" name="burgers[{{$burgerIndex}}][sides][]" value="{{$side->name}}"
                                       class="mr-2">
                                {{ $side->name }}
                            </label>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <p class="text-white rounded bg-red-500 hover:bg-red-700 px-4 py-2 btn-remove-burger text-center w-1/2 mx-auto">Remove</p>
    <div class="border-t border-gray-300 my-4"></div>
</div>
