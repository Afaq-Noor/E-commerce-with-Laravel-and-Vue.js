<?php

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\HomeBannerController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DynamicAjaxAttributeController;
use App\Http\Controllers\Admin\ProductListController;
use App\Http\Controllers\Admin\TaxController;
use App\Models\CategoryAttribute;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('admin.index');
})->name('admin.dashboard');

// profile section
Route::get('/profile', [ProfileController::class, 'index']);
Route::post('/save-profile', [ProfileController::class, 'store']);

//home banner
Route::get('/home-banner', [HomeBannerController::class, 'index']);
Route::post('/update-home-banner', [HomeBannerController::class, 'store']);
Route::delete('admin/delete-home-banner/{id?}/{table?}', [HomeBannerController::class, 'destroy']);

// Size
Route::get('/manage-size', [SizeController::class, 'index']);
Route::post('/update-size', [SizeController::class, 'store']);

//Color
Route::get('/manage-color', [ColorController::class, 'index']);
Route::post('/update-color', [ColorController::class, 'store']);
Route::get('admin/delete-data/{id?}/{table?}', [AuthController::class, 'destroy']);


//Attribue
Route::get('/attribute-name', [AttributeController::class, 'index_attribute_name']);
Route::post('/update-attribute-name', [AttributeController::class, 'store_attribute_name']);

Route::get('/attribute-value', [AttributeController::class, 'index_attribute_value']);
Route::post('/update-attribute-value', [AttributeController::class, 'store_attribute_value']);


//Categories

Route::get('/category-name', [CategoryController::class, 'index']);
Route::post('/update-category', [CategoryController::class, 'store']);

Route::get('/category-attribute', [CategoryController::class, 'index_category_attribute']);
Route::post('/update-category-attribute', [CategoryController::class, 'store_category_attribute']);


//brand

Route::get('/index-brand', [BrandController::class, 'index']);
Route::post('/update-or-add-brands', [BrandController::class, 'store']);


// Tax 

Route::get('/index-tax', [TaxController::class, 'index']);
Route::post('/update-or-add-tax', [TaxController::class, 'store']);



Route::controller(DynamicAjaxAttributeController::class)->group(function () {
    Route::get('/get-categories', 'getCategories')->name('get.categories');
    Route::get('/get-brands/{category_id?}', 'getBrandsByCategory')->name('get.brands.by.category');
    Route::get('/api/colors', 'getColors')->name('get.colors');
    Route::get('/api/attribute-value', 'getAttributeValue')->name('get.attribute.value');

    Route::get('/get-sizes', 'getSizes')->name('get.sizes');
    Route::get('/get-taxes', 'getTaxes')->name('get.taxes');
});


// product 

Route::get('/product-add-form-index', [ProductController::class, 'index'])->name('product_form_index');

// Route::delete('admin/delete-attribute-name/{id?}/{table?}', [AuthController::class, 'destroy']);

Route::get('/api/product/form-data', [ProductController::class, 'getFormData'])->name('api.product.form-data');
Route::post('/products/store-basic', [ProductController::class, 'storeBasic'])->name('products.store.basic');
Route::post('admin/products/attributes', [ProductController::class, 'storeAttributes'])
    ->name('products.attributes.store');
    Route::post('/admin/product-images', [ProductController::class, 'storeImages'])
    ->name('products.images.store');
    Route::post('/admin/attribute-images', [ProductController::class, 'storeAttributeImages'])
    ->name('products.attribute.images.store');
    Route::get('/product-lists' , [ ProductListController::class , 'product_lists'])->name('product_lists'); 
    Route::get('/product/fetch-attr/{prd_id?}', [ProductListController::class, 'fetchAttr'])->name('product.fetch.attr');
    
    Route::post('admin/products/update', [ProductListController::class, 'storeAttributes'])
        ->name('products.attributes.update');


        Route::get('/admin/products/fetch', [ProductController::class, 'fetchProducts'])->name('products.fetch');
