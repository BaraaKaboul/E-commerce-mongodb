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
}
