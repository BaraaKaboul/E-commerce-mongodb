<?php

namespace App\Repositories;

use App\Models\Brand;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminRepository implements AdminRepositoryInterface
{
    public function index()
    {
        return view('admin.index');
    }

    public function getBrands()
    {
        try {
            $brands = Brand::orderBy('id','desc')->paginate(10);
            return view('admin.brands',compact('brands'));
        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error'=>$e->getMessage()]);
        }
    }

    public function createBrandPage()
    {
        return view('admin.create-brand');
    }

    public function createBrand(Request $request)
    {
        try {
            $brand = new Brand();
            $brand->name = $request->name;
            $brand->slug = Str::slug($request->slug);


            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $file_name = $image->getClientOriginalName();
                $brand->image = $file_name;

                // move pic
                $imageName = $file_name;
                $request->image->move(public_path('Attachments/' . $request->name), $imageName);
            }
            $brand->save();

            return to_route('admin.brands');
        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error'=>$e->getMessage()]);
        }
    }
}
