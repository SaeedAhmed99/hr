@extends('layouts.app')

@section('page-title')
    {{ __('Resignation') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">All Resignation</p>
                        @can('Create Resignation')
                            <button data-bs-toggle="modal" data-bs-target="#add_resignation_modal" class="btn btn-gray"><i
                                    class="fa-solid fa-plus"></i></button>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <table id="resignation" class="table table-condensed">
                        <thead>
                            <tr>
                                <th>{{ __('Employee Name') }}</th>
                                <th>{{ __('Notice Date') }}</th>
                                <th>{{ __('Resignation Date') }}</th>
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
    <div class="modal fade" tabindex="-1" id="add_resignation_modal">
        <div class="modal-dialog">
            <form action="" id="add_resignation_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Resignation</h5>
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
                                    <label for="notice_date" class="form-label">Notice Date</label>
                                    <input type="text" name="notice_date" class="form-control" id="notice_date">
                                    <div id="notice_date_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="mt-2">
                                    <label for="resignation_date" class="form-label">Resignation Date</label>
                                    <input type="text" name="resignation_date" class="form-control"
                                        id="resignation_date">
                                    <div id="resignation_date_invalid" class="invalid-feedback"></div>
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
    <div class="modal fade" tabindex="-1" id="edit_resignation_modal">
        <div class="modal-dialog">
            <form action="" id="update_resignation_form">
                <input type="hidden" id="_method" name="_method" value="patch">
                <input type="hidden" name="resignation_id" id="resignation_id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Resignation</h5>
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
                                    <label for="notice_date_update" class="form-label">Notice Date</label>
                                    <input type="text" name="notice_date_update" class="form-control"
                                        id="notice_date_update">
                                    <div id="notice_date_update_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="mt-2">
                                    <label for="resignation_date_update" class="form-label">Resignation Date</label>
                                    <input type="text" name="resignation_date_update" class="form-control"
                                        id="resignation_date_update">
                                    <div id="resignation_date_update_invalid" class="invalid-feedback"></div>
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
                dropdownParent: $('#add_resignation_modal'),
                width: 'style',

            });


            $("#notice_date").datepicker({
                dateFormat: 'yy-mm-dd'
            });
            $("#resignation_date").datepicker({
                dateFormat: 'yy-mm-dd'
            });
            $("#notice_date_update").datepicker({
                dateFormat: 'yy-mm-dd'
            });
            $("#resignation_date_update").datepicker({
                dateFormat: 'yy-mm-dd'
            });



            resignationTable = $('#resignation').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('resignation.data') }}",
                columns: [{
                        data: 'employee.user.name',
                        name: 'employee.user.name'
                    },
                    {
                        data: 'notice_date',
                        name: 'notice_date'
                    },
                    {
                        data: 'resignation_date',
                        name: 'resignation_date'
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




            $('#add_resignation_form').on('submit', (e) => {
                e.preventDefault();
                let url = "{{ route('resignation.store') }}";
                let formData = new FormData(e.target);
                $.ajax({
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    url: url,
                    success: function success(data) {
                        $('#add_resignation_form').trigger("reset");
                        resignationTable.ajax.reload();
                        modalHide('add_resignation_modal');
                        show_toastr('Success', 'Registration successfully added.', 'success');
                    },
                    error: function error(data) {
                        handleFormValidation(data);
                        show_toastr('Error', 'Permission denied.', 'error');
                    }
                });
            });


            $('#resignation').on('draw.dt', function() {
                $('.resignation-delete').on('click', (e) => {
                    let resignation = e.currentTarget.dataset.id;
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
                                url: `{{ url('resignation') }}/${resignation}`,
                                success: function success(data) {
                                    resignationTable.ajax.reload();
                                    show_toastr('Success',
                                        'Registration successfully deleted.',
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


                $('.resignation-edit').on('click', (e) => {
                    let resignation = e.currentTarget.dataset.id;
                    //console.log('fdfs');
                    $.ajax({
                        type: "get",
                        url: `{{ url('resignation') }}/${resignation}/edit`,
                        success: function success(data) {
                            //console.log(data.id);
                            $('#resignation_id').val(data.id);
                            $('#employee_update').val(data.employee_id);
                            $('#notice_date_update').val(data.notice_date);
                            $('#resignation_date_update').val(data.resignation_date);
                            $('#description_update').val(data.description);
                        },
                        error: function error(data) {
                            console.error(data);
                        }
                    });
                });


                $('#update_resignation_form').on('submit', (e) => {
                    e.preventDefault();

                    let resignation_id = $('#resignation_id').val();
                    //console.log(e.target);
                    let formData = new FormData(e.target);
                    $.ajax({
                        type: "post",
                        data: formData,
                        processData: false,
                        contentType: false,
                        url: `{{ url('resignation') }}/${resignation_id}`,
                        success: function success(data) {
                            resignationTable.ajax.reload();
                            modalHide('edit_resignation_modal');
                            show_toastr('Success', 'Termination successfully updated.',
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
