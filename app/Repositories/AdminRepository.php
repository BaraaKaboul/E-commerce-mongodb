<?php

namespace App\Repositories;

use App\Models\Brand;
use App\Models\Category;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use function MongoDB\create_field_path_type_map;

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
                $file_name = time() . '_' . $image->getClientOriginalName();
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

    public function updateBrandPage($brand)
    {
        try {
            $brand_id = Brand::find($brand);
            return view('admin.edit-brand',compact('brand_id'));
        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error'=>$e->getMessage()]);
        }

    }

    public function updateBrand(Request $request, $brand){
        try {
            $old_image = $request->old_image;


            if ($request->hasFile('image')) {

                //هاي التعليمة بتحذف الصورة القديمة ومنستبدلها بالصورة الي رح يضيفا المستخدم ازا بدو يعدل الصورة
                unlink($old_image);

                $image = $request->file('image');
                $fileName = time() . '.' . $image->getClientOriginalName();
                $request->image->move(public_path('Attachments/'.$request->name), $fileName);


                Brand::where('id', $brand)->findOrFail($brand)->update([
                    'name' => $request->name,
                    'slug' => Str::slug($request->slug),
                    'image'=>$fileName,
                ]);
                return to_route('admin.brands');
            }
            else
                Brand::findOrFail($brand)->update([
                    'name' => $request->name,
                    'slug' => Str::slug($request->slug),
                ]);
            return to_route('admin.brands');

        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error'=>$e->getMessage()]);
        }
    }

    public function deleteBrand($brand)
    {
        try {
            Brand::where('id', $brand)->delete();
            return redirect()->back();
        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error'=>$e->getMessage()]);
        }
    }

    public function getCategories()
    {
        try {
            $categories = Category::orderBy('id','desc')->paginate(10);
            return view('admin.category',compact('categories'));
        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error'=>$e->getMessage()]);
        }
    }
}
