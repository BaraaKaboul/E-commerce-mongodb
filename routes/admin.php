<?php


use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;




Route::middleware(['auth','AuthAdmin'])->group(function (){
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/dashboard/brands', [AdminController::class, 'getBrand'])->name('admin.brands');
    Route::get('/dashboard/brand/create', [AdminController::class, 'createBrandPage'])->name('admin.brand.create.page');
    Route::post('/dashboard/brand/create', [AdminController::class, 'createBrand'])->name('admin.brand.create');
});
