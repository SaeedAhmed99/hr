@extends('layouts.app')
@section('page-title')
    {{ __('Leave Type') }}
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">All Leave Type</p>
                        <button data-bs-toggle="modal" data-bs-target="#add_leaveType_modal" class="btn btn-gray"><i
                                class="fa-solid fa-plus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="leaveType" class="table table-condensed">
                        <thead>
                            <tr>
                                <th>{{ __('Leave Type') }}</th>
                                 <th>{{ __('Days/Years') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    {{--  add modal start  --}}
    <div class="modal fade" tabindex="-1" id="add_leaveType_modal">
        <div class="modal-dialog">
            <form action="" id="add_leaveType_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Leave Type</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">

                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter Leave Type" aria-describedby="name_invalid">
                                <div id="name_invalid" class="invalid-feedback"></div>
                            </div>
                            <div class="col-12">

                                <label for="days" class="form-label">Days</label>
                                <input type="number" class="form-control" id="days" name="days"
                                    placeholder="Enter Days" aria-describedby="days_invalid">
                                <div id="days_invalid" class="invalid-feedback"></div>
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
    <div class="modal fade" tabindex="-1" id="edit_leaveType_modal">
        <div class="modal-dialog">
            <form action="" id="update_leaveType_form">
                <input type="hidden" id="_method" name="_method" value="patch">
                <input type="hidden" name="leavetype_id" id="leavetype_id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Leave Type</h5>
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
                            <div class="col-12">
                                <label for="days_update" class="form-label">Days</label>
                                <input type="Number" class="form-control" id="days_update" name="days_update"
                                    placeholder="Days" aria-describedby="days_update_invalid">
                                <div id="days_update_invalid" class="invalid-feedback"></div>
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
        var leaveTypeTable;
        $(document).ready(function() {

            leaveTypeTable = $('#leaveType').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('leave.type.data') }}",
                columns: [
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'days',
                        name: 'days'
                    },
                    {
                        data: 'action', className: "dt-right",
                        name: 'action'
                    }
                ],
                columnDefs: [{

                }],
            });



            $('#add_leaveType_form').on('submit', (e) => {
                e.preventDefault();
                let url = "{{ route('leavetype.store') }}";
                let formData = new FormData(e.target);
                $.ajax({
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    url: url,
                    success: function success(data) {
                        $('#add_leaveType_form').trigger("reset");
                        leaveTypeTable.ajax.reload();
                        modalHide('add_leaveType_modal');
                        show_toastr('Success', 'Leave Type successfully added.', 'success');
                    },
                    error: function error(data) {
                        handleFormValidation(data);
                        show_toastr('Error', 'Permission denied.', 'error');
                    }
                });
            });


            $('#leaveType').on('draw.dt', function() {
                $('.leaveType-delete').on('click', (e) => {
                    let leaveType = e.currentTarget.dataset.id;
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
                                url: `{{ url('leavetype') }}/${leaveType}`,
                                success: function success(data) {
                                    leaveTypeTable.ajax.reload();
                                    show_toastr('Success', 'Leave Type successfully deleted.', 'success');
                                },
                                error: function error(data) {
                                    console.error(data);
                                    show_toastr('Error', 'Permission denied.', 'error');
                                }
                            });
                        }
                    })
                });


                $('.leaveType-edit').on('click', (e) => {
                    let leaveType = e.currentTarget.dataset.id;
                    //console.log('fdfs');
                    $.ajax({
                        type: "get",
                        url: `{{ url('leavetype') }}/${leaveType}/edit`,
                        success: function success(data) {
                            //console.log(data.id);
                            $('#leavetype_id').val(data.id);
                            $('#name_update').val(data.name);
                            $('#days_update').val(data.days);
                        },
                        error: function error(data) {
                            console.error(data);
                        }
                    });
                });


                $('#update_leaveType_form').on('submit', (e) => {
                    e.preventDefault();

                    let leavetype_id = $('#leavetype_id').val();
                    //console.log(e.target);
                    let formData = new FormData(e.target);
                    $.ajax({
                        type: "post",
                        data: formData,
                        processData: false,
                        contentType: false,
                        url: `{{ url('leavetype') }}/${leavetype_id}`,
                        success: function success(data) {
                            leaveTypeTable.ajax.reload();
                            modalHide('edit_leaveType_modal');
                            show_toastr('Success', 'Leave Type successfully updated.', 'success');

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
