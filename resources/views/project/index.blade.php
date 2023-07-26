@extends('layouts.app')
@section('page-title')
    {{ __('Projects') }}
@endsection

@push('css')
    <style>
        .employee-search {
            width: 100%;
        }
    </style>
@endpush

@section('content')
    <div class="content">
        <div class="d-flex justify-content-between align-items-center mb-3">
            @if (Auth::user()->can('Create Project'))
                <div>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal_create_project"><i
                            class="fas fa-plus me-2"></i>Create Project</button>
                </div>
            @endif
        </div>

        <div class="post" id="kt_post">
            @if (count($projects) != 0)
                @foreach ($projects as $project)
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-self-center">
                                <p class="card-heading">
                                    <span class="card-label">{{ $project->title }}</span>
                                    {{-- <span class="text-muted">Started at: {{ $project->created_at->format('d M, Y') }}</span> --}}
                                    <span class="text-muted">Started at:
                                        {{ \Carbon\Carbon::parse($project->created_at)->timezone(Auth::user()->timezone)->format('d M, Y') }}</span>
                                </p>
                                @if (Auth::user()->can('Manage Project'))
                                    <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-trigger="hover" title=""
                                        data-bs-original-title="Click to assign an employee">
                                        <button class="btn btn-sm btn-primary assign-employee-button" type="button"
                                            data-id="{{ $project->id }}">Assign Employee</button>
                                        <button class="btn btn-sm btn-danger delete-project" type="button"
                                            data-id="{{ $project->id }}">Delete Project</button>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="card-body py-4">
                            <div class="table-responsive">
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                    <thead>
                                        <tr class="fw-bolder">
                                            <th class="min-w-200px">Employee</th>
                                            <th class="min-w-150px">Today's tasks</th>
                                            <th class="min-w-150px">Today total time</th>
                                            <th class="min-w-150px">
                                                Total Time This Week
                                            </th>
                                            <th class="min-w-100px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($project->employees as $idx => $employee)
                                            {{-- <div>{{ $user }}</div> --}}
                                            @if ($user == 'employee' && Auth::user()->id == $employee->user_id)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            {{-- <div class="symbol symbol-45px me-5">
                                                            @isset($employee->user->avater)
                                                                <img class="profile-picture" alt="Profile Picture"
                                                                    src="{{ asset('storage/avatar/' . $employee->user->avater) }}"
                                                                    class="w-100" />
                                                            @else
                                                                <img class="profile-picture" alt="Profile Picture"
                                                                    src="{{ asset('storage/avatar/avatar.png') }}"
                                                                    class="w-100" />
                                                            @endisset
                                                        </div> --}}

                                                            <div class="d-flex justify-content-start flex-column">
                                                                <a href=""
                                                                    class="text-dark fw-bolder text-hover-primary fs-6">{{ $employee->user->name }}</a>
                                                            </div>

                                                            @if ($employee->pivot->is_active == 1)
                                                                <span class="badge bg-success p-1 ms-1">Active</span>
                                                            @else
                                                                <span class="badge bg-warning p-1 ms-1">Removed</span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @php
                                                            $totalMinutes = 0;
                                                            $todayTotal = 0;
                                                            $tasksToday = false;
                                                            if ($idx == 0) {
                                                                // dd($employee, $employee->pivot, $employee->pivot->timeTrackers->pluck('id'));
                                                            }
                                                        @endphp
                                                        <div class="d-flex flex-column w-100 me-2">
                                                            @foreach ($employee->pivot->timeTrackers as $timeTrack)
                                                                @php
                                                                    $start = new \Carbon\Carbon($timeTrack->start);
                                                                    if (!is_null($timeTrack->end)) {
                                                                        $end = new \Carbon\Carbon($timeTrack->end);
                                                                    } else {
                                                                        $end = now();
                                                                    }
                                                                    $totalMinutes += $end->diffInRealMinutes($start);
                                                                    if ($start->isSameDay()) {
                                                                        $todayTotal += $end->diffInRealMinutes($start);
                                                                    }
                                                                @endphp
                                                                @if ($timeTrack->created_at->isSameDay())
                                                                    @php
                                                                        $tasksToday = true;
                                                                    @endphp
                                                                    @if (is_null($timeTrack->end))
                                                                        <span
                                                                            class="me-2 fs-7 fw-bold">{{ $timeTrack->task_title }}
                                                                            -
                                                                            (<span class="text-muted">from:</span>
                                                                            @php
                                                                                $start = new \Carbon\Carbon($timeTrack->start);
                                                                                // echo $start->format('h:i a');
                                                                                echo \Carbon\Carbon::parse($start)
                                                                                    ->timezone(Auth::user()->timezone)
                                                                                    ->format('h:i a');
                                                                            @endphp,
                                                                            <span class="text-muted">Currently
                                                                                working</span>)
                                                                        </span>
                                                                    @else
                                                                        <span
                                                                            class="me-2 fs-7 fw-bold">{{ $timeTrack->task_title }}
                                                                            -
                                                                            (<span class="text-muted">from:</span>
                                                                            @php
                                                                                $start = new \Carbon\Carbon($timeTrack->start);
                                                                                // echo $start->format('h:i a');
                                                                                echo \Carbon\Carbon::parse($start)
                                                                                    ->timezone(Auth::user()->timezone)
                                                                                    ->format('h:i a');
                                                                            @endphp,
                                                                            <span class="text-muted">to</span>
                                                                            @php
                                                                                $end = new \Carbon\Carbon($timeTrack->end);
                                                                                // echo $end->format('h:i a');
                                                                                echo \Carbon\Carbon::parse($end)
                                                                                    ->timezone(Auth::user()->timezone)
                                                                                    ->format('h:i a');
                                                                            @endphp)</span>
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                            @if (!$tasksToday)
                                                                <span
                                                                    class="text-muted fw-bold text-muted d-block fs-7">Today
                                                                    tracker not started!</span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="d-flex flex-column w-100 me-2">
                                                            <div class="d-flex flex-stack mb-2">
                                                                <span
                                                                    class="me-2 fs-7 fw-bold">{{ sprintf('%02d', intdiv($todayTotal, 60)) . ' : ' . sprintf('%02d', $todayTotal % 60) . ' H' }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="d-flex flex-column w-100 me-2">
                                                            <div class="d-flex flex-stack mb-2">
                                                                <span
                                                                    class="me-2 fs-7 fw-bold">{{ sprintf('%02d', intdiv($totalMinutes, 60)) . ' : ' . sprintf('%02d', $totalMinutes % 60) . ' H' }}</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <a role="button"
                                                            href="{{ route('employee.project.timetracker', $employee->pivot->id) }}"
                                                            class="btn btn-info btn-sm">Show TimeTracking</a>
                                                        @if ($employee->pivot->is_active == true)
                                                            <button class="btn btn-danger btn-sm remove_project_member"
                                                                data-id="{{ $employee->pivot->id }}">Remove</button>
                                                        @else
                                                            <button
                                                                class="btn btn-success btn-sm reassign_project_member_button"
                                                                data-id="{{ $employee->pivot->id }}">Reassign</button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @elseif($user == 'company')
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            {{-- <div class="symbol symbol-45px me-5">
                                                            @isset($employee->user->avater)
                                                                <img class="profile-picture" alt="Profile Picture"
                                                                    src="{{ asset('storage/avatar/' . $employee->user->avater) }}"
                                                                    class="w-100" />
                                                            @else
                                                                <img class="profile-picture" alt="Profile Picture"
                                                                    src="{{ asset('storage/avatar/avatar.png') }}"
                                                                    class="w-100" />
                                                            @endisset
                                                        </div> --}}

                                                            <div class="d-flex justify-content-start flex-column">
                                                                <a href=""
                                                                    class="text-dark fw-bolder text-hover-primary fs-6">{{ $employee->user->name }}</a>
                                                            </div>

                                                            @if ($employee->pivot->is_active == 1)
                                                                <span class="badge bg-success p-1 ms-1">Active</span>
                                                            @else
                                                                <span class="badge bg-warning p-1 ms-1">Removed</span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @php
                                                            $totalMinutes = 0;
                                                            $todayTotal = 0;
                                                            $tasksToday = false;
                                                            if ($idx == 0) {
                                                                // dd($employee, $employee->pivot, $employee->pivot->timeTrackers->pluck('id'));
                                                            }
                                                        @endphp
                                                        <div class="d-flex flex-column w-100 me-2">
                                                            @foreach ($employee->pivot->timeTrackers as $timeTrack)
                                                                @php
                                                                    $start = new \Carbon\Carbon($timeTrack->start);
                                                                    if (!is_null($timeTrack->end)) {
                                                                        $end = new \Carbon\Carbon($timeTrack->end);
                                                                    } else {
                                                                        $end = now();
                                                                    }
                                                                    $totalMinutes += $end->diffInRealMinutes($start);
                                                                    if ($start->isSameDay()) {
                                                                        $todayTotal += $end->diffInRealMinutes($start);
                                                                    }
                                                                @endphp
                                                                @if ($timeTrack->created_at->isSameDay())
                                                                    @php
                                                                        $tasksToday = true;
                                                                    @endphp
                                                                    @if (is_null($timeTrack->end))
                                                                        <span
                                                                            class="me-2 fs-7 fw-bold">{{ $timeTrack->task_title }}
                                                                            -
                                                                            (<span class="text-muted">from:</span>
                                                                            @php
                                                                                $start = new \Carbon\Carbon($timeTrack->start);
                                                                                // echo $start->format('h:i a');
                                                                                echo \Carbon\Carbon::parse($start)
                                                                                    ->timezone(Auth::user()->timezone)
                                                                                    ->format('h:i a');
                                                                            @endphp,
                                                                            <span class="text-muted">Currently
                                                                                working</span>)
                                                                        </span>
                                                                    @else
                                                                        <span
                                                                            class="me-2 fs-7 fw-bold">{{ $timeTrack->task_title }}
                                                                            -
                                                                            (<span class="text-muted">from:</span>
                                                                            @php
                                                                                $start = new \Carbon\Carbon($timeTrack->start);
                                                                                // echo $start->format('h:i a');
                                                                                echo \Carbon\Carbon::parse($start)
                                                                                    ->timezone(Auth::user()->timezone)
                                                                                    ->format('h:i a');
                                                                            @endphp,
                                                                            <span class="text-muted">to</span>
                                                                            @php
                                                                                $end = new \Carbon\Carbon($timeTrack->end);
                                                                                // echo $end->format('h:i a');
                                                                                echo \Carbon\Carbon::parse($end)
                                                                                    ->timezone(Auth::user()->timezone)
                                                                                    ->format('h:i a');
                                                                            @endphp)</span>
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                            @if (!$tasksToday)
                                                                <span
                                                                    class="text-muted fw-bold text-muted d-block fs-7">Today
                                                                    tracker not started!</span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="d-flex flex-column w-100 me-2">
                                                            <div class="d-flex flex-stack mb-2">
                                                                <span
                                                                    class="me-2 fs-7 fw-bold">{{ sprintf('%02d', intdiv($todayTotal, 60)) . ' : ' . sprintf('%02d', $todayTotal % 60) . ' H' }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="d-flex flex-column w-100 me-2">
                                                            <div class="d-flex flex-stack mb-2">
                                                                <span
                                                                    class="me-2 fs-7 fw-bold">{{ sprintf('%02d', intdiv($totalMinutes, 60)) . ' : ' . sprintf('%02d', $totalMinutes % 60) . ' H' }}</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <a role="button"
                                                            href="{{ route('employee.project.timetracker', $employee->pivot->id) }}"
                                                            class="btn btn-info btn-sm">Show TimeTracking</a>
                                                        @if ($employee->pivot->is_active == true)
                                                            <button class="btn btn-danger btn-sm remove_project_member"
                                                                data-id="{{ $employee->pivot->id }}">Remove</button>
                                                        @else
                                                            <button
                                                                class="btn btn-success btn-sm reassign_project_member_button"
                                                                data-id="{{ $employee->pivot->id }}">Reassign</button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Table container-->
                        </div>
                        <!--end::Card body-->
                    </div>
                @endforeach
            @else
                @if (Auth::user()->hrm->type == 'employee')
                    <h4>Any project still not assigned to you</h4>
                @else
                    <h4>Any project still not created by you</h4>
                @endif
            @endif
            <!--end::Card-->
        </div>
        <!--end::Post-->

    </div>

    <div class="modal fade" tabindex="-1" id="employee_search">
        <div class="modal-dialog">
            <form action="" id="assign_employee_form">
                <input type="hidden" name="project_for_employee" id="project_for_employee" value="">\
                <div id="project_for_employee_invalid" class="invalid-feedback"></div>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Assign employee</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <select class="employee-search" style="width: 100%" name="search[]" id="search"
                                value="" placeholder="Search by email" data-kt-search-element="input"
                                multiple="multiple"></select>
                            <div id="search_invalid" class="invalid-feedback"></div>
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

    <div class="modal fade" id="modal_create_project" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add a project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                    <form id="add_project" action="{{ route('project.store') }}" method="POST" class="form"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex flex-column mb-3 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Project Title</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                    title="Specify a title for the project"></i>
                            </label>
                            <input type="text" class="form-control form-control-solid"
                                placeholder="Enter project Title" name="project_title" required />
                        </div>
                        <div class="d-flex flex-column mb-3 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Project Details</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                    title="Write some description about the peoject"></i>
                            </label>
                            <textarea class="form-control form-control-solid" rows="3" name="project_description"
                                placeholder="Type Target Details" required></textarea>
                        </div>
                        <div class="text-center mt-2">
                            <button type="reset" id="modal_new_target_cancel"
                                class="btn btn-light me-3">Cancel</button>
                            <button type="submit" id="modal_new_target_submit" class="btn btn-primary">
                                <span class="indicator-label">Submit</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="remove_project_member_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content rounded">
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2"
                                    rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                    transform="rotate(45 7.41422 6)" fill="currentColor" />
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                    <div class="mb-13 text-center">
                        <h1 class="mb-3">Remove Member</h1>
                    </div>

                    <div class="d-flex flex-column mb-8 fv-row">
                        Are you sure want to remove this member from this project?
                    </div>

                    <div class="text-center">
                        <form action="{{ route('employee.project.remove') }}" method="post">
                            @csrf
                            @method('put')
                            <input type="hidden" id="project_people_id" name="id">
                            <button type="submit" class="btn btn-light btn-light-danger btn-sm">Remove</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="reassign_project_member_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content rounded">
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2"
                                    rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                    transform="rotate(45 7.41422 6)" fill="currentColor" />
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                    <div class="mb-13 text-center">
                        <h1 class="mb-3">Reassign Member</h1>
                    </div>

                    <div class="d-flex flex-column mb-8 fv-row">
                        Are you sure want to reassign this member from this project?
                    </div>

                    <div class="text-center">
                        <form action="{{ route('employee.project.reassign') }}" method="post">
                            @csrf
                            @method('put')
                            <input type="hidden" id="project_people_id_reassign" name="id">
                            <button type="submit" class="btn btn-light btn-light-success btn-sm">Reassign</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).on('click', '.assign-employee-button', function(e) {
            $('#employee_search').modal('show');
            $('#project_for_employee').val($(this).data('id'));
        });
    </script>

    <script>
        $(document).on('click', '.delete-project', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete this project!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Yes!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "post",
                        data: {
                            _method: 'DELETE',
                        },
                        url: `{{ url('project') }}/${e.currentTarget.dataset.id}`,
                        success: function success(data) {
                            show_toastr('Success', data, 'success');
                            location.reload();
                            // allowanceOptionTable.ajax.reload();
                        },
                        error: function error(data) {}
                    });
                }
            })
        });

        $(document).on('click', '.remove_project_member', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to remove this member from the project!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "post",
                        data: {
                            _method: 'PATCH',
                            project: e.currentTarget.dataset.id
                        },
                        url: `{{ route('employee.project.remove') }}`,
                        success: function success(data) {
                            show_toastr('Success', data, 'success');
                            location.reload();
                            // allowanceOptionTable.ajax.reload();
                        },
                        error: function error(data) {}
                    });
                }
            })
        });
    </script>

    <script>
        $(document).on('click', '.reassign_project_member_button', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to reassign this member to this project!",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "post",
                        data: {
                            _method: 'PATCH',
                            project: e.currentTarget.dataset.id
                        },
                        url: `{{ route('employee.project.reassign') }}`,
                        success: function success(data) {
                            show_toastr('Success', data, 'success');
                            location.reload();
                            // allowanceOptionTable.ajax.reload();
                        },
                        error: function error(data) {
                            console.error(data);
                            show_toastr('Error', 'Permission denied.', 'error');
                        }
                    });
                }
            })
        });

        $(document).ready(() => {
            $('#assign_employee_form').on('submit', (e) => {
                e.preventDefault();
                let formData = new FormData(e.target);
                $.ajax({
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    url: "{{ route('employee-project.store') }}",
                    success: function success(data) {
                        $('#assign_employee_form').trigger("reset");
                        // performanceTable.ajax.reload();
                        modalHide('employee_search');
                        show_toastr('Success', data, 'success');
                        location.reload();
                    },
                    error: function error(data) {
                        handleFormValidation(data);
                    }
                });
            });
            $('.employee-search').select2({
                dropdownParent: $('#employee_search'),
                width: 'resolve',
                multiple: true,
                ajax: {
                    url: "{{ route('employee.search') }}",
                    dataType: 'json'
                    // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                }
            });
        })
    </script>
@endpush
