<?php


use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;




Route::middleware(['auth'])->group(function (){
    Route::get('/dashboard', [UserController::class, 'index'])->name('user.index');
});
