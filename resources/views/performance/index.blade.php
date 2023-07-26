@extends('layouts.app')
@section('page-title')
    {{ __('Performance') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">All Performance</p>
                        @can('Create Performance')
                        <button data-bs-toggle="modal" data-bs-target="#add_performance_modal" class="btn btn-gray"><i
                                class="fa-solid fa-plus"></i></button>
                                @endcan
                    </div>
                </div>
                <div class="card-body">
                    <table id="performance" class="table table-condensed">
                        <thead>
                            <tr>
                                <th>{{ __('Employee') }}</th>
                                <th>{{ __('Branch') }}</th>
                                <th>{{ __('Designation') }}</th>
                                <th>{{ __('Month') }}</th>
                                <th>{{ __('Overall Rating') }}</th>
                                <th>{{ __('Performed By') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    {{--  add modal start  --}}
    <div class="modal fade" tabindex="-1" id="add_performance_modal">
        <div class="modal-dialog">
            <form action="" id="add_performance_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create Performance</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <label for="branch">
                                        Branch
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Branch select"
                                        name="branch" id="branch">
                                        <option value="">Select Branch</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}"> {{ $branch->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="branch_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="mt-2">
                                    <label for="employee">
                                        Employee
                                    </label>
                                    <div class="employee_div">
                                        <select style="width: 100%" class="form-select employee" aria-label="Branch select"
                                            name="employee" id="employee">
                                            <option value="">Select Employee</option>
                                            {{--  @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}"> {{ $employee->user->name }}
                                            </option>
                                        @endforeach  --}}
                                        </select>
                                    </div>

                                    <div id="employee_invalid" class="invalid-feedback"></div>
                                </div>
                                {{--  <div class="mt-2">
                                    <label for="designation">
                                        Designation
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Branch select"
                                        name="designation" id="designation">
                                        <option value="">Select Designation</option>
                                        @foreach ($designations as $designation)
                                            <option value="{{ $designation->id }}"> {{ $designation->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="designation_invalid" class="invalid-feedback"></div>
                                </div>  --}}
                                <div class="mt-2">
                                    <label for="month" class="form-label">Performance Month</label>
                                    <input type="text" class="form-control" id="month" name="month"
                                        placeholder="Select Month" aria-describedby="name_invalid">
                                    <div id="month_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="mt-2">
                                    <label for="remark" class="form-label">Remark</label>
                                    <textarea type="text" class="form-control" id="remark" name="remark" cols="4" rows="4"
                                        placeholder="Remark" aria-describedby="name_invalid"></textarea>
                                    <div id="remark_invalid" class="invalid-feedback"></div>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            @foreach ($performance_critarias as $performance_critaria)
                                <div class="col-md-12 mt-3">
                                    <h6>{{ $performance_critaria->name }}</h6>
                                    <hr class="mt-0">
                                </div>

                                @foreach ($performance_critaria->metric as $types)
                                    <div class="col-6">
                                        {{ $types->name }}
                                    </div>
                                    <input type="hidden" name="performance_metric_id" id="performance_metric_id"
                                        value="{{ $types->id }}">
                                    <div class="col-6">
                                        <fieldset id='demo1' class="rate">
                                            <input class="stars" type="radio" id="technical-5-{{ $types->id }}"
                                                name="rating[{{ $types->id }}]" value="5" />
                                            <label class="full" for="technical-5-{{ $types->id }}"
                                                title="Awesome - 5 stars"></label>
                                            <input class="stars" type="radio" id="technical-4-{{ $types->id }}"
                                                name="rating[{{ $types->id }}]" value="4" />
                                            <label class="full" for="technical-4-{{ $types->id }}"
                                                title="Pretty good - 4 stars"></label>
                                            <input class="stars" type="radio" id="technical-3-{{ $types->id }}"
                                                name="rating[{{ $types->id }}]" value="3" />
                                            <label class="full" for="technical-3-{{ $types->id }}"
                                                title="Meh - 3 stars"></label>
                                            <input class="stars" type="radio" id="technical-2-{{ $types->id }}"
                                                name="rating[{{ $types->id }}]" value="2" />
                                            <label class="full" for="technical-2-{{ $types->id }}"
                                                title="Kinda bad - 2 stars"></label>
                                            <input class="stars" type="radio" id="technical-1-{{ $types->id }}"
                                                name="rating[{{ $types->id }}]" value="1" />
                                            <label class="full" for="technical-1-{{ $types->id }}"
                                                title="Sucks big time - 1 star"></label>
                                        </fieldset>
                                    </div>
                                @endforeach
                            @endforeach
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
    <div class="modal fade" tabindex="-1" id="edit_performance_modal">
        <div class="modal-dialog">
            <form action="" id="update_performance_form">
                <input type="hidden" id="_method" name="_method" value="patch">
                <input type="hidden" name="performance_id" id="performance_id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Performance</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <label for="branch_update">
                                        Branch
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Branch select"
                                        name="branch_update" id="branch_update" disabled>
                                        <option value="">Select Branch</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}"> {{ $branch->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="branch_update_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="mt-2">
                                    <label for="employee_update">
                                        Employee
                                    </label>
                                    <div class="employee_div">
                                        <select style="width: 100%" class="form-select" aria-label="Branch select"
                                            name="employee_update" id="employee_update" disabled>
                                            <option value="">Select Employee</option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}"> {{ $employee->user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div id="employee_update_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="mt-2">
                                    <label for="month_update" class="form-label">Performance Month</label>
                                    <input type="text" class="form-control" id="month_update" name="month_update"
                                        placeholder="Select Month" aria-describedby="name_invalid">
                                    <div id="month_update_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="mt-2">
                                    <label for="remark_update" class="form-label">Remark</label>
                                    <textarea type="text" class="form-control" id="remark_update" name="remark_update" cols="4"
                                        rows="4" placeholder="Remark" aria-describedby="name_invalid"></textarea>
                                    <div id="remark_update_invalid" class="invalid-feedback"></div>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            @foreach ($performance_critarias as $performance_critaria)
                                <div class="col-md-12 mt-3">
                                    <h6>{{ $performance_critaria->name }}</h6>
                                    <hr class="mt-0">
                                </div>

                                @foreach ($performance_critaria->metric as $types)
                                    <div class="col-6">
                                        {{ $types->name }}
                                    </div>
                                    <input type="hidden" name="performance_metric_id" id="performance_metric_id"
                                        value="{{ $types->id }}">
                                    <div class="col-6">
                                        <fieldset id='demo1' class="rate">
                                            <input class="stars" type="radio" id="performance-5-{{ $types->id }}"
                                                name="rating_update[{{ $types->id }}]" value="5" />
                                            <label class="full" for="performance-5-{{ $types->id }}"
                                                title="Awesome - 5 stars"></label>
                                            <input class="stars" type="radio" id="performance-4-{{ $types->id }}"
                                                name="rating_update[{{ $types->id }}]" value="4" />
                                            <label class="full" for="performance-4-{{ $types->id }}"
                                                title="Pretty good - 4 stars"></label>
                                            <input class="stars" type="radio" id="performance-3-{{ $types->id }}"
                                                name="rating_update[{{ $types->id }}]" value="3" />
                                            <label class="full" for="performance-3-{{ $types->id }}"
                                                title="Meh - 3 stars"></label>
                                            <input class="stars" type="radio" id="performance-2-{{ $types->id }}"
                                                name="rating_update[{{ $types->id }}]" value="2" />
                                            <label class="full" for="performance-2-{{ $types->id }}"
                                                title="Kinda bad - 2 stars"></label>
                                            <input class="stars" type="radio" id="performance-1-{{ $types->id }}"
                                                name="rating_update[{{ $types->id }}]" value="1" />
                                            <label class="full" for="performance-1-{{ $types->id }}"
                                                title="Sucks big time - 1 star"></label>
                                        </fieldset>
                                    </div>
                                @endforeach
                            @endforeach
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

    {{--  show modal start  --}}
    <div class="modal fade" tabindex="-1" id="show_performance_modal">
        <div class="modal-dialog">
            <form action="" id="update_performance_form">
                <input type="hidden" id="_method" name="_method" value="patch">
                <input type="hidden" name="performance_id" id="performance_id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Performance Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div>
                                    <strong>{{ __('Branch') }} : </strong>

                                </div>
                                <div>
                                    <strong>{{ __('Employee') }} : </strong>
                                </div>
                                <div>
                                    <strong>{{ __('Month') }} : </strong>
                                </div>
                                 <div>
                                    <strong>{{ __('Remark') }} : </strong>
                                </div>
                            </div>
                            <div class="col-6">
                                <div>
                                    <span id="branch_label"></span>
                                </div>
                                <div>
                                    <span id="employee_label"></span>
                                </div>
                                <div>
                                    <span id="month_label"></span>
                                </div>
                                 <div>
                                    <span id="remark_label"></span>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            @foreach ($performance_critarias as $performance_critaria)
                                <div class="col-md-12 mt-3">
                                    <h6>{{ $performance_critaria->name }}</h6>
                                    <hr class="mt-0">
                                </div>

                                @foreach ($performance_critaria->metric as $types)
                                    <div class="col-6">
                                        {{ $types->name }}
                                    </div>
                                    <input type="hidden" name="performance_metric_id" id="performance_metric_id"
                                        value="{{ $types->id }}">
                                    <div class="col-6">
                                        <fieldset id='demo1' class="rate">
                                            <input class="stars" type="radio" id="show-performance-5-{{ $types->id }}"
                                                name="rating_update[{{ $types->id }}]" value="5" />
                                            <label class="full" for="show-performance-5-{{ $types->id }}"
                                                title="Awesome - 5 stars"></label>
                                            <input class="stars" type="radio" id="show-performance-4-{{ $types->id }}"
                                                name="rating_update[{{ $types->id }}]" value="4" />
                                            <label class="full" for="show-performance-4-{{ $types->id }}"
                                                title="Pretty good - 4 stars"></label>
                                            <input class="stars" type="radio" id="show-performance-3-{{ $types->id }}"
                                                name="rating_update[{{ $types->id }}]" value="3" />
                                            <label class="full" for="show-performance-3-{{ $types->id }}"
                                                title="Meh - 3 stars"></label>
                                            <input class="stars" type="radio" id="show-performance-2-{{ $types->id }}"
                                                name="rating_update[{{ $types->id }}]" value="2" />
                                            <label class="full" for="show-performance-2-{{ $types->id }}"
                                                title="Kinda bad - 2 stars"></label>
                                            <input class="stars" type="radio" id="show-performance-1-{{ $types->id }}"
                                                name="rating_update[{{ $types->id }}]" value="1" />
                                            <label class="full" for="show-performance-1-{{ $types->id }}"
                                                title="Sucks big time - 1 star"></label>
                                        </fieldset>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                    {{--  <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>  --}}
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).on('change', 'select[name=branch]', function() {
            var branch = $(this).val();
            //console.log(branch);
            getEmployee(branch);
        });


        function getEmployee(did) {
            $.ajax({
                url: '{{ route('branch.employee.json') }}',
                type: 'POST',
                data: {
                    "branch": did,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {
                    //console.log(data);
                    // $('#employee').empty();
                    // $('#employee').append('<option value="">{{ __('Select Branch') }}</option>');
                    // $.each(data, function(key, value) {
                    //     $('#employee').append('<option value="' + key + '">' + value + '</option>');
                    // });

                    $('.employee').empty();
                    var emp_selct = ` <select style="width: 100%" class="form-select  employee" name="employee" id="employee"
                                            placeholder="Select Employee" >
                                            </select>`;
                    $('.employee_div').html(emp_selct);

                    //$('.employee').append('<option value="0"> {{ __('All') }} </option>');
                    $.each(data, function(key, value) {

                        $('.employee').append('<option value="' + value.id + '">' + value.user.name +
                            '</option>');

                    });
                    $('#employee').select2({
                        dropdownParent: $('#add_performance_modal'),
                        width: 'style'
                    });

                }
            });
        }
    </script>
    <script>
        $('#branch').select2({
            dropdownParent: $('#add_performance_modal'),
            width: 'style'
        });
        $('#employee').select2({
            dropdownParent: $('#add_performance_modal'),
            width: 'style'
        });
        $('#branch_update').select2({
            dropdownParent: $('#edit_performance_modal'),
            width: 'style'
        });


        $("#month").datepicker({
            dateFormat: 'yy-mm',
        });

        $("#month_update").datepicker({
            dateFormat: 'yy-mm',
        });

        var performanceTable;
        $(document).ready(function() {

            performanceTable = $('#performance').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('employee.performance.data') }}",
                columns: [{
                        data: 'employee.user.name',
                        name: 'employee.user.name'
                    },
                    {
                        data: 'branch.name',
                        name: 'branch.name'
                    },
                    {
                        data: 'designation.name',
                        name: 'designation.name'
                    },
                    {
                        data: 'performance_month',
                        name: 'performance_month'
                    },
                    {
                        data: 'score_avarage',
                        name: 'score_avarage'
                    },
                    {
                        data: 'performed_user.name',
                        name: 'performed_user.name'
                    },

                    {
                        data: 'action',className: "dt-right",
                        name: 'action'
                    }
                ],
                columnDefs: [{

                }],
            });



            $('#add_performance_form').on('submit', (e) => {
                e.preventDefault();
                let url = "{{ route('employee-performance.store') }}";
                let formData = new FormData(e.target);
                $.ajax({
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    url: url,
                    success: function success(data) {
                        $('#add_performance_form').trigger("reset");
                        performanceTable.ajax.reload();
                        modalHide('add_performance_modal');
                        show_toastr('Success', data, 'success');
                    },
                    error: function error(data) {
                        handleFormValidation(data);
                    }
                });
            });


            $('#performance').on('draw.dt', function() {
                $('.performance-delete').on('click', (e) => {
                    let performance = e.currentTarget.dataset.id;
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
                                url: `{{ url('employee-performance') }}/${performance}`,
                                success: function success(data) {
                                    performanceTable.ajax.reload();
                                    show_toastr('Success', data, 'success');
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


                $('.performance-edit').on('click', (e) => {
                    let performance = e.currentTarget.dataset.id;
                    //console.log('fdfs');
                    $.ajax({
                        type: "get",
                        url: `{{ url('employee-performance') }}/${performance}/edit`,
                        success: function success(data) {
                            //console.log(data.id);
                            $('#performance_id').val(data.id);
                            $('#branch_update').val(data.branch_id);
                            $('#branch_update').trigger('change');
                            $('#employee_update').val(data.employee_id);
                            $('#employee_update').trigger('change');
                            $('#month_update').val(data.performance_month.substr(0, 7));
                            $('#remark_update').val(data.remark);
                            data.performance_score.forEach((score) => {
                                $(`#performance-${score.score}-${score.performance_metric_id}`)
                                    .prop("checked", true);
                            })
                        },
                        error: function error(data) {
                            console.error(data);
                        }
                    });
                });


                $('.performance-show').on('click', (e) => {
                    let performance = e.currentTarget.dataset.id;
                    //console.log('fdfs');
                    $.ajax({
                        type: "get",
                        url: `{{ url('employee-performance') }}/${performance}`,
                        success: function success(data) {
                            //console.log(data.id);
                            $('#performance_id').val(data.id);
                            $('#branch_label').html(data.branch.name);
                            $('#employee_label').html(data.employee.user.name);
                            $('#month_label').html(data.performance_month.substr(0, 7));
                            $('#remark_label').html(data.remark);
                            data.performance_score.forEach((score) => {
                                $(`#show-performance-${score.score}-${score.performance_metric_id}`)
                                    .prop("checked", true);
                            })
                        },
                        error: function error(data) {
                            console.error(data);
                        }
                    });
                });


                $('#update_performance_form').on('submit', (e) => {
                    e.preventDefault();

                    let performance_id = $('#performance_id').val();
                    //console.log(e.target);
                    let formData = new FormData(e.target);
                    $.ajax({
                        type: "post",
                        data: formData,
                        processData: false,
                        contentType: false,
                        url: `{{ url('employee-performance') }}/${performance_id}`,
                        success: function success(data) {
                            performanceTable.ajax.reload();
                            modalHide('edit_performance_modal');
                            show_toastr('Success', data, 'success');
                        },
                        error: function error(data) {
                            handleFormValidation(data);
                            show_toastr('Error', 'Please Fill Up the field', 'error');
                        }
                    });
                });


            });
        });
    </script>
@endpush
