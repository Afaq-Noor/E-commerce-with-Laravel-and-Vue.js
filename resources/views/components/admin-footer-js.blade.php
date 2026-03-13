<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<!--plugins-->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
<script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<script src="{{ asset('assets/plugins/chartjs/js/Chart.min.js') }}"></script>
<script src="{{ asset('assets/plugins/chartjs/js/Chart.extension.js') }}"></script>
<script src="{{ asset('assets/js/index.js') }}"></script>
<!--app JS-->
<script src="{{ asset('assets/js/app.js') }}"></script>

<script src="{{ asset('assets/dist/snackbar.js') }}"></script>
<!-- Js -->
<script src="https://code.jquery.com/jquery-3.6.1.min.js" crossorigin="anonymous">
    < script src = "https://developercodez.com/developerCorner/parsley/parsley.min.js" >
</script>


<script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/js/select2.full.js') }}"></script>

<script>
    $(document).ready(function() {
        $("#show_hide_password a").on('click', function(event) {
            event.preventDefault();
            if ($('#show_hide_password input').attr("type") == "text") {
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').addClass("bx-hide");
                $('#show_hide_password i').removeClass("bx-show");
            } else if ($('#show_hide_password input').attr("type") == "password") {
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass("bx-hide");
                $('#show_hide_password i').addClass("bx-show");
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#formSubmit').on('submit', function(e) {
            e.preventDefault();


            var formData = new FormData(this);
            var html =
                '<button class="btn btn-primary" type="button" disabled=""> <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...</button>';
            var html1 =
                '<input type="submit" id="" class="btn btn-primary px-4" value="Save Changes" />';
            $('#submitButton').html(html);

            $.ajax({
                type: 'POST',
                url: $('#formSubmit').attr('action'),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(result) {
                    if (result.status == 'success') {
                        showAlert(result.status, result.message)

                        $('#submitButton').html(html1);
                        if (result.data.reload === true) {
                            // alert('reload') ;
                            location.reload();
                        }
                    } else {
                        showAlert(result.status, result.message)
                        $('#submitButton').html(html);
                    }
                },
                error: function(xhr) {
                    $('#submitButton').html(html1);
                    let response = JSON.parse(xhr.responseText);

                    // alert(xhr ? 'xhr is received ✅'  + statuss  + messagge : 'xhr is undefined ❌');
                    // console.log('Error:', xhr.status, xhr.responseText);

                    showAlert(xhr.status, response.message)
                }
            });
        });
    });



function deleteData(id, table) {
    if (!confirm('Are you sure you want to delete this item?')) return;

    $.ajax({
        type: 'GET',
        url: 'admin/delete-data/'  + id + '/' + table,
        data: { _token: '{{ csrf_token() }}' },
        cache: false,
        success: function(result) {
            if (result.status === 'success') {
                showAlert(result.status, result.message);
                if (result.data.reload === true) location.reload();
            } else {
                showAlert(result.status, result.message);
            }
        },
        error: function(xhr) {
            let response = {};
            try {
                response = JSON.parse(xhr.responseText);
            } catch (e) {
                response.message = 'Something went wrong';
            }
            showAlert(xhr.status, response.message);
        }
    });
}

</script>







<script>
    function showAlert(status, message) {
        Snackbar.show({
            text: status + ' : ' + message,
            pos: 'top-right', // or 'top-right', 'bottom-center', etc.
            //   showAction: true,
            actionText: 'Close',
            duration: 5000, // 5 seconds
            // textColor: '#fff',
            // backgroundColor: '#6c42f5' // green for success
        });
    }
</script>

<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>
<script>
    $(document).ready(function() {
        var table = $('#example2').DataTable({
            lengthChange: false,
            buttons: ['copy', 'excel', 'pdf', 'print']
        });

        table.buttons().container()
            .appendTo('#example2_wrapper .col-md-6:eq(0)');
    });
</script>


<script>
    // 🟢 Event listener for file input change
    $('#photo').off('change').on('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#imgPreview').attr('src', e.target.result);
            };
            reader.readAsDataURL(file);
        } else {
            // If no file selected (user cancels), show default upload.png again
            $('#imgPreview').attr('src', "{{ URL::asset('image/upload.png') }}");
        }
    }); // ← you missed this closing parenthesis + semicolon
</script>
