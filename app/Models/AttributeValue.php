<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    protected $guarded = [] ;



      // Each value belongs to one attribute

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attributes_id');
    }

}
