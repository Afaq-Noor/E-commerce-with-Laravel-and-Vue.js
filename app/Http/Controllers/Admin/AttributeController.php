<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use Validator ;
use App\Traits\ApiResponse;

class AttributeController extends Controller
{
           use ApiResponse ;
    /**
     * Display a listing of the resource.
     */
    public function index_attribute_name()
    {
        $data = Attribute::get() ;
        return view('admin/Attribute/attribute_name' , get_defined_vars() ) ;
    }

        public function index_attribute_value()
    {
        $attribute_name =   Attribute::get() ;
        $data = AttributeValue::get() ;
        return view('admin/Attribute/attribute_value' , get_defined_vars() ) ;
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
   public function store_attribute_name(Request $request)
{
    $validate = Validator::make($request->all(), [
        'attribute_name'  => 'required|string|max:255',
        'attribute_slug' => 'required|string|max:255',
    ]);

    if ($validate->fails()) {
        return $this->error($validate->errors()->first(), 400, []);
    }


    Attribute::updateOrCreate(
        ['id' => $request->id],
        [
            'name'  => $request->attribute_name,
            'slug' => $request->attribute_slug ,
            'id' => $request->id ,
        ]
    );

    return $this->success(['reload' => true ], 'Successfully updated');
}


   public function store_attribute_value(Request $request)
{
    $validate = Validator::make($request->all(), [
        'attribute_name_id'  => 'required|exists:attributes,id',
        'attribute_value' => 'required|string|max:255',
    ]);

    if ($validate->fails()) {
        return $this->error($validate->errors()->first(), 400, []);
    }


    AttributeValue::updateOrCreate(
        ['id' => $request->id],
        [
            'attributes_id'  => $request->attribute_name_id ,
            'value' => $request->attribute_value ,
            'id' => $request->id ,
        ]
    );

    return $this->success(['reload' => true ], 'Successfully updated');
}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy_attribute_name($id = '', $table = '')
{
    try {
        // Find the record
        $Attribute = Attribute::find($id);
      
        if (!$Attribute) {
            return $this->error('Record not found', 404, []);
        }


        // 🗑️ Delete record
        $Attribute->delete();

        // ✅ Return success JSON
        return $this->success(['reload' => true], 'Successfully deleted');
    } catch (\Exception $e) {
        return $this->error('Error deleting record: ' . $e->getMessage(), 500, []);
    }
}
}