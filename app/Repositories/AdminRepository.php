<?php

namespace App\Repositories;

use App\Models\Brand;
use App\Repositories\Interfaces\AdminRepositoryInterface;

class AdminRepository implements AdminRepositoryInterface
{
    public function index()
    {
        return view('admin.index');
    }

    public function createBrand()
    {
        try {
            $brands = Brand::orderBy('id','desc')->paginate(10);
            return view('admin.brands',compact('brands'));
        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error'=>$e->getMessage()]);
        }

    }
}
