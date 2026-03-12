<?php

namespace App\Services;

use App\Models\Product;


class ProductService{

    public function getPaginated(){
        return Product::orderBy('name', 'asc')->paginate(10);
    }
}