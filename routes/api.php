<?php

use Illuminate\Support\Facades\Route;

Route::prefix('1')
->as('1.')
->group(function (): void {

    Route::prefix('nyt')
        ->as('nyt.')
        ->group(function (): void {

            Route::get('/best-sellers', function () {
                return view('welcome');
            })->name('best-sellers');

        });
});
