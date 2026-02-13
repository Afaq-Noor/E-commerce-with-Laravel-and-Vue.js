<?php

namespace App\Http\Controllers\FrontendUser;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\HomeBanner;
use App\Models\Product;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categoriesWithProduct = Category::with(['products.productAttr'])->get();
        $homeBanners = HomeBanner::get();
        $brands = Brand::get();
        $productWithAttr = Product::with('productAttr')->get();
        return response()->json([
            'success' => true,
            'data' => [
                'categoriesWithProducts' => $categoriesWithProduct,
                'homeBanners' => $homeBanners,
                'brands' => $brands,
                'productWithAttr' => $productWithAttr
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function navBarCategory()
    {
        $categories = Category::get();

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
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
