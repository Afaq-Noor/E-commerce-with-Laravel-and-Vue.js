<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $guarded = [];


    // One attribute can have many values


    public function values()
    {
        return $this->hasMany(AttributeValue::class, 'attributes_id');
    }

    
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_attributes', 'attribute_id', 'category_id');
    }
}
