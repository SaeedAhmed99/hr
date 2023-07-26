<ul class="list-group">
    @forelse ($holidays as $holiday)
        <li class="list-group-item p-3">
            <div class="d-flex align-items-center">
                <button data-id="{{ $holiday->id }}" class="btn btn-info btn-xs me-2 holiday-update" data-bs-toggle="modal" data-bs-target="#edit_holiday_modal"><i class="fas fa-edit"></i></button>
                <button data-id="{{ $holiday->id }}" class="btn btn-danger btn-xs me-2 holiday-delete"><i class="fas fa-times"></i></button>
                @if ($holiday->holidate != $holiday->end_date)                    
                <span class="p-0"><b><span class="text-muted">From:</span> {{ $holiday->holidate }} <span class="text-muted">to:</span> {{ $holiday->end_date }}</b> {{ $holiday->name }}</span>
                @else
                <span class="p-0"><b>{{ $holiday->holidate }}</b> {{ $holiday->name }}</span>
                @endif
            </div>
        </li>
    @empty
        <h5 class="text-danger text-center">No holiday has been setup for this year!</h5>
    @endforelse
</ul>