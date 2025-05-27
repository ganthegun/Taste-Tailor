<div class="max-w-3xl mx-auto py-8">
    <h2 class="text-2xl font-bold mb-6 dark:text-white">Edit Order #{{ $order->id }}</h2>

    <form wire:submit.prevent="update" class="space-y-6 bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
        <!-- Order Summary -->
        <div>
            <h3 class="font-semibold mb-2 dark:text-gray-200">Food Boxes</h3>
            <ul class="list-disc list-inside text-gray-700 dark:text-gray-300">
                @foreach($order->foodBoxes as $box)
                <li>
                    {{ $box->name }} &times; {{ $box->pivot->quantity }}
                </li>
                @endforeach
            </ul>
            </div>

            <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Price (MYR) :</label>
                <div class="text-gray-900 dark:text-white">{{ number_format($order->price,2) }}</div>
            </div>
            <div>
                <label class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Meals / Week :</label>
                <div class="text-gray-900 dark:text-white">{{ $order->meals_per_week }}</div>
            </div>
            </div>

            <div>
            <label for="address" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Delivery Address</label>
            <flux:input
                id="address"
                wire:model.defer="address"
                type="text"
                name="address"
                placeholder="Enter new delivery address"
                required
                class="w-full"
            />
            @error('address')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end space-x-4">
            <button
                type="button"
                wire:click="cancel"
                class="px-4 py-2 bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded hover:bg-gray-400"
            >
                Cancel
            </button>
            <button
                type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
            >
                Save Address
            </button>
        </div>
    </form>
    <x-action-message class="me-3 flex justify-end font-medium mt-5" on="success">
        {{ __('Order updated successfully.') }}
    </x-action-message>
</div>
