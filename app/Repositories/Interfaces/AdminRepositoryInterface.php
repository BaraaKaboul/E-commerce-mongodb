<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface AdminRepositoryInterface
{
    public function index();

    public function getBrands();

    public function createBrandPage();

    public function createBrand(Request $request);

    public function updateBrandPage($brand);

    public function updateBrand(Request $request, $brand);

    public function deleteBrand($brand);

    public function getCategories();

    public function createCategoryPage();

    public function createCategory($request);

    public function updateCategoryPage($category);

    public function updateCategory($request, $category);

    public function deleteCategory($category);
}
