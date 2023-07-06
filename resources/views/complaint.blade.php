<x-auth-app-layout>

    <div class="flex flex-col justify-center items-center px-8 py-4 rounded bg-white shadow-2xl mt-8 w-2/5 mx-auto">
        <p class="text-gray-700">Complaint for order: <a class="bg-gray-500 text-white px-4 py-1 rounded"
                                                         href="{{route('order.show', $complaint->order)}}">{{$complaint->order_id}}</a>
        </p>
        <div class="my-4">
            <div class="text-gray-700">Message: {{ $complaint->customer_message }}</div>
{{--            @dd($complaint)--}}
            <p>Status: {{$complaint->is_resolved() ? 'Resolved' : 'Pending'}}</p>
        </div>
        @if(auth()->user()->role === \App\Helper\UserRole::ADMIN)
            <form action="/complaints/{{$complaint->id}}" method="POST">
                @csrf
                @method('PUT')
                <div class="flex flex-col mt-4">
                    <label class="mt-4" for="refund">Refund</label>
                    <select name="refund" id="refund" class="border border-gray-300 rounded-md p-2">
                        <option value="0" @if(!$complaint->refund) selected @endif>Don't Refund</option>
                        <option value="1" @if($complaint->refund) selected @endif>Refund</option>
                    </select>
                    @error('refund')
                        <p class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="flex flex-col">
                    <label class="mt-4" for="admin_message">Admin Message</label>
                    <textarea name="admin_message" id="admin_message" cols="30" rows="10"
                              class="border border-gray-300 rounded-md p-2">{{old("admin_message")}}</textarea>
                    @error('admin_message')
                        <p class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="flex justify-center mt-4">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
                </div>
            </form>
        @endif
    </div>
</x-auth-app-layout>
