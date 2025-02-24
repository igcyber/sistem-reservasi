<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/reservations/calender', function(){
        return view('reservation.calendar');
    })->name('reservations.calendar');
    Route::get('/reservation/calender', function(){
        return view('reservation.assesor-calendar');
    })->name('reservations.assesor.calendar');
    Route::get('/client/calender', function(){
        return view('reservation.client-calendar');
    })->name('reservations.client.calendar');
    Route::get('/calendar/events', [ReservationController::class, 'getAllReservations'])->name('calendar.events');
    Route::get('/assesor-calendar/events', [ReservationController::class, 'getReservationAssesor'])->name('calendar.assesor.events');
    Route::post('/reservations/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');
    Route::get('/status-reservation/{Uid}/{status}', [ReservationController::class, 'changeReservation']);
    Route::get('/status-payment/{Uid}/{status}', [ReservationController::class, 'changePayment']);
});
    Route::resource('users', UserController::class)->except('show', 'create');
    Route::resource('reservations', ReservationController::class)->except('show');

require __DIR__.'/auth.php';
