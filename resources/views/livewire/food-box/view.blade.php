<div>
    <div class="flex items-center gap-4">
        <x-action-message class="me-3" on="food-box-deleted">
            {{ __('Food box deleted successfully.') }}
        </x-action-message>
    </div>
    <!-- Box Cards -->
    <div class="grid md:grid-cols-3 lg:grid-cols-3 gap-6 p-6">
        @foreach ($food_boxes as $index => $food_box)
            <div class="bg-white dark:bg-zinc-800 shadow-md rounded-lg overflow-hidden flex flex-col h-full">
                <div class="p-6 space-y-3 flex-1 flex flex-col">
                    <div class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{ $food_box['name'] }}</div>
                    <div class="text-md font-medium text-gray-600 dark:text-gray-400">{{ $food_box['description'] }}</div>
                    <div class="text-md font-medium text-gray-600 dark:text-gray-400">{{  __('Dietary Preference : ') . $food_box['dietary_preference'] }}</div>
                    <div class="text-md font-medium text-gray-600 dark:text-gray-400">{{  __('Menu : ') . implode(', ', array_column($menus[$index], 'name')) ?? '' }}</div>
                    <div class="text-md font-bold text-gray-800 dark:text-gray-200">{{ __('Price : ') . number_format($food_box['total_price'], 2) }}</div>
                    
                    <!-- This div will push the buttons to the bottom -->
                    <div class="flex-1"></div>
                    
                    <div class="flex justify-between pt-4">
                        <!-- Edit Button -->
                        <button wire:click="edit({{ $food_box['id'] }})" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            {{ __('Edit') }}
                        </button>
                        <!-- Delete Button -->
                        <button 
                        wire:click="delete({{ $food_box['id'] }})" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 flex items-center justify-center">
                            <flux:icon name="trash" class="w-5 h-5" />
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

