<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tax;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\ProductAttr;
use App\Models\ProductAttribute;
use App\Models\ProductAttrImage;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $categories = Category::get();
        $brands = Brand::get();
        $taxes = Tax::get();
        return view('admin/Product/product_index_form', get_defined_vars());
    }




    // 🟦 Get dropdown data
    public function getFormData()
    {
        $attribute_value = AttributeValue::get();
        $categories = Category::get();
        $brands = Brand::get();
        $taxes = Tax::get();

        return $this->success([
            'attribute_value' => $attribute_value,
            'categories' => $categories,
            'brands' => $brands,
            'taxes' => $taxes,
        ], 'Form data loaded');
    }

    // 🟩 Store basic info
    public function storeBasic(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'category_id' => 'required|integer|exists:categories,id',
            'brand_id' => 'required|integer|exists:brands,id',
            'tax_id' => 'required|integer|exists:taxes,id',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif|max:5120',
            'status' => 'string',
            'keywords' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validate->fails()) {
            return $this->error($validate->errors()->first(), 400, []);
        }

        // 🔹 Find existing product (for update)
        $existing = Product::find($request->id);

        // 🔸 Keep old image name if no new file uploaded
        $image_name = $existing?->image ?? null;

        if ($request->hasFile('image')) {
            $image_name = 'image/products/' . time() . '.' . $request->image->extension();
            $request->image->move(public_path('image/products/'), basename($image_name));
        }

        $slug = replaceStr($request->slug);
        $product = Product::updateOrCreate(
            ['id' => $request->id],
            [
                'name' =>  $request->name,
                'slug' =>  $slug,
                'category_id' =>  $request->category_id,
                'brand_id' =>   $request->brand_id,
                'tax_id' =>  $request->tax_id,
                'image' =>   $image_name,
                'status' => $request->status ?? '1',
                'keywords' =>   $request->keywords,
                'description' =>  $request->description,
            ]
        );

        return $this->success([
            'product_id' => $product->id,
            'category_id' => $product->category_id,
            'reload' => true,
        ], 'Product saved successfully');
    }

    // 🟧 Store Attributes
    public function storeAttributes(Request $request)
    {
        $payload = $request->all();
        Log::info('Incoming attribute rows:', $payload);

        $validator = Validator::make($payload, [
            'product_id' => 'required|integer|exists:products,id',
            'rows' => 'required|array|min:1',
            'rows.*.color_id' => 'nullable|integer|exists:colors,id',
            'rows.*.attribute_value_id' => 'nullable',
            'rows.*.size_id'  => 'nullable|integer|exists:sizes,id',
            'rows.*.sku'      => 'nullable|string|max:255',
            'rows.*.mrp'      => 'nullable|numeric',
            'rows.*.price'    => 'nullable|numeric',
            'rows.*.qty'      => 'nullable|integer',
            'rows.*.length'   => 'nullable|string|max:50',
            'rows.*.breadth'  => 'nullable|string|max:50',
            'rows.*.height'   => 'nullable|string|max:50',
            'rows.*.weight'   => 'nullable|string|max:50',
            'rows.*.attribute_values' => 'nullable|array',
            'rows.*.attribute_values.*' => 'nullable|integer|exists:attribute_values,id',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 400, []);
        }

        $product = Product::findOrFail($payload['product_id']);

        DB::beginTransaction();
        try {
            $createdVariantIds = [];

            foreach ($payload['rows'] as $row) {
                // create variant in product_attrs
                $variant = ProductAttr::create([
                    'product_id' => $product->id,
                    'color_id'   => $row['color_id'] ?? null,
                    'size_id'    => $row['size_id'] ?? null,
                    'sku'        => $row['sku'] ?? null,
                    'mrp'        => $row['mrp'] ?? 0,
                    'price'      => $row['price'] ?? 0,
                    'qty'        => $row['qty'] ?? 0,
                    'length'     => $row['length'] ?? null,
                    'breadth'    => $row['breadth'] ?? null,
                    'height'     => $row['height'] ?? null,
                    'weight'     => $row['weight'] ?? null,
                ]);

                $createdVariantIds[] = $variant->id;

                // handle attribute_value_id and category_opt_id
                $attributeIds = $row['attribute_value_id'] ?? [];
                if (!is_array($attributeIds)) {
                    $attributeIds = [$attributeIds];
                }

                $categoryIds = $row['category_opt_id'] ?? [];
                if (!is_array($categoryIds)) {
                    $categoryIds = [$categoryIds];
                }

                if (empty(array_filter($attributeIds)) && empty(array_filter($categoryIds))) {
                    continue;
                }

                foreach ($attributeIds as $attrId) {
                    foreach ($categoryIds as $ctgId) {
                        if (!$attrId && !$ctgId) continue;

                        $exists = ProductAttribute::where('product_id', $product->id)
                            ->where('attribute_id', $attrId)
                            ->where('category_id', $ctgId)
                            ->exists();


                        if (!$exists) {
                            ProductAttribute::create([
                                'product_id' => $product->id,
                                'category_id' => $ctgId ?? null,
                                'attribute_id' => $attrId ?? null,
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            return $this->success([
                'product_id' => $product->id,
                'created_variant_ids' => $createdVariantIds,
                'next' => 'images',
                'reload' => true,
            ], 'Attributes saved successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Attribute save failed: ' . $e->getMessage());
            return $this->error('Failed to save attributes: ' . $e->getMessage(), 500, []);
        }
    }

    // 🟩 Store Attribute Images
    public function storeAttributeImages(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'product_attr_id' => 'required|exists:product_attrs,id',
            'attr_image' => 'required|array',
            'attr_image.*' => 'required|image|max:2048',
        ]);

        $productId = $request->product_id;
        $variantId = $request->product_attr_id;

        // 🧹 Step 1: Delete existing images for this variant
        $existingImages = ProductAttrImage::where('product_attr_id', $variantId)->get();

        foreach ($existingImages as $img) {
            // delete from storage
            if (\Storage::disk('public')->exists($img->image)) {
                \Storage::disk('public')->delete($img->image);
            }
            // delete from database
            $img->delete();
        }

        // 🆕 Step 2: Store new images
        $uploaded = [];
        foreach ($request->file('attr_image', []) as $image) {
            $path = $image->store('products/attribute_images', 'public');
            $uploaded[] = ProductAttrImage::create([
                'product_id' => $productId,
                'product_attr_id' => $variantId,
                'image' => $path,
            ]);
        }

        return $this->success([
            'status' => 'success',
            'message' => 'Attribute images updated successfully!',
            'data' => $uploaded,
        ], 'Image Addedd Successfully');
    }


    // 🟩 Store General Product Images
    public function storeImages(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'images.*' => 'required|image|max:5012',
        ]);

        $uploaded = [];
        foreach ($request->file('images', []) as $image) {
            $path = $image->store('/products', 'public');
            $uploaded[] = ProductImage::create([
                'product_id' => $request->product_id,
                'image_path' => $path,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Images uploaded successfully!',
            'data' => $uploaded,
        ]);
    }
}
