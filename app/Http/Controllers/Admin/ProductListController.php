<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttributeValue;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductAttr;
use App\Models\Size;
use Illuminate\Http\Request;

use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductListController extends Controller
{
    use ApiResponse;
    public function product_lists()
    {
        // $product_attr = ProductAttr::get();
        $product_lists = Product::with([
            'category',
            'brand',
            'tax',
            'productAttr.color',
            'productAttr.size'
        ])
            ->orderByDesc('id')
            ->get();


        return view('admin/Product/product_lists', get_defined_vars());
    }


    public function fetchProducts()
    {
        $product_lists = Product::with([
            'category',
            'brand',
            'tax',
            'productAttr.color',
            'productAttr.size'
        ])
            ->latest()
            ->get();

        return view('admin.partials.product_table_rows', compact('product_lists'));
    }


    public function fetchAttr($prd_id)
    {

        // Fetch product and its specific attribute
        // $product = Product::with([
        //     'brand',
        //     'tax',
        //     'category',
        //     'productAttr.color', // 👈 includes color info
        //     'productAttr.size',  // 👈 includes size info
        //     'productAttr.attributeValue',  // 👈 includes size info
        //     'productAttr.images',
        // ])->findOrFail($prd_id);
        $query = Product::with([
            'brand',
            'tax',
            'category',
            'productAttr.color', // 👈 includes color info
            'productAttr.size',
            'productAttr.attributeValue',
            'productAttr.images',
        ]);

        if ($prd_id) {
            // if product_id is provided → get single product
            $product = $query->find($prd_id);
        } else {
            // if product_id is not provided → get all products
            $product = $query->get();
        }
        if (!$product) {
            return $this->error('Data Not Found', 400, []);
        } else {
            // ✅ Fetch all available dropdown data
            $colors = Color::get();

            $sizes = Size::get();

            // If you have a model for attribute values (maybe AttributeValue or similar)
            $attributeValues = AttributeValue::get();

            // Return both as JSON
            return $this->success([
                'product' => $product,
                'variants' => $product->productAttr,
                'colors' => $colors,
                'sizes' => $sizes,
                'attribute_values' => $attributeValues,
            ], 'Data Fatched Successfully');
        }
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
            'rows.*.size_id'  => 'required|integer|exists:sizes,id',
            'rows.*.sku'      => 'required|string|max:255',
            'rows.*.mrp'      => 'required|numeric',
            'rows.*.price'    => 'required|numeric',
            'rows.*.qty'      => 'required|integer',
            'rows.*.length'   => 'required|string|max:50',
            'rows.*.breadth'  => 'required|string|max:50',
            'rows.*.height'   => 'required|string|max:50',
            'rows.*.weight'   => 'required|string|max:50',
            'rows.*.attribute_values' => 'nullable|array',
            'rows.*.attribute_values.*' => 'nullable|integer|exists:attribute_values,id',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 400, []);
        }

        $product = Product::findOrFail($payload['product_id']);

        DB::beginTransaction();
        try {
            // 1. Handle deleted variants
            $deletedVariantIds = json_decode($request->input('deletedVariantId'), true);
            if (!empty($deletedVariantIds)) {
                ProductAttr::whereIn('id', $deletedVariantIds)->delete();
            }
            $createdVariantIds = [];

            foreach ($payload['rows'] as $row) {

                // create variant in product_attrs
                $variant = ProductAttr::updateOrCreate(
                    ['id' => $row['product_variant_id']],
                    [
                        'product_id' => $product->id,
                        'color_id'   => $row['color_id'] ?? null,
                        'attribute_value_id' => $row['attribute_value_id'] ?? null,
                        'size_id'    => $row['size_id'] ?? null,
                        'sku'        => $row['sku'] ?? null,
                        'mrp'        => $row['mrp'] ?? 0,
                        'price'      => $row['price'] ?? 0,
                        'qty'        => $row['qty'] ?? 0,
                        'length'     => $row['length'] ?? null,
                        'breadth'    => $row['breadth'] ?? null,
                        'height'     => $row['height'] ?? null,
                        'weight'     => $row['weight'] ?? null,
                    ]
                );

                $createdVariantIds[] = $variant->id;

                // handle attribute_value_id and category_opt_id
                $attributeIds = $row['attribute_value_id'] ?? [];
                if (!is_array($attributeIds)) {
                    $attributeIds = [$attributeIds];
                }


                if (empty(array_filter($attributeIds))) {
                    continue;
                }

                // foreach ($attributeIds as $attrId) {
                //         if (!$attrId) continue;

                // $exists = ProductAttribute::where('product_id', $product->id)
                //     ->where('attribute_id', $attrId)
                //     ->exists();


                //     if (!$exists) {
                //         ProductAttribute::create([
                //             'product_id' => $product->id,
                //             'category_id' => $ctgId ?? null,
                //             'attribute_id' => $attrId ?? null,
                //         ]);

                // }
                // }
            }

            DB::commit();

            return $this->success([
                'product_id' => $product->id,
                'created_variant_ids' => $createdVariantIds,
                'next' => 'images',
                 'reload' => true ,
            ], 'Attributes saved successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Attribute save failed: ' . $e->getMessage());
            return $this->error('Failed to save attributes: ' . $e->getMessage(), 500, []);
        }
    }
}
