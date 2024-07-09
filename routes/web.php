<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HallsController;
use App\Http\Controllers\FilmsController;
use App\Http\Controllers\SessionController;
use App\Models\Hall;
use App\Models\Film;

// Route::post('/admin', function () {
//     dd(Hall::all());
// })->name('admin');

Route::get('/', [HallsController::class, 'indexClient'])->name('client');
Route::get('/hall/{id}', [SessionController::class, 'index'])->name('bookingHall');
Route::post('/payment/update', [SessionController::class, 'updateSession']);
Route::get('/payment', [SessionController::class, 'payment'])->name('payment');
Route::get('/ticket', [SessionController::class, 'ticket'])->name('ticket');


Auth::routes();
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', [HallsController::class, 'index'])->name('admin');
        Route::post('/addhall', [HallsController::class, 'addHall'])->name('addHall');
        Route::get('/delete/{id}', [HallsController::class, 'deleteHall'])->name('deleteHall');
        Route::get('/price', [HallsController::class, 'price']);
        Route::post('/price/update', [HallsController::class, 'updatePrice']);
        Route::post('/config/update', [HallsController::class, 'updateConfig']);
        Route::post('/addfilm', [FilmsController::class, 'addFilm'])->name('addFilm');
        Route::get('/deleteFilm{id}', [FilmsController::class, 'deleteFilm'])->name('deleteFilm');
        Route::post('/addsession', [SessionController::class, 'addSession'])->name('addSession');
        Route::get('/deletesession/{id}', [SessionController::class, 'deleteSession'])->name('deleteSession');
        Route::post('/startsale', [HallsController::class, 'startSale'])->name('startSale');
    });
});
