<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Coupon;
use Illuminate\Http\Request;
use Validator ;
use App\Traits\ApiResponse;
class CouponController extends Controller
{
             use ApiResponse ;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Coupon::get() ;
        return view('admin/Coupon/Coupon' , get_defined_vars() ) ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $validate = Validator::make($request->all(), [
        'couponText'  => 'required|string|max:255',
        'couponType'  => 'required|numeric|in:1,2',
        'value'  => 'required|numeric',
        'minValue' => 'required|numeric',
    ]);

    if ($validate->fails()) {
        return $this->error($validate->errors()->first(), 400, []);
    }


    Coupon::updateOrCreate(
        ['id' => $request->id],
        [
            'name'  => $request->couponText,
            'type'  => $request->couponType,
            'value'  => $request->value,
            'minvalue' => $request->minValue ,
            'id' => $request->id ,
        ]
    );

    return $this->success(['reload' => true ], 'Successfully updated');
}


   
   public function destroy($id = '', $table = '')
{
    try {
        // Find the record
        $Coupon = Coupon::find($id);
      
        if (!$Coupon) {
            return $this->error('Record not found', 404, []);
        }


        // 🗑️ Delete record
        $Coupon->delete();

        // ✅ Return success JSON
        return $this->success(['reload' => true], 'Successfully deleted');
    } catch (\Exception $e) {
        return $this->error('Error deleting record: ' . $e->getMessage(), 500, []);
    }
}
}
