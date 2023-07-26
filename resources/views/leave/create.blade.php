@extends('layouts.app')

@section('content')
    <div class="mt-5 p-2">
        <form class="row g-3 needs-validation" novalidate method="post" action="{{ route('leave.store') }}">
            @csrf
            <div class="col-md-2">
                <label for="validationCustom04" class="form-label">Employee</label>
                <select class="form-select" name="employee" aria-label="Default select example" required>
                    <option value="">Select Employee</option>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}"> {{ Auth::user()->getName($employee->user_id)->name }}
                        </option>
                    @endforeach

                </select>
                @if ($errors->has('employee'))
                    <span class="text-danger">{{ $errors->first('employee') }}</span>
                @endif
            </div>
            <div class="col-md-2">
                <label for="validationCustom04" class="form-label">Leave Type</label>
                <select class="form-select" name="leave_type_id" aria-label="Default select example" required>
                    <option value="">Select Type</option>
                    @foreach ($leavetypes as $leavetype)
                        <option value="{{ $leavetype->id }}"> {{ $leavetype->name }}
                        </option>
                    @endforeach

                </select>
                @if ($errors->has('leave_type_id'))
                    <span class="text-danger">{{ $errors->first('leave_type_id') }}</span>
                @endif
            </div>
            <div class="col-md-2">
                <label for="validationCustom01" class="form-label">Start Date</label>
                <input type="text" name="start_date" class="form-control" id="start_datepicker" value="{{ old('start_date') }}" required>
                @if ($errors->has('start_date'))
                    <span class="text-danger">{{ $errors->first('start_date') }}</span>
                @endif
            </div>
            <div class="col-md-2">
                <label for="validationCustom01" class="form-label">End Date</label>
                <input type="text" name="end_date" class="form-control" id="end_datepicker" value="{{ old('end_dateleave_type_id') }}" required>
                @if ($errors->has('end_date'))
                    <span class="text-danger">{{ $errors->first('end_date') }}</span>
                @endif
            </div>
            <hr>
            <div class="col-md-4">
                <label for="validationCustom01" class="form-label">Leave Reason</label>
                <textarea name="leave_reason" class="form-control" id="leave_reason" rows="3">
                </textarea>
                @if ($errors->has('leave_reason'))
                    <span class="text-danger">{{ $errors->first('leave_reason') }}</span>
                @endif
            </div>
            <div class="col-md-4">
                <label for="validationCustom01" class="form-label">Remark</label>
                <textarea name="remark" class="form-control" id="remark" rows="3">
                </textarea>
                @if ($errors->has('remark'))
                    <span class="text-danger">{{ $errors->first('remark') }}</span>
                @endif
            </div>

            <div class="col-12">
                <button class="btn btn-primary" type="submit">Submit</button>
            </div>
        </form>
    </div>
@endsection


@push('js')
    <script src="{{ asset('js/jquery-ui.js') }}"></script>


    <script type="text/javascript">
        $(function() {
            $('#start_datepicker').datepicker({
                dateFormat: 'yy-mm-dd'
            });
            $('#end_datepicker').datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>
@endpush
