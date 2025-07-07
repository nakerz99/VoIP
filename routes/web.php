<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CallTicketController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Call Ticket routes
    Route::resource('call-tickets', CallTicketController::class)->except(['edit', 'destroy']);
    Route::post('/call-tickets/{callTicket}/notes', [CallTicketController::class, 'addNote'])->name('call-tickets.add-note');
    Route::post('/call-tickets/{callTicket}/assign-to-me', [CallTicketController::class, 'assignToMe'])->name('call-tickets.assign-to-me');
    Route::post('/call-tickets/{callTicket}/complete', [CallTicketController::class, 'complete'])->name('call-tickets.complete');
    Route::post('/call-tickets/{callTicket}/forward', [CallTicketController::class, 'forward'])->name('call-tickets.forward');
    Route::post('/call-tickets/{callTicket}/escalate', [CallTicketController::class, 'escalate'])->name('call-tickets.escalate');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
