<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
        protected $table = 'product_attributes';
   protected $guarded = [];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }


    
    public function attributeValue()
    {
        // your migration used attribute_id referencing attribute_values
        return $this->belongsTo(AttributeValue::class, 'attribute_id');
    }


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
