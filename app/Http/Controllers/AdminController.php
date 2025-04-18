<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\AdminRepositoryInterface;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $admin;

    public function __construct(AdminRepositoryInterface $admin)
    {
        $this->admin = $admin;
    }

    public function index(){
        return $this->admin->index();
    }

    public function getBrand(){
        return $this->admin->getBrands();
    }

    public function createBrandPage(){
        return $this->admin->createBrandPage();
    }

    public function createBrand(Request $request){
        return $this->admin->createBrand($request);
    }

    public function updateBrandPage($brand){
        return $this->admin->updateBrandPage($brand);
    }

    public function updateBrand(Request $request, $brand){
        return $this->admin->updateBrand($request, $brand);
    }

    public function deleteBrand($brand){
        return $this->admin->deleteBrand($brand);
    }
}
