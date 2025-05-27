<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>
            
            <flux:navlist variant="outline">
                @if(auth()->user()->role === 'admin')
                    <flux:navlist.group heading="{{ __('Menu') }}" expandable>
                        <flux:navlist.item icon="utensils" :href="route('menu.view')" :current="request()->routeIs('menu.view')" wire:navigate>{{ __('View Menu') }}</flux:navlist.item>
                        <flux:navlist.item icon="utensils" :href="route('menu.create')" :current="request()->routeIs('menu.create')" wire:navigate>{{ __('Create Menu') }}</flux:navlist.item>
                    </flux:navlist.group>
                @endif
                @if(auth()->user()->role === 'user')
                    <flux:navlist.group heading="{{ __('Food Box') }}" expandable>
                        <flux:navlist.item icon="utensils" :href="route('food-box.view')" :current="request()->routeIs('food-box.view')" wire:navigate>{{ __('Existing Boxes') }}</flux:navlist.item>
                        <flux:navlist.item icon="utensils" :href="route('food-box.create')" :current="request()->routeIs('food-box.create')" wire:navigate>{{ __('Create Your\'s Now') }}</flux:navlist.item>
                    </flux:navlist.group>
                    <flux:navlist.group heading="{{ __('Order') }} & {{ __('Subscription') }}" expandable>
                        <flux:navlist.item icon="utensils" :href="route('order.create')" :current="request()->routeIs('order.create')" wire:navigate>{{ __('Order Now') }}</flux:navlist.item>
                        <flux:navlist.item icon="utensils" :href="route('order.view')" :current="request()->routeIs('order.view')" wire:navigate>{{ __('View Subscription') }}</flux:navlist.item>
                    </flux:navlist.group>
                @endif
            </flux:navlist>

            <flux:spacer />

            <!-- Desktop User Menu -->
            <flux:dropdown position="bottom" align="start">    
                <flux:profile
                    :name="auth()->user()->name"
                    avatar="{{ auth()->user()->profile_picture ? Storage::url(auth()->user()->profile_picture) : null }}"
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 rounded-lg justify-center items-center overflow-hidden">
                                    <flux:avatar 
                                        src="{{ auth()->user()->profile_picture ? Storage::url(auth()->user()->profile_picture) : null }}" 
                                        :initials="auth()->user()->initials()"
                                        class="flex items-center justify-center overflow-hidden text-center w-100 h-100"
                                    />
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
