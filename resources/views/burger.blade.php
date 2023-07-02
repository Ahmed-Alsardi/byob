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
                                <option value="white">White</option>
                                <option value="brown">Brown</option>
                            </select>
                        </div>
                        <div>
                            <label for="meat${burgerCounter}" class="font-bold">Meat:</label>
                            <select id="meat${burgerCounter}" name="burgers[${burgerCounter}][meat]" class="block mt-1 mb-4 w-full p-2 border-gray-300 border rounded-md">
                                <option value="meat">Meat</option>
                                <option value="chicken">Chicken</option>
                            </select>
                        </div>
                        <div>
                            <label class="font-bold">Sides:</label>
                            <div class="mt-1 mb-4">
                                <label class="flex items-center">
                                    <input type="checkbox" name="burgers[${burgerCounter}][sides][]" value="tomato" class="mr-2">
                                    Tomato
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="burgers[${burgerCounter}][sides][]" value="onion" class="mr-2">
                                    Onion
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="burgers[${burgerCounter}][sides][]" value="lettuce" class="mr-2">
                                    Lettuce
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="burgers[${burgerCounter}][sides][]" value="ketchup" class="mr-2">
                                    Ketchup
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="burgers[${burgerCounter}][sides][]" value="garlic" class="mr-2">
                                    Garlic
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="burgers[${burgerCounter}][sides][]" value="mayo" class="mr-2">
                                    Mayo
                                </label>
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
