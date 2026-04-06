<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOrderDetail extends Model
{
    
    protected $guarded = [];
    
    public function productAttr()
{
    return $this->belongsTo(ProductAttr::class,'product_attr_id');
}
}
