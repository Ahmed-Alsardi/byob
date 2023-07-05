<x-auth-app-layout>
    <form action="{{ route('order.storeComplaint', $order) }}" method="POST" class="mt-20 max-w-md mx-auto">
        @csrf
        <p class="text-gray-700">Complaint for order: <a class="bg-gray-500 text-white px-4 py-1 rounded" href="{{route('order.show', $order)}}">{{$order->id}}</a></p>
        <div class="mb-4">
            <label for="message" class="block mb-2">Message:</label>
            <textarea name="message" id="message" rows="4" class="@error('message') border-red-500 @enderror w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">{{ old("message") }}</textarea>
            @error('message')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Submit Complaint</button>
    </form>
</x-auth-app-layout>
