<?php

declare(strict_types=1);

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::prefix('1')
->as('1.')
->group(function (): void {

    Route::prefix('nyt')
        ->as('nyt.')
        ->group(function (): void {

            Route::get('/best-sellers', [BookController::class, 'bestSellers'])->name('best-sellers');
        });
});
