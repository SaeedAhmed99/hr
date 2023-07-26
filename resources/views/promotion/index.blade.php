@extends('layouts.app')
@section('page-title')
    {{ __('Promotion') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">All Promotion</p>
                        @can('Create Promotion')
                            <button data-bs-toggle="modal" data-bs-target="#add_promotion_modal" class="btn btn-gray"><i class="fa-solid fa-plus"></i></button>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <table id="promotion" class="table table-condensed">
                        <thead>
                            <tr>
                                <th>{{ __('Employee Name') }}</th>
                                <th>{{ __('Old Designation') }}</th>
                                <th>{{ __('New Designation') }}</th>
                                <th>{{ __('Old Salary') }}</th>
                                <th>{{ __('New Salary') }}</th>
                                <th>{{ __('Promotion Title') }}</th>
                                <th>{{ __('Promotion Date') }}</th>
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
    <div class="modal fade" tabindex="-1" id="add_promotion_modal">
        <div class="modal-dialog modal-xl">
            <form action="" id="add_promotion_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Promote employee</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div>
                                    <label for="employee">
                                        Employee
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Branch select" name="employee" id="employee">
                                        <option value=""> Select Employee</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}"> {{ $employee->user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="employee_invalid" class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="mt-2">
                                    <label for="designation">
                                        Old Designation
                                    </label>
                                    <input type="text" name="old_designation" id="old_designation" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mt-2">
                                    <label for="designation">
                                        New Designation
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Designation select" name="designation" id="designation">
                                        <option value=""> Select Designation (Do not select if unchanged)</option>
                                        @foreach ($designations as $designation)
                                            <option value="{{ $designation->id }}"> {{ $designation->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="designation_invalid" class="invalid-feedback"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="mt-2">
                                    <label for="designation">
                                        Old Salary
                                    </label>
                                    <input type="number" name="old_salary" id="old_salary" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mt-2">
                                    <label for="designation">
                                        New Salary
                                    </label>
                                    <input type="number" name="salary" id="salary" class="form-control" placeholder="Leave empty if unchaged">
                                    <div id="salary_invalid" class="invalid-feedback"></div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mt-2">
                                    <label for="promotion_title" class="form-label">Promotion Title</label>
                                    <input type="text" class="form-control" id="promotion_title" name="promotion_title" placeholder="Enter Purpose" aria-describedby="description_invalid"></input>
                                    <div id="promotion_title_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="mt-2">
                                    <label for="promotion_date" class="form-label">Promotion Effective From</label>
                                    <input type="text" name="promotion_date" class="form-control" id="promotion_date">
                                    <div id="promotion_date_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="yes" id="promotion_effective_immidiate" name="promotion_effective_immidiate">
                                    <label class="form-check-label" for="promotion_effective_immidiate">
                                        Promotion effective immidiate
                                    </label>
                                </div>
                            </div>
                            <div>
                                <label for="description" class="form-label">Description</label>
                                <textarea type="text" class="form-control" id="description" name="description" placeholder="Enter Description" aria-describedby="description_invalid" row="3"></textarea>
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
    <div class="modal fade" tabindex="-1" id="edit_promotion_modal">
        <div class="modal-dialog modal-xl">
            <form action="" id="update_promotion_form">
                <input type="hidden" id="_method" name="_method" value="patch">
                <input type="hidden" name="promotion_id" id="promotion_id">
                <input type="hidden" name="employee_id" id="employee_update">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit promotion record</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div>
                                    <label for="employee">
                                        Employee
                                    </label>
                                    <input type="text" name="employee_name" id="employee_name" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-6">
                            </div>
                            <div class="col-6">
                                <div class="mt-2">
                                    <label for="designation">
                                        Old Designation
                                    </label>
                                    <input type="text" name="old_designation" id="old_designation_update" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mt-2">
                                    <label for="designation">
                                        New Designation
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Designation select" name="designation" id="designation_update">
                                        <option value=""> Select Designation (Do not select if unchanged)</option>
                                        @foreach ($designations as $designation)
                                            <option value="{{ $designation->id }}"> {{ $designation->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="designation_update_invalid" class="invalid-feedback"></div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="mt-2">
                                    <label for="old_salary_update">
                                        Old Salary
                                    </label>
                                    <input step="any" type="text" name="old_salary" id="old_salary_update" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mt-2">
                                    <label for="salary_update">
                                        New Salary
                                    </label>
                                    <input step="any" type="number" name="salary" id="salary_update" class="form-control" placeholder="Leave empty if unchaged">
                                    <div id="salary_update_invalid" class="invalid-feedback"></div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mt-2">
                                    <label for="promotion_title_update" class="form-label">Promotion Title</label>
                                    <input type="text" class="form-control" id="promotion_title_update" name="promotion_title" placeholder="Enter Purpose" aria-describedby="description_invalid"></input>
                                    <div id="promotion_title_update_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="mt-2">
                                    <label for="promotion_date_update" class="form-label">Promotion Effective From</label>
                                    <input type="text" name="promotion_date" class="form-control" id="promotion_date_update">
                                    <div id="promotion_date_update_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="yes" id="promotion_effective_immidiate_update" name="promotion_effective_immidiate">
                                    <label class="form-check-label" for="promotion_effective_immidiate_update">
                                        Promotion effective immidiate
                                    </label>
                                </div>
                            </div>
                            <div>
                                <label for="description_update" class="form-label">Description</label>
                                <textarea type="text" class="form-control" id="description_update" name="description" placeholder="Enter Description" aria-describedby="description_invalid" row="3"></textarea>
                                <div id="description_update_invalid" class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- <div class="modal fade" tabindex="-1" id="edit_promotion_modal">
        <div class="modal-dialog">
            <form action="" id="update_promotion_form">
                <input type="hidden" id="_method" name="_method" value="patch">
                <input type="hidden" name="promotion_id" id="promotion_id" value="">
                <input type="hidden" name="employee_id" id="employee_update" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Promotion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">

                                <div>
                                    <label for="employee_update">
                                        Employee
                                    </label>
                                    <input type="text" class="form-control" name="employee_update_name" id="employee_update_name" readonly>
                                </div>

                                <div class="mt-2">
                                    <label for="designation_update">
                                        Designation
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Branch select" name="designation_update" id="designation_update">
                                        <option value=""> Select Designation</option>
                                        @foreach ($designations as $designation)
                                            <option value="{{ $designation->id }}"> {{ $designation->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="designation_update_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="col-6">
                                    <div class="mt-2">
                                        <label for="designation">
                                            Old Designation
                                        </label>
                                        <input type="text" name="old_designation" id="old_designation" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mt-2">
                                        <label for="designation_update">
                                            New Designation
                                        </label>
                                        <select style="width: 100%" class="form-select" aria-label="Designation select" name="designation_update" id="designation_update">
                                            <option value=""> Select Designation (Do not select if unchanged)</option>
                                            @foreach ($designations as $designation)
                                                <option value="{{ $designation->id }}"> {{ $designation->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div id="designation_update_invalid" class="invalid-feedback"></div>
                                    </div>
                                </div>



                                <div class="mt-2">
                                    <label for="promotion_title_update" class="form-label">Promotion Title</label>
                                    <input type="text" class="form-control" id="promotion_title_update" name="promotion_title_update" placeholder="Enter Purpose" aria-describedby="description_invalid"></input>
                                    <div id="promotion_title_update_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="mt-2">
                                    <label for="promotion_date_update" class="form-label">Promotion Date</label>
                                    <input type="text" name="promotion_date_update" class="form-control" id="promotion_date_update">
                                    <div id="promotion_date_update_invalid" class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div>
                                <label for="description_update" class="form-label">Description</label>
                                <textarea type="text" class="form-control" id="description_update" name="description_update" placeholder="Enter Description" aria-describedby="description_invalid" row="3"></textarea>
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
    </div> --}}
@endsection

@push('js')
    <script>
        var transferTable;
        $(document).ready(function() {

            $('#promotion_effective_immidiate').on('change', (e) => {
                if(e.target.checked){
                    $("#promotion_date").attr('disabled', true);
                }else{
                    $("#promotion_date").attr('disabled', false);
                }
            });

            $('#promotion_effective_immidiate_update').on('change', (e) => {
                if(e.target.checked){
                    $("#promotion_date_update").attr('disabled', true);
                }else{
                    $("#promotion_date_update").attr('disabled', false);
                }
            });
            $('#employee').on('change', (e) => {
                $.ajax({
                    type: "get",
                    url: `{{ url('employee') }}/${e.target.value}`,
                    success: function success(data) {
                        console.log(data);
                        $('#old_designation').val(data.designation.name);
                        $('#old_salary').val(data.salary);
                    },
                    error: function error(data) {
                        show_toastr('Error', 'Something went wrong.', 'error');
                    }
                });
            });

            $('#employee').select2({
                dropdownParent: $('#add_promotion_modal'),
                width: 'style',

            });

            $('#designation').select2({
                dropdownParent: $('#add_promotion_modal'),
                width: 'style',

            });

            $("#promotion_date").datepicker({
                dateFormat: 'yy-mm-dd'
            });

            $("#promotion_date_update").datepicker({
                dateFormat: 'yy-mm-dd'
            });

            promotionTable = $('#promotion').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('promotion.data') }}",
                columns: [{
                        data: 'employee.user.name',
                        name: 'employee.user.name'
                    },
                    {
                        data: 'old_designation.name',
                        name: 'old_designation.name'
                    },
                    {
                        data: 'new_designation.name',
                        name: 'new_designation.name'
                    },
                    {
                        data: 'old_salary',
                        name: 'old_salary'
                    },
                    {
                        data: 'new_salary',
                        name: 'new_salary'
                    },
                    {
                        data: 'promotion_title',
                        name: 'promotion_title'
                    },
                    {
                        data: 'promotion_date',
                        name: 'promotion_date'
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

            $('#add_promotion_form').on('submit', (e) => {
                e.preventDefault();
                let url = "{{ route('promotion.store') }}";
                let formData = new FormData(e.target);
                $.ajax({
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    url: url,
                    success: function success(data) {
                        $('#add_promotion_form').trigger("reset");
                        $("#employee").val('').trigger('change');
                        $("#designation").val('').trigger('change');
                        promotionTable.ajax.reload();
                        modalHide('add_promotion_modal');
                        show_toastr('Success', 'Promotion successfully added.', 'success');
                    },
                    error: function error(data) {
                        handleFormValidation(data);
                    }
                });
            });

            $('#promotion').on('draw.dt', function() {
                $('.promotion-delete').on('click', (e) => {
                    let promotion = e.currentTarget.dataset.id;
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
                                url: `{{ url('promotion') }}/${promotion}`,
                                success: function success(data) {
                                    promotionTable.ajax.reload();
                                    show_toastr('Success', 'Promotion successfully deleted.', 'success');
                                },
                                error: function error(data) {
                                    console.error(data);
                                    show_toastr('Error', 'Permission denied.', 'error');
                                }
                            });
                        }
                    })
                });

                $('.promotion-edit').on('click', (e) => {
                    let promotion = e.currentTarget.dataset.id;
                    //console.log('fdfs');
                    $.ajax({
                        type: "get",
                        url: `{{ url('promotion') }}/${promotion}/edit`,
                        success: function success(data) {
                            //console.log(data.id);
                            $('#promotion_id').val(data.id);
                            $('#employee_update').val(data.employee_id);
                            $('#employee_name').val(data.employee.user.name);
                            $('#old_designation_update').val(data.old_designation.name);
                            $('#designation_update').val(data.new_designation_id);
                            $('#old_salary_update').val(data.old_salary);
                            $('#salary_update').val(data.new_salary);
                            $('#promotion_title_update').val(data.promotion_title);
                            $('#promotion_date_update').val(data.promotion_date);
                            $('#description_update').val(data.description);
                        },
                        error: function error(data) {
                            console.error(data);
                        }
                    });
                });

                $('#update_promotion_form').on('submit', (e) => {
                    e.preventDefault();

                    let promotion_id = $('#promotion_id').val();
                    //console.log(e.target);
                    let formData = new FormData(e.target);
                    $.ajax({
                        type: "post",
                        data: formData,
                        processData: false,
                        contentType: false,
                        url: `{{ url('promotion') }}/${promotion_id}`,
                        success: function success(data) {
                            promotionTable.ajax.reload();
                            modalHide('edit_promotion_modal');
                            show_toastr('Success', 'Promotion successfully updated.', 'success');
                        },
                        error: function error(data) {
                            handleFormValidation(data, 'update');
                        }
                    });
                });
            });
        });
    </script>
@endpush
