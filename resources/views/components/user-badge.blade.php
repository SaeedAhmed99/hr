<div class="user-badge">
    @php
        $count = 0;
        $limit = 4;
    @endphp
    @foreach ($employees as $idx => $meeting_employee)
        @if ($count >= $limit)
            <div data-id="{{ $meeting_id }}" class="show-meeting-modal user-badge-child user-count">+{{ $employees->count() - $limit }}</div>
            @break
        @endif
        <img data-id="{{ $meeting_id }}" title="{{ $meeting_employee->employee->user->name }}" class="show-meeting-modal meeting-details user-badge-child img-{{ $idx }}" src="{{ userAvater($meeting_employee->employee->user->avater) }}" alt="user-avatar">
        @php
            $count++;
        @endphp
    @endforeach
</div>
