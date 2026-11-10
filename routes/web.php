<?php

use Illuminate\Support\Facades\Route;

// Catch-all route for Vue 3 SPA, excluding Filament admin and Livewire routes
Route::get('/{any?}', function () {
    return view('welcome');
})->where('any', '^(?!admin|livewire).*$');

