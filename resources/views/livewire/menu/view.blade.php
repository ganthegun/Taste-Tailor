<div>
    <div class="flex items-center gap-4">
        <x-action-message class="me-3" on="menu-deleted">
            {{ __('Menu item deleted successfully.') }}
        </x-action-message>
    </div>
    <!-- Menu Cards -->
    <div class="grid md:grid-cols-3 lg:grid-cols-3 gap-6 p-6">
        @foreach ($menus as $menu)
            <div class="bg-white dark:bg-zinc-800 shadow-md rounded-lg overflow-hidden flex flex-col h-full">
                <img 
                    src="{{ Storage::url($menu->image) }}" 
                    alt="{{ $menu->name }}" 
                    class="w-full h-48 object-cover"
                />
                <div class="p-4 flex flex-col flex-1">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $menu->name }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ $menu->description }}</p>
                    <p class="text-sm text-gray-800 dark:text-gray-300 mt-2">
                        <strong>Price:</strong> ${{ number_format($menu->price, 2) }}
                    </p>
                    <p class="text-sm text-gray-800 dark:text-gray-300 mt-2">
                        <strong>Nutrient:</strong> {{ $menu->nutrient }}
                    </p>
                    
                    <!-- This div will push the buttons to the bottom -->
                    <div class="flex-1"></div>
                    
                    <div class="flex justify-between pt-4">
                        <!-- Edit Button -->
                        <button wire:click="edit({{ $menu->id }})" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Edit
                        </button>
                        <!-- Delete Button -->
                        <button 
                        wire:click="delete({{ $menu->id }})" 
                        class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 flex items-center justify-center"
                        >
                            <flux:icon name="trash" class="w-5 h-5" />
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
