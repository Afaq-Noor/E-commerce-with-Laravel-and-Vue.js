<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttrImage extends Model
{
    //
   protected $guarded = [];
     protected $table = 'product_attr_images';

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function productAttr()
    {
        return $this->belongsTo(ProductAttr::class, 'product_attr_id');
    }

}
