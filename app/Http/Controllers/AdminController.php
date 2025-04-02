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

    public function getCategories(){
        return $this->admin->getCategories();
    }

    public function createCategoryPage(){
        return $this->admin->createCategoryPage();
    }

    public function createCategory(Request $request){
        return $this->admin->createCategory($request);
    }

    public function updateCategoryPage($category){
        return $this->admin->updateCategoryPage($category);
    }

    public function updateCategory(Request $request, $category){
        return $this->admin->updateCategory($request, $category);
    }

    public function deleteCategory($category){
        return $this->admin->deleteCategory($category);
    }
}
