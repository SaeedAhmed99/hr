@extends('layouts.app')
@section('page-title')
    {{ __('Transfer') }}
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">All Transfer</p>
                        @can('Create Transfer')
                            <button data-bs-toggle="modal" data-bs-target="#add_transfer_modal" class="btn btn-gray"><i
                                    class="fa-solid fa-plus"></i></button>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <table id="transfer" class="table table-condensed">
                        <thead>
                            <tr>
                                <th>{{ __('Employee Name') }}</th>
                                <th>{{ __('Branch') }}</th>
                                <th>{{ __('Department') }}</th>
                                <th>{{ __('Transfer Date') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    {{--  add modal start  --}}
    <div class="modal fade" tabindex="-1" id="add_transfer_modal">
        <div class="modal-dialog">
            <form action="" id="add_transfer_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Transfer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">

                                <div>
                                    <label for="employee">
                                        Employee
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Branch select"
                                        name="employee" id="employee">
                                        <option value=""> Select Employee</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}"> {{ $employee->user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="employee_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="mt-2">
                                    <label for="branch">
                                        Branch
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Branch select"
                                        name="branch" id="branch" onchange="fetchDepartment(this.value)">
                                        <option value=""> Select Branch</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}"> {{ $branch->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="branch_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="mt-2">
                                    <label for="department">
                                        Department
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Branch select"
                                        name="department" id="department">
                                        <option value=""> Select Department</option>
                                        {{--  @foreach ($departments as $department)
                                            <option value="{{ $department->id }}"> {{ $department->name }}
                                            </option>
                                        @endforeach  --}}
                                    </select>
                                    <div id="department_invalid" class="invalid-feedback"></div>
                                </div>


                                <div class="mt-2">
                                    <label for="date" class="form-label">Transfer Date</label>
                                    <input type="text" name="date" class="form-control" id="date" required>
                                    <div id="date_invalid" class="invalid-feedback"></div>
                                </div>

                            </div>

                            <div>
                                <label for="description" class="form-label">Description</label>
                                <textarea type="text" class="form-control" id="description" name="description" placeholder="Enter Description"
                                    aria-describedby="description_invalid" row="3"></textarea>
                                <div id="description_invalid" class="invalid-feedback"></div>
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
    <div class="modal fade" tabindex="-1" id="edit_transfer_modal">
        <div class="modal-dialog">
            <form action="" id="update_transfer_form">
                <input type="hidden" id="_method" name="_method" value="patch">
                <input type="hidden" name="transfer_id" id="transfer_id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Transfer</h5>
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
                                            <option value="{{ $employee->id }}"> {{ $employee->user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="employee_update_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="mt-2">
                                    <label for="branch_update">
                                        Branch
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Branch select"
                                        name="branch_update" id="branch_update">
                                        <option value="" selected> Select Branch</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}"> {{ $branch->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="branch_update_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="mt-2">
                                    <label for="department_update">
                                        Department
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Branch select"
                                        name="department_update" id="department_update">
                                        <option value="" selected> Select Department</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}"> {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="department_update_invalid" class="invalid-feedback"></div>
                                </div>


                                <div class="mt-2">
                                    <label for="date_update" class="form-label">Transfer Date</label>
                                    <input type="text" name="date_update" class="form-control" id="date_update"
                                        required>
                                    <div id="date_update_invalid" class="invalid-feedback"></div>
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


            $('#branch').select2({
                dropdownParent: $('#add_transfer_modal'),
                width: 'style',

            });
            $('#department').select2({
                dropdownParent: $('#add_transfer_modal'),
                width: 'style',

            });
            $('#employee').select2({
                dropdownParent: $('#add_transfer_modal'),
                width: 'style',

            });

            $('#branch_update').select2({
                dropdownParent: $('#edit_transfer_modal'),
                width: 'style',

            });
            $('#department_update').select2({
                dropdownParent: $('#edit_transfer_modal'),
                width: 'style',

            });
            $('#employee_update').select2({
                dropdownParent: $('#edit_transfer_modal'),
                width: 'style',

            });

            $("#date").datepicker({
                dateFormat: 'yy-mm-dd'
            });
            $("#date_update").datepicker({
                dateFormat: 'yy-mm-dd'
            });


            transferTable = $('#transfer').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('transfer.data') }}",
                columns: [{
                        data: 'employee.user.name',
                        name: 'employee.user.name'
                    },
                    {
                        data: 'branch.name',
                        name: 'branch.name'
                    },
                    {
                        data: 'department.name',
                        name: 'department.name'
                    },
                    {
                        data: 'transfer_date',
                        name: 'transfer_date'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'action', className: "dt-right",
                        name: 'action'
                    }
                ],
                columnDefs: [{

                }],
            });




            $('#add_transfer_form').on('submit', (e) => {
                e.preventDefault();
                let url = "{{ route('transfer.store') }}";
                let formData = new FormData(e.target);
                $.ajax({
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    url: url,
                    success: function success(data) {
                        $('#add_transfer_form').trigger("reset");
                        transferTable.ajax.reload();
                        modalHide('add_transfer_modal');
                        show_toastr('Success', 'Transfer successfully added.', 'success');
                    },
                    error: function error(data) {
                        handleFormValidation(data);
                        show_toastr('Error', 'Permission denied.', 'error');
                    }
                });
            });


            $('#transfer').on('draw.dt', function() {
                $('.transfer-delete').on('click', (e) => {
                    let transfer = e.currentTarget.dataset.id;
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
                                url: `{{ url('transfer') }}/${transfer}`,
                                success: function success(data) {
                                    transferTable.ajax.reload();
                                    show_toastr('Success',
                                        'Transfer successfully deleted.',
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


                $('.transfer-edit').on('click', (e) => {
                    let transfer = e.currentTarget.dataset.id;
                    //console.log('fdfs');
                    $.ajax({
                        type: "get",
                        url: `{{ url('transfer') }}/${transfer}/edit`,
                        success: function success(data) {
                            //console.log(data.id);
                            $('#transfer_id').val(data.id);
                            $('#employee_update').val(data.employee_id);
                            $('#employee_update').trigger('change');
                            $('#branch_update').val(data.new_branch_id);
                            $('#branch_update').trigger('change');
                            $('#department_update').val(data.new_department_id);
                            $('#department_update').trigger('change');
                            $('#date_update').val(data.transfer_date);
                            $('#description_update').val(data.description);
                        },
                        error: function error(data) {
                            console.error(data);
                        }
                    });
                });


                $('#update_transfer_form').on('submit', (e) => {
                    e.preventDefault();

                    let transfer_id = $('#transfer_id').val();
                    //console.log(e.target);
                    let formData = new FormData(e.target);
                    $.ajax({
                        type: "post",
                        data: formData,
                        processData: false,
                        contentType: false,
                        url: `{{ url('transfer') }}/${transfer_id}`,
                        success: function success(data) {
                            transferTable.ajax.reload();
                            modalHide('edit_transfer_modal');
                            show_toastr('Success', 'Transfer successfully updated.',
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
    <script>
        let fetchDepartment = (branch_id) => {

            $.ajax({
                type: "GET",
                url: "/department-branch/" + branch_id,
                dataType: 'json',
                success: function(data) {
                    //console.log(data);
                    let department = document.getElementById('department');
                    let all_options = "<option selected>Select Department</option>";

                    data.forEach(element => {
                        all_options = all_options + "<option value='" + element['id'] + "'>" +
                            element['name'] + "</option>";
                    });

                    document.getElementById('department').innerHTML = all_options;
                }
            });
        }
    </script>
@endpush
