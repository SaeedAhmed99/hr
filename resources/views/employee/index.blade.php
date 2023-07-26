@extends('layouts.app')
@section('page-title')
    {{ __('Employee') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">All Employee</p>
                        <div>
                            <a href="{{ route('employee.create') }}" class="btn btn-gray"><i class="fa-solid fa-plus"></i></a>
                            <a title="Employee Upload" href="{{ route('import.view') }}" class="btn btn-gray"><i
                                    class="fa-solid fa-file-excel"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="employees" class="table table-condensed">
                        <thead>
                            <tr>
                                <th>{{ __('Employee ID') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Branch') }}</th>
                                <th>{{ __('Department') }}</th>
                                <th>{{ __('Designation') }}</th>
                                <th>{{ __('Date Of Joining') }}</th>
                                <th>{{ __('Role') }}</th>
                                @if (Auth::user()->can('Edit Employee') || Auth::user()->can('Delete Employee'))
                                    <th width="200px">{{ __('Action') }}</th>
                                @endif
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{--  add modal start  --}}
    <div class="modal fade" tabindex="-1" id="add_employees_modal">
        <div class="modal-dialog modal-lg">
            <form action="" id="add_employees_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Trip</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">

                                <div class="mt-2">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control" id="name" required>
                                    <div id="name_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="mt-2">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="text" name="end_date" class="form-control" id="end_date" required>
                                    <div id="end_date_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="mt-2">
                                    <label for="purpose_of_visit" class="form-label">Purpose of Visit</label>
                                    <input type="text" class="form-control" id="purpose_of_visit" name="purpose_of_visit"
                                        placeholder="Enter Purpose" aria-describedby="description_invalid"></input>
                                    <div id="purpose_of_visit_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="mt-2">
                                    <label for="place_of_visit" class="form-label">Place of Visit</label>
                                    <input type="text" class="form-control" id="place_of_visit" name="place_of_visit"
                                        placeholder="Enter Visit" aria-describedby="description_invalid"></input>
                                    <div id="place_of_visit_invalid" class="invalid-feedback"></div>
                                </div>

                            </div>
                            <div class="col-6">

                                <div class="mt-2">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="text" name="start_date" class="form-control" id="start_date" required>
                                    <div id="start_date_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="mt-2">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="text" name="end_date" class="form-control" id="end_date" required>
                                    <div id="end_date_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="mt-2">
                                    <label for="purpose_of_visit" class="form-label">Purpose of Visit</label>
                                    <input type="text" class="form-control" id="purpose_of_visit" name="purpose_of_visit"
                                        placeholder="Enter Purpose" aria-describedby="description_invalid"></input>
                                    <div id="purpose_of_visit_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="mt-2">
                                    <label for="place_of_visit" class="form-label">Place of Visit</label>
                                    <input type="text" class="form-control" id="place_of_visit" name="place_of_visit"
                                        placeholder="Enter Visit" aria-describedby="description_invalid"></input>
                                    <div id="place_of_visit_invalid" class="invalid-feedback"></div>
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
    {{--  edit modal start  --}}
    <div class="modal fade" tabindex="-1" id="edit_employees_modal">
        <div class="modal-dialog">
            <form action="" id="update_employees_form">
                <input type="hidden" id="_method" name="_method" value="patch">
                <input type="hidden" name="employees_id" id="employees_id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit employees</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">

                                <div>
                                    <label for="employee_update">
                                        Employee
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Branch select"
                                        name="employee_update" id="employee_update">
                                        <option value=""> Select Employee</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}">
                                                {{ $employee->user ? $employee->user->name : '-' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="employee_update_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="mt-2">
                                    <label for="start_date_update" class="form-label">Start Date</label>
                                    <input type="text" name="start_date_update" class="form-control"
                                        id="start_date_update" required>
                                    <div id="start_date_update_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="mt-2">
                                    <label for="end_date_update" class="form-label">End Date</label>
                                    <input type="text" name="end_date_update" class="form-control"
                                        id="end_date_update" required>
                                    <div id="end_date_update_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="mt-2">
                                    <label for="purpose_of_visit_update" class="form-label">Purpose of Visit</label>
                                    <input type="text" class="form-control" id="purpose_of_visit_update"
                                        name="purpose_of_visit_update" placeholder="Enter Purpose"
                                        aria-describedby="description_invalid"></input>
                                    <div id="purpose_of_visit_update_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="mt-2">
                                    <label for="place_of_visit_update" class="form-label">Place of Visit</label>
                                    <input type="text" class="form-control" id="place_of_visit_update"
                                        name="place_of_visit_update" placeholder="Enter Visit"
                                        aria-describedby="description_invalid"></input>
                                    <div id="place_of_visit_update_invalid" class="invalid-feedback"></div>
                                </div>

                            </div>

                            <div>
                                <label for="description_update" class="form-label">Description</label>
                                <textarea type="text" class="form-control" id="description_update" name="description_update"
                                    placeholder="Enter Description" aria-describedby="description_invalid" row="3"></textarea>
                                <div id="description_update_invalid" class="invalid-feedback"></div>
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
        var transferTable;
        $(document).ready(function() {
            $('#employee').select2({
                dropdownParent: $('#add_employees_modal'),
                width: 'style',

            });
            $('#employee_update').select2({
                dropdownParent: $('#edit_employees_modal'),
                width: 'style',

            });
            $("#start_date").datepicker({
                dateFormat: 'yy-mm-dd'
            });
            $("#end_date").datepicker({
                dateFormat: 'yy-mm-dd'
            });
            $("#start_date_update").datepicker({
                dateFormat: 'yy-mm-dd'
            });
            $("#end_date_update").datepicker({
                dateFormat: 'yy-mm-dd'
            });


            employeesTable = $('#employees').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('employee.data') }}",
                columns: [{
                        data: 'employee_id',
                        name: 'employee_id'
                    },
                    {
                        data: 'user.name',
                        name: 'user.name'
                    },
                    {
                        data: 'user.email',
                        name: 'user.email'
                    },
                    {
                        data: 'branch',
                        name: 'branch'
                    },
                    {
                        data: 'department',
                        name: 'department'
                    },
                    {
                        data: 'designation',
                        name: 'designation'
                    },
                    {
                        data: 'date_of_joining',
                        name: 'date_of_joining'
                    },
                    {
                        data: 'role',
                        name: 'role'
                    },
                    @if (Gate::check('Edit Employee') || Gate::check('Delete Employee'))
                        {
                            data: 'action',
                            className: "dt-right",
                            name: 'action'
                        }
                    @endif
                ],
                columnDefs: [{

                }],
                dom: '<"d-flex justify-content-end"<"mb-2"B>><"container-fluid"<"row"<"col"l><"col"f>>>rtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ],
                "lengthChange": true
            });




            $('#add_employees_form').on('submit', (e) => {
                e.preventDefault();
                let url = "{{ route('employee.store') }}";
                let formData = new FormData(e.target);
                $.ajax({
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    url: url,
                    success: function success(data) {
                        $('#add_employees_form').trigger("reset");
                        employeesTable.ajax.reload();
                        modalHide('add_employees_modal');
                        show_toastr('Success', 'employees successfully added.', 'success');
                    },
                    error: function error(data) {
                        handleFormValidation(data);
                        show_toastr('Error', 'Permission denied.', 'error');
                    }
                });
            });

            let deleteEmployee = (e) => {
                let employees = e.currentTarget.dataset.id;
                console.log(employees);
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
                            url: `{{ url('employee') }}/${employees}`,
                            success: function success(data) {
                                employeesTable.ajax.reload();
                                show_toastr('Success',
                                    'employees successfully deleted.',
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
            };

            $('#employees').on('draw.dt', function() {
                $('.employees-delete').on('click', deleteEmployee);

                employeesTable.on('responsive-display', function(e, datatable, row, showHide, update) {
                    $('.employees-delete').on('click', deleteEmployee);
                });

                $('.employees-edit').on('click', (e) => {
                    let employees = e.currentTarget.dataset.id;
                    //console.log('fdfs');
                    $.ajax({
                        type: "get",
                        url: `{{ url('employee') }}/${employee}/edit`,
                        success: function success(data) {
                            //console.log(data.id);
                            $('#employees_id').val(data.id);
                            $('#employee_update').val(data.employee_id);
                            $('#employee_update').trigger('change');
                            $('#start_date_update').val(data.start_date);
                            $('#end_date_update').val(data.end_date);
                            $('#purpose_of_visit_update').val(data.purpose_of_visit);
                            $('#place_of_visit_update').val(data.place_of_visit);
                            $('#description_update').val(data.description);
                        },
                        error: function error(data) {
                            console.error(data);
                        }
                    });
                });


                $('#update_employees_form').on('submit', (e) => {
                    e.preventDefault();

                    let employees_id = $('#employees_id').val();
                    //console.log(e.target);
                    let formData = new FormData(e.target);
                    $.ajax({
                        type: "post",
                        data: formData,
                        processData: false,
                        contentType: false,
                        url: `{{ url('employee') }}/${employees_id}`,
                        success: function success(data) {
                            employeesTable.ajax.reload();
                            modalHide('edit_employees_modal');
                            show_toastr('Success', 'employees successfully updated.',
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
