<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Size;
use App\Models\Tax;
use Illuminate\Http\Request;

use App\Traits\ApiResponse;
use Attribute;
use Exception;


class DynamicAjaxAttributeController extends Controller
{


    use ApiResponse;
    // Get all categories
    public function getCategories()
    {
        try {

            $categories = Category::select('id', 'name')->get();

            if ($categories->isEmpty()) {
                return $this->error('No Categories Found', 404);
            }
            return $this->success($categories, 'Categories loaded successfully');
        } catch (Exception $e) {
            return $this->error('Failed to load categories', 500, ['error' => $e->getMessage()]);
        }
    }


    
    // ✅ 2. Get Brands by Category
    public function getBrandsByCategory($category_id = '')
    { 
        try {
            $brands = Brand::get() ;

            if($brands->isEmpty()) {
                return $this->error('No Brands found for this category' , 404) ;
            }

            return $this->success($brands , 'Brands loaded Successfully') ;

        } catch (Exception $e) {
            //throw $th;
            return $this->error('Failed to load brands' , 500 , ['error' => $e->getMessage()]) ;
        }
    }


    // Get Colors 
    public function getColors() 
    {
        try {
            //code...
            $colors = Color::select('id' , 'text' , 'value')->get() ;

            if($colors->isEmpty()) {
                return $this->error('No colors found', 404) ;
            }

            return $this->success($colors , 'Colors loaded successfully') ;
        } catch (Exception $e) {
            //throw $th;
            return $this->error('Failed to load colors' , 500 , ['error' => $e->getMessage()]) ;
        }
    }

// getAttributeValue
    

    // Get getAttributeValue 
    public function getAttributeValue() 
    {
        try {
            //code...
        
            $attributeValue =  AttributeValue::with('attribute')->get() ;

            if($attributeValue->isEmpty()) {
                return $this->error('No Attribute Value found', 404) ;
            }

            return $this->success( $attributeValue  , 
            'Attribute Value loaded successfully') ;
        } catch (Exception $e) {
            //throw $th;
            return $this->error('Failed to load colors' , 500 , ['error' => $e->getMessage()]) ;
        }
    }


    // ✅ 4. Get Sizes
    public function getSizes()
    { 
       try {
        //code...
        $sizes = Size::select('id' , 'text')->get() ;

        if($sizes->isEmpty()) {
            return $this->error('No sizes found' , 404) ;
        }

        return $this->success($sizes , 'Sizes loaded Successfully') ;
       } catch (Exception $e) {
        //throw $th;
        return $this->error('Failed to load sizes' , 500 , ['error' => $e->getMessage()]) ;
       }

    }


       // ✅ 5. Get Taxes
    public function getTaxes()
    {
        try {
            //code...
            $taxes = Tax::get() ;
            if($taxes->isEmpty()) {
                return $this->error('No taxes found' , 404) ;
            }
           
            return $this->success($taxes , 'Taxes are fatched Successfully') ;
       } catch (Exception $e) {
            //throw $th;
            return $this->error('Failed to load taxes' , 500 , ['error' => $e->getMessage()]) ;
        } 
    }
}

