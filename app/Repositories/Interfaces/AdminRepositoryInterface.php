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
}
