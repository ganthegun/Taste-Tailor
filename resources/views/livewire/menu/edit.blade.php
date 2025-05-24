<form wire:submit="update({{ $id }})">
    <div class="grid grid-cols-1 gap-6 mb-6">
        <flux:label class="text-xl font-medium">{{ __('Edit Menu') }}</flux:label>
    </div>
    <div class="grid md:grid-cols-2 lg:grid-cols-2 gap-10">
        <div>
            <div class="flex flex-col items-center gap-6">
                <div class="flex-shrink-0 mt-6">
                    <img 
                        class="w-48 h-48 rounded object-cover shadow-lg" 
                        @if ($upload)
                            src="{{ $upload->temporaryUrl() }}"
                        @else
                            src="{{ $image ? Storage::url($image) : Storage::url('default-image.png') }}"
                        @endif
                        alt="{{ $name }}" 
                    />
                </div>

                <flux:input wire:model="upload" :label="__('Choose New Image')" accept="image/*" class="max-w-xs text-xl font-medium" type="file" />
            </div>
        </div>

        <!-- Right Column: Form Inputs -->
        <div class="space-y-6">
            <!-- Name Input -->
            <flux:input wire:model="name" :label="__('Name')" type="text" required />

            <!-- Description Input -->
            <flux:textarea wire:model="description" :label="__('Description')" rows="3" required />

            <!-- Price Input -->
            <flux:input wire:model="price" :label="__('Price')" type="number" step="0.1" required />

            <!-- Nutrient Dropdown -->
            <flux:label for="nutrient" class="mb-1 block">{{ __('Nutrient') }}</flux:label>
            <div class="mt-1 pb-1">
                <flux:dropdown id="nutrient">
                    <flux:button icon:trailing="chevron-down">{{ $nutrient }}</flux:button>
                    <flux:menu>
                        <flux:menu.radio.group wire:model.live="nutrient">
                            <flux:menu.radio value="Carbohydrates">Carbohydrates</flux:menu.radio>
                            <flux:menu.radio value="Proteins">Proteins</flux:menu.radio>
                            <flux:menu.radio value="Fats">Fats</flux:menu.radio>
                            <flux:menu.radio value="Vitamins">Vitamins</flux:menu.radio>
                            <flux:menu.radio value="Minerals">Minerals</flux:menu.radio>
                            <flux:menu.radio value="Dietary Fiber">Dietary Fiber</flux:menu.radio>
                            <flux:menu.radio value="Water">Water</flux:menu.radio>
                        </flux:menu.radio.group>
                    </flux:menu>
                </flux:dropdown>
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Update') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="menu-updated">
                    {{ __('Updated.') }}
                </x-action-message>
            </div>
        </div>
    </div>

    <!-- Save Button -->
</form>