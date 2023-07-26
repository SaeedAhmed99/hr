@extends('layouts.app')

@section('content')
    <div>
        <form class="row g-3 needs-validation" novalidate method="POST" action="{{ route('leave.changeaction') }}">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <table class="table" id="pc-dt-simple">
                            <tr role="row">
                                <th>{{ __('Employee') }}</th>
                                <td>{{ !empty(\Auth::user()->getEmployee($leave->employee_id)) ? Auth::user()->getEmployee($leave->employee_id)->name : '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('Leave Type ') }}</th>
                                <td>{{ !empty(\Auth::user()->getLeaveType($leave->leave_type_id)) ? Auth::user()->getLeaveType($leave->leave_type_id)->name : '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('Appplied On') }}</th>
                                <td>{{ $leave->applied_on }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Start Date') }}</th>
                                <td>{{ $leave->start_date }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('End Date') }}</th>
                                <td>{{ $leave->end_date }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Leave Reason') }}</th>
                                <td>{{ !empty($leave->leave_reason) ? $leave->leave_reason : '' }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Status') }}</th>
                                <td>
                                    @if ($leave->status == '0')
                                        <div class="badge bg-warning p-2 px-3 rounded">Pending</div>
                                    @elseif($leave->status == '1')
                                        <div class="badge bg-success p-2 px-3 rounded">Approved</div>
                                    @else($leave->status == "2")
                                        <div class="badge bg-danger p-2 px-3 rounded">Reject</div>
                                    @endif
                                </td>
                            </tr>
                            <input type="hidden" value="{{ $leave->id }}" name="leave_id">
                        </table>
                    </div>
                </div>
            </div>
            {{-- <div class="col-12">
        <input type="submit" class="btn-create badge-success" value="{{ __('Approval') }}" name="status">
        <input type="submit" class="btn-create bg-danger" value="{{ __('Reject') }}" name="status">
    </div> --}}
            <div class="modal-footer">
                <input type="submit" value="{{ __('Approved') }}" class="btn btn-success rounded" name="status">
                <input type="submit" value="{{ __('Reject') }}" class="btn btn-danger rounded" name="status">
            </div>
        </form>
    </div>
@endsection
