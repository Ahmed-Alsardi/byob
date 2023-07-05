<x-auth-app-layout>

    <div class="flex flex-col justify-center items-center px-8 py-4 rounded bg-white shadow-2xl mt-8 w-2/5 mx-auto">
        <p class="text-gray-700">Complaint for order: <a class="bg-gray-500 text-white px-4 py-1 rounded"
                                                         href="{{route('order.show', $complaint->order)}}">{{$complaint->order_id}}</a>
        </p>
        <div class="my-4">
            <div class="text-gray-700">Message: {{ $complaint->customer_message }}</div>
            <p>Status: {{$complaint->is_resolve ? 'Resolved' : 'Pending'}}</p>
        </div>
    </div>
</x-auth-app-layout>
