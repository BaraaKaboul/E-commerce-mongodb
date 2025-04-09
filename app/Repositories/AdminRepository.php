<?php

namespace App\Repositories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
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
            $brands = Brand::orderBy('id', 'desc')->paginate(10);
            return view('admin.brands', compact('brands'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
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
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function updateBrandPage($brand)
    {
        try {
            $brand_id = Brand::find($brand);
            return view('admin.edit-brand', compact('brand_id'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    public function updateBrand(Request $request, $brand)
    {
        //try {
            $old_image = $request->old_image;


            if ($request->hasFile('image')) {

                //هاي التعليمة بتحذف الصورة القديمة ومنستبدلها بالصورة الي رح يضيفا المستخدم ازا بدو يعدل الصورة
                unlink($old_image);

                $image = $request->file('image');
                $fileName = time() . '.' . $image->getClientOriginalName();
                $request->image->move(public_path('Attachments/' .$request->name), $fileName);


                Category::where('id', $brand)->findOrFail($brand)->update([
                    'name' => $request->name,
                    'slug' => Str::slug($request->slug),
                    'image' => $fileName,
                ]);
                return to_route('admin.brands');
            } else
                Category::findOrFail($brand)->update([
                    'name' => $request->name,
                    'slug' => Str::slug($request->slug),
                ]);
            return to_route('admin.brands');
        //}catch (\Exception $e){
           // return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        //}
    }

    public function deleteBrand($brand)
    {
        try {
            $bra = Brand::findOrFail($brand);
            if ($bra->image){
                $imagePath = public_path('Attachments/' . Str::slug($bra->name) . '/' . $bra->image);
                if (File::exists($imagePath)){
                    File::delete($imagePath);

                    // to delete the folder
                    $folderPath = dirname($imagePath);
                    if (is_dir($folderPath) && count(scandir($folderPath)) == 2) {
                        rmdir($folderPath);
                    }
                }
                $bra->delete();
            }
            $bra->delete();

            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function getCategories()
    {
        try {
            $categories = Category::orderBy('id', 'desc')->paginate(10);
            return view('admin.category', compact('categories'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function createCategoryPage()
    {
        try {
            $brands = Brand::all();
            return view('admin.create-category',compact('brands'));
        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function createCategory($request)
    {
        try {
            $brand = Brand::findOrFail($request->brand);
            $category = new Category();
            $category->name = $request->name;
            $category->slug = Str::slug($request->slug);
            $category->brand_id = $request->brand;


            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $file_name = time() . '_' . $image->getClientOriginalName();
                $category->image = $file_name;

                // move pic
                $imageName = $file_name;
                $request->image->move(public_path('Attachments/' .$brand->name.'/'.$request->name), $imageName);
            }
            $category->save();

            return to_route('admin.categories');
        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function updateCategoryPage($category)
    {
        try {
            $brands = Brand::select('id','name')->get();
            $category_id = Category::findOrFail($category);
            return view('admin.edit-category',compact('category_id','brands'));
        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function updateCategory($request, $category)
    {
        try {
            $old_image = $request->old_image;
            $brand = Brand::findOrFail($request->brand);


            if ($request->hasFile('image')) {

                //هاي التعليمة بتحذف الصورة القديمة ومنستبدلها بالصورة الي رح يضيفا المستخدم ازا بدو يعدل الصورة
                unlink($old_image);

                $image = $request->file('image');
                $fileName = time() . '.' . $image->getClientOriginalName();
                $request->image->move(public_path('Attachments/' .$brand->name.'/'.$request->name), $fileName);


                Category::where('id', $category)->findOrFail($category)->update([
                    'name' => $request->name,
                    'slug' => Str::slug($request->slug),
                    'image' => $fileName,
                ]);
                return to_route('admin.categories');
            } else
                Category::findOrFail($category)->update([
                    'name' => $request->name,
                    'slug' => Str::slug($request->slug),
                ]);
            return to_route('admin.categories');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function deleteCategory($category)
    {
        try {
        $cat = Category::findOrFail($category);
        if ($cat->image) {
            // بناء المسار الصحيح للصورة
            $imagePath = public_path('Attachments/' . Str::slug($cat->brand->name) . '/' . $cat->name . '/' . $cat->image);

            // التحقق من وجود الصورة قبل الحذف
            if (File::exists($imagePath)) {
                File::delete($imagePath);

                // (اختياري) حذف المجلد إذا أصبح فارغاً
                $folderPath = dirname($imagePath);
                if (is_dir($folderPath) && count(scandir($folderPath)) == 2) {
                    rmdir($folderPath);
                }
            }
            $cat->delete();
        }else{
            $cat->delete();
        }
            return to_route('admin.categories');
        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function getProducts()
    {
        $products = Product::orderby('created_at','desc')->paginate(10);
        return view('admin.products', compact('products'));
    }

    public function createProductPage()
    {
        $categories = Category::select('id','name')->orderBy('name')->get();
        $brands = Brand::select('id','name')->orderBy('name')->get();
        return view('admin.create-product',compact('categories','brands'));
    }

    public function getCategoriesAjax($brand_id)
    {
        $categories = Category::where('brand_id',$brand_id)->pluck('name','id');// name then id
        return json_encode($categories);
    }

    public function createProduct($request)
    {
        try {
            $brand_id = Brand::where('id',$request->brand_id)->select('id','name')->first();
            $category_id = Category::where('id',$request->category_id)->select('id'.'name')->first();

            $product = new Product();
            $product->name = $request->name;
            $product->slug = Str::slug($request->name);
            $product->short_description = $request->short_description;
            $product->description = $request->description;
            $product->regular_price = $request->regular_price;
            $product->sale_price = $request->sale_price;
            $product->SKU = $request->SKU;
            $product->stock_status = $request->stock_status;
            $product->featured = $request->featured;
            $product->quantity = $request->quantity;
            $product->category_id = $request->category_id;
            $product->brand_id = $request->brand_id;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $file_name = time() . '_' . $image->getClientOriginalName();
                $product->image = $file_name;

                // move pic
                $imageName = $file_name;
                $request->image->move(public_path('Attachments/' .$brand_id->name.'/'.$category_id->name.'/'.$request->name), $imageName);
            }

//        if ($request->hasFile('images')){
//            foreach ($request->file('images') as $imgs)
//            {
//                $imgsName =time() . '_' . $imgs->getClientOriginalName();
//                $product->images = $imgsName;
//
//                // move imgs
//                $imagesName = $imgsName;
//                $imgs->move(public_path('Attachments/' .$brand_id->name.'/'.$category_id->name.'/'.$request->name.'/'.'Gallery images'), $imagesName);
//            }
//        }
            if ($request->hasFile('images')) {
                $galleryImages = [];
                $galleryPath = public_path('Attachments/' . $brand_id->name . '/' . $category_id->name . '/' . $product->name . '/' . 'Gallery');

                if (!file_exists($galleryPath)) {
                    mkdir($galleryPath, 0777, true);
                }

                foreach ($request->file('images') as $image) {
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $image->move($galleryPath, $imageName);
                    $galleryImages[] = $imageName;
                }

                $product->images = json_encode($galleryImages);
            }

            $product->save();
            return to_route('admin.products');

        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function updateProductPage($product)
    {
        try {
            $prod = Product::findOrFail($product);
            $categories = Category::select('id','name')->orderBy('name')->get();
            $brands = Brand::select('id','name')->orderBy('name')->get();

            return view('admin.edit-product',compact('prod','brands','categories'));
        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function updateProduct($request, $product)
    {
        try {
            $brand = Brand::findOrFail($request->brand_id);
            $category = Category::findOrFail($request->category_id);

            $prod = Product::findOrFail($product);

            // حفظ البيانات الأساسية
            $prod->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'description' => $request->description,
                'regular_price' => $request->regular_price,
                'sale_price' => $request->sale_price,
                'SKU' => $request->SKU,
                'stock_status' => $request->stock_status,
                'featured' => $request->featured,
                'quantity' => $request->quantity,
                'category_id' => $request->category_id,
                'brand_id' => $request->brand_id,
            ]);

            // معالجة الصورة الرئيسية
            if ($request->hasFile('image')) {
                // حذف الصورة القديمة إذا كانت موجودة
                if ($prod->image) {
                    $oldImagePath = public_path('Attachments/'.$prod->brand->name.'/'.$prod->name.'/'.$prod->image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = public_path('Attachments/'.$brand->name.'/'.$request->name);

                if (!file_exists($imagePath)) {
                    mkdir($imagePath, 0777, true);
                }

                $image->move($imagePath, $imageName);
                $prod->image = $imageName;
            }

            // معالجة صور المعرض
            $galleryImages = json_decode($prod->images, true) ?? [];

            // حذف الصور المحددة للحذف
            if ($request->deleted_images) {
                foreach ($request->deleted_images as $deletedImage) {
                    $imagePath = public_path('Attachments/'.$brand->name.'/'.$request->name.'/Gallery/'.$deletedImage);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }

                    // إزالة الصورة من المصفوفة
                    $galleryImages = array_diff($galleryImages, [$deletedImage]);
                }
            }

            // إضافة الصور الجديدة
            if ($request->hasFile('images')) {
                $galleryPath = public_path('Attachments/'.$brand->name.'/'.$request->name.'/Gallery');

                if (!file_exists($galleryPath)) {
                    mkdir($galleryPath, 0777, true);
                }

                foreach ($request->file('images') as $image) {
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $image->move($galleryPath, $imageName);
                    $galleryImages[] = $imageName;
                }
            }

            $prod->images = json_encode(array_values($galleryImages));
            $prod->save();

            return redirect()->route('admin.products')->with('success', 'Product updated successfully');
        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function deleteProduct($product)
    {
        try {
            $product = Product::findOrFail($product);
            if ($product->image){
                $oldImagePath = public_path('Attachments/'.$product->brand->name.'/'.$product->name.'/'.$product->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            if ($product->images){
                $galleryPath = public_path('Attachments/'.$product->brand->name.'/'.$product->name.'/Gallery');
                if (file_exists($galleryPath)){
                    $files = glob($galleryPath.'/*');
                    foreach ($files as $file) {
                        if (file_exists($file)) {
                            unlink($file);
                        }
                    }
                    // Delete 'Gallery' folder
                    rmdir($galleryPath);
                }
            }
            // Delete product folder when it's empty
            $productPath = public_path('Attachments/'.$product->brand->name.'/'.$product->name);
            if (file_exists($productPath) && count(glob($productPath.'/*')) === 0) {
                rmdir($productPath);
            }
            $product->delete();
            return redirect()->back();
        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
