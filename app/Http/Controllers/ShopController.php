<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\ShopRepositoryInterface;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    protected $shop;

    public function __construct(ShopRepositoryInterface $shop){
        $this->shop = $shop;
    }

    public function index(){
        return $this->shop->index();
    }

    public function product_details($product_slug){
        return $this->shop->product_details($product_slug);
    }
}
