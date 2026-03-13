<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttr extends Model
{
    //
    protected $guarded = [];

    protected $table = 'product_attrs';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function colors()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }


    public function sizes()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }

    public function attributeValue()
    {
        return $this->belongsTo(AttributeValue::class);
    }

    public function images()
    {
        return $this->hasMany(ProductAttrImage::class, 'product_attr_id');
    }
}
