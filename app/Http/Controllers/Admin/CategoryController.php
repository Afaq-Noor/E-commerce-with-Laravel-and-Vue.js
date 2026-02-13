<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\CategoryAttribute;
use Illuminate\Http\Request;
use Validator;
use App\Traits\ApiResponse;

class CategoryController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $data = Category::get();
        return view('admin/Category/category_name', get_defined_vars());
    }

    public function index_category_attribute()
    {

        $categories = Category::orderBy('name')->get();
        $attributes = Attribute::orderBy('name')->get();


        $data = CategoryAttribute::with(['category', 'attribute'])->get();
        return view('admin/Category/category_attributes', get_defined_vars());
    }


    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'category_name' => 'required|string|max:255',
            'category_slug' => 'required|string|max:255',
        ]);

        if ($validate->fails()) {
            return $this->error($validate->errors()->first(), 400, []);
        }

        $category = Category::find($request->id);
        $image_name = $category ? $category->image : null;

        if ($request->hasFile('enter_image')) {

            // ✅ SAFE DELETE
            if ( $category && $category->image && file_exists(public_path($category->image)) &&
                is_file(public_path($category->image))
            ) {
                unlink(public_path($category->image));
            }

            $image_name = 'image/Categories/' . time() . '.' . $request->enter_image->extension();
            $request->enter_image->move(public_path('image/Categories'), basename($image_name));
        }

        $slug = replaceStr($request->category_slug) ;
        Category::updateOrCreate(
            ['id' => $request->id],
            [
                'name' => $request->category_name,
                'slug' => $slug ,
                'image' => $image_name,
                'parent_category_id' => is_numeric($request->parent_category_id) && $request->parent_category_id != 0
                    ? $request->parent_category_id
                    : null,
            ]
        );

        return $this->success(['reload' => true], 'Successfully updated');
    }



    public function store_category_attribute(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'select_attribute_id'  => 'required|integer|max:255|exists:attributes,id',
            'select_category_id' => 'required|integer|max:255|exists:categories,id',
        ]);

        if ($validate->fails()) {
            return $this->error($validate->errors()->first(), 400, []);
        }


        CategoryAttribute::updateOrCreate(
            ['id' => $request->id],
            [
                'attribute_id' => $request->select_attribute_id,
                'category_id'  => $request->select_category_id,
                'id' => $request->id,
            ]
        );

        return $this->success(['reload' => true], 'Successfully updated');
    }
}
