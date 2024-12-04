<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;

Route::prefix('bookings')->group(function () {
    Route::post('/', [BookingController::class, 'store']); // Создать новую бронь
    Route::get('/', [BookingController::class, 'index']); // Список броней
    Route::get('/{id}', [BookingController::class, 'show']); // Бронь по ID
    Route::put('/{id}', [BookingController::class, 'update']); // Редактировать бронь
    Route::delete('/{id}', [BookingController::class, 'destroy']); // Удалить бронь
    Route::get('/user/{userId}', [BookingController::class, 'getByUser']); // Брони пользователя
});
