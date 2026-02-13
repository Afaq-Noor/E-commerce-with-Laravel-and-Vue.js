<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Validator ;
use App\Traits\ApiResponse;

class BrandController extends Controller
{
       use ApiResponse ;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Brand::get() ;
        return view('admin/Brand/brands' , get_defined_vars()) ;
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
        'enter_text'  => 'required|string|max:255',
        'enter_image' => 'nullable|mimes:jpeg,png,jpg,gif|max:5120',
    ]);

    if ($validate->fails()) {
        return $this->error($validate->errors()->first(), 400, []);
    }

    $oldBanner = Brand::find($request->id);
    $image_name = $oldBanner ? $oldBanner->image : null;

    if ($request->hasFile('enter_image')) {
        // delete old image if exists
        if ($oldBanner && file_exists(public_path($oldBanner->image))) {
            unlink(public_path($oldBanner->image));
        }

        $image_name = 'image/brands/' . time() . '.' . $request->enter_image->extension();
        $request->enter_image->move(public_path('/image/brands/'), basename($image_name));
    }

    Brand::updateOrCreate(
        ['id' => $request->id],
        [
            'text'  => $request->enter_text,
            'image' => $image_name, 
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
   public function destroy($id = '', $table = '')
{
    try {
        // Find the record
        $banner = Brand::find($id);

        if (!$banner) {
            return $this->error('Record not found', 404, []);
        }

        // 🧹 Delete old image if exists
        if (!empty($banner->image) && file_exists(public_path($banner->image))) {
            unlink(public_path($banner->image));
        }

        // 🗑️ Delete record
        $banner->delete();

        // ✅ Return success JSON
        return $this->success(['reload' => true], 'Successfully deleted');
    } catch (\Exception $e) {
        return $this->error('Error deleting record: ' . $e->getMessage(), 500, []);
    }
}

}
