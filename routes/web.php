<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Menu;
use App\Livewire\FoodBox;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    // Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::get('menu/create', Menu\Create::class)->name('menu.create');
    Route::get('menu/view', Menu\View::class)->name('menu.view');
    Route::get('menu/edit/{id}', Menu\Edit::class)->name('menu.edit');

    Route::get('food-box/create', FoodBox\Create::class)->name('food-box.create');
    Route::get('food-box/view', FoodBox\View::class)->name('food-box.view');
    Route::get('food-box/edit/{id}', FoodBox\Edit::class)->name('food-box.edit');
});

require __DIR__.'/auth.php';
