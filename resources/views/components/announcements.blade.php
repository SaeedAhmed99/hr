@forelse ($announcements as $announcement)
    <div class="card m-md-2 m-0 announcement-div shadow-none
    @switch($announcement->type)
        @case('Meeting')
            meeting-bg
            @break
        @case('Announcement')
            announcement-bg
            @break
        @case('Termination')
            termination-bg
            @break
        @case('Promotion')
            promotion-bg
            @break
        @case('Award')
            award-bg
            @break
        @case('Transfer')
            transfer-bg
            @break
        @case('Performance')
            performance-bg
            @break
        @default
    @endswitch">
        <div class="card-body pt-2 pb-2 ps-3 pe-2">
            <div class="d-flex justify-content-between">
                <div>
                    <h4>
                        <b
                            @switch($announcement->type)
                                @case('Meeting')
                                    class="text-meeting"
                                    @break
                                @case('Announcement')
                                    class="text-announcement"
                                    @break
                                @case('Termination')
                                    class="text-termination"
                                    @break
                                @case('Promotion')
                                    class="text-promotion"
                                    @break
                                @case('Award')
                                    class="text-award"
                                    @break
                                @case('Transfer')
                                    class="text-transfer"
                                    @break                                    
                                @case('Performance')
                                    class="text-performance"
                                    @break
                                @default                                
                            @endswitch>{{ $announcement->type }}</b>
                    </h4>
                    <p class="m-0 text-1">{{ $announcement->title }}</p>
                    @php
                        $notice_time = new \Carbon\Carbon($announcement->notice_date . ' ' . $announcement->notice_time);
                    @endphp
                    <p class="m-0 text-1">Time: {{ $notice_time->format('Y-m-d') }} {{ $notice_time->format('h:i a') }}</p>
                </div>
                <div class="align-self-center me-md-5 me-0">
                    <i data-id="{{ $announcement->id }}" class="fa-regular fa-eye-slash text-1 seen"></i>
                </div>
            </div>
            <p class="m-0 text-1 announcement-body">{{ $announcement->body }}</p>
        </div>
    </div>
@empty
    <h1>No Notice</h1>
@endforelse
