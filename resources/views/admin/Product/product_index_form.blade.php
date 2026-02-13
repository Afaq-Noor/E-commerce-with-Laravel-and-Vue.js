@extends('admin/layout')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-none d-md-block bg-light sidebar"></div>

            <!-- Main content -->
            <div class="col-md-9 col-lg-10 ms-sm-auto px-md-4">
                <div class="card border-top border-0 border-4 border-info mt-4">
                    <div class="card-body">
                        <div class="border p-4 rounded">
                            <div class="card-title d-flex align-items-center mb-3">
                                <i class="bx bxs-user me-2 font-22 text-info"></i>
                                <h5 class="mb-0 text-info">User Registration</h5>
                            </div>

                            <hr />

                            <!-- Tabs -->
                            <ul class="nav nav-tabs mb-3" id="productTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="basic-tab" data-bs-toggle="tab"
                                        data-bs-target="#basic" type="button" role="tab">Basic Info</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link disabled" id="attributes-tab" data-bs-toggle="tab"
                                        data-bs-target="#attributes" type="button" role="tab">Attributes</button>
                                </li>
                                {{-- <li class="nav-item" role="presentation">
                                    <button class="nav-link disabled" id="images-tab" data-bs-toggle="tab"
                                        data-bs-target="#product-images" type="button" role="tab">Images</button>
                                </li> --}}
                            </ul>

                            <div class="tab-content" id="productTabsContent">
                                <div class="tab-pane fade show active" id="basic" role="tabpanel">
                                    <form id="productBasicForm" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Product Name</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="name" class="form-control"
                                                    placeholder="Enter product name" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Slug</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="slug" class="form-control"
                                                    placeholder="Auto or manual slug">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Category</label>
                                            <div class="col-sm-9">
                                                <select name="category_id" class="form-select" id="categorySelect"
                                                    required>
                                                    <option value="">Select Category</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Brand</label>
                                            <div class="col-sm-9">
                                                <select name="brand_id" class="form-select" id="brandSelect"
                                                    required>
                                                    <option value="">Select Brand</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Tax</label>
                                            <div class="col-sm-9">
                                                <select name="tax_id" class="form-select " id="taxSelect" required>
                                                    <option value="">Select Tax</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">Image</label>
                                            <div class="col-sm-9">
                                                <input type="file" name="image" class="form-control" accept="image/*">
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

                                <!-- TAB 2: ATTRIBUTES -->
                                <div class="tab-pane fade" id="attributes" role="tabpanel">
                                    <div class="card border-top border-0 border-4 border-info mt-3">
                                        <div class="card-body">
                                            <h5 class="text-info mb-3">Product Attributes</h5>
                                            <form id="productAttributesForm">
                                                <input type="hidden" name="product_id" id="product_id">

                                                <div id="attributesTable" class="attributes-grid">
                                                    <div class="attributeRow row g-3 mb-3">
                                                        <div class="col-md-3">
                                                            <label>Color</label>
                                                            <select name="color_id[]"
                                                                class="form-control colorSelect"></select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label>Size</label>
                                                            <select name="size_id[]"
                                                                class="form-control sizeSelect"></select>
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

                                                <div class="mt-3 text-end">
                                                    <button type="button" class="btn btn-info" id="addRow">Add
                                                        More</button>
                                                    <button type="submit" class="btn btn-success">Save
                                                        Attributes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- TAB 3: IMAGES -->
                                {{-- <div class="tab-pane fade" id="product-images" role="tabpanel" aria-labelledby="product-images-tab">

                                    <form id="productImagesForm" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="product_id" id="image_product_id" value="{{ $product->id ?? '' }}">

                                        <div class="mb-3">
                                            <label class="form-label">Upload Product Images</label>
                                            <input type="file" name="images[]" id="imagesInput" class="form-control" multiple accept="image/*">
                                        </div>

                                        <!-- Preview section -->
                                        <div id="previewContainer" class="d-flex flex-wrap gap-2"></div>

                                        <button type="submit" class="btn btn-success mt-3">Save Images</button>
                                    </form>
                                </div> --}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Select2 CSS/JS -->
   
    <!-- Snackbar (node-snackbar) CSS/JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/node-snackbar/dist/snackbar.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/node-snackbar/dist/snackbar.min.js"></script>

    <script>
        $(document).ready(function() {
            const message = sessionStorage.getItem('flashMessage');
            if (message) {
                showAlert('Success', message);
                sessionStorage.removeItem('flashMessage'); // clear it
            }
            // ---------- utility & state ----------
            let colorsData = [];
            let attributeValueData = [];
            let categoryOptData = [];
            let sizesData = [];

            // ---------- snackbar helper (global) ----------
            function showAlert(status, message) {
                const text = typeof message === 'string' ? message : (message?.message || JSON.stringify(message));
                Snackbar.show({
                    text: `${status}: ${text}`,
                    pos: 'top-right',
                    actionText: 'Close',
                    duration: 4000,
                });
            }

            // ---------- helper: format color option ----------
            function formatColorOption(option) {
                if (!option || !option.id) return option && option.text ? option.text : '';
                const el = option.element;
                let colorCode = el ? $(el).data('color') : option.color;
                const text = option.text || '';
                const safeColor = colorCode || '#ffffff';
                return `
                    <span style="display:flex;align-items:center;gap:8px;">
                        <span style="
                            width:16px;height:16px;border-radius:50%;
                            background:${safeColor};border:1px solid #ccc;"></span>
                        ${text}
                    </span>`;
            }

            // ---------- init simple select2 ----------
            function initSimpleSelect2($select) {
                // safe init (only init if select2 not already applied)
                if (!$select || !$select.length) return;
                if ($select.hasClass('select2-hidden-accessible')) {
                    try {
                        $select.select2('destroy');
                    } catch (e) {}
                }
                
            }

            // ---------- refresh color selects ----------
            function refreshColorSelects($context = $(document)) {
                $context.find('.colorSelect').each(function() {
                    const select = $(this);
                    const prev = select.val() || null;
                    try {
                        if (select.hasClass('select2-hidden-accessible')) select.select2('destroy');
                    } catch (e) {}
                    select.empty().append('<option value="">Select Color</option>');
                    if (Array.isArray(colorsData) && colorsData.length) {
                        colorsData.forEach(c => {
                            // assuming each color has id, text, value (hex)
                            select.append(
                                `<option value="${c.id}" data-color="${c.value || ''}">${c.text || c.name || c.value}</option>`
                            );
                        });
                    }
                    
                    if (prev) select.val(prev).trigger('change');
                });
            }

            // ---------- refresh Attribute Value selects ----------
            function refreshAttributeValueSelects($context = $(document)) {
                $context.find('.attributeValueSelect').each(function() {
                    const select = $(this);
                    const prev = select.val() || null;
                    try {
                        if (select.hasClass('select2-hidden-accessible')) select.select2('destroy');
                    } catch (e) {}
                    select.empty().append('<option value="">Select Attribute(Value)</option>');
                    if (Array.isArray(attributeValueData) && attributeValueData.length) {
                        attributeValueData.forEach(a_v => {
                            // safe access: attribute may be nested or absent
                            const id = a_v.id ?? (a_v.attribute?.id ?? null);
                            const label = a_v.attribute?.name ?
                                `${a_v.attribute.name} (${a_v.value ?? ''})` : (a_v.value ?? a_v
                                    .name ?? `#${id}`);
                            select.append(`<option value="${id}">${label}</option>`);
                        });
                    }
                    initSimpleSelect2(select);
                    if (prev) select.val(prev).trigger('change');
                });
            }

            // ---------- refresh Category Value selects ----------
            function refreshCategoryOptSelects($context = $(document)) {
                $context.find('.categoryOptSelect').each(function() {
                    const select = $(this);
                    const prev = select.val() || null;
                    try {
                        if (select.hasClass('select2-hidden-accessible')) select.select2('destroy');
                    } catch (e) {}
                    select.empty().append('<option value="">Select Category</option>');
                    if (Array.isArray(categoryOptData) && categoryOptData.length) {
                        categoryOptData.forEach(ctg => {
                            select.append(`<option value="${ctg.id}">${ctg.name}</option>`);
                        });
                    }
                    initSimpleSelect2(select);
                    if (prev) select.val(prev).trigger('change');
                });
            }

            // ---------- refresh size selects ----------
            function refreshSizeSelects($context = $(document)) {
                $context.find('.sizeSelect').each(function() {
                    const select = $(this);
                    const prev = select.val() || null;
                    try {
                        if (select.hasClass('select2-hidden-accessible')) select.select2('destroy');
                    } catch (e) {}
                    select.empty().append('<option value="">Select Size</option>');
                    if (Array.isArray(sizesData) && sizesData.length) {
                        sizesData.forEach(s => select.append(
                            `<option value="${s.id}">${s.text ?? s.name ?? s.value}</option>`));
                    }
                    initSimpleSelect2(select);
                    if (prev) select.val(prev).trigger('change');
                });
            }

            // ---------- fetch colors & sizes & attributes & categories ----------
            function fetchAttributeData() {
                $.get('/admin/api/colors', res => {
                    if (res?.status === 'success' && Array.isArray(res.data)) {
                        colorsData = res.data;
                        refreshColorSelects();
                    }
                }).fail(() => console.warn('Failed to load colors'));

                $.get('/admin/api/attribute-value', res => {
                    if (res?.status === 'success' && Array.isArray(res.data)) {
                        attributeValueData = res.data;
                        refreshAttributeValueSelects();
                    }
                }).fail(() => console.warn('Failed to load attribute values'));

                $.get('/admin/get-categories', res => {
                    if (res?.status === 'success' && Array.isArray(res.data)) {
                        categoryOptData = res.data;
                        refreshCategoryOptSelects();
                    }
                }).fail(() => console.warn('Failed to load categories'));

                $.get('/admin/get-sizes', res => {
                    if (res?.status === 'success' && Array.isArray(res.data)) {
                        sizesData = res.data;
                        refreshSizeSelects();
                    }
                }).fail(() => console.warn('Failed to load sizes'));
            }

            // ---------- load categories/brands/taxes ----------
            function loadDropdowns() {
                $.get("{{ route('api.product.form-data') }}", response => {
                    if (response?.status === 'success') {
                        const {
                            categories = [], brands = [], taxes = []
                        } = response.data || {};

                        $('#categorySelect').empty().append('<option value="">Select Category</option>');
                        categories.forEach(c => $('#categorySelect').append(
                            `<option value="${c.id}">${c.name}</option>`));

                        $('#brandSelect').empty().append('<option value="">Select Brand</option>');
                        brands.forEach(b => $('#brandSelect').append(
                            `<option value="${b.id}">${b.name ?? b.text}</option>`));

                        $('#taxSelect').empty().append('<option value="">Select Tax</option>');
                        taxes.forEach(t => $('#taxSelect').append(
                            `<option value="${t.id}">${t.name ?? t.text} ${t.rate ? `(${t.rate}%)` : ''}</option>`
                        ));

                        initSimpleSelect2($('#categorySelect'));
                        initSimpleSelect2($('#brandSelect'));
                        initSimpleSelect2($('#taxSelect'));
                    } else {
                        showAlert('Error', 'Failed to load form dropdowns');
                    }
                }).fail(() => showAlert('Error', 'Network error while loading form dropdowns'));
            }

            // ---------- init ----------
            loadDropdowns();
            fetchAttributeData();

            // ---------- CSRF setup ----------
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // ---------- save basic form ----------
            $('#productBasicForm').on('submit', function(e) {
                e.preventDefault();
                // basic client validation
                if (!$('input[name="name"]').val()) {
                    showAlert('Error', 'Product name is required');
                    return;
                }
                const formData = new FormData(this);

                const $btn = $(this).find('button[type="submit"]');
                $.ajax({
                    url: "{{ route('products.store.basic') }}",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: () => $btn.prop('disabled', true).text('Saving...'),
                    success: res => {
                        if (res?.status === 'success') {
                            showAlert('Success', res.message);
                            
                            sessionStorage.setItem('flashMessage', res.message);
                            $('#product_id').val(res.data.product_id);
                            // also set hidden image product id for the images form
                            $('#image_product_id').val(res.data.product_id);
                            $('#attributes-tab, #images-tab').removeClass('disabled');
                            // switch to attributes tab
                            $('#attributes-tab').tab('show');
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

            // ---------- add new attribute row ----------
            $('#addRow').on('click', function() {
                const firstRow = $('#attributesTable .attributeRow:first');
                const newRow = firstRow.clone(true, true);

                // Clear inputs
                newRow.find('input').each(function() {
                    $(this).val('');
                });

                // Reset file input properly
                newRow.find('.attr-image-input').each(function() {
                    $(this).val('');
                });

                // Reset selects: destroy any Select2 attached and clear options selection
                newRow.find('select').each(function() {
                    const $s = $(this);
                    try {
                        if ($s.hasClass('select2-hidden-accessible')) $s.select2('destroy');
                    } catch (e) {}
                    $s.val('').trigger('change');
                });

                // append and reinitialize selects within newRow
                $('#attributesTable').append(newRow);

                // re-populate options & init select2 widgets for this row
                refreshColorSelects(newRow);
                refreshAttributeValueSelects(newRow);
                refreshCategoryOptSelects(newRow);
                refreshSizeSelects(newRow);
            });

            // ---------- remove attribute row ----------
            $(document).on('click', '.removeRow', function() {
                if ($('#attributesTable .attributeRow').length > 1) {
                    $(this).closest('.attributeRow').remove();
                } else {
                    showAlert('Error', 'At least one attribute row is required.');
                }
            });

            // ---------- save attributes ----------
            $('#productAttributesForm').on('submit', function(e) {
                e.preventDefault();
                const productId = $('#product_id').val();
                if (!productId) {
                    showAlert('Error', 'Please save Basic Info first.');
                    return;
                }

                const rows = [];
                $('#attributesTable .attributeRow').each(function() {
                    const $r = $(this);
                    // gather values - single selects per row
                    rows.push({
                        color_id: $r.find('.colorSelect').val() ? parseInt($r.find(
                            '.colorSelect').val()) : null,
                        attribute_value_id: $r.find('.attributeValueSelect').val() ?
                            parseInt($r.find('.attributeValueSelect').val()) : null,
                        size_id: $r.find('.sizeSelect').val() ? parseInt($r.find(
                            '.sizeSelect').val()) : null,
                        category_opt_id: $r.find('.categoryOptSelect').val() ? parseInt($r
                            .find('.categoryOptSelect').val()) : null,
                        sku: $r.find('input[name="sku[]"]').val() || null,
                        mrp: $r.find('input[name="mrp[]"]').val() ? Number($r.find(
                            'input[name="mrp[]"]').val()) : 0,
                        price: $r.find('input[name="price[]"]').val() ? Number($r.find(
                            'input[name="price[]"]').val()) : 0,
                        qty: $r.find('input[name="qty[]"]').val() ? parseInt($r.find(
                            'input[name="qty[]"]').val()) : 0,
                        length: $r.find('input[name="length[]"]').val() || null,
                        breadth: $r.find('input[name="breadth[]"]').val() || null,
                        height: $r.find('input[name="height[]"]').val() || null,
                        weight: $r.find('input[name="weight[]"]').val() || null,
                        // we will not include file content here — images uploaded after variants are created
                    });
                });

                if (rows.length === 0) {
                    showAlert('Error', 'Add at least one attribute row.');
                    return;
                }

                const $btn = $('#productAttributesForm button[type="submit"]');
                $btn.prop('disabled', true).text('Saving...');

                $.ajax({
                    url: "{{ route('products.attributes.store') }}",
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        product_id: productId,
                        rows
                    }),
                    success: res => {
                        if (res?.status === 'success') {
                            showAlert('Success', res.message);

                            // Upload images for each attribute row (if chosen)
                            const variantIds = res.data.created_variant_ids || [];

                            // match rows with DOM attributeRows by index
                            $('#attributesTable .attributeRow').each(function(index) {
                                const fileInputEl = $(this).find('.attr-image-input')[
                                    0];
                                const variantId = variantIds[index] ?? null;
                                if (fileInputEl && fileInputEl.files.length > 0 &&
                                    variantId) {
                                    const formData = new FormData();
                                    formData.append('product_attr_id', variantId);


                                    // ensure product_id included for reference
                                    formData.append('product_id', productId);
                                    Array.from(fileInputEl.files).forEach(f => formData
                                        .append('attr_image[]', f));

                                    $.ajax({
                                        url: "{{ route('products.attribute.images.store') }}",
                                        method: "POST",
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        success: res2 => {
                                            console.log(
                                                'Attribute image uploaded:',
                                                res2);
                                        },
                                        error: err => {
                                            console.error(
                                                'Image upload failed:',
                                                err);
                                        }
                                    });
                                }
                            });

                            if (res?.data.reload == true) {
                                location.reload();
                            }
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

            // ---------- Preview selected images before upload ----------
            $('#imagesInput').on('change', function() {
                $('#previewContainer').html('');
                const files = this.files;
                if (!files.length) return;
                Array.from(files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = e => {
                        $('#previewContainer').append(`
                            <div class="border p-1 rounded" style="width:100px; height:100px; overflow:hidden;">
                                <img src="${e.target.result}" alt="preview" class="img-fluid rounded" style="width:100%; height:100%; object-fit:cover;">
                            </div>
                        `);
                    };
                    reader.readAsDataURL(file);
                });
            });

            // ---------- Submit Images Form ----------
            $('#productImagesForm').on('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const $btn = $(this).find('button[type="submit"]');
                $.ajax({
                    url: "{{ route('products.images.store') }}",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: () => {
                        $btn.prop('disabled', true).text('Uploading...');
                    },
                    success: res => {
                        if (res?.status === 'success') {
                            showAlert('Success', res.message);
                            $('#imagesInput').val('');
                            $('#previewContainer').html('');
                        } else {
                            showAlert('Error', res?.message || 'Failed to upload images');
                        }
                    },
                    error: xhr => {
                        showAlert('Error', xhr.responseJSON?.message ||
                            'Server error during image upload');
                    },
                    complete: () => {
                        $btn.prop('disabled', false).text('Save Images');
                    }
                });
            });
        }); // END document.ready
    </script>
@endsection
