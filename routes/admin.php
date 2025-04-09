<?php


use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;




Route::middleware(['auth','AuthAdmin'])->controller(AdminController::class)->group(function (){
    Route::get('/dashboard','index')->name('admin.index');

    Route::get('/dashboard/brands','getBrand')->name('admin.brands');
    Route::get('/dashboard/brand/create','createBrandPage')->name('admin.brand.create.page');
    Route::post('/dashboard/brand/create','createBrand')->name('admin.brand.create');
    Route::get('/dashboard/brand/update/{brand}','updateBrandPage')->name('admin.brand.update.page');
    Route::patch('/dashboard/brand/update/{brand}','updateBrand')->name('admin.brand.update');
    Route::delete('/dashboard/brand/delete/{brand}','deleteBrand')->name('admin.brand.delete');

    Route::get('/dashboard/categories','getCategories')->name('admin.categories');
    Route::get('/dashboard/category/create','createCategoryPage')->name('admin.categories.create.page');
    Route::post('/dashboard/category/create','createCategory')->name('admin.categories.create');
    Route::get('/dashboard/category/update/{category}','updateCategoryPage')->name('admin.categories.update.page');
    Route::patch('/dashboard/category/update/{category}','updateCategory')->name('admin.category.update');
    Route::delete('/dashboard/category/delete/{category}','deleteCategory')->name('admin.category.delete');

    Route::get('/dashboard/products','getProducts')->name('admin.products');
    Route::get('/dashboard/product/create','createProductPage')->name('admin.product.create.page');
    // To get categories that related to brands
    Route::get('/brand/{brand_id}','getCategoriesAjax');
    Route::post('/dashboard/product/create','createProduct')->name('admin.product.create');
    Route::get('/dashboard/product/update/{product}','updateProductPage')->name('admin.products.update.page');
    Route::patch('/dashboard/product/update/{product}','updateProduct')->name('admin.product.update');
    Route::delete('/dashboard/product/delete/{category}','deleteProduct')->name('admin.product.delete');

});
