<p><span class="text-muted">Title</span>: <span class="text-1">{{ $meeting->title }}</span></p>
@if (!empty($meeting->description))
    <p><span class="text-muted">Description</span>: <span class="text-1">{{ $meeting->description }}</span></p>
@endif
@php
    $meeting_time = new \Carbon\Carbon($meeting->date . " " . $meeting->time);
@endphp
<p><span class="text-muted">Time</span>: <span class="text-1">{{ $meeting_time->format("Y-m-d h:i a") }}</span></p>

@if (!$meeting->meeting_braches->isEmpty())
    <p><span class="text-muted">{{ Str::plural('Branch', $meeting->meeting_braches->count()) }}</span>: <span class="text-1">
            @foreach ($meeting->meeting_braches as $idx => $meeting_branch)
                <span class="border border-success border-2 rounded-pill p-1 pt-0 pb-0">{{ Str::ucfirst($meeting_branch->branch->name) }}</span>
            @endforeach
        </span></p>
@endif

@if (!$meeting->meeting_departments->isEmpty())
    <p><span class="text-muted">{{ Str::plural('Department', $meeting->meeting_braches->count()) }}</span>: <span class="text-1">
            @foreach ($meeting->meeting_departments as $meeting_department)
                <span class="border border-success border-2 rounded-pill p-1 pt-0 pb-0">{{ Str::ucfirst($meeting_department->department->name) }}</span>
            @endforeach
        </span></p>
@endif

<p class="text-1">Employees</p>
@foreach ($meeting->meeting_employees as $meeting_employee)
    <div class="d-flex align-items-center gap-2 mb-1">
        <img class="border-rounded" width="60px" height="60px" src="{{ userAvater($meeting_employee->employee->user->avater) }}" alt="">
        <div>
            <p class="p-0 m-0">{{ $meeting_employee->employee->user->name }}</p>
            <p class="p-0 m-0 text-muted">{{ $meeting_employee->employee->user->email }}</p>
        </div>
    </div>
@endforeach
