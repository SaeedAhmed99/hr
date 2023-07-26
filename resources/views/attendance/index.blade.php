@extends('layouts.app')
@section('page-title')
    {{ __('Attendence') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">Attendence</p>
                        {{--  <button data-bs-toggle="modal" data-bs-target="#add_award_modal" class="btn btn-gray"><i
                                class="fa-solid fa-plus"></i></button>  --}}
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('attendance.index') }}" method="get" id="attendance_filter">
                        <div class="row align-items-center">
                            {{-- <div class="col-xl-2 col-md-12 col-12">
                                <label class="form-label">{{ __('Type') }}</label> <br>
                                <div class="form-check form-check-inline form-group">
                                    <input type="radio" id="monthly" value="monthly" name="type" class="form-check-input" {{ isset($_GET['type']) && $_GET['type'] == 'monthly' ? 'checked' : 'checked' }}>
                                    <label class="form-check-label" for="monthly">{{ __('Monthly') }}</label>
                                </div>
                                <div class="form-check form-check-inline form-group">
                                    <input type="radio" id="daily" value="daily" name="type" class="form-check-input" {{ isset($_GET['type']) && $_GET['type'] == 'daily' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="daily">{{ __('Date Range') }}</label>
                                </div>
                            </div> --}}
                            {{-- <div class="col-xl-2 col-md-3 col-sm-12 col-12 month">
                                <div class="btn-box">
                                    <label class="form-label" name="month">{{ __('Month') }}</label>
                                    <input id="month" name="month" class="month-btn form-control"
                                        value="{{ isset($_GET['month']) ? $_GET['month'] : date('Y-m') }}">
                                </div>
                            </div> --}}
                            <div class="col-xl-3 col-md-6 col-sm-12 col-12 date">
                                <div class="d-flex gap-1">
                                    <div class="">
                                        <label class="form-label" for="from">From</label>
                                        <input class="form-control" type="text" id="from" name="from"
                                            value="{{ isset($_GET['from']) ? $_GET['from'] : date('Y-m-d') }}">
                                    </div>
                                    <div>
                                        <label class="form-label" for="to">to</label>
                                        <input class="form-control" type="text" id="to" name="to"
                                            value="{{ isset($_GET['to']) ? $_GET['to'] : date('Y-m-d') }}">
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-3 date"></div> --}}
                            @if (Auth::user()->can('Manage Attendance'))
                                <div class="col-xl-2 col-md-3 col-sm-12 col-12">
                                    <div class="btn-box">
                                        <label class="form-label" name="branch">{{ __('Branch') }}</label>
                                        <select id="branch" name="branch" class="form-control"
                                            onchange="fetchDepartment(this.value)">
                                            <option value="">All</option>
                                            @foreach ($branches as $key => $branch)
                                                <option value="{{ $key }}"
                                                    {{ (isset($_GET['branch']) and $key == $_GET['branch']) ? 'selected' : '' }}>
                                                    {{ $branch }}
                                                </option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="col-xl-2 col-md-3 col-sm-12 col-12">
                                    <div class="btn-box">
                                        <label class="form-label" name="department">{{ __('Department') }}</label>
                                        <select id="department" name="department" class="form-control">
                                            <option value="">All</option>
                                            @foreach ($department as $key => $department)
                                                <option value="{{ $key }}"
                                                    {{ (isset($_GET['department']) and $key == $_GET['department']) ? 'selected' : '' }}>
                                                    {{ $department }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="btn-box">
                                        <label class="form-label" name="department">{{ __('Employee') }}</label>
                                        <select id="employee" name="employee" class="form-control">
                                            <option value="">All</option>
                                            @foreach ($employees as $employee)
                                                @if (isset($_GET['employee']) and $_GET['employee'] == $employee->id)
                                                    <option value="{{ $employee->id }}" selected>
                                                        {{ $employee->user->name }} </option>
                                                @else
                                                    <option value="{{ $employee->id }}"> {{ $employee->user->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif

                            <div class="col-auto mt-4">
                                <div class="row">
                                    <div class="col-auto">

                                        <a href="#" class="btn btn-sm btn-primary"
                                            onclick="document.getElementById('attendance_filter').submit(); return false;"
                                            data-bs-toggle="tooltip" title="{{ __('Apply') }}"
                                            data-original-title="{{ __('apply') }}">
                                            <span class="btn-inner--icon"><i
                                                    class="fa-solid fa-magnifying-glass"></i></i></span>
                                        </a>

                                        {{-- <a href="{{ route('attendance.index') }}" class="btn btn-sm btn-danger "
                                            data-bs-toggle="tooltip" title="{{ __('Reset') }}"
                                            data-original-title="{{ __('Reset') }}">
                                            <span class="btn-inner--icon"><i class="fa-solid fa-trash"></i></span>
                                        </a> --}}

                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <table id="attendance" class="table table-condensed">
                        <thead>
                            <tr>
                                @if (Auth::user()->can('Manage Attendance'))
                                    <th>{{ __('Employee') }}</th>
                                @endif
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Clock In') }}</th>
                                <th>{{ __('Clock Out') }}</th>
                                <th>{{ __('Duration') }}</th>
                                <th>{{ __('Overtime') }}</th>
                                @if (Auth::user()->can('Edit Attendance') || Auth::user()->can('Delete Attendance'))
                                    <th width="200px">{{ __('Action') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attendanceEmployee as $attendance)
                                <tr>
                                    @if (Auth::user()->can('Manage Attendance'))
                                        <td>{{ !empty($attendance->employee->user) ? $attendance->employee->user->name : '' }}
                                        </td>
                                    @endif
                                    <td>
                                        @if ($attendance->status == 1)
                                            Present
                                        @else
                                            Absent
                                        @endif
                                    </td>
                                    <td>{{ $attendance->clock_in->format('Y-m-d h:i A') }}
                                    </td>
                                    <td>{{ $attendance->clock_out ? $attendance->clock_out->format('Y-m-d h:i A') : ' - ' }}
                                    </td>
                                    <td>
                                        @php
                                            if (!is_null($attendance->clock_out)) {
                                                $diffInSeconds = $attendance->clock_out->diffInSeconds($attendance->clock_in);
                                                echo gmdate('H:i \m', $diffInSeconds);
                                            }
                                        @endphp
                                    </td>
                                    <td>{{ $attendance->overtime }}</td>
                                    @if (Auth::user()->can('Edit Attendance') || Auth::user()->can('Delete Attendance'))
                                        <td class="Action">
                                            <div class="col-auto">
                                                @can('Edit Attendance')
                                                    <a href="#" class="btn btn-sm btn-primary attendance-edit"
                                                        data-bs-target="#edit_attendance_modal" data-bs-toggle="modal"
                                                        data-id="{{ $attendance->id }}" title="{{ __('Edit') }}"
                                                        data-original-title="{{ __('Edit') }}">
                                                        <span class="btn-inner--icon"><i
                                                                class="fa-regular fa-pen-to-square"></i></span>
                                                    </a>
                                                @endcan
                                                @can('Delete Attendance')
                                                    <button class="btn btn-sm btn-danger attendance-delete"
                                                        title="{{ __('Delete') }}" data-id="{{ $attendance->id }}"
                                                        data-original-title="{{ __('Delete') }}">
                                                        <span class="btn-inner--icon"><i class="fa-solid fa-trash"></i></span>
                                                    </button>
                                                @endcan
                                            </div>
                                        </td>
                                    @endif

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{--  add modal start  --}}
    <div class="modal fade" tabindex="-1" id="add_award_modal">
        <div class="modal-dialog">
            <form action="" id="add_award_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Award Type</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">

                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter Award Type Name" aria-describedby="name_invalid">
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
    <div class="modal fade" tabindex="-1" id="edit_attendance_modal">
        <div class="modal-dialog modal-lg">
            <form action="" id="update_attendance_form">
                <input type="hidden" id="_method" name="_method" value="patch">
                <input type="hidden" name="attendance_id" id="attendance_id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Attendance</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <label for="employee" class="form-label">Employee</label>
                                <input type="text" readonly class="form-control" id="employe" name="employee"
                                    placeholder="Name" aria-describedby="name_invalid">
                                <div id="employee_invalid" class="invalid-feedback"></div>
                            </div>
                            <div class="col-6 mt-2">
                                <label for="clock_in_date" class="form-label">Clock In Date</label>
                                <input type="text" class="form-control" id="clock_in_date" name="clock_in_date"
                                    placeholder="Clock In Date" aria-describedby="name_invalid">
                                <div id="clock_in_date_invalid" class="invalid-feedback"></div>
                            </div>
                            <div class="col-6 mt-2">
                                <label for="clock_in_time" class="form-label">Clock In Time</label>
                                <input type="text" class="form-control" id="clock_in_time" name="clock_in_time"
                                    placeholder="Clock In Time" aria-describedby="name_invalid">
                                <div id="clock_in_time_invalid" class="invalid-feedback"></div>
                            </div>
                            <div class="col-6 mt-2">
                                <label for="clock_out_date" class="form-label">Clock Out Date</label>
                                <input type="text" class="form-control" id="clock_out_date" name="clock_out_date"
                                    placeholder="Clock Out Date" aria-describedby="name_invalid">
                                <div id="clock_out_date_invalid" class="invalid-feedback"></div>
                            </div>
                            <div class="col-6 mt-2">
                                <label for="clock_out_time" class="form-label">Clock Out Time</label>
                                <input type="text" class="form-control" id="clock_out_time" name="clock_out_time"
                                    placeholder="Clock Out Time" aria-describedby="name_invalid">
                                <div id="clock_out_time_invalid" class="invalid-feedback"></div>
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
@endsection

@push('js')
    <script>
        var awardTable;

        $("#clock_in_date").datepicker({
            dateFormat: "yy-mm-dd"
        });
        $("#clock_out_date").datepicker({
            dateFormat: "yy-mm-dd"
        });
        $("#clock_in_time").timepicker({
            zindex: 9999999
        });
        $("#clock_out_time").timepicker({
            zindex: 9999999
        });

        $("#month").datepicker({
            dateFormat: "yy-mm"
        });
        $("#date").datepicker({
            dateFormat: "yy-mm-dd"
        });


        $(document).ready(function() {

            attendanceTable = $('#attendance').DataTable({
                "searching": false,
                dom: '<"d-flex justify-content-between"l<"mb-2"B>>rtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ]
            });

            $('#add_award_form').on('submit', (e) => {
                e.preventDefault();
                let url = "{{ route('award.store') }}";
                let formData = new FormData(e.target);
                $.ajax({
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    url: url,
                    success: function success(data) {
                        $('#add_award_form').trigger("reset");
                        awardTable.ajax.reload();
                        modalHide('add_award_modal');
                        show_toastr('Success', 'Award Type successfully added.', 'success');
                    },
                    error: function error(data) {
                        handleFormValidation(data);
                        show_toastr('Error', 'Permission denied.', 'error');
                    }
                });
            });

            $('.attendance-delete').on('click', (e) => {
                let attendance = e.currentTarget.dataset.id;

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
                            url: `{{ url('attendance') }}/${attendance}`,
                            success: function success(data) {
                                window.location.reload();
                                show_toastr('Success',
                                    'Attendance Type successfully deleted.',
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

            $('.attendance-edit').on('click', (e) => {
                let attendance = e.currentTarget.dataset.id;
                //console.log('fdfs');
                $.ajax({
                    type: "get",
                    url: `{{ url('attendance') }}/${attendance}/edit`,
                    success: function success(data) {
                        //console.log(data.attendance.id);
                        $('#attendance_id').val(data.attendance.id);
                        $('#employe').val(data.employee.user.name);
                        $('#clock_in_date').val(data.clock_in_date);
                        $('#clock_in_time').val(data.clock_in_time);
                        $('#clock_out_date').val(data.clock_out_date);
                        $('#clock_out_time').val(data.clock_out_time);
                    },
                    error: function error(data) {
                        console.error(data);
                    }
                });
            });


            $('#update_attendance_form').on('submit', (e) => {
                e.preventDefault();

                let attendance_id = $('#attendance_id').val();
                //console.log(e.target);
                let formData = new FormData(e.target);
                $.ajax({
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    url: `{{ url('manual-attendance') }}/${attendance_id}`,
                    success: function success(data) {
                        //awardTable.ajax.reload();
                        window.location.reload();
                        show_toastr('Success', 'Award Type successfully updated.', 'success');

                    },
                    error: function error(data) {
                        handleFormValidation(data);
                    }
                });
            });
        });
    </script>

    <script>
        $('input[name="type"]:radio').on('change', function(e) {
            var type = $(this).val();

            if (type == 'monthly') {
                $('.month').addClass('d-block');
                $('.month').removeClass('d-none');
                $('.date').addClass('d-none');
                $('.date').removeClass('d-block');
            } else {
                $('.date').addClass('d-block');
                $('.date').removeClass('d-none');
                $('.month').addClass('d-none');
                $('.month').removeClass('d-block');
            }
        });

        $('input[name="type"]:radio:checked').trigger('change');



        let fetchDepartment = (branch_id) => {

            $.ajax({
                type: "GET",
                url: "/department-branch/" + branch_id,
                dataType: 'json',
                success: function(data) {
                    //console.log(data);
                    let department = document.getElementById('department');
                    let all_options = "<option value='' selected>All</option>";

                    data.forEach(element => {
                        all_options = all_options + "<option value='" + element['id'] + "'>" +
                            element['name'] + "</option>";
                    });

                    document.getElementById('department').innerHTML = all_options;
                }
            });
        }
    </script>
    <script>
        $(function() {
            var dateFormat = "yy-mm-dd",
                from = $("#from")
                .datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    numberOfMonths: 1,
                    dateFormat: "yy-mm-dd"
                })
                .on("change", function() {
                    to.datepicker("option", "minDate", getDate(this));
                }),
                to = $("#to").datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    numberOfMonths: 1,
                    dateFormat: "yy-mm-dd"
                })
                .on("change", function() {
                    from.datepicker("option", "maxDate", getDate(this));
                });

            function getDate(element) {
                var date;
                try {
                    date = $.datepicker.parseDate(dateFormat, element.value);
                } catch (error) {
                    date = null;
                }

                return date;
            }
        });
    </script>
@endpush
