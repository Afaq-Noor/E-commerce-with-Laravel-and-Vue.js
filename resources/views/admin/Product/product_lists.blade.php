@extends('admin.layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            {{-- PRODUCT TABLE --}}
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-3">Product List</h5>
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Action</th>
                                    <th>Brand</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Color</th>
                                    <th>Size</th>
                                    <th>MRP</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Height</th>
                                    <th>Weight</th>
                                    <th>Tax</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($product_lists as $product)
                                    @php
                                        $variants = $product->productAttr;
                                        $variantCount = $variants->count();
                                    @endphp

                                    <tr>
                                        <td>{{ $product->id }}</td>

                                        <td>
                                            <button type="button" class="btn btn-outline-info px-4 radius-30"
                                                data-bs-toggle="modal" data-bs-target="#productModal"
                                                onclick="fetchData({{ $product->id }})">
                                                Update
                                            </button>
                                            <button onclick="deleteData('{{ addslashes($product->id) }}' , 'products')"
                                                class="btn btn-outline-danger px-5 radius-30">Delete</button>
                                        </td>
                                        </td>

                                        <td>{{ $product->brand->text ?? '-' }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->slug }}</td>

                                        <td>
                                            @if ($product->image)
                                                <img src="{{ asset($product->image) }}" width="60" height="60"
                                                    alt="Product Image">
                                            @else
                                                No Image
                                            @endif
                                        </td>

                                        <td>

                                            @php
                                                if ($product->status == '1') {
                                                    $isActive = true;
                                                } else {
                                                    $isActive = false;
                                                }
                                            @endphp
                                            <span class="badge {{ $isActive ? 'bg-success' : 'bg-danger' }}">
                                                {{ $isActive ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>

                                        {{-- COLOR --}}
                                        <td>
                                            @foreach ($variants->take(2) as $attr)
                                                <div>
                                                    {{ $attr->color->text ?? '-' }}
                                                    <span
                                                        style="display:inline-block; width:20px; height:20px; background-color:{{ $attr->color->value ?? '#ccc' }}; border:1px solid #aaa; border-radius:4px; vertical-align:middle;"></span>
                                                </div>
                                            @endforeach

                                            @if ($variantCount > 2)
                                                <small class="text-muted fst-italic">
                                                    1 +{{ $variantCount - 2 }} more — click update to see
                                                </small>
                                            @endif
                                        </td>

                                        {{-- SIZE --}}
                                        <td>
                                            @foreach ($variants->take(2) as $attr)
                                                <div>{{ $attr->size->text ?? '-' }}</div>
                                            @endforeach
                                            @if ($variantCount > 2)
                                                <small
                                                    class="text-muted
                                                    fst-italic">
                                                    +{{ $variantCount - 2 }} more click update to see
                                                </small>
                                            @endif
                                        </td>

                                        {{-- MRP --}}
                                        <td>
                                            @foreach ($variants->take(2) as $attr)
                                                <div>{{ $attr->mrp ?? '-' }}</div>
                                            @endforeach
                                            @if ($variantCount > 2)
                                                <small class="text-muted fst-italic">
                                                    +{{ $variantCount - 2 }} more click update to see
                                                </small>
                                            @endif
                                        </td>

                                        {{-- PRICE --}}
                                        <td>
                                            @foreach ($variants->take(2) as $attr)
                                                <div>{{ $attr->price ?? '-' }}</div>
                                            @endforeach
                                            @if ($variantCount > 2)
                                                <small class="text-muted fst-italic">
                                                    +{{ $variantCount - 2 }} more click update to see
                                                </small>
                                            @endif
                                        </td>

                                        {{-- QTY --}}
                                        <td>
                                            @foreach ($variants->take(2) as $attr)
                                                <div>{{ $attr->qty ?? '-' }}</div>
                                            @endforeach
                                            @if ($variantCount > 2)
                                                <small class="text-muted fst-italic">
                                                    +{{ $variantCount - 2 }} more click update to see
                                                </small>
                                            @endif
                                        </td>

                                        {{-- HEIGHT --}}
                                        <td>
                                            @foreach ($variants->take(2) as $attr)
                                                <div>{{ $attr->height ?? '-' }}</div>
                                            @endforeach
                                            @if ($variantCount > 2)
                                                <small class="text-muted fst-italic">
                                                    +{{ $variantCount - 2 }} more click update to see
                                                </small>
                                            @endif
                                        </td>

                                        {{-- WEIGHT --}}
                                        <td>
                                            @foreach ($variants->take(2) as $attr)
                                                <div>{{ $attr->weight ?? '-' }}</div>
                                            @endforeach
                                            @if ($variantCount > 2)
                                                <small class="text-muted fst-italic">
                                                    +{{ $variantCount - 2 }} more click update to see
                                                </small>
                                            @endif
                                        </td>

                                        {{-- TAX --}}
                                        <td>{{ $product->tax->text ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Update Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <!-- Basic Info Tab -->
                            <ul class="nav nav-tabs mb-3" id="productTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="basic-tab" data-bs-toggle="tab"
                                        data-bs-target="#basic" type="button" role="tab">Basic Info</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="attributes-tab" data-bs-toggle="tab"
                                        data-bs-target="#attributes" type="button" role="tab">Attributes</button>
                                </li>
                            </ul>

                            <div class="tab-content" id="productTabsContent">
                                <div class="tab-pane fade show active" id="basic" role="tabpanel">
                                    <form id="productBasicForm" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="id" id="basic_product_id">

                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Product Name</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="name" id="product_name" class="form-control"
                                                    placeholder="Enter product name" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Slug</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="slug" id="product_slug" class="form-control"
                                                    placeholder="Auto or manual slug">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Category</label>
                                            <div class="col-sm-9">
                                                <select id="product_ctg" name="category_id" class="form-select "></select>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Brand</label>
                                            <div class="col-sm-9">
                                                <select id="product_brand" name="brand_id" class="form-select "></select>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Tax</label>
                                            <div class="col-sm-9">
                                                <select id="product_tax" name="tax_id" class="form-select "></select>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Status</label>
                                            <div class="col-sm-9">
                                                <select id="product_tax" name="status"
                                                    class="form-select statusSelect"></select>
                                            </div>
                                        </div>


                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Image</label>
                                            <div class="col-sm-9">
                                                <input type="file" name="image" id="product_image"
                                                    class="form-control" accept="image/*">

                                                <!-- Image preview container -->
                                                <div id="image_preview_container" class="mt-3"
                                                    style="position: relative; display: none;">
                                                    <img id="image_preview" src="" alt="Product Image"
                                                        width="120" class="rounded border">
                                                    <button type="button" id="remove_image_btn"
                                                        class="btn btn-sm btn-danger"
                                                        style="position:absolute; top:-8px; right:-8px; border-radius:50%; padding:0 6px;">&times;</button>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Keywords</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="keywords" class="form-control"
                                                    placeholder="SEO keywords">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Description</label>
                                            <div class="col-sm-9">
                                                <textarea name="description" class="form-control" rows="3"></textarea>
                                            </div>
                                        </div>

                                        <div class="text-end">
                                            <button type="submit" class="btn btn-info px-4">Save & Continue</button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Attributes Tab -->
                                <div class="tab-pane fade" id="attributes" role="tabpanel">
                                    <form id="productAttributesForm" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="id" id="attributes_product_id">
                                        <input type="hidden" name="deleted_variant_ids" id="deleted_variant_ids">
                                        <div id="attributesTable" class="attributes-grid">
                                            <div class="attributeRow row g-3 mb-3 d-none" id="attributeRowTemplate">
                                                <input type="hidden" class="product_variant_id"
                                                    name="product_variant_id[]">

                                                <div class="col-md-3">
                                                    <label>Color</label>
                                                    <select name="color_id[]" class="form-control colorSelect"></select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Size</label>
                                                    <select name="size_id[]" class="form-control sizeSelect"></select>
                                                </div>

                                                <div class="col-md-3">
                                                    <label>Available Attribute (Value)</label>
                                                    <select name="attribute_value_id[]"
                                                        class="form-control attributeValueSelect"></select>
                                                </div>

                                                <div class="col-md-3">
                                                    <label>Image</label>
                                                    <input type="file" name="attr_image[]"
                                                        class="form-control attr-image-input" accept="image/*">

                                                    <!-- Existing images will be appended here dynamically -->
                                                    <div class="existing-images mt-2"></div>
                                                </div>

                                                <div class="col-md-3">
                                                    <label>SKU</label>
                                                    <input type="text" name="sku[]" class="form-control">
                                                </div>
                                                <div class="col-md-3">
                                                    <label>MRP</label>
                                                    <input type="number" name="mrp[]" class="form-control"
                                                        min="0" step="0.01">
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Price</label>
                                                    <input type="number" name="price[]" class="form-control"
                                                        min="0" step="0.01">
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Qty</label>
                                                    <input type="number" name="qty[]" class="form-control"
                                                        min="0">
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Length</label>
                                                    <input type="number" name="length[]" class="form-control"
                                                        min="0" step="0.01">
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Breadth</label>
                                                    <input type="number" name="breadth[]" class="form-control"
                                                        min="0" step="0.01">
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Height</label>
                                                    <input type="number" name="height[]" class="form-control"
                                                        min="0" step="0.01">
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Weight</label>
                                                    <input type="number" name="weight[]" class="form-control"
                                                        min="0" step="0.01">
                                                </div>

                                                <div class="col-md-3 d-flex align-items-end">
                                                    <button type="button"
                                                        class="btn btn-danger removeRow w-100">Remove</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            <button type="button" class="btn btn-info" id="addRow">Add More</button>
                                            <button type="submit" class="btn btn-success">Save Attributes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script>
        $(document).ready(function() {
            const message = sessionStorage.getItem('flashMessage');
            if (message) {
                showAlert('Success', message);
                sessionStorage.removeItem('flashMessage'); // clear it
            }
            // ✅ Global storage for dropdown data
            let globalColors = [];
            let globalSizes = [];
            let globalAttributeValues = [];
            let deletedVariantIds = [];

            // Reset modal form on show
            $('#productModal').on('show.bs.modal', function() {
                $(this).find('form')[0].reset();
                $('#attributesTable .attributeRow:not(#attributeRowTemplate)').remove();
            });

            let productFormm = $(this);
            // ✅ Fetch product and variants
            window.fetchData = function(product_id) {
                $.get(`/admin/product/fetch-attr/${product_id}`, function(response) {

                    const product = response.data.product;
                    const variants = response.data.variants;
                    const colors = response.data.colors;
                    const sizes = response.data.sizes;
                    const attributeValues = response.data.attribute_values;

                    // ✅ Store globally for later use
                    globalColors = colors || [];
                    globalSizes = sizes || [];
                    globalAttributeValues = attributeValues || [];

                    // Basic Info Section
                    const existingImage = product.image;
                    $('#basic_product_id').val(product.id);
                    $('#product_name').val(product.name);
                    $('#product_slug').val(product.slug);


                    const statusSelect = productFormm.find('.statusSelect');

                    // clear and add options
                    statusSelect.empty()
                        .append('<option value="">Select Status</option>')
                        .append('<option value="1">Active</option>')
                        .append('<option value="0">Inactive</option>');

                    // set selected option based on variant.status
                    if (product.status == '1') {
                        statusSelect.val('1'); // Active
                    } else {
                        statusSelect.val('0'); // Inactive
                    }

                    if (existingImage) {
                        $('#image_preview').attr('src', '/' + existingImage);
                        $('#image_preview_container').show();
                    }

                    // Image preview change
                    $('#product_image').on('change', function() {
                        const file = this.files[0];
                        if (file) {
                            $('#image_preview').attr('src', URL.createObjectURL(file));
                            $('#image_preview_container').show();
                        }
                    });

                    // Remove image
                    $('#remove_image_btn').on('click', function() {
                        $('#image_preview').attr('src', '');
                        $('#image_preview_container').hide();
                        $('#product_image').val('');
                    });

                    $('#attributes_product_id').val(product.id);
                    $('#attributesTable .attributeRow:not(#attributeRowTemplate)').remove();

                    // ✅ Add rows (existing or empty)
                    if (variants && variants.length > 0) {
                        variants.forEach(v => addVariantRow(v, globalColors, globalSizes,
                            globalAttributeValues));
                    } else {
                        addVariantRow({}, globalColors, globalSizes, globalAttributeValues);
                    }

                    populateDropdowns(product.category_id, product.brand_id, product.tax_id);
                });
            };

            // ✅ Populate category/brand/tax dropdowns
            function populateDropdowns(selectedCategoryId, selectedBrandId, selectedTaxId) {
                const categories = $.get('/admin/get-categories');
                const brands = $.get('/admin/get-brands/');
                const taxes = $.get('/admin/get-taxes');

                return Promise.all([categories, brands, taxes]).then(([catRes, brandRes, taxRes]) => {

                    if (catRes.status === 'success') {
                        const select = $('#product_ctg');
                        select.empty().append('<option value="">Select Category</option>');
                        catRes.data.forEach(ctg => select.append(
                            `<option value="${ctg.id}">${ctg.name}</option>`));
                        if (selectedCategoryId) select.val(selectedCategoryId);
                    }

                    if (brandRes.status === 'success') {
                        const select = $('#product_brand');
                        select.empty().append('<option value="">Select Brand</option>');
                        brandRes.data.forEach(b => select.append(
                            `<option value="${b.id}">${b.text}</option>`));
                        if (selectedBrandId) select.val(selectedBrandId);
                    }

                    if (taxRes.status === 'success') {
                        $('#product_tax').empty().append('<option value="">Select Tax</option>');
                        taxRes.data.forEach(t => $('#product_tax').append(
                            `<option value="${t.id}">${t.text}</option>`));
                        if (selectedTaxId) $('#product_tax').val(selectedTaxId);
                    }
                });
            }

            // ✅ Add Variant Row
            function addVariantRow(
                variant = {},
                colors = globalColors,
                sizes = globalSizes,
                attributeValues = globalAttributeValues
            ) {
                const newRow = $('#attributeRowTemplate')
                    .clone()
                    .removeAttr('id')
                    .removeClass('d-none');

                $('#attributesTable').append(newRow);

                // Fill Color dropdown
                const colorSelect = newRow.find('.colorSelect');
                colorSelect.empty().append('<option value="">Select Color</option>');
                (colors || []).forEach(c => colorSelect.append(`<option value="${c.id}" style="background-color:${c.value};">
                     ${c.text}</option>`));
                if (variant.color_id) colorSelect.val(variant.color_id);

                // Fill Size dropdown
                const sizeSelect = newRow.find('.sizeSelect');
                sizeSelect.empty().append('<option value="">Select Size</option>');
                (sizes || []).forEach(s => sizeSelect.append(`<option value="${s.id}">${s.text}</option>`));
                if (variant.size_id) sizeSelect.val(variant.size_id);

                const statusSelect = newRow.find('.statusSelect');




                // Fill Attribute Value dropdown
                const attrValueSelect = newRow.find('.attributeValueSelect');
                attrValueSelect.empty().append('<option value="">Select Attribute</option>');
                (attributeValues || []).forEach(a => attrValueSelect.append(
                    `<option value="${a.id}">${a.value}</option>`));
                if (variant.attribute_value_id) attrValueSelect.val(variant.attribute_value_id);

                // Fill inputs
                newRow.find('input[name="product_variant_id[]"]').val(variant.id || '');
                newRow.find('input[name="sku[]"]').val(variant.sku || '');
                newRow.find('input[name="mrp[]"]').val(variant.mrp || '');
                newRow.find('input[name="price[]"]').val(variant.price || '');
                newRow.find('input[name="qty[]"]').val(variant.qty || '');
                newRow.find('input[name="length[]"]').val(variant.length || '');
                newRow.find('input[name="breadth[]"]').val(variant.breadth || '');
                newRow.find('input[name="height[]"]').val(variant.height || '');
                newRow.find('input[name="weight[]"]').val(variant.weight || '');

                // Existing images
                const imageContainer = newRow.find('.existing-images');
                imageContainer.empty();
                if (variant.images && variant.images.length > 0) {
                    variant.images.forEach(img => {
                        imageContainer.append(`
                        <div class="d-inline-block me-2 position-relative">
                            <img src="/storage/${img.image.replace('public/', '')}" width="60" height="60" class="rounded border">
                        </div>
                    `);
                    });
                }
            }

            // ✅ Add Row Button
            $('#addRow').on('click', function() {
                addVariantRow({}, globalColors, globalSizes, globalAttributeValues);
            });

            // ✅ Remove Row Button
            $(document).on('click', '.removeRow', function() {
                const variantId = $(this).closest('.attributeRow').find('.product_variant_id').val();
                if (variantId) {
                    deletedVariantIds.push(parseInt(variantId));
                    $('#deleted_variant_ids').val(JSON.stringify(deletedVariantIds));
                }
                $(this).closest('.attributeRow').remove();
            });

            // ✅ Snackbar alert
            function showAlert(status, message) {
                Snackbar.show({
                    text: `${status}: ${message}`,
                    pos: 'top-right',
                    actionText: 'Close',
                    duration: 3000
                });
            }

            // ✅ Save Basic Form
            $('#productBasicForm').on('submit', function(e) {
                e.preventDefault();
                if (!$('input[name="name"]').val()) {
                    showAlert('Error', 'Product name is required');
                    return;
                }

                const formData = new FormData(this);
                const $btn = $(this).find('button[type="submit"]');
                // 🟦 Collect selected files BEFORE sending main AJAX request
                let selectedFiles = [];
                $('#attributesTable .attributeRow').each(function() {
                    const fileInputEl = $(this).find('.attr-image-input')[0];
                    selectedFiles.push(fileInputEl && fileInputEl.files.length > 0 ? fileInputEl
                        .files : null);
                });
                $.ajax({
                    url: "{{ route('products.store.basic') }}",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: () => $btn.prop('disabled', true).text('Saving...'),
                    success: res => {
                        if (res?.status === 'success') {
                            // Save message in sessionStorage (temporary browser storage)
                            sessionStorage.setItem('flashMessage', res.message);


                            if (res?.data.reload == true) {
                                location.reload();
                            }
                            $('#attributes_product_id').val(res.data.product_id);
                        } else {
                            showAlert('Error', res.message || 'Unexpected response');
                        }
                    },
                    error: xhr => {
                        showAlert('Error', xhr.responseJSON?.message ||
                            'Something went wrong!');
                    },
                    complete: () => $btn.prop('disabled', false).text('Save & Continue')
                });
            });

            // ✅ Save Attributes
            $('#productAttributesForm').on('submit', function(e) {
                e.preventDefault();

                const productId = $('#attributes_product_id').val();
                const deletedVariantId = $('#deleted_variant_ids').val();

                if (!productId) {
                    showAlert('Error', 'Basic Info Product Id is missing.');
                    return;
                }

                const rows = [];
                const selectedFiles = [];
                $('#attributesTable .attributeRow').each(function() {
                    const $r = $(this);
                    const sku = $r.find('input[name="sku[]"]').val();
                    const color = $r.find('.colorSelect').val();
                    const size = $r.find('.sizeSelect').val();

                    if (!sku && !color && !size) return;

                    rows.push({
                        product_variant_id: $r.find('.product_variant_id').val() ? parseInt(
                            $r.find('.product_variant_id').val()) : null,
                        color_id: $r.find('.colorSelect').val() ? parseInt($r.find(
                            '.colorSelect').val()) : null,
                        attribute_value_id: $r.find('.attributeValueSelect').val() ?
                            parseInt($r.find('.attributeValueSelect').val()) : null,
                        size_id: $r.find('.sizeSelect').val() ? parseInt($r.find(
                            '.sizeSelect').val()) : null,
                        sku: sku || null,
                        mrp: Number($r.find('input[name="mrp[]"]').val()) || 0,
                        price: Number($r.find('input[name="price[]"]').val()) || 0,
                        qty: parseInt($r.find('input[name="qty[]"]').val()) || 0,
                        length: $r.find('input[name="length[]"]').val() || null,
                        breadth: $r.find('input[name="breadth[]"]').val() || null,
                        height: $r.find('input[name="height[]"]').val() || null,
                        weight: $r.find('input[name="weight[]"]').val() || null
                    });
                    // ✅ collect file input for this row
                    // ✅ Safe file input check
                    const fileInputEl = $r.find('.attr-image-input')[0];
                    if (fileInputEl && fileInputEl.files && fileInputEl.files.length > 0) {
                        selectedFiles.push(fileInputEl.files);
                    } else {
                        selectedFiles.push(null);
                    }
                });



                if (rows.length === 0) {
                    showAlert('Error', 'Add at least one attribute row.');
                    return;
                }

                const $btn = $('#productAttributesForm button[type="submit"]');
                $btn.prop('disabled', true).text('Saving...');
                console.log($('.attr-image-input')[0].files.length);

                $.ajax({
                    url: "{{ route('products.attributes.update') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: 'application/json',
                    data: JSON.stringify({
                        product_id: productId,
                        deletedVariantId: deletedVariantId,
                        rows
                    }),
                    success: res => {
                        if (res?.status === 'success') {
                            showAlert('Success', res.message);
                            console.log(selectedFiles);
                            const variantIds = res.data.created_variant_ids || [];
                            console.log(variantIds);
                            // Use saved files now
                            $('#attributesTable .attributeRow').each(function(index) {
                                const files = selectedFiles[index];
                                const variantId = variantIds[index] || null;

                                if (files && files.length > 0 && variantId) {
                                    const formData = new FormData();
                                    formData.append('product_attr_id', variantId);
                                    formData.append('product_id', productId);
                                    Array.from(files).forEach(f => formData.append(
                                        'attr_image[]', f));


                                    $.ajax({
                                        url: "{{ route('products.attribute.images.store') }}",
                                        method: "POST",
                                        headers: {
                                            'X-CSRF-TOKEN': $(
                                                    'meta[name="csrf-token"]')
                                                .attr('content')
                                        },
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        success: res2 => {
                                            showAlert('Success',
                                                'Image Added');

                                        },
                                        error: err => {
                                            alert('not image')
                                            console.error(
                                                'Image upload failed:',
                                                err);
                                        }
                                    });
                                }
                            });

                            sessionStorage.setItem('flashMessage', res.message);
                            if (res?.data.reload == true) {
                                location.reload();
                            }
                            // $('#images-tab').removeClass('disabled');
                            // $('#images-tab').tab('show');
                        } else {
                            showAlert('Error', res.message || 'Unable to save attributes');
                        }
                    },
                    error: xhr => {
                        showAlert('Error', xhr.responseJSON?.message ||
                            'Server error while saving attributes');
                    },
                    complete: () => $btn.prop('disabled', false).text('Save Attributes')
                });
            });
        });
    </script>
@endsection
