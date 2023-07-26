@extends('layouts.app')
@section('page-title')
    {{ __('Leave') }}
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">All Leave</p>
                        <button data-bs-toggle="modal" data-bs-target="#add_leave_modal" class="btn btn-gray"><i
                                class="fa-solid fa-plus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    {{-- <form action="" method="get" id=""> --}}
                    <div class="row align-items-center">
                        <div class="col-xl-3 col-md-6 col-sm-12 col-12 date">
                            <div class="d-flex gap-1">
                                <div class="">
                                    <label class="form-label" for="from">From</label>
                                    <input class="form-control" id="from" type="date" name="from">
                                </div>
                                <div>
                                    <label class="form-label" for="to">To</label>
                                    <input class="form-control" id="to" type="date" name="to">
                                </div>
                            </div>
                        </div>
                        <div class="col-auto mt-4">
                            <div class="row">
                                <div class="col-auto">
                                    <button id="filter" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- </form> --}}
                    <table id="leave" class="table table-condensed">
                        <thead>
                            <tr>
                                @if (Auth::user()->hrm->type == 'company')
                                    <th>{{ __('Employee') }}</th>
                                @else
                                    <th></th>
                                @endif
                                <th>{{ __('Leave Type') }}</th>
                                <th>{{ __('Applied On') }}</th>
                                <th>{{ __('Start Date') }}</th>
                                <th>{{ __('End Date') }}</th>
                                <th>{{ __('Total Days') }}</th>
                                <th>{{ __('Leave Reason') }}</th>
                                <th>{{ __('status') }}</th>
                                <th width="200px">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    {{--  add modal start  --}}
    <div class="modal fade" tabindex="-1" id="add_leave_modal">
        <div class="modal-dialog">
            <form action="" id="add_leave_form">
                <input type="hidden" name="employee" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add leave</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                @can('Manage Leave')
                                    <div>
                                        <label for="employee">
                                            Employee*
                                        </label>
                                        <select style="width: 100%" class="form-select" aria-label="Branch select"
                                            name="employee" id="employee">
                                            <option value="" selected>Select Employee</option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}">
                                                    {{ $employee->user ? $employee->user->name : '-' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div id="employee_invalid" class="invalid-feedback"></div>
                                    </div>
                                @endcan


                                <div>
                                    <label for="leavetype">
                                        Leave Type*
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Branch select"
                                        name="leave_type_id" id="leave_type_id">
                                        <option value="" selected>Select Type</option>
                                        @foreach ($leavetypes as $leavetype)
                                            <option value="{{ $leavetype->id }}"> {{ $leavetype->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="leave_type_id_invalid" class="invalid-feedback"></div>
                                </div>



                                <div class="col-12 mt-2">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="text" name="start_date" class="form-control" id="start_datepicker"
                                        required>
                                    <div id="start_date_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="col-12 mt-2">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="text" name="end_date" class="form-control" id="end_datepicker" required>
                                    <div id="end_date_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="col-12 mt-2">
                                    <label for="leave_reason" class="form-label">Leave Reason</label>
                                    <textarea name="leave_reason" class="form-control" id="leave_reason" rows="3"></textarea>
                                    <div id="leave_reason_invalid" class="invalid-feedback"></div>
                                </div>
                                @can('Manage Leave')
                                    <div class="col-12 mt-2">
                                        <label for="remark" class="form-label">Remark</label>
                                        <textarea name="remark" class="form-control" id="remark" rows="3"></textarea>
                                        <div id="remark_invalid" class="invalid-feedback"></div>
                                    </div>
                                @endcan


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

    {{--  Action modal start  --}}
    <div class="modal fade" tabindex="-1" id="action_leave_modal">
        <div class="modal-dialog">
            <form id="action_leave_form" method="POST" action="{{ route('leave.changeaction') }}">
                @csrf
                {{--  <input type="hidden" id="_method" name="_method" value="patch">  --}}
                <input type="hidden" name="leave_id" id="leave_id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Action leave</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3 row">
                                    <label for="staticEmail" class="col-sm-6 col-form-label">Employee</label>
                                    <div class="col-sm-6">
                                        <input type="text" readonly class="form-control-plaintext"
                                            id="employee_action">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="leave_type_action" class="col-sm-6 col-form-label">Leave Type</label>
                                    <div class="col-sm-6">
                                        <input type="text" readonly class="form-control-plaintext"
                                            id="leave_type_action">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="applied_on_action" class="col-sm-6 col-form-label">Appplied On</label>
                                    <div class="col-sm-6">
                                        <input type="text" readonly class="form-control-plaintext"
                                            id="applied_on_action">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="start_date_action" class="col-sm-6 col-form-label">Start Date</label>
                                    <div class="col-sm-6">
                                        <input type="text" readonly class="form-control-plaintext"
                                            id="start_date_action">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="end_date_action" class="col-sm-6 col-form-label">End Date</label>
                                    <div class="col-sm-6">
                                        <input type="text" readonly class="form-control-plaintext"
                                            id="end_date_action">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="leave_reason_action" class="col-sm-6 col-form-label">Leave Status</label>
                                    <div class="col-sm-6">
                                        <div id="status_action"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="{{ __('Approved') }}" class="btn btn-success rounded"
                            name="status">
                        <input type="submit" value="{{ __('Reject') }}" class="btn btn-danger rounded"
                            name="status">
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{--  edit modal start  --}}
    <div class="modal fade" tabindex="-1" id="edit_leave_modal">
        <div class="modal-dialog">
            <form action="" id="update_leave_form">
                <input type="hidden" id="_method" name="_method" value="patch">
                <input type="hidden" name="leave_id" id="leave_id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit leave</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <label for="employee_update">
                                        Employee*
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Branch select"
                                        name="employee_update" id="employee_update">
                                        <option value="" selected>Select Employee</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}">
                                                {{ $employee->user ? $employee->user->name : '-' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="employee_update_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="mt-2">
                                    <label for="leavetype">
                                        Leave Type*
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Branch select"
                                        name="leave_type_id_update" id="leave_type_id_update">
                                        <option value="" selected>Select Type</option>
                                        @foreach ($leavetypes as $leavetype)
                                            <option value="{{ $leavetype->id }}"> {{ $leavetype->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="leave_type_id_update_invalid" class="invalid-feedback"></div>
                                </div>



                                <div class="col-12 mt-2">
                                    <label for="start_date_update" class="form-label">Start Date</label>
                                    <input type="text" name="start_date_update" class="form-control"
                                        id="start_date_update" required>
                                    <div id="start_date_update_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="col-12 mt-2">
                                    <label for="end_date_update" class="form-label">End Date</label>
                                    <input type="text" name="end_date_update" class="form-control"
                                        id="end_date_update" required>
                                    <div id="end_date_update_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="col-12 mt-2">
                                    <label for="leave_reason_update" class="form-label">Leave Reason</label>
                                    <textarea name="leave_reason_update" class="form-control" id="leave_reason_update" rows="3"></textarea>
                                    <div id="leave_reason_update_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="col-12 mt-2">
                                    <label for="remark_update" class="form-label">Remark</label>
                                    <textarea name="remark_update" class="form-control" id="remark_update" rows="3"></textarea>
                                    <div id="remark_update_invalid" class="invalid-feedback"></div>
                                </div>

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
        var leaveTable;
        $(document).ready(function() {
            $('#employee').select2({
                dropdownParent: $('#add_leave_modal'),
                width: 'style'
            });
            $('#leave_type_id').select2({
                dropdownParent: $('#add_leave_modal'),
                width: 'style'
            });
            $('#start_datepicker').datepicker({
                dateFormat: 'yy-mm-dd'
            });
            $('#end_datepicker').datepicker({
                dateFormat: 'yy-mm-dd'
            });
            $('#employee_update').select2({
                dropdownParent: $('#edit_leave_modal'),
                width: 'style'
            });
            $('#leave_type_id_update').select2({
                dropdownParent: $('#edit_leave_modal'),
                width: 'style'
            });
            $('#start_date_update').datepicker({
                dateFormat: 'yy-mm-dd'
            });
            $('#end_date_update').datepicker({
                dateFormat: 'yy-mm-dd'
            });

            leaveTable = $('#leave').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('leave.data') }}",
                    data: function(d) {
                        d.from = $('#from').val();
                        d.to = $('#to').val();
                    },
                },
                columns: [{
                        data: 'employee',
                        name: 'employee'
                    },
                    {
                        data: 'leave_type.name',
                        name: 'leave_type.name'
                    },
                    {
                        data: 'applied_on',
                        name: 'applied_on'
                    },
                    {
                        data: 'start_date',
                        name: 'start_date'
                    },
                    {
                        data: 'end_date',
                        name: 'end_date'
                    },
                    {
                        data: 'total_leave_days',
                        name: 'total_leave_days'
                    },
                    {
                        data: 'leave_reason',
                        name: 'leave_reason'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        className: "dt-right",
                        name: 'action'
                    }
                ],
                columnDefs: [{}],
                dom: '<"d-flex justify-content-end"<"mb-2"B>><"container-fluid"<"row"<"col"l><"col"f>>>rtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ],
                "lengthChange": true
            });

            $('#filter').on('click', function(e) {
                leaveTable.draw();
            });

            $('#add_leave_form').on('submit', (e) => {
                e.preventDefault();
                let url = "{{ route('leave.store') }}";
                let formData = new FormData(e.target);
                $.ajax({
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    url: url,
                    success: function success(data) {
                        $('#add_leave_form').trigger("reset");
                        leaveTable.ajax.reload();
                        modalHide('add_leave_modal');
                        show_toastr('Success', 'leave successfully added.', 'success');
                    },
                    error: function error(data) {
                        handleFormValidation(data);
                        show_toastr('Error', 'Permission denied.', 'error');
                    }
                });
            });
            $('#leave').on('draw.dt', function() {
                $('.leave-delete').on('click', (e) => {
                    let leave = e.currentTarget.dataset.id;
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
                                url: `{{ url('leave') }}/${leave}`,
                                success: function success(data) {
                                    leaveTable.ajax.reload();
                                    show_toastr('Success',
                                        'leave successfully deleted.',
                                        'success');
                                },
                                error: function error(data) {
                                    console.error(data);
                                    show_toastr('Error', 'Permission denied.',
                                        'error');
                                }
                            });
                        }
                    })
                });
                $('.leave-action').on('click', (e) => {
                    let leave = e.currentTarget.dataset.id;
                    //console.log('fdfs');
                    $.ajax({
                        type: "get",
                        url: `{{ url('leave') }}/${leave}/action`,
                        success: function success(data) {
                            //console.log(data.id);
                            $('#leave_id').val(data.id);
                            $('#employee_action').val(data.employee.user.name);
                            $('#leave_type_action').val(data.leave_type.name);
                            $('#applied_on_action').val(data.applied_on);
                            $('#start_date_action').val(data.start_date);
                            $('#end_date_action').val(data.end_date);
                            $('#leave_reason_action').val(data.leave_reason);
                            if (data.status == 0) {
                                $('#status_action').html(
                                    `<div class="badge bg-warning p-2 px-3 rounded">Pending</div>`
                                );
                            } else if (data.status == '1') {
                                $('#status_action').html(
                                    `<div class="badge bg-success p-2 px-3 rounded">Approved</div>`
                                );
                            } else if (data.status == "2") {
                                $('#status_action').html(
                                    `<div class="badge bg-danger p-2 px-3 rounded">Reject</div>`
                                );
                            }
                        },
                        error: function error(data) {
                            console.error(data);
                        }
                    });
                });
                $('.leave-edit').on('click', (e) => {
                    let leave = e.currentTarget.dataset.id;
                    //console.log('fdfs');
                    $.ajax({
                        type: "get",
                        url: `{{ url('leave') }}/${leave}/edit`,
                        success: function success(data) {
                            //console.log(data.id);
                            $('#leave_id').val(data.id);
                            $('#employee_update').val(data.employee_id);
                            $('#employee_update').trigger('change');
                            $('#leave_type_id_update').val(data.leave_type_id);
                            $('#leave_type_id_update').trigger('change');
                            $('#start_date_update').val(data.start_date);
                            $('#end_date_update').val(data.end_date);
                            $('#leave_reason_update').val(data.leave_reason);
                            $('#remark_update').val(data.remark);
                        },
                        error: function error(data) {
                            console.error(data);
                        }
                    });
                });
                $('#update_leave_form').on('submit', (e) => {
                    e.preventDefault();
                    let leave_id = $('#leave_id').val();
                    //console.log(e.target);
                    let formData = new FormData(e.target);
                    $.ajax({
                        type: "post",
                        data: formData,
                        processData: false,
                        contentType: false,
                        url: `{{ url('leave') }}/${leave_id}`,
                        success: function success(data) {
                            leaveTable.ajax.reload();
                            modalHide('edit_leave_modal');
                            show_toastr('Success', 'leave successfully updated.',
                                'success');
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
