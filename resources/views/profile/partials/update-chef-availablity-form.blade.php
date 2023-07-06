<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            @if(auth()->user()->isAvailable())
                {{ __('Currently Available') }}
            @else
                {{ __('Currently Unavailable until: ' . auth()->user()->unavailable_until) }}
            @endif
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's availability") }}
        </p>
    </header>
    <form action="{{route('chef.available', auth()->user())}}" method="POST">
        @csrf
        @method('PUT')
        <div class="mt-2">
            <label class="block mb-1" for="unavailable_for">Unavailable for (Minutes)</label>
            <input type="number" id="unavailable_for" name="unavailable_for" class="border rounded px-2 py-1">
            @error('unavailable_for')
            <p class="text-red-500 mt-2 text-sm">
                {{$message}}
            </p>
            @enderror
        </div>
        <div class="mt-4">
            <x-auth.primary-button>{{ __('Save') }}</x-auth.primary-button>
        </div>
    </form>
</section>
