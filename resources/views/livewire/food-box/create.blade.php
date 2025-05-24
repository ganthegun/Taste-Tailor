<div>
    <div class="text-2xl font-medium text-gray-900 dark:text-white">
        {{ __('Create Your Food Box!') }}
    </div>
    <div class="grid md:grid-cols-2 lg:grid-cols-2 gap-6">
        {{-- show all menu --}}
        <div>
            <div class="text-sm text-gray-400 dark:text-white mt-4">
                Click to add menu items to your food box.
            </div>
            <div class="grid md:grid-cols-3 lg:grid-cols-3 gap-6 p-6">
                @foreach ($menus as $menu)
                    <div
                        @if (collect($selectedMenus)->contains('id', $menu->id))
                            class="bg-white dark:bg-zinc-800 shadow-md rounded-lg overflow-hidden hover:shadow-lg cursor-pointer clickable border-4 border-grey-500"
                            wire:click="removeMenu({{ $menu->id }})"
                        @else
                            class="bg-white dark:bg-zinc-800 shadow-md rounded-lg overflow-hidden hover:shadow-lg cursor-pointer clickable"
                            wire:click="addMenu({{ $menu->id }})"
                        @endif
                    >
                        <img 
                            src="{{ Storage::url($menu->image) }}" 
                            alt="{{ $menu->name }}" 
                            class="w-full h-25 object-cover"
                        />
                        <div class="p-4">
                            <div class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $menu->name }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ $menu->description }}</div>
                            <div class="text-sm text-gray-800 dark:text-gray-300 mt-2">
                                <strong>Price:</strong> RM {{ number_format($menu->price, 2) }}
                            </div>
                            <div class="text-sm text-gray-800 dark:text-gray-300 mt-2">
                                <strong>{{ __('Nutrient:') }}</strong> {{ $menu->nutrient }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        {{-- input form --}}
        <form wire:submit="create" class="space-y-6">
            <flux:input wire:model="name" :label="__('Name')" type="text" required />
            <flux:textarea wire:model="description" :label="__('Description')" rows="3" required />
            <flux:input :label="__('Selected Menu')" type="text" value="{{ implode(', ', array_column($selectedMenus, 'name')) ?? '' }}" required readonly/>
            <flux:label class="mb-1 block">{{ __('Dietary Preference') }}</flux:label>
                <div class="mt-1 pb-1">
                    <flux:dropdown>
                        <flux:button icon:trailing="chevron-down">{{ $dietary_preference ?? __('Dietary Preference') }}</flux:button>
                        <flux:menu>
                            <flux:menu.radio.group wire:model.live="dietary_preference">
                                <flux:menu.radio value="Omnivore">Omnivore</flux:menu.radio>
                                <flux:menu.radio value="Flexitarian">Flexitarian</flux:menu.radio>
                                <flux:menu.radio value="Pescatarian">Pescatarian</flux:menu.radio>
                                <flux:menu.radio value="Pollotarian">Pollotarian</flux:menu.radio>
                                <flux:menu.radio value="Vegetarian">Vegetarian</flux:menu.radio>
                                <flux:menu.radio value="Vegan">Vegan</flux:menu.radio>
                                <flux:menu.radio value="Raw Vegan">Raw Vegan</flux:menu.radio>
                                <flux:menu.radio value="Macrobiotic">Macrobiotic</flux:menu.radio>
                                <flux:menu.radio value="Paleolithic">Paleolithic</flux:menu.radio>
                                <flux:menu.radio value="Ketogenic">Ketogenic</flux:menu.radio>
                                <flux:menu.radio value="Carnivore">Carnivore</flux:menu.radio>
                                <flux:menu.radio value="Mediterranean">Mediterranean</flux:menu.radio>
                            </flux:menu.radio.group>
                        </flux:menu>
                    </flux:dropdown>
                </div>
            <flux:input :label="__('Total Price')" type="number" value="{{ number_format($total_price, 2) }}" readonly  />
            <div class="flex justify-end">
                <flux:button type="submit" variant="primary" class="px-6 py-2">
                    {{ __('Create Food Box') }}
                </flux:button>
            </div>
            <x-action-message class="me-3 flex justify-end" on="food-box-created">
                {{ __('Created.') }}
            </x-action-message>
        </form>
    </div>
</div>
