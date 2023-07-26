<input type="hidden" name="attendance_id" id="attendance_id" value="{{ $attendanceId }}">
<div class="d-flex align-items-center ps-3 pe-5 mb-4">
    <div class="icon text-success">
        <i class="fa-solid fa-arrow-right-to-bracket"></i>
    </div>
    <div class="ms-2">
        <p class="m-0 p-0 time"> {{ $clockedIn->format('h:i A') }} </p>
        <p class="m-0 p-0 text-muted">Clock in</p>
    </div>
</div>
