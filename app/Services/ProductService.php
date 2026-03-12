<?php

namespace App\Services;

use App\Models\Product;


class ProductService{

    
    public function getPaginated($search, $sort){

        return Product::query()

            ->when($search, function($q) use ($search){
                $q->where('name','like','%'.$search.'%');
            })

            ->orderBy('price', $sort)

            ->paginate(10);
    }

    public function delete($id){
        Product::findOrFail($id)->delete();
    }
    
    public function update($id, $data){
        Product::findOrFail($id)->update($data);
    }
}