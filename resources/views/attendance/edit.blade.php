{{ Form::model($attendanceEmployee, ['route' => ['attendance.update', $attendanceEmployee->id], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-lg-6 col-md-6 ">
            <label class="col-form-label" name="employee_id">{{ __('Employee') }}</label>
            <input name="employee_id" id="employee_id" class="form-control" value="{{ $employees->user}}">

        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('date', __('Date'), ['class' => 'col-form-label']) }}
            {{ Form::text('date', $date, ['class' => 'form-control d_week', 'autocomplete' => 'off']) }}
        </div>

        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('clock_in', __('Clock In'), ['class' => 'col-form-label']) }}
            {{ Form::text('clock_in', null, ['class' => 'form-control d_clock', 'id' => 'clock_in']) }}
        </div>

        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('clock_out', __('Clock Out'), ['class' => 'col-form-label']) }}
            {{ Form::text('clock_out', null, ['class' => 'form-control d_clock ', 'id' => 'clock_out']) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Update') }}" class="btn btn-primary">
</div>
{{ Form::close() }}
