<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your profile details')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">

            <div class="mb-6 border-t border-zinc-200 pt-6 dark:border-zinc-700">
                <flux:label class="mb-4 block text-lg font-medium">{{ __('Profile Picture') }}</flux:label>

                <div class="flex items-center gap-6">
                    <div class="flex-shrink-0 pt-2">
                        <flux:avatar size="xl" 
                        class="flex items-center justify-center overflow-hidden text-center"
                        src="{{ $originalProfilePicture ? Storage::url($originalProfilePicture) : Storage::url('profile_pictures/default-profile.png') }}" 
                        alt="{{ auth()->user()->name ?? 'Profile picture' }}" />
                    </div>

                    <flux:input wire:model="uploadedProfilePicture" :label="__('Choose New Picture')" accept="image/*" class="max-w-xs" type="file" />
                </div>
            </div>

            <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />

            <div>
                <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                    <div>
                        <flux:text class="mt-4">
                            {{ __('Your email address is unverified.') }}

                            <flux:link class="text-sm cursor-pointer"
                                wire:click.prevent="resendVerificationNotification">
                                {{ __('Click here to re-send the verification email.') }}
                            </flux:link>
                        </flux:text>

                        @if (session('status') === 'verification-link-sent')
                            <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </flux:text>
                        @endif
                    </div>
                @endif
            </div>

            <flux:input wire:model="phoneNumber" :label="__('Phone Number')" type="tel" autocomplete="tel"
                required />

            <flux:label for="dietaryPreference" class="mb-1 block">{{ __('Dietary Preference') }}</flux:label>
            <div class="mt-1 pb-1">
                <flux:dropdown id="dietaryPreference">
                    <flux:button icon:trailing="chevron-down">{{ $dietaryPreference }}</flux:button>
                    <flux:menu>
                        <flux:menu.radio.group wire:model.live="dietaryPreference">
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

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>

        <livewire:settings.delete-user-form />
    </x-settings.layout>
</section>
