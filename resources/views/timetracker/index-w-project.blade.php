@extends('layouts.app')
@push('head')
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

        * {
            box-sizing: border-box;
        }

        .row>.column {
            padding: 0 8px;
        }

        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        .column {
            float: left;
            width: 25%;
        }

        /* The Modal (background) */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: black;
        }

        /* Modal Content */
        .modal-content {
            position: relative;
            background-color: #fefefe;
            margin: auto;
            padding: 0;
            width: 90%;
            max-width: 1200px;
        }

        /* The Close Button */
        .close {
            color: white;
            position: absolute;
            top: 10px;
            right: 25px;
            font-size: 35px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #999;
            text-decoration: none;
            cursor: pointer;
        }

        .mySlides {
            display: none;
        }

        .cursor {
            cursor: pointer;
        }

        /* Next & previous buttons */
        .prev,
        .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            padding: 16px;
            margin-top: -50px;
            color: rgb(79, 61, 247);
            font-weight: bold;
            font-size: 20px;
            transition: 0.6s ease;
            border-radius: 0 3px 3px 0;
            user-select: none;
            -webkit-user-select: none;
        }

        /* Position the "next button" to the right */
        .next {
            right: 0;
            border-radius: 3px 0 0 3px;
        }

        /* On hover, add a black background color with a little bit see-through */
        .prev:hover,
        .next:hover {
            background-color: rgba(28, 29, 29, 0.8);
        }

        /* Number text (1/3 etc) */
        .numbertext {
            color: #f2f2f2;
            font-size: 12px;
            padding: 8px 12px;
            position: absolute;
            top: 0;
        }

        img {
            margin-bottom: -4px;
        }

        .caption-container {
            text-align: center;
            background-color: black;
            padding: 2px 16px;
            color: white;
        }

        .demo {
            opacity: 0.6;
        }

        .active,
        .demo:hover {
            opacity: 1;
        }

        img.hover-shadow {
            transition: 0.3s;
        }

        .hover-shadow:hover {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
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
                <h3 class="d-flex align-items-center my-1">
                    <span class="text-dark fw-bolder">Time Tracker</span>
                </h3>
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
                    <h4 class="fw-bolder me-5 my-1"><span class="text-muted">Time Trackers of:</span>
                        {{ $employee->user->name }} <span class="text-muted">for the project:</span> {{ $project->title }}
                    </h4>
                </div>
            </div>
            <div class="tab-content">
                <div class="timeline">
                    @foreach ($timeTrackers as $counter => $timeTracker)
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
                                                        {{ $screenshot->activity == 'Excellent' ? 'bg-success' : ($screenshot->activity == 'Okay' ? 'bg-primary' : 'bg-danger') }}">
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
                                                    {{-- <a href="{{ asset('captured/' . $screenshot->image) }}"
                                                        data-lightbox="mygallery">
                                                        <img alt="img" class="rounded w-300px"
                                                            src="{{ asset('captured/' . $screenshot->image) }}" />
                                                    </a> --}}

                                                    {{-- <div class="row"> --}}
                                                    <div class="column">
                                                        <img alt="img" class="rounded w-300px hover-shadow cursor"
                                                            src="{{ asset('captured/' . $screenshot->image) }}"
                                                            onclick="openModal({{ $counter }});currentSlide({{ $key + 1 }}, {{ $counter }})" />
                                                    </div>
                                                    {{-- </div> --}}


                                                </div>
                                            </div>
                                        </div>
                                    @endforeach


                                    <div id="myModal{{ $counter }}" class="modal">
                                        <span class="close cursor" onclick="closeModal({{ $counter }})">&times;</span>
                                        <div class="modal-content">
                                            <div class="row">
                                                @foreach ($timeTracker->screenshots as $key => $screenshot)
                                                    <div class="mySlides{{ $counter }}">
                                                        <div class="numbertext btn btn-primary">{{ $key + 1 }} /
                                                            {{ count($timeTracker->screenshots) }}</div>
                                                        <img src="{{ asset('captured/' . $screenshot->image) }}"
                                                            style="width:100%">
                                                    </div>
                                                @endforeach
                                                <a class="prev"
                                                    onclick="plusSlides(-1, {{ $counter }})">&#10094;</a>
                                                <a class="next"
                                                    onclick="plusSlides(1, {{ $counter }})">&#10095;</a>

                                                {{-- <div class="caption-container">
                                                <p id="caption"></p>
                                            </div> --}}
                                                {{-- @foreach ($timeTracker->screenshots as $key => $screenshot)
                                                    <div class="column">
                                                        <img class="demo cursor"
                                                            src="{{ asset('captured/' . $screenshot->image) }}"
                                                            style="width:100%"
                                                            onclick="currentSlide({{ $key + 1 }})"
                                                            alt="Nature and sunrise">
                                                    </div>
                                                @endforeach --}}
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
    <script>
        $(function() {
            var dateFormat = "yy-mm-dd",
                from = $("#from")
                .datepicker({
                    changeMonth: true,
                    numberOfMonths: 1,
                    dateFormat: "yy-mm-dd"
                })
                .on("change", function() {
                    to.datepicker("option", "minDate", getDate(this));
                }),
                to = $("#to").datepicker({
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

        // Open the Modal
        function openModal(counter) {
            document.getElementById("myModal" + counter).style.display = "block";
        }

        // Close the Modal
        function closeModal(counter) {
            document.getElementById("myModal" + counter).style.display = "none";
        }

        var slideIndex = 1;
        showSlides(slideIndex);

        // Next/previous controls
        function plusSlides(n, counter) {
            showSlides(slideIndex += n, counter);
        }

        // Thumbnail image controls
        function currentSlide(n, counter) {
            showSlides(slideIndex = n, counter);
        }

        function showSlides(n, counter) {
            var i;
            var slides = document.getElementsByClassName("mySlides" + counter);
            console.log(slides);
            var dots = document.getElementsByClassName("demo");
            var captionText = document.getElementById("caption");
            if (n > slides.length) {
                slideIndex = 1
            }
            if (n < 1) {
                slideIndex = slides.length
            }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
            captionText.innerHTML = dots[slideIndex - 1].alt;
        }
    </script>
@endpush
