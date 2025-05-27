<div>
    <div class="text-2xl font-medium text-gray-900 dark:text-white">
        {{ __('Place your order now!') }}
    </div>
    <form wire:submit="pay" class="grid md:grid-cols-2 lg:grid-cols-2 gap-6">
        {{-- show all menu --}}
        <div>
            <div class="text-sm text-gray-400 dark:text-white mt-4">
               {{ __('Click to add menu items to your food box.') }}
            </div>
            <div class="grid md:grid-cols-3 lg:grid-cols-3 gap-6 p-6">
                @foreach ($food_boxes as $index => $food_box)
                    @php
                    $isSelected = collect($selected_food_boxes)->contains('id', $food_box['id']);
                    @endphp

                    <div class="flex flex-col h-full">
                    {{-- Food Box Card --}}
                    <div
                        class="relative bg-white dark:bg-zinc-800 shadow-md rounded-lg overflow-hidden hover:shadow-lg cursor-pointer flex-grow
                            {{ $isSelected ? 'border-4 border-gray-500' : '' }}"
                        wire:click="{{ $isSelected ? 'removeFoodBox' : 'addFoodBox' }}({{ $food_box['id'] }})"
                    >
                        <div class="p-4 h-full flex flex-col justify-between">
                        <div>
                            <div class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                            {{ $food_box['name'] }}
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                            {{ $food_box['description'] }}
                            </div>
                            <div class="text-sm text-gray-800 dark:text-gray-300 mt-2">
                            {{ __('Dietary Preference: ') . $food_box['dietary_preference'] }}
                            </div>
                            <div class="text-sm text-gray-800 dark:text-gray-300 mt-2">
                            {{ __('Menu: ') . implode(', ', array_column($menus[$index], 'name')) }}
                            </div>
                        </div>
                        <div class="text-sm text-gray-800 dark:text-gray-300 mt-2">
                            {{ __('Price: ') . number_format($food_box['total_price'], 2) }}
                        </div>
                        </div>
                    </div>

                    {{-- Quantity Input placeholder --}}
                    <div class="mt-2 h-14">
                        @if ($isSelected)
                        <flux:input
                            wire:model="quantity.{{ $food_box['id'] }}"
                            wire:change="updatePrice"
                            type="number"
                            min="1"
                            :label="__('Quantity')"
                            required
                        />
                        @endif
                        {{-- when not selected, this empty div still takes up 14 units of height --}}
                    </div>
                    </div>
                @endforeach
            </div>
        </div>
        {{-- input form --}}
        <div class="space-y-6">
            <flux:textarea wire:model="address" :label="__('Address')" rows="3" required />
            <flux:select wire:model="meals_per_week" wire:change="updatePrice" :label="__('Meals per Week')" required>
                @for ($i = 1; $i <= 7; $i++)
                    <option value={{ $i }}>{{ $i }}</option>
                @endfor
            </flux:select>
            <flux:input :label="__('Selected Food Box')" type="text" value="{{ implode(', ', array_column($selected_food_boxes, 'name')) ?? '' }}" required readonly/>
            <flux:input :label="__('Total Price')" type="number" value="{{ number_format($price, 2) }}" readonly />
            <div class="flex justify-end">
                <flux:button type="submit" variant="primary" class="px-6 py-2">
                    {{ __('Proceed to payment.') }}
                </flux:button>
            </div>
            <div class="flex justify-end">
                @if (session('error'))
                    <div class="text-red-500 text-sm">
                        {{ session('error') }}  
                    </div>
                @endif
            </div>
        </div>
    </form>
</div>
