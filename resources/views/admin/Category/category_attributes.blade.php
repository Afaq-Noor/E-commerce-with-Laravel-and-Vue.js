@extends('admin/layout')


@section('content')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Category</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Category Name</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary">Settings</button>
                        <button type="button"
                            class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split"
                            data-bs-toggle="dropdown"> <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end"> <a class="dropdown-item"
                                href="javascript:;">Action</a>
                            <a class="dropdown-item" href="javascript:;">Another action</a>
                            <a class="dropdown-item" href="javascript:;">Something else here</a>
                            <div class="dropdown-divider"></div> <a class="dropdown-item" href="javascript:;">Separated
                                link</a>
                        </div>
                    </div>
                </div>
            </div>
            <h6 class="mb-0 text-uppercase">Category Name</h6>
            <div class="col">
                <button type="button" class="btn btn-outline-info px-5 radius-30"
                    onclick="saveData( 'new', '','', '' , '' , '', '')" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">Category Name</button>
            </div>
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Attribute Name</th>
                                    <th>Category Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $list)
                                    <tr>
                                        <td>{{ $list->id }}</td>
                                        <td>{{ $list->attribute->name }}</td>
                                        <td>{{ $list->category->name }}</td>
                                        <td> <button type="button"
                                                onclick="saveData('' , '{{ addslashes($list->id) }}', '{{ addslashes($list->attribute->id) }}' ,  '{{ addslashes($list->attribute->name) }}' , '{{ addslashes($list->category->id) }}' , '{{ addslashes($list->category->name) }}' )"
                                                class="btn btn-outline-info px-5 radius-30" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal">Update</button>
                                            <button
                                                onclick="deleteData('{{ addslashes($list->id) }}' , 'category_attributes')"
                                                class="btn btn-outline-danger px-5 radius-30">Delete</button>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Text</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>










    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Size</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formSubmit" action="{{ url('admin/update-category-attribute') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="card border-top border-0 border-4 border-info">
                            <div class="card-body">
                                <div class="border p-4 rounded">
                                    <div class="card-title d-flex align-items-center">
                                        <div><i class="bx bxs-user me-1 font-22 text-info"></i>
                                        </div>
                                        <h5 class="mb-0 text-info">Category Name</h5>
                                    </div>
                                    <hr>


                                 

                                    <div class="row mb-3">
                                        <label for="select_attribute_id" class="col-sm-3 col-form-label">Select Attribute
                                            Name</label>
                                        <div class="col-sm-9">
                                            <select class="form-select" name="select_attribute_id" id="select_attribute_id"
                                                aria-label="Default select example">
                                                <option selected>Click To See Option</option>
                                                @foreach ($data as $item)
                                                    <option value="{{ $item->attribute->id }}">{{ $item->attribute->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                         <div class="row mb-3">
                                        <label for="select_category_id" class="col-sm-3 col-form-label">Select Category
                                            Name</label>
                                        <div class="col-sm-9">
                                            <select class="form-select" name="select_category_id" id="select_category_id"
                                                aria-label="Default select example">
                                                <option selected>Click To See Option</option>
                                                @foreach ($data as $item)
                                                    <option value="{{ $item->category->id }}">{{ $item->category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                 

                                    <input type="hidden" name="id" id="enter_id" value="">
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <span id="submitButton">
                            <button type="submit" class="btn btn-info px-5">Save changes</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function saveData(nnew, id, attr_id , attr_name, ctg_id , ctg_name) {
           
          
            $('#enter_id').val(id);

            if (nnew === 'new') {
                // $('#category_name').attr('placeholder', 'Enter');
                // $('#category_slug').attr('placeholder', 'Enter');

                // ✅ Build dropdown options correctly
                let options = `<option selected>Click To See Option</option>`;
                @foreach ($attributes as $item)
                    options += `<option value="{{ $item->id }}">{{ $item->name }}</option>`;
                @endforeach

                 let options2 = `<option selected>Click To See Option</option>`;
                @foreach ($categories as $item)
                    options2 += `<option value="{{ $item->id }}">{{ $item->name }}</option>`;
                @endforeach


                $('#select_attribute_id').html(options);
                $('#select_category_id').html(options2)

            }
             else if (nnew === '') {
                // ✅ Make sure the dropdown selects the correct parent
                $('#select_attribute_id option').each(function() {
                    if (parseInt($(this).val()) == parseInt(attr_id)) {
                        $(this).prop('selected', true);
                    }
                });

                 $('#select_category_id option').each(function() {
                    if (parseInt($(this).val()) == parseInt(ctg_id)) {
                        $(this).prop('selected', true);
                    }
                });
                // $('#parent_category_id').trigger('change');


                // ✅ Optional: if you want to rename the selected option text dynamically
                // $('#parent_category_id option:selected').text(name);

                // $('#category_name').val(name);
                // $('#category_slug').val(slug);
            }


            // let key_image;
            // let baseUrl = "{{ URL::asset('') }}"; // this gives you e.g. https://example.com/image/

            // if (image == '') {
            //     key_image = "{{ URL::asset('image') }}/" + 'upload.png';
            // } else {
            //     key_image = baseUrl + image;
            // }
            // // Now use JS variable correctly
            // const htmll = `<img src="${key_image}" id="imgPreview" width="200px" height="150px" alt="upload">`;
            // $('#image_key').html(htmll);




        }
    </script>
@endsection
