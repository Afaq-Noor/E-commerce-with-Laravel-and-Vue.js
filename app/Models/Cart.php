<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $guarded = [];


    protected $hidden = [
        'id' ,
    ];

    public function products() 
    {
        return $this->hasMany(Product::class, 'id', 'product_id')->with('productAttr') ;
    }
}
