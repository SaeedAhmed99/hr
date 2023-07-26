@extends('layouts.app')

@push('head')
    <style>
        #employee_attendance,
        #department_wise_employee,
        #designation_wise_employee {
            min-height: 275px;
        }

        .icon {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 100%;
            background-color: var(--base-color);
        }

        .time {
            font-size: 1.1rem;
        }

        #announcements {
            max-height: 345px;
            overflow-y: auto;
        }

        .text-meeting {
            color: #46e2c8;
        }

        .meeting-bg {
            background: #46e2c815;
        }

        .text-announcement {
            color: #46b1e2;
        }

        .announcement-bg {
            background: #46b1e215;
        }

        .text-termination {
            color: #e2467a;
        }

        .termination-bg {
            background: #e2467a15;
        }

        .text-promotion {
            color: #46e26d;
        }

        .promotion-bg {
            background: #46e26d15;
        }

        .text-award {
            color: #4684e2;
        }

        .award-bg {
            background: #4684e215;
        }

        .text-transfer {
            color: #e2df46;
        }

        .transfer-bg {
            background: #e2df4615;
        }

        .text-performance {
            color: #9c46e2;
        }

        .performance-bg {
            background: #9c46e215;
        }
    </style>
@endpush

@section('page-title')
    {{ __('Dashboard') }}
@endsection

