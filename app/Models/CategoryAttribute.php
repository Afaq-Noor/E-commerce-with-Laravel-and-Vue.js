<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryAttribute extends Model
{
    protected $guarded = [] ;
    public $timestamps = false; // 
    protected $table = 'category_attributes' ;

    public function category() {
            return $this->belongsTo(Category::class , 'category_id') ;
    }

    public function attribute() {
          return $this->hasOne(Attribute::class , 'id' , 'attribute_id')->with('values')  ;
    }
}
