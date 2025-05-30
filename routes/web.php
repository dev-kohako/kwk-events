<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SubscribeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [EventController::class, 'index']);

Route::middleware(['auth'])->group(function () {
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::controller(EventController::class)->group(function () {
        Route::get('/events', 'index')->name('events');
        Route::get('/events/create', 'create')->name('events.create');
        Route::post('/events', 'store')->name('events.store');
        Route::get('/events/my-events', 'myEvents')->name('events.my-events');
        Route::get('/events/{event}', 'show')->name('events.show');
        Route::get('/events/subscriptions', 'subscriptions')->name('events.subscriptions');
        Route::get('/events/{event}/edit', 'edit')->name('events.edit');
        Route::put('/events/{event}', 'update')->name('events.update');
        Route::delete('/events/{event}', 'destroy')->name('events.destroy');
    });

    Route::controller(SubscribeController::class)->group(function () {
        Route::post('/events/{event}/subscribe', 'subscribe')->name('events.subscribe');
        Route::delete('/events/{event}/unsubscribe', 'unsubscribe')->name('events.unsubscribe');
    });
});

require __DIR__ . '/auth.php';
