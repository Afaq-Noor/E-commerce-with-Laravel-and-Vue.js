<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];
    // children / parent
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_category_id');
    }
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_category_id');
    }




    // pivot to attributes
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'category_attributes', 'category_id', 'attribute_id');
    }

    
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }




}
