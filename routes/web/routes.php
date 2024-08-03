<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::as('pages:')->group(static function (): void {
    Route::inertia(uri: 'terms', component: 'TermsOfService')->name('terms');
    Route::inertia(uri: 'privacy', component: 'PrivacyPolicy')->name('privacy');
    Route::middleware(['auth:sanctum', 'verified', config('jetstream.auth_session')])->group(static function (): void {
        Route::inertia(uri: '/', component: 'Index')->name('home');

        Route::inertia('example', 'Example')->name('example');
    });
});
