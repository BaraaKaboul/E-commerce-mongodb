<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface AdminRepositoryInterface
{
    public function index();

    public function getBrands();

    public function createBrandPage();

    public function createBrand(Request $request);
}
