<x-app-layout>
    <!-- views/burger.blade.php -->
    <form class="mt-20 w-4/5 mx-auto flex justify-center items-center flex-col" method="POST" action="/burgers">
        @csrf

        <div id="burger-sections" class="space-y-4 ">
            <!-- Burger input sections will be dynamically added here -->
        </div>
        <div class="mb-8">
            <button id="add-burger-btn" type="button" class="mx-4 bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">Add Burger</button>
            <button type="submit" class="mx-auto bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">Submit</button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addBurgerBtn = document.getElementById('add-burger-btn');
            const burgerSectionsContainer = document.getElementById('burger-sections');
            let burgerCounter = 0;

            addBurgerBtn.addEventListener('click', function() {
                const burgerSection = document.createElement('div');
                burgerSection.innerHTML = `
                <div class="flex justify-center items-center w-80">
                    <h2 class="font-bold text-center w-1/2">Burger ${burgerCounter + 1}</h2>
                    <div class="flex flex-col justify-center items-center w-1/2 text-center">
                        <div>
                            <label for="bread${burgerCounter}" class="font-bold">Bread:</label>
                            <select id="bread${burgerCounter}" name="burgers[${burgerCounter}][bread]" class="block mt-1 mb-4 w-full p-2 border-gray-300 border rounded-md">
                            @foreach($breads as $bread)
                                <option value="{{$bread->name}}">{{$bread->name}}</option>
                            @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="meat${burgerCounter}" class="font-bold">Meat:</label>
                            <select id="meat${burgerCounter}" name="burgers[${burgerCounter}][meat]" class="block mt-1 mb-4 w-full p-2 border-gray-300 border rounded-md">
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
                                        <input type="checkbox" name="burgers[${burgerCounter}][sides][]" value="{{$side->name}}" class="mr-2">
                                            {{ $side->name }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                </div>
            </div>
            <div class="border-t border-gray-300 my-4"></div>
            `;
                burgerSectionsContainer.appendChild(burgerSection);

                burgerCounter++;
            });
        });
    </script>
</x-app-layout>
