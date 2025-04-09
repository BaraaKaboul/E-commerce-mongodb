<?php

namespace App\Http\Controllers;

use App\Models\Category;
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

    public function getProducts(){
        return $this->admin->getProducts();
    }

    public function createProductPage(){
        return $this->admin->createProductPage();
    }

    public function getCategoriesAjax($brand_id){
        return $this->admin->getCategoriesAjax($brand_id);
    }

    public function createProduct(Request $request){
        return $this->admin->createProduct($request);
    }

    public function updateProductPage($product){
        return $this->admin->updateProductPage($product);
    }

    public function updateProduct(Request $request, $product){
        return $this->admin->updateProduct($request, $product);
    }

    public function deleteProduct($product){
        return $this->admin->deleteProduct($product);
    }
}
