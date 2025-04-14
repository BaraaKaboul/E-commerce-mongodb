<?php

namespace App\Repositories\Interfaces;

interface ShopRepositoryInterface
{
    public function index();

    public function product_details($product_slug);
}
