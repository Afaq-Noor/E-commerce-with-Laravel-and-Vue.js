@extends('admin/layout')


@section('content')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Attribute</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Attribute Value</li>
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
            <h6 class="mb-0 text-uppercase">Attribute Value</h6>
            <div class="col">
                <button type="button" class="btn btn-outline-info px-5 radius-30" onclick="saveData('','0', '' , '')"
                    data-bs-toggle="modal" data-bs-target="#exampleModal">Attribute Value</button>
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
                                    <th>Value</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $list)
                                    <tr>
                                        <td>{{ $list->id }}</td>
                                        <td>{{ $list->attribute->name }}</td>
                                        <td>{{ $list->value }}</td>
                                        <td> <button type="button"
                                                onclick="saveData('{{ addslashes($list->id) }}', '{{ addslashes($list->attributes_id) }}' ,  '{{ addslashes($list->attribute->name) }}' , '{{ addslashes($list->value) }}')"
                                                class="btn btn-outline-info px-5 radius-30" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal">Update</button>
                                            <button
                                                onclick="deleteData('{{ addslashes($list->id) }}' , 'attribute_values')"
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
                <form id="formSubmit" action="{{ url('admin/update-attribute-value') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="card border-top border-0 border-4 border-info">
                            <div class="card-body">
                                <div class="border p-4 rounded">
                                    <div class="card-title d-flex align-items-center">
                                        <div><i class="bx bxs-user me-1 font-22 text-info"></i>
                                        </div>
                                        <h5 class="mb-0 text-info">Attribue Value</h5>
                                    </div>
                                    <hr>

                                    <div class="row mb-3">
                                        <label for="attribute_name_id" class="col-sm-3 col-form-label">Select Attribute
                                            Name</label>
                                        <div class="col-sm-9">
                                            <select class="form-select" name="attribute_name_id" id="attribute_name_id"
                                                aria-label="Default select example">
                                                <option value="0" selected>Click To See Option</option>
                                                @foreach ($attribute_name as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="attribute_value" class="col-sm-3 col-form-label">Enter Attribute
                                            Value</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="attribute_value"
                                                id="attribute_value" placeholder="Enter Attribute Value">
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
        function saveData(id, attribute_id, attribute_name, attribute_value) {

            $('#enter_id').val(id)

            $('#attribute_name_id').val(attribute_id);
            if (attribute_id == '0') {
                $('#attribute_name_id option:selected').val('0');
            } else {
                $('#attribute_name_id option:selected').text(attribute_name);
                $('#attribute_value').val(attribute_value);
                $('#enter_id').val(id)

            }




        }
    </script>
@endsection
