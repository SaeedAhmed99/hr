@extends('layouts.app')
@section('page-title')
    {{ __('Branch') }}
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">All Branch</p>
                        <button data-bs-toggle="modal" data-bs-target="#add_branch_modal" class="btn btn-gray"><i
                                class="fa-solid fa-plus"></i></button>
                    </div>
                </div>
                <div class="card-body" >
                    <table id="branch" class="table table-condensed">
                        <thead>
                            <tr>
                                <th>{{ __('Branch Code') }}</th>
                                <th>{{ __('Branch Name') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    {{--  add modal start  --}}
    <div class="modal fade" tabindex="-1" id="add_branch_modal">
        <div class="modal-dialog">
            <form action="" id="add_branch_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Branch</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <label for="branch_code" class="form-label">Branch Code</label>
                                <input type="text" class="form-control" id="branch_code" name="branch_code"
                                    placeholder="Enter Code" aria-describedby="branch_code_invalid">
                                <div id="branch_code_invalid" class="invalid-feedback"></div>
                            </div>
                            <div class="col-12">
                                <label for="name" class="form-label">Branch Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter Branch Name" aria-describedby="name_invalid">
                                <div id="name_invalid" class="invalid-feedback"></div>
                            </div>
                            <div class="col-12">
                                <label for="order" class="form-label">Order</label>
                                <input type="text" class="form-control" id="order" name="order"
                                    placeholder="Enter Order" aria-describedby="name_invalid">
                                <div id="order_invalid" class="invalid-feedback"></div>
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
    <div class="modal fade" tabindex="-1" id="edit_branch_modal">
        <div class="modal-dialog">
            <form action="" id="update_branch_form">
                <input type="hidden" id="_method" name="_method" value="patch">
                <input type="hidden" name="branch_id" id="branch_id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Branch</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <label for="branch_code_update" class="form-label">Branch Code</label>
                                <input type="text" class="form-control" id="branch_code_update" name="branch_code_update"
                                    placeholder="Enter Code" aria-describedby="branch_code_invalid">
                                <div id="branch_code_update_invalid" class="invalid-feedback"></div>
                            </div>
                            <div class="col-12">
                                <label for="name_update" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name_update" name="name_update"
                                    placeholder="Name" aria-describedby="name_invalid">
                                <div id="name_update_invalid" class="invalid-feedback"></div>
                            </div>
                            <div class="col-12">
                                <label for="order_update" class="form-label">Order</label>
                                <input type="text" class="form-control" id="order_update" name="order_update"
                                    placeholder="Enter Order" aria-describedby="name_invalid">
                                <div id="order_update_invalid" class="invalid-feedback"></div>
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
        var branchTable;
        $(document).ready(function() {

            branchTable = $('#branch').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('branch.data') }}",
                columns: [{
                        data: 'branch_code',
                        name: 'branch_code'
                    },
                    {
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



            $('#add_branch_form').on('submit', (e) => {
                e.preventDefault();
                let url = "{{ route('branch.store') }}";
                let formData = new FormData(e.target);
                $.ajax({
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    url: url,
                    success: function success(data) {
                        $('#add_branch_form').trigger("reset");
                        branchTable.ajax.reload();
                        modalHide('add_branch_modal');
                        show_toastr('Success', 'Branch successfully added.', 'success');
                    },
                    error: function error(data) {
                        handleFormValidation(data);
                        show_toastr('Error', 'Permission denied.', 'error');
                    }
                });
            });


            $('#branch').on('draw.dt', function() {
                $('.branch-delete').on('click', (e) => {
                    let branch = e.currentTarget.dataset.id;
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
                                url: `{{ url('branch') }}/${branch}`,
                                success: function success(data) {
                                    branchTable.ajax.reload();
                                    show_toastr('Success', 'Branch successfully deleted.', 'success');
                                },
                                error: function error(data) {
                                    console.error(data);
                                    show_toastr('Error', 'Permission denied.', 'error');
                                }
                            });
                        }
                    })
                });


                $('.branch-edit').on('click', (e) => {
                    let branch = e.currentTarget.dataset.id;
                    //console.log('fdfs');
                    $.ajax({
                        type: "get",
                        url: `{{ url('branch') }}/${branch}/edit`,
                        success: function success(data) {
                            //console.log(data.id);
                            $('#branch_id').val(data.id);
                            $('#name_update').val(data.name);
                            $('#branch_code_update').val(data.branch_code);
                            $('#order_update').val(data.order);



                        },
                        error: function error(data) {
                            console.error(data);
                        }
                    });
                });


                $('#update_branch_form').on('submit', (e) => {
                    e.preventDefault();

                    let branch_id = $('#branch_id').val();
                    //console.log(e.target);
                    let formData = new FormData(e.target);
                    $.ajax({
                        type: "post",
                        data: formData,
                        processData: false,
                        contentType: false,
                        url: `{{ url('branch') }}/${branch_id}`,
                        success: function success(data) {
                            branchTable.ajax.reload();
                            modalHide('edit_branch_modal');
                            show_toastr('Success', 'Branch successfully updated.', 'success');
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
