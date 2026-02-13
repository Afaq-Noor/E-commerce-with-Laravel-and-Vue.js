<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
 
    protected $guarded = [];


      public function productSizeVariants()
    {
        return $this->hasMany(ProductAttr::class, 'size_id');
    }
}
