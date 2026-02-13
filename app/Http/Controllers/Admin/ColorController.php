<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;
use Validator ;
use App\Traits\ApiResponse;
class ColorController extends Controller
{
         use ApiResponse ;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Color::get() ;
        return view('admin/Color/color' , get_defined_vars() ) ;
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
        'text'  => 'required|string|max:255',
        'value' => 'required|string|max:255',
    ]);

    if ($validate->fails()) {
        return $this->error($validate->errors()->first(), 400, []);
    }


    Color::updateOrCreate(
        ['id' => $request->id],
        [
            'text'  => $request->text,
            'value' => $request->value ,
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
        $color = Color::find($id);
      
        if (!$color) {
            return $this->error('Record not found', 404, []);
        }


        // 🗑️ Delete record
        $color->delete();

        // ✅ Return success JSON
        return $this->success(['reload' => true], 'Successfully deleted');
    } catch (\Exception $e) {
        return $this->error('Error deleting record: ' . $e->getMessage(), 500, []);
    }
}
}