@section('content')
    <div class="row">
        <div class="@if (!auth()->user()->isEmployee()) col-xl-7 @else col-xl-6 @endif col-12">
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="d-flex justify-content-between ps-3 pt-4 mb-5">
                                <div>
                                    <h5> Hi, {{ auth()->user()->name }} </h5>
                                    <h5>
                                        {{ \Carbon\Carbon::greet() }}!
                                        @if (is_null($todays_attendance) and
                                                auth()->user()->isEmployee())
                                            <span class="text-muted" id="clocked_in_message">You have not clocked in
                                                yet</span>
                                        @endif
                                    </h5>
                                </div>
                                <div>
                                    @if (auth()->user()->isEmployee())
                                        <button data-bs-toggle="modal" data-bs-target="#clock_in_modal"
                                            class="clock-in-button text-nowrap btn btn-primary rounded-0 rounded-start {{ is_null($todays_attendance) ? '' : 'd-none' }}">Clock
                                            In</button>
                                        <button
                                            class="text-nowrap clock-out-button btn btn-danger rounded-0 rounded-start  {{ (is_null($todays_attendance) or !is_null($todays_attendance->clock_out)) ? 'd-none' : '' }}">Clock
                                            Out</button>
                                    @endif
                                </div>
                            </div>
                            <div class="clock-in-div">
                                @if (
                                    !is_null($todays_attendance) and
                                        is_null($todays_attendance->clock_out) and
                                        auth()->user()->isEmployee())
                                    <x-clock-in-show :clocked-in="$todays_attendance->clock_in" :attendance-id="$todays_attendance->id" />
                                @elseif(
                                    !is_null($todays_attendance) and
                                        !is_null($todays_attendance->clock_out) and
                                        auth()->user()->isEmployee())
                                    <x-clock-out-show :clocked-in="$todays_attendance->clock_in" :clocked-out="$todays_attendance->clock_out" />
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @if (auth()->user()->isEmployee())
                    <div class="col-md-6 col-12 mt-3">
                        <div class="card backcolor text-white dashboard-card-hover div-link"
                            data-link="{{ route('attendance.index') }}">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="col-auto">
                                        <b>This weeks work hour</b>
                                        <h4><b id="week_hour">
                                                <div class="spinner-border text-primary" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </b></h4>
                                    </div>
                                    <div class="col-auto text-2"><i class="fa-solid fa-person-digging"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 mt-3">
                        <div class="card dashboard-card-hover div-link" data-link="{{ route('attendance.index') }}">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="col-auto">
                                        <b>Todays total hour</b>
                                        <h4><b id="today_hour">
                                                <div class="spinner-border text-primary" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </b></h4>
                                    </div>
                                    <div class="col-auto text-2 text-warning"><i
                                            class="fa-solid fa-person-walking-arrow-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if (!auth()->user()->isEmployee())
                    <div class="col-xl-4 col-12 mt-3">
                        <div class=" h-100 card backcolor text-white dashboard-card-hover div-link"
                            data-link="{{ route('employee.index') }}">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center h-100">
                                    <div class="col-auto">
                                        <b>Total employee</b>
                                        <h4><b>{{ $employee_count }}</b></h4>
                                    </div>
                                    <div class="col-auto text-2"><i class="fa fa-user"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-12 mt-3">
                        <div class="card dashboard-card-hover div-link" data-link="{{ route('leave.index') }}">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="">
                                        <b>Employees on leave</b>
                                        <h4><b>{{ $leave_employee_count }}</b></h4>
                                    </div>
                                    <div class="text-2 text-warning"><i class="fa-solid fa-person-walking-arrow-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-12 mt-3">
                        <div class="card backcolor-rotated text-white dashboard-card-hover div-link"
                            data-link="{{ route('daily.attendance.report') }}">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="">
                                        <b>Employees on time</b>
                                        <h4><b id="employee_on_time">
                                                <div class="spinner-border text-primary" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </b></h4>
                                    </div>
                                    <div class="text-2"><i class="fa-solid fa-user-clock"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="row">
                @if (!auth()->user()->isEmployee())
                    <div class="col-12 mt-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="col-auto">
                                        <b>Employee attendance</b>
                                    </div>
                                </div>
                                <div>
                                    <div id="employee_attendance"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if (auth()->user()->isEmployee())
                    <div class="col-12 mt-3">
                        <div class="container">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <b>Notices</b>
                                <button class="btn btn-xs mark-all"><i class="fas fa-check"></i>Clear All Notice</button>
                            </div>
                            <div id="announcements"></div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        @if (!auth()->user()->isEmployee())
            <div class="col-xl-5 col-12 m-xl-0 mt-3">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Modal -->
        <div class="modal fade" id="clock_in_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Clock in</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex">
                            <div class="icon">
                                <i class="fa-solid fa-arrow-right-to-bracket"></i>
                            </div>
                            <div class="ms-2">
                                <p class="mb-0">Clock in date & time</p>
                                <p class="time" id="time"> </p>
                            </div>
                        </div>
                        <textarea name="note" id="note" cols="15" rows="3" class="form-control" placeholder="Note"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary clock-in">Clock in</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        var timeDisplay = document.getElementById("time");
        let notice_table;
        let todaytime

        function refreshTime() {
            var dateString = new Date().toLocaleString({
                timeZone: "Asia/Dhaka"
            });
            var formattedString = dateString.replace(", ", " - ");
            timeDisplay.innerHTML = formattedString;
        }

        let countTodayTime = () => {
            let dividedtime = toHoursAndMinutes(todaytime);
            $('#today_hour').html(
                `${dividedtime.h}h : ${dividedtime.m.padStart(2, "0")}m : ${dividedtime.s.padStart(2, "0")}s`);
            todaytime++;
        }

        refreshTime();
        setInterval(refreshTime, 1000);


        $('.mark-all').on('click', (e) => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to mark all notices as seen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "post",
                        url: "{{ route('notice.clear.all') }}",
                        success: function success(data) {
                            getAnnouncement();
                        },
                        error: function error(data) {
                            show_toastr('Error', data.responseJSON.message, 'error');
                        }
                    });
                }
            })
        });

        $('.clock-in').on('click', () => {
            $.ajax({
                type: "post",
                data: {
                    "note": $("#note").val()
                },
                url: "{{ route('attendance.store') }}",
                success: function success(data) {
                    $("#clocked_in_message").addClass('d-none');
                    $('.clock-in-button').addClass('d-none');
                    $('.clock-out-button').removeClass('d-none');
                    $(".clock-in-div").html(data.html);
                    $("#clock_in_modal").modal("hide");
                    show_toastr('Success', data.meassage, 'success');
                },
                error: function error(data) {
                    console.log(data);
                    if (data.status == 422) {
                        show_toastr('Error', data.responseJSON.errors.meassage[0], 'error');
                    } else {
                        handleFormValidation(data);
                    }
                }
            });
        });
        $('.clock-out-button').on('click', () => {
            $.ajax({
                type: "post",
                data: {
                    _method: 'patch'
                },
                url: `{{ url('attendance') }}/${$("#attendance_id").val()}`,
                success: function success(data) {
                    $('.clock-in-button').addClass('disabled');
                    $('.clock-out-button').addClass('d-none');
                    $(".clock-in-div").html(data.html);
                    show_toastr('Success', data.meassage, 'success');
                },
                error: function error(data) {
                    handleFormValidation(data);
                }
            });
        });

        notice_table = $('#notice').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('notice.data') }}",
            columns: [{
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'body',
                    name: 'body'
                },
                {
                    data: 'notice_date',
                    name: 'notice_date'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ],
            columnDefs: [{

            }],
        });

        let updateEventListener = () => {
            $('.seen').on('click', (e) => {
                let notice = e.currentTarget.dataset.id;
                $.ajax({
                    type: "post",
                    data: {
                        "_method": "patch"
                    },
                    url: `{{ url('notice') }}/${notice}`,
                    success: function success(data) {
                        getAnnouncement()
                    },
                    error: function error(data) {
                        show_toastr('Error', data.responseJSON.message, 'error');
                    }
                });
            });
        }

        let getAnnouncement = () => {
            $.ajax({
                type: "get",
                url: "{{ route('last.announcements') }}",
                success: function success(data) {
                    $("#announcements").html(data);
                    updateEventListener();
                }
            });
        }

        let toHoursAndMinutes = (totalSeconds) => {
            const totalMinutes = Math.floor(totalSeconds / 60);

            const seconds = totalSeconds % 60;
            const hours = Math.floor(totalMinutes / 60);
            const minutes = totalMinutes % 60;

            return {
                h: hours.toString(),
                m: minutes.toString(),
                s: seconds.toString()
            };
        }

        $(document).ready(function() {
            @if (!auth()->user()->isEmployee())

                $.ajax({
                    type: "get",
                    url: "{{ route('department.wise.employee') }}",
                    success: function success(data) {
                        let series = data.series.map(function(item) {
                            return parseInt(item, 10);
                        })
                        var options = {
                            series: series,
                            labels: data.label,
                            chart: {
                                type: 'donut',
                                height: '100%',
                                width: '100%'
                            },
                            legend: {
                                position: 'bottom'
                            }
                        };

                        var chart = new ApexCharts(document.querySelector("#department_wise_employee"),
                            options);
                        chart.render();
                    }
                });

                $.ajax({
                    type: "get",
                    url: "{{ route('designation.wise.employee') }}",
                    success: function success(data) {
                        let series = data.series.map(function(item) {
                            return parseInt(item, 10);
                        })
                        var options = {
                            series: series,
                            labels: data.label,
                            chart: {
                                type: 'donut',
                                height: '100%',
                                width: '100%'
                            },
                            legend: {
                                position: 'bottom'
                            }
                        };

                        var chart = new ApexCharts(document.querySelector("#designation_wise_employee"),
                            options);
                        chart.render();
                    }
                });

                $.ajax({
                    type: "get",
                    url: "{{ route('todays.employee.attendance') }}",
                    success: function success(data) {
                        console.log(data.series[2]);
                        $('#employee_on_time').html(data.series[
                            2]); // 2 index of the series is total employee on time!
                        let series = data.series.map(function(item) {
                            return parseInt(item, 10);
                        })
                        var options = {
                            series: [{
                                name: "Employee attendance",
                                data: series
                            }],
                            chart: {
                                type: 'bar',
                                height: 250
                            },
                            plotOptions: {
                                bar: {
                                    // borderRadius: 4,
                                    horizontal: true,
                                    distributed: true
                                }
                            },
                            xaxis: {
                                categories: data.label,
                            },
                            dataLabels: {
                                enabled: true
                            }
                        };

                        var chart = new ApexCharts(document.querySelector("#employee_attendance"),
                            options);
                        chart.render();
                    }
                });
            @endif

            $.ajax({
                type: "get",
                url: "{{ route('future.notice') }}",
                success: function success(data) {
                    var calendarEl = document.getElementById('calendar');
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth',
                        events: data,
                        headerToolbar: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'timeGridDay,timeGridWeek,dayGridMonth'
                        },
                        buttonText: {
                            timeGridDay: "Day",
                            timeGridWeek: "Week",
                            dayGridMonth: "Month"
                        },
                        themeSystem: 'bootstrap',
                        eventClick: function(info) {
                            Swal.fire({
                                title: info.event.title,
                                text: info.event.start.toLocaleString(),
                                footer: info.event.extendedProps.description
                            })
                        }
                    });
                    calendar.render();
                }
            });

            let getWorkHour = () => {
                $.ajax({
                    type: "get",
                    url: "{{ route('employee.work.hour') }}",
                    success: function success(data) {
                        if (data.employee) {
                            $('#week_hour').html(data.week);
                            todaytime = data.today;
                            if (todaytime == 0 || data.today_clock_out) {
                                let dividedtime = toHoursAndMinutes(todaytime);
                                $('#today_hour').html(`${dividedtime.h}h : ${dividedtime.m}m`);
                            } else {
                                setInterval(countTodayTime, 1000)
                            }
                        }
                    }
                });
            }

            getWorkHour();

            getAnnouncement();
        });



        document.addEventListener('DOMContentLoaded', function() {
            console.log('calender');
        });
    </script>
@endpush
