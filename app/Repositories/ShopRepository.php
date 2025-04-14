<?php

namespace App\Repositories;

use App\Models\Product;

class ShopRepository implements Interfaces\ShopRepositoryInterface
{
    public function index()
    {
        $products = Product::orderBy('created_at','DESC')->paginate(12);
        return view('shop.shop',compact('products'));
    }

    public function product_details($product_slug)
    {
        $product = Product::where('slug',$product_slug)->first();
        $rproduct = Product::where('slug','<>',$product_slug)->take(8)->get();
        return view('shop.product-details',compact('product','rproduct'));
    }
}
