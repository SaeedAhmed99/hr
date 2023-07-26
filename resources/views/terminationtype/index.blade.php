@extends('layouts.app')
@section('page-title')
    {{ __('Termination Type') }}
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">All Termination Type</p>
                        <button data-bs-toggle="modal" data-bs-target="#add_terminationType_modal" class="btn btn-gray"><i
                                class="fa-solid fa-plus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="terminationType" class="table table-condensed">
                        <thead>
                            <tr>
                                <th>{{ __('Termination Type') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    {{--  add modal start  --}}
    <div class="modal fade" tabindex="-1" id="add_terminationType_modal">
        <div class="modal-dialog">
            <form action="" id="add_terminationType_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Termination Type</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">

                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter Termination Type" aria-describedby="name_invalid">
                                <div id="name_invalid" class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{--  edit modal start  --}}
    <div class="modal fade" tabindex="-1" id="edit_terminationType_modal">
        <div class="modal-dialog">
            <form action="" id="update_terminationType_form">
                <input type="hidden" id="_method" name="_method" value="patch">
                <input type="hidden" name="terminationtype_id" id="terminationtype_id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Termination Type</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <label for="name_update" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name_update" name="name_update"
                                    placeholder="Name" aria-describedby="name_invalid">
                                <div id="name_update_invalid" class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        var terminationTypeTable;
        $(document).ready(function() {

            terminationTypeTable = $('#terminationType').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('termination.type.data') }}",
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'action', className: "dt-right",
                        name: 'action'
                    }
                ],
                columnDefs: [{

                }],
            });



            $('#add_terminationType_form').on('submit', (e) => {
                e.preventDefault();
                let url = "{{ route('terminationtype.store') }}";
                let formData = new FormData(e.target);
                $.ajax({
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    url: url,
                    success: function success(data) {
                        $('#add_terminationType_form').trigger("reset");
                        terminationTypeTable.ajax.reload();
                        modalHide('add_terminationType_modal');
                        show_toastr('Success', 'Termination Type successfully added.', 'success');
                    },
                    error: function error(data) {
                        handleFormValidation(data);
                        show_toastr('Error', 'Permission denied.', 'error');
                    }
                });
            });


            $('#terminationType').on('draw.dt', function() {
                $('.terminationType-delete').on('click', (e) => {
                    let terminationType = e.currentTarget.dataset.id;
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You want to delete this item!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "post",
                                data: {
                                    _method: 'delete'
                                },
                                url: `{{ url('terminationtype') }}/${terminationType}`,
                                success: function success(data) {
                                    terminationTypeTable.ajax.reload();
                                    show_toastr('Success', 'Termination Type successfully deleted.', 'success');
                                },
                                error: function error(data) {
                                    console.error(data);
                                    show_toastr('Error', 'Permission denied.', 'error');
                                }
                            });
                        }
                    })
                });


                $('.terminationType-edit').on('click', (e) => {
                    let terminationType = e.currentTarget.dataset.id;
                    //console.log('fdfs');
                    $.ajax({
                        type: "get",
                        url: `{{ url('terminationtype') }}/${terminationType}/edit`,
                        success: function success(data) {
                            //console.log(data.id);
                            $('#terminationtype_id').val(data.id);
                            $('#name_update').val(data.name);



                        },
                        error: function error(data) {
                            console.error(data);
                        }
                    });
                });


                $('#update_terminationType_form').on('submit', (e) => {
                    e.preventDefault();

                    let terminationtype_id = $('#terminationtype_id').val();
                    //console.log(e.target);
                    let formData = new FormData(e.target);
                    $.ajax({
                        type: "post",
                        data: formData,
                        processData: false,
                        contentType: false,
                        url: `{{ url('terminationtype') }}/${terminationtype_id}`,
                        success: function success(data) {
                            terminationTypeTable.ajax.reload();
                            modalHide('edit_terminationType_modal');
                            show_toastr('Success', 'Termination Type successfully updated.', 'success');
                        },
                        error: function error(data) {
                            handleFormValidation(data);
                            show_toastr('Error', 'Permission denied.', 'error');
                        }
                    });
                });



            });
        });
    </script>
@endpush
