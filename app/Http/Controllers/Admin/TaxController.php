<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tax;
use Illuminate\Http\Request;
use Validator;
use App\Traits\ApiResponse;

class TaxController extends Controller
{
     use ApiResponse;

    public function index()
    {
        $data = Tax::get();
        return view('admin/Tax/tax', get_defined_vars());
    }

 

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'tax_text'  => 'required',
        ]);

        if ($validate->fails()) {
            return $this->error($validate->errors()->first(), 400, []);
        }


        Tax::updateOrCreate(
            ['id' => $request->id],
            [
                'text'  => $request->tax_text,
                'id' => $request->id,
            ]
        );

        return $this->success(['reload' => true], 'Successfully updated');
    }


}
