<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOrder extends Model
{
    protected $guarded = [];


    public function payments() {
        return $this->hasMany(Payment::class) ;
    }

    public function orderDetails()
{
    return $this->hasMany(UserOrderDetail::class,'order_id');
}

   public function address()
{
    return $this->belongsTo(UserAddress::class,'address_id');
}
}
