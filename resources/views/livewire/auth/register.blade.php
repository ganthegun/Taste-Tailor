<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="register" class="flex flex-col gap-6">
        <!-- Name -->
        <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name"
            :placeholder="__('Full name')" />

        <!-- Email Address -->
        <flux:input wire:model="email" :label="__('Email address')" type="email" required autocomplete="email"
            placeholder="email@example.com" />

        <flux:input wire:model="phone_number" :label="__('Phone Number')" type="tel" required autocomplete="tel"
            :placeholder="__('012-3456789')" />

        <!-- Password -->
        <flux:input wire:model="password" :label="__('Password')" type="password" required autocomplete="new-password"
            :placeholder="__('Password')" />

        <!-- Confirm Password -->
        <flux:input wire:model="password_confirmation" :label="__('Confirm Password')" type="password" required
            autocomplete="new-password" :placeholder="__('Confirm password')" />
        <div class="mb-5">
            <flux:label for="dietary_preference" class="mb-1 block">{{ __('Dietary Preference') }}</flux:label>
            <flux:dropdown id="dietary_preference" class="mt-2 block">
                <flux:button icon:trailing="{{ empty($dietaryPreference) ? 'chevron-down' : null }}" class="w-full justify-between">
                    {{ empty($dietary_preference) ? 'Select dietary preference' : $dietary_preference }}
                </flux:button>
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

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Create account') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        {{ __('Already have an account?') }}
        <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
    </div>
</div>
