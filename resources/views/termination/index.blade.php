@extends('layouts.app')
@section('page-title')
    {{ __('Termination') }}
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">All Termination</p>
                        <button data-bs-toggle="modal" data-bs-target="#add_termination_modal" class="btn btn-gray"><i
                                class="fa-solid fa-plus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="termination" class="table table-condensed">
                        <thead>
                            <tr>
                                <th>{{ __('Employee Name') }}</th>
                                <th>{{ __('Termination Type') }}</th>
                                <th>{{ __('Notice Date') }}</th>
                                <th>{{ __('Termination Date') }}</th>
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
    <div class="modal fade" tabindex="-1" id="add_termination_modal">
        <div class="modal-dialog">
            <form action="" id="add_termination_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Termination</h5>
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
                                    <label for="termination_type">
                                        Termination Type
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Branch select"
                                        name="termination_type" id="termination_type">
                                        <option value=""> Select Type</option>
                                        @foreach ($termination_types as $termination_type)
                                            <option value="{{ $termination_type->id }}"> {{ $termination_type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="termination_type_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="mt-2">
                                    <label for="notice_date" class="form-label">Notice Date</label>
                                    <input type="text" name="notice_date" class="form-control" id="notice_date">
                                    <div id="notice_date_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="mt-2">
                                    <label for="termination_date" class="form-label">Termination Date</label>
                                    <input type="text" name="termination_date" class="form-control" id="termination_date">
                                    <div id="termination_date_invalid" class="invalid-feedback"></div>
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
    <div class="modal fade" tabindex="-1" id="edit_termination_modal">
        <div class="modal-dialog">
            <form action="" id="update_termination_form">
                <input type="hidden" id="_method" name="_method" value="patch">
                <input type="hidden" name="termination_id" id="termination_id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Termination</h5>
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

                                <div>
                                    <label for="termination_type_update">
                                       Termination Type
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Branch select"
                                        name="termination_type_update" id="termination_type_update">
                                        <option value=""> Select Type</option>
                                        @foreach ($termination_types as $termination_type)
                                            <option value="{{ $termination_type->id }}"> {{ $termination_type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="termination_type_update_invalid" class="invalid-feedback"></div>
                                </div>



                                 <div class="mt-2">
                                    <label for="notice_date_update" class="form-label">Notice Date</label>
                                    <input type="text" name="notice_date_update" class="form-control" id="notice_date_update">
                                    <div id="notice_date_update_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="mt-2">
                                    <label for="termination_date_update" class="form-label">termination Date</label>
                                    <input type="text" name="termination_date_update" class="form-control" id="termination_date_update">
                                    <div id="termination_date_update_invalid" class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div>
                                <label for="description_update" class="form-label">Description</label>
                                <textarea type="text" class="form-control" id="description_update" name="description_update" placeholder="Enter Description"
                                    aria-describedby="description_invalid" row="3"></textarea>
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
                dropdownParent: $('#add_termination_modal'),
                width: 'style',

            });

            $('#termination_type').select2({
                dropdownParent: $('#add_termination_modal'),
                width: 'style',

            });

            $('#employee_update').select2({
                dropdownParent: $('#edit_termination_modal'),
                width: 'style',

            });
            $('#termination_type_update').select2({
                dropdownParent: $('#edit_termination_modal'),
                width: 'style',

            });




            $("#notice_date").datepicker({
                dateFormat: 'yy-mm-dd'
            });
            $("#termination_date").datepicker({
                dateFormat: 'yy-mm-dd'
            });
            $("#notice_date_update").datepicker({
                dateFormat: 'yy-mm-dd'
            });
            $("#termination_date_update").datepicker({
                dateFormat: 'yy-mm-dd'
            });



            terminationTable = $('#termination').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('termination.data') }}",
                columns: [{
                        data: 'employee.user.name',
                        name: 'employee.user.name'
                    },
                    {
                        data: 'termination_type.name',
                        name: 'termination_type.name'
                    },
                    {
                        data: 'notice_date',
                        name: 'notice_date'
                    },
                    {
                        data: 'termination_date',
                        name: 'termination_date'
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




            $('#add_termination_form').on('submit', (e) => {
                e.preventDefault();
                let url = "{{ route('termination.store') }}";
                let formData = new FormData(e.target);
                $.ajax({
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    url: url,
                    success: function success(data) {
                        $('#add_termination_form').trigger("reset");
                        terminationTable.ajax.reload();
                        modalHide('add_termination_modal');
                        show_toastr('Success', 'Termination successfully added.', 'success');
                    },
                    error: function error(data) {
                        handleFormValidation(data);
                        show_toastr('Error', 'Permission denied.', 'error');
                    }
                });
            });


            $('#termination').on('draw.dt', function() {
                $('.termination-delete').on('click', (e) => {
                    let termination = e.currentTarget.dataset.id;
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
                                url: `{{ url('termination') }}/${termination}`,
                                success: function success(data) {
                                    terminationTable.ajax.reload();
                                    show_toastr('Success', 'Termination successfully deleted.', 'success');
                                },
                                error: function error(data) {
                                    console.error(data);
                                    show_toastr('Error', 'Permission denied.', 'error');
                                }
                            });
                        }
                    })
                });


                $('.termination-edit').on('click', (e) => {
                    let termination = e.currentTarget.dataset.id;
                    //console.log('fdfs');
                    $.ajax({
                        type: "get",
                        url: `{{ url('termination') }}/${termination}/edit`,
                        success: function success(data) {
                            //console.log(data.id);
                            $('#termination_id').val(data.id);
                            $('#employee_update').val(data.employee_id);
                            $('#employee_update').trigger('change');
                            $('#termination_type_update').val(data.termination_type_id);
                            $('#termination_type_update').trigger('change');
                            $('#notice_date_update').val(data.notice_date);
                            $('#termination_date_update').val(data.termination_date);
                            $('#description_update').val(data.description);
                        },
                        error: function error(data) {
                            console.error(data);
                        }
                    });
                });


                $('#update_termination_form').on('submit', (e) => {
                    e.preventDefault();

                    let termination_id = $('#termination_id').val();
                    //console.log(e.target);
                    let formData = new FormData(e.target);
                    $.ajax({
                        type: "post",
                        data: formData,
                        processData: false,
                        contentType: false,
                        url: `{{ url('termination') }}/${termination_id}`,
                        success: function success(data) {
                            terminationTable.ajax.reload();
                            modalHide('edit_termination_modal');
                            show_toastr('Success', 'Termination successfully updated.', 'success');
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
