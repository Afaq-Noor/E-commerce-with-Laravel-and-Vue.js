<?php

namespace App\Http\Controllers\FrontendUser;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoryAttribute;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductAttr;
use App\Models\Size;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryPageController extends Controller
{

    public function getCategoryData($slug)
    {   
        // Get Category One Time 
        $category = Category::where('slug' , $slug)->with(['products.productAttr'])->firstOrFail() ;

        // Products
        $products = Product::where('category_id', $category->id)->with('productAttr')
                     ->paginate(10) ;
        
        // Sibling Child categories
        if($category->parent_category_id === null || $category->parent_category_id === $category->id) 
        {

            // Parent category 
            $categories = Category::where('parent_category_id', $category->id)->get() ;
        } else {
            // Child category siblings
            $categories = Category::where('parent_category_id', $category->parent_category_id)
               ->where('id','=',$category->id)->get() ;
        }

         // 4️⃣ Filters
    $lowPrice = ProductAttr::min('price');
    $highPrice = ProductAttr::max('price');

    $brands = Brand::all();
    $sizes = Size::all();
    $colors = Color::all();

    // 5️⃣ Category attributes
    $cat_attributes = CategoryAttribute::where('category_id', $category->id)
        ->with('attribute.values')
        ->get();

    return response()->json([
        'success' => true,
        'data' => compact(
            'category',
            'products',
            'categories',
            'lowPrice',
            'highPrice',
            'brands',
            'sizes',
            'colors',
            'cat_attributes'
        )
    ]);
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
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
    public function destroy(string $id)
    {
        //
    }
}
