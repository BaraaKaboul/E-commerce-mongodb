<?php


use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;




Route::middleware(['auth','AuthAdmin'])->group(function (){
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/dashboard/brands', [AdminController::class, 'getBrand'])->name('admin.brands');
});
