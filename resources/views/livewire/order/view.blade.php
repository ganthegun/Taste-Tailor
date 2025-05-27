<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-gray-100">Your Subscription</h1>

    @if($orders->isEmpty())
        <p class="text-gray-600 dark:text-gray-400">You have no orders yet.</p>
    @else
        <div class="overflow-x-auto">
            <table class="table-auto w-full border-collapse border border-gray-300 dark:border-gray-700">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200">
                        <th class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-left">#</th>
                        <th class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-left">Food Box</th>
                        <th class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-left">Price (MYR)</th>
                        <th class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-left">Address</th>
                        <th class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-left">Meals Per Week</th>
                        <th class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-left">Created At</th>
                        <th class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-gray-800 dark:text-gray-200">{{ $loop->iteration }}</td>
                            <td class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-gray-800 dark:text-gray-200">
                                @foreach ($order->foodBoxes as $food_box)
                                    <span class="block">{{ $food_box->name }} - {{ $food_box->pivot->quantity }}</span>
                                @endforeach
                            </td>
                            <td class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-gray-800 dark:text-gray-200">{{ number_format($order->price, 2) }}</td>
                            <td class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-gray-800 dark:text-gray-200">
                                {{ $order->address ? $order->address : 'No address provided' }}
                            </td>
                            <td class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-gray-800 dark:text-gray-200">{{ $order->meals_per_week }}</td>    
                            <td class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-gray-800 dark:text-gray-200">{{ $order->created_at->format('d M Y, h:i A') }}</td>
                            <td class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-center">
                                <div class="inline-flex space-x-4">
                                    <button
                                    type="button"
                                    class="text-blue-500 hover:underline"
                                    wire:click="edit({{ $order->id }})"
                                    >
                                    Edit
                                    </button>
                                    <button
                                    type="button"
                                    class="text-red-500 hover:underline"
                                    wire:click="delete({{ $order->id }})"
                                    >
                                    Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    <x-action-message class="me-3 flex justify-end font-medium mt-5" on="success">
        {{ __('Order and subscription deleted successfully.') }}
    </x-action-message>
    <x-action-message class="me-3 flex justify-end font-medium mt-5" on="error">
        {{ __('Order and subscription failed to be deleted.') }}
    </x-action-message>
</div>