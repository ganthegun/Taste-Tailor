<div>
    <div class="max-w-4xl mx-auto mt-10">
        <div class="bg-white dark:bg-zinc-800 shadow-md rounded-lg p-6">
            <h1 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">{{ __('Create Menu') }}</h1>
            
            <form wire:submit="submit" class="space-y-6">
                @csrf

                <!-- Name -->
                <flux:input wire:model="name" :label="__('Name')" type="text" name="name" required class="w-full"/>

                <!-- Description -->
                <flux:textarea wire:model="description" :label="__('Description')" name="description" rows="4" required class="w-full"></flux:textarea>

                <!-- Price -->
                <flux:input wire:model="price" :label="__('Price')" type="number" name="price" step="0.1" required class="w-full"/>

                <!-- Nutrient -->
                <div class="mt-1 pb-1">
                    <flux:dropdown id="nutrient">
                        <flux:button icon:trailing="chevron-down">{{ $nutrient ? $nutrient : __('Nutrient Category') }}</flux:button>
                        <flux:menu>
                            <flux:menu.radio.group wire:model.live="nutrient">
                                <flux:menu.radio value="Carbohydrates">Carbohydrates</flux:menu.radio>
                                <flux:menu.radio value="Proteins">Proteins</flux:menu.radio>
                                <flux:menu.radio value="Fats">Fats</flux:menu.radio>
                                <flux:menu.radio value="Vitamins">Vitamins</flux:menu.radio>
                                <flux:menu.radio value="Minerals">Minerals</flux:menu.radio>
                                <flux:menu.radio value="Dietary Fiber">Dietary Fiber</flux:menu.radio>
                            </flux:menu.radio.group>
                        </flux:menu>
                    </flux:dropdown>
                </div>

                <!-- Image -->
                <div>
                    <flux:input wire:model="image" :label="__('Upload Image')" type="file" name="image" required class="w-full"/>
                    
                    <!-- Image Preview -->
                    @if ($image)
                        <div class="mt-4">
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Image Preview:') }}</p>
                            <img src="{{ $image->temporaryUrl() }}" alt="Image Preview" class="w-32 h-32 object-cover rounded-md">
                        </div>
                    @endif
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary" class="px-6 py-2">
                        {{ __('Create Menu') }}
                    </flux:button>
                </div>
                <x-action-message class="me-3 flex justify-end" on="menu-created">
                    {{ __('Created.') }}
                </x-action-message>
            </form>
        </div>
    </div>
</div>
