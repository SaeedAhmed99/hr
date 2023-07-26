@extends('layouts.app')
@push('head')
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/css/lightbox.min.css">
    <style>
        .hour-text {
            margin: 1rem;
            padding: 5px 10px 5px 10px;
            background-color: #2ECD6F;
            width: fit-content;
            font-weight: 500;
            color: whitesmoke;
            border-radius: 5px;
        }

        .left-bar {
            border-radius: 30px 0px 0px 30px;
            display: block;
            content: " ";
            justify-content: center;
            position: absolute;
            z-index: 100;
            left: 8px;
            top: 0;
            bottom: 0;
            transform: translate(50%);
            border-left-width: 4px;
            border-left-style: solid;
            border-left-color: #2ECD6F;
        }

        img {
            width: 300px;
        }

        .per-hour-relative {
            position: relative;
        }

        .ml-10px {
            margin-left: 10px;
        }
    </style>
@endpush

@section('page-title')
    {{ __('Termination Type') }}
@endsection

@section('content')
    <div class="content flex-column-fluid" id="kt_content">
        <div class="toolbar d-flex flex-stack flex-wrap" id="kt_toolbar">
            <div class="page-title d-flex flex-column py-1">
                <h1 class="d-flex align-items-center my-1">
                    <span class="text-dark fw-bolder fs-1">Time Tracker</span>
                </h1>
            </div>
        </div>
        {{-- @if (Auth::user()->hrm->type == 'employee')
            <div class="card mb-3">
                <div class="card-body">
                    <form action="" class="form" method="get">
                        <div class="row mb-6 align-items-end">
                            <div class="col-xl-3 col-md-6 col-sm-12 col-12">
                                <div class="d-flex gap-1">
                                    <div class="form-group">
                                        <label class="form-label" for="project_id">Project</label>
                                        <select name="project_id" id="" class="form-control">
                                            <option value="">Select a project</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="date">Date</label>
                                        <input class="form-control" type="text" id="date" name="date"
                                            value="{{ request()->date }}" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <button type="submit" class="btn btn-primary"
                                    id="kt_account_profile_details_submit">Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @else --}}
        <div class="card mb-3">
            <div class="card-body">
                <form action="" class="form" method="get">
                    <div class="row mb-6 align-items-end">
                        <div class="col-xl-5 col-md-6 col-sm-12 col-12">
                            <div class="d-flex gap-1">
                                <div class="form-group">
                                    <label class="form-label" for="from">From</label>
                                    <input class="form-control" type="text" id="from" name="from"
                                        value="{{ request()->from }}" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="to">To</label>
                                    <input class="form-control" type="text" id="to" name="to"
                                        value="{{ request()->to }}" autocomplete="off">
                                </div>
                                @if (Auth::user()->hrm->type == 'employee')
                                    <div class="form-group">
                                        <label class="form-label" for="employee_id">Project</label>
                                        <select name="employee_project_id" id="" class="form-control">
                                            <option value="">Select Project</option>
                                            @foreach ($projectEmployees as $projectEmployee)
                                                <option value="{{ $projectEmployee->id }}">
                                                    {{ $projectEmployee->project->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @else
                                    <div class="form-group">
                                        <label class="form-label" for="employee_id">Employee</label>
                                        <select name="employee_project_id" id="" class="form-control">
                                            <option value="">Select Employee</option>
                                            @foreach ($projectEmployees as $projectEmployee)
                                                <option value="{{ $projectEmployee->id }}"
                                                    {{ $projectEmployee->employee->user->id == $employee->user->id ? 'selected' : '' }}>
                                                    {{ $projectEmployee->employee->user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <button type="submit" class="btn btn-primary"
                                id="kt_account_profile_details_submit">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        {{-- @endif --}}

        <div class="card p-3">
            <div class="d-flex flex-wrap flex-stack pb-7">
                <div class="d-flex flex-wrap align-items-center my-1">
                    <h3 class="fw-bolder me-5 my-1"><span class="text-muted">Time Trackers of:</span>
                        {{ $employee->user->name }} <span class="text-muted">for the project:</span> {{ $project->title }}
                    </h3>
                </div>
            </div>
            <div class="tab-content">
                <div class="timeline">
                    @foreach ($timeTrackers as $count => $timeTracker)
                        <div class="timeline-item mb-2 p-3 bg-light">
                            <div class="timeline-content mb-10 mt-n1">
                                <div class="pe-3 mb-1 d-flex align-items-center gap-3">
                                    <div class="fs-5 fw-bold">{{ $timeTracker->task_title }}</div>
                                    {{-- <div class="d-flex align-items-center mt-1 fs-6"> --}}
                                    {{-- <div class="text-muted me-2 fs-7">Started at {{ $timeTracker->created_at->format('d M, Y') }} </div> --}}
                                    <div class="text-muted me-2 fs-7">Started at
                                        {{ \Carbon\Carbon::parse($timeTracker->created_at)->timezone(Auth::user()->timezone)->format('l, j F Y, h:i:s a') }}
                                    </div>
                                    {{-- </div> --}}
                                </div>
                                <div class="row">
                                    @php
                                        $prev_hour = null;
                                        $timeTrackingDuration = \Carbon\Carbon::parse($timeTracker->end)->diffInSeconds(\Carbon\Carbon::parse($timeTracker->start));
                                    @endphp

                                    <hr>
                                    <p class="btn btn-primary">Hour:
                                        {{ \Carbon\Carbon::parse($timeTracker->start)->timezone(Auth::user()->timezone)->format('h:i a') .'-' .\Carbon\Carbon::parse($timeTracker->end)->timezone(Auth::user()->timezone)->format('h:i a') .'(' .gmdate('H:i:s', $timeTrackingDuration) .')' }}
                                    </p>
                                    @foreach ($timeTracker->screenshots as $key => $screenshot)
                                        <div class="col-lg-4 col-xl-4 col-xxl-4 col-md-6 col-sm-12 col-12 mb-5">
                                            <div class="overlay me-10">
                                                <div class="overlay-wrapper">
                                                    <p class="screenshot-time">
                                                        {{-- {{ $screenshot->created_at->format('h:i a') }} --}}
                                                        {{ \Carbon\Carbon::parse($screenshot->created_at)->timezone(Auth::user()->timezone)->format('h:i a') }}
                                                        <span
                                                            class="badge ml-10px
                                                        {{ $screenshot->activity == 'Excellent' ? 'badge-success' : ($screenshot->activity == 'Okay' ? 'badge-primary' : 'badge-danger') }}">
                                                            {{ $screenshot->activity }}
                                                        </span>
                                                        <span class="ml-10px">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none">
                                                                <path
                                                                    d="M21 5H3a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h18a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2zm-8 2h2v2h-2V7zm0 4h2v2h-2v-2zM9 7h2v2H9V7zm0 4h2v2H9v-2zM5 7h2v2H5V7zm0 4h2v2H5v-2zm12 6H7v-2h10v2zm2-4h-2v-2h2v2zm0-4h-2V7h2v2z"
                                                                    fill="currentColor">
                                                                </path>
                                                            </svg>
                                                            <span class="text-dark fs-base fw-bolder lh-1">
                                                                {{ $screenshot->keystroke }}
                                                            </span>
                                                        </span>
                                                        <span class="ml-10px">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none">
                                                                <path
                                                                    d="M13 2v8h6V8c0-3.309-2.691-6-6-6zM5 16c0 3.309 2.691 6 6 6h2c3.309 0 6-2.691 6-6v-4H5v4zm0-8v2h6V2C7.691 2 5 4.691 5 8z"
                                                                    fill="currentColor">
                                                                </path>
                                                            </svg>
                                                            <span class="text-dark fs-base fw-bolder lh-1">
                                                                {{ $screenshot->mouse_click }}
                                                            </span>
                                                        </span>
                                                    </p>
                                                    <a href="{{ asset('captured/' . $screenshot->image) }}"
                                                        data-lightbox="mygallery">
                                                        <img alt="img" class="rounded w-300px"
                                                            src="{{ asset('captured/' . $screenshot->image) }}" />
                                                    </a>

                                                    {{-- @foreach ($galleryImages as $galleryImage) --}}
                                                    {{-- <div class="col-sm-6 col-md-4 col-lg-3 item"> --}}
                                                    {{-- <a href="{{ asset('captured/' . $screenshot->image) }}"
                                                        data-lightbox="photos">
                                                        <img class="img-fluid"
                                                            src="{{ asset('captured/' . $screenshot->image) }}">
                                                    </a> --}}
                                                    {{-- </div> --}}
                                                    {{-- @endforeach --}}

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="modal lightbox-modal" id="lightbox-modal" tabindex="-1">
                                        <div class="modal-dialog modal-fullscreen">
                                            <div class="modal-content">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                <div class="modal-body">
                                                    <div class="container-fluid p-0">
                                                        <!-- JS content here -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- @if ($timeTracker->screenshots->count() != 0) --}}
                                </div>
                            </div>
                            {{-- @endif --}}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>

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
