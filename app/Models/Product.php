<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }



    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class, 'tax_id');
    }

    public function images()
    {
        return $this->hasMany(ProductAttrImage::class);
    }

    // product -> selected attribute values (product_attributes table)
    public function productAttributes()
    {
        return $this->hasMany(ProductAttribute::class, 'product_id');
    }

    // product -> variants
    public function productAttr()
    {
        return $this->hasMany(ProductAttr::class,  'product_id');
    }

    // optional product-level images if you add them later
    // public function images() { return $this->hasMany(ProductImage::class, 'product_id'); }
}
