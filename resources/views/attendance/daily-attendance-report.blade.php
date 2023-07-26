@extends('layouts.app')
@section('page-title')
    {{ __('Daily Attendence Report') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <p class="card-heading">Daily Attendence Report</p>
                </div>
                <div class="card-body">
                    <table id="attendance" class="table table-condensed">
                        <thead>
                            <tr>
                                <th>{{ __('Employee') }}</th>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Clock In') }}</th>
                                <th>{{ __('Clock Out') }}</th>
                                <th>{{ __('Late') }}</th>
                                <th>{{ __('Overtime') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attendanceEmployee as $attendance)
                                <tr>
                                    <td>{{ $attendance->user->name }}
                                    </td>
                                    <td>{{ now()->format('Y-m-d') }}
                                    <td>
                                        @if($attendance->todayOnLeave)
                                            <span class="badge bg-warning p-1 rounded-1">On Leave</span>
                                        @elseif ($attendance->todaysAttendance)
                                            <span class="badge bg-success p-1 rounded-1">Present</span>
                                        @else
                                            <span class="badge bg-danger p-1 rounded-1">Absent</span>
                                        @endif
                                    </td>
                                    <td>{{ $attendance->todaysAttendance ? $attendance->todaysAttendance->clock_in->format('h:i a') : '-' }}</td>
                                    <td>{{ ($attendance->todaysAttendance AND $attendance->todaysAttendance->clock_out) ? $attendance->todaysAttendance->clock_out->format('h:i A') : ' - ' }}</td>
                                    <td>{{ ($attendance->todaysAttendance AND $attendance->todaysAttendance->late) ? gmdate("H:i", $attendance->todaysAttendance->late) : '-' }}</td>
                                    <td>{{ ($attendance->todaysAttendance AND $attendance->todaysAttendance->overtime) ? gmdate("H:i", $attendance->todaysAttendance->overtime) : '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            let attendanceTable = $('#attendance').DataTable({
                dom: '<"d-flex justify-content-end"<"mb-2"B>><"container-fluid"<"row"<"col"l><"col"f>>>rtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ],
                "lengthChange": true
            });
        });
    </script>
@endpush
