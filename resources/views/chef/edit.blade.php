<x-auth-app-layout>

    <div class="w-1/4 mx-auto mt-20 ">
        <h1 class="text-3xl font-bold text-center">Edit Chef: {{$chef->name}}</h1>
        <form class="flex flex-col justify-center items-center" method="POST" action="{{ route('chef.update', $chef) }}">
            @csrf
            @method('PUT')
            <!-- Name -->
            <div class="w-full">
                <x-auth.input-label for="name" :value="__('Name')"/>
                <x-auth.text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$chef->name"
                                   required autofocus autocomplete="name"/>
                <x-auth.input-error :messages="$errors->get('name')" class="mt-2"/>
            </div>

            <!-- Email Address -->
            <div class="mt-4 w-full">
                <x-auth.input-label for="email" :value="__('Email')"/>
                <x-auth.text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="$chef->email"
                                   required autocomplete="username"/>
                <x-auth.input-error :messages="$errors->get('email')" class="mt-2"/>
            </div>


            <div class="flex items-center justify-end mt-8">
                <x-auth.primary-button class="ml-4">
                    {{ __('Update') }}
                </x-auth.primary-button>
            </div>
        </form>
    </div>
</x-auth-app-layout>
