<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
      protected $guarded = []; 


       public function productColorVariants()
    {
        return $this->hasMany(ProductAttr::class, 'color_id');
    }
}
