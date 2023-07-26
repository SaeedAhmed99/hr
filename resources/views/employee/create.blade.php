@extends('layouts.app')
@section('page-title')
    {{ __('Employee Create') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">Employee Create</p>
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        <form class="row g-3 needs-validation" novalidate method="post" action="{{ route('employee.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-3">
                                <label for="validationCustom01" class="form-label">Employee ID</label>
                                <input type="text" name="employee_id" class="form-control" id="employee_id"
                                    value="{{ $employeesId }}" readonly>
                                @if ($errors->has('employee_id'))
                                    <span class="text-danger">{{ $errors->first('employee_id') }}</span>
                                @endif
                            </div>
                            <div class="col-md-3">
                                <label for="validationCustom01" class="form-label">Name<span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" id="validationCustom01"
                                    value="{{ old('name') }}" required>
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="col-md-3">
                                <label for="validationCustom01" class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" id="validationCustom01"
                                    value="{{ old('phone') }}" required>
                                @if ($errors->has('phone'))
                                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                                @endif
                            </div>
                            <div class="col-md-3">
                                <label for="validationCustom01" class="form-label">Date of Birth</label>
                                <input type="text" value="{{ old('dob') }}" name="dob" class="form-control"
                                    id="datepicker" required>
                                @error('dob')
                                    <span class="text-danger">{{ $message }}</span>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <div>
                                        <label for="validationCustom01" class="form-label">Gender<span
                                                class="text-danger">*</span></label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="inlineRadio1"
                                            value="Male" checked="checked">
                                        <label class="form-check-label" for="inlineRadio1">Male</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="inlineRadio2"
                                            value="Female">
                                        <label class="form-check-label" for="inlineRadio2">Female</label>
                                    </div>
                                    @if ($errors->has('gender'))
                                        <span class="text-danger">{{ $errors->first('gender') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <label for="validationCustom02" class="form-label">Email<span
                                            class="text-danger">*</span></label>
                                    <input type="eamil" name="email" class="form-control" id="email"
                                        value="{{ old('email') }}" required>
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <label for="validationCustom03" class="form-label">Password<span
                                            class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control" id="password" required>
                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <label for="validationCustom01" class="form-label">Address</label>
                                    <input type="text" name="address" class="form-control" id="address"
                                        value="{{ old('address') }}" required>
                                    @if ($errors->has('address'))
                                        <span class="text-danger">{{ $errors->first('address') }}</span>
                                    @endif
                                </div>

                                <hr>



                                <div class="col-md-3">
                                    <label for="validationCustom04" class="form-label">Branch</label>
                                    <select class="form-select" name="branch_id" onchange="fetchDepartment(this.value)"
                                        aria-label="Default select example" required>
                                        <option value="">Select Branch</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}"
                                                {{ old('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('branch_id'))
                                        <span class="text-danger">{{ $errors->first('branch_id') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <label for="validationCustom04" class="form-label">Department</label>
                                    <select class="form-select" name="department_id" id="departments"
                                        aria-label="Default select example" required>
                                        <option value="">Select Department</option>
                                        {{--  @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach  --}}
                                    </select>
                                    @if ($errors->has('department_id'))
                                        <span class="text-danger">{{ $errors->first('department_id') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <label for="validationCustom04" class="form-label">Designation</label>
                                    <select class="form-select" name="designation_id" aria-label="Default select example"
                                        required>
                                        <option value="">Select Designation</option>
                                        @foreach ($designations as $designation)
                                            <option value="{{ $designation->id }}"
                                                {{ old('designation_id') == $designation->id ? 'selected' : '' }}>
                                                {{ $designation->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('designation_id'))
                                        <span class="text-danger">{{ $errors->first('designation_id') }}</span>
                                    @endif
                                </div>



                                <div class="col-md-2">
                                    <label for="validationCustom01" class="form-label">Date Of Joining</label>
                                    <input type="text" value="{{ old('company_doj') }}" name="company_doj"
                                        class="form-control" id="datepicker2" required>
                                    @if ($errors->has('company_doj'))
                                        <span class="text-danger">{{ $errors->first('company_doj') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <label for="validationCustom04" class="form-label">Role<span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" name="role" aria-label="Default select example">
                                        <option value="">Select Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ old('role') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                        @endforeach

                                    </select>
                                    @if ($errors->has('role'))
                                        <span class="text-danger">{{ $errors->first('role') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <label for="reporting_boss" class="form-label">Reporting To</label>
                                    <select class="form-select" name="reporting_boss" id="reporting_boss"
                                        aria-label="Default select example">
                                        <option value="">Select Reporting To</option>
                                        @foreach ($all_employee as $employee)
                                            <option value="{{ $employee->id }}"
                                                {{ old('reporting_boss') == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->user->name }}</option>
                                        @endforeach

                                    </select>
                                    @if ($errors->has('reporting_boss'))
                                        <span class="text-danger">{{ $errors->first('reporting_boss') }}</span>
                                    @endif
                                </div>
                                <hr>
                                <div class="mb-3 row">
                                    <label for="photo" class="col-sm-4 col-form-label">Profile
                                        Photo</label>
                                    <div class="col-sm-2">
                                        <input class="form-control form-control-sm" id="photo" name="photo"
                                            type="file" value="">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="photo" class="col-sm-4 col-form-label">Timezone</label>
                                    <div class="col-sm-2">
                                        <select name="timezone" id="" class="form-control">
                                            <option value="">Select Timezone</option>
                                            @foreach ($timezonelist as $timezone)
                                                <option value="{{ $timezone }}"
                                                    {{ old('timezone') == $timezone ? 'selected' : '' }}>{{ $timezone }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <div class="card-body employee-detail-create-body">
                                    @foreach ($documents as $key => $document)
                                        <div class="row">
                                            <div class="form-group col-12 d-flex">
                                                <div class="float-left col-4">
                                                    <label for="document"
                                                        class="float-left pt-1 form-label">{{ $document->name }} @if ($document->is_required == 1)
                                                            <span class="text-danger">*</span>
                                                        @endif
                                                    </label>
                                                </div>
                                                <div class="float-right col-8">
                                                    <input type="hidden" name="emp_doc_id[{{ $document->id }}]"
                                                        id="" value="{{ $document->id }}">
                                                    <!--  <div class="choose-file form-group">
                                                                                                                                                                                                                                                                                                                                                                                                                        <label for="document[{{ $document->id }}]"
                                                                                                                                                                                                                                                                                                                                                                                                                            class="choose-files bg-primary">
                                                                                                                                                                                                                                                                                                                                                                                                                            <div>{{ __('Choose File') }}</div>
                                                                                                                                                                                                                                                                                                                                                                                                                            <input
                                                                                                                                                                                                                                                                                                                                                                                                                                class="form-control d-none @error('document') is-invalid @enderror border-0"
                                                                                                                                                                                                                                                                                                                                                                                                                                @if ($document->is_required == 1) required @endif
                                                                                                                                                                                                                                                                                                                                                                                                                                name="document[{{ $document->id }}]" type="file"
                                                                                                                                                                                                                                                                                                                                                                                                                                id="document[{{ $document->id }}]"
                                                                                                                                                                                                                                                                                                                                                                                                                                data-filename="{{ $document->id . '_filename' }}">
                                                                                                                                                                                                                                                                                                                                                                                                                        </label>
                                                                                                                                                                                                                                                                                                                                                                                                                       <a href="#"><p class="{{ $document->id . '_filename' }} "></p></a>

                                                                                                                                                                                                                                                                                                                                                                                                                    </div> -->

                                                    <div class="choose-files ">
                                                        <label for="document[{{ $document->id }}]">
                                                            <div class="document"> <i
                                                                    class="ti ti-upload px-1"></i>{{ __('Choose file here') }}
                                                            </div>
                                                            <input type="file"
                                                                class="form-control file  d-none @error('document') is-invalid @enderror"
                                                                @if ($document->is_required == 1) required @endif
                                                                name="document[{{ $document->id }}]"
                                                                id="document[{{ $document->id }}]"
                                                                data-filename="{{ $document->id . '_filename' }}"
                                                                onchange="document.getElementById('{{ 'blah' . $key }}').src = window.URL.createObjectURL(this.files[0])">
                                                            @if ($errors->has('document'))
                                                                <span
                                                                    class="text-danger">{{ $errors->first('document') }}</span>
                                                            @endif
                                                        </label>
                                                        {{--  <a href="#"><p class="{{ $document->id . '_filename' }} "></p></a>  --}}
                                                        <img id="{{ 'blah' . $key }}" src=""
                                                            width="10%" /><label></label>

                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                {{-- <hr> --}}

                                {{-- <div class="col-md-3">
                                    <label for="validationCustom01" class="form-label">Account Number</label>
                                    <input type="text" name="account_number" class="form-control" id="validationCustom01"
                                        value="{{ old('account_number') }}">
                                    @if ($errors->has('account_number'))
                                        <span class="text-danger">{{ $errors->first('account_number') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <label for="validationCustom01" class="form-label">Bank Name</label>
                                    <input type="text" name="bank_name" class="form-control" id="validationCustom01"
                                        value="{{ old('bank_name') }}">
                                    @if ($errors->has('bank_name'))
                                        <span class="text-danger">{{ $errors->first('bank_name') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <label for="validationCustom01" class="form-label">Branch Location</label>
                                    <input type="text" name="branch_location" class="form-control"
                                        id="validationCustom01" value="{{ old('branch_location') }}">
                                    @if ($errors->has('branch_location'))
                                        <span class="text-danger">{{ $errors->first('branch_location') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <label for="validationCustom01" class="form-label">Branch Identifier Code</label>
                                    <input type="text" name="bank_identifier_code" class="form-control"
                                        id="validationCustom01" value="{{ old('bank_identifier_code') }}">
                                    @if ($errors->has('bank_identifier_code'))
                                        <span
                                            class="text-danger">{{ $errors->first('bank_identifier_code') }}</span>branch_location
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <label for="validationCustom01" class="form-label">Account Holder Name</label>
                                    <input type="text" name="account_holder_name" class="form-control"
                                        id="validationCustom01" value="{{ old('account_holder_name') }}">
                                    @if ($errors->has('account_holder_name'))
                                        <span class="text-danger">{{ $errors->first('account_holder_name') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <label for="validationCustom01" class="form-label">
                                        Tax Payer Id</label>
                                    <input type="text" name="tax_payer_id" class="form-control" id="validationCustom01"
                                        value="{{ old('tax_payer_id') }}">
                                    @if ($errors->has('tax_payer_id'))
                                        <span class="text-danger">{{ $errors->first('tax_payer_id') }}</span>
                                    @endif
                                </div> --}}

                                {{-- <hr> --}}

                                <div class="col-md-2">
                                    <label for="validationCustom04" class="form-label">Salary Type</label>
                                    <select class="form-select" name="salary_type" aria-label="Default select example"
                                        required>
                                        <option value="">Select Type</option>
                                        <option value="0" {{ old('salary_type') == 0 ? 'selected' : '' }} selected>
                                            Monthly
                                        </option>
                                        <option value="1" {{ old('salary_type') == 1 ? 'selected' : '' }}>Daily</option>
                                        <option value="2" {{ old('salary_type') == 2 ? 'selected' : '' }}>Hourly</option>

                                    </select>
                                    @if ($errors->has('salary_type'))
                                        <span class="text-danger">{{ $errors->first('salary_type') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    <label for="validationCustom01" class="form-label">Salary</label>
                                    <input type="text" name="salary" class="form-control" id="validationCustom01"
                                        value="{{ old('salary') }}" required>
                                    @if ($errors->has('salary'))
                                        <span class="text-danger">{{ $errors->first('salary') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-2">
                                    <label for="validationCustom04" class="form-label">Shift</label>
                                    <select class="form-select" name="shift_id" aria-label="Default select example" required>
                                        <option value="">Select Shift</option>
                                        @foreach ($shifts as $shift)
                                            <option value="{{ $shift->id }}"
                                                {{ old('shift_id') == $shift->id ? 'selected' : '' }}>
                                                {{ $shift->name .' [' .\Carbon\Carbon::parse($shift->start_time)->timezone(Auth::user()->timezone)->format('h:i a') .'-' .\Carbon\Carbon::parse($shift->end_time)->timezone(Auth::user()->timezone)->format('h:i a') .']' }}
                                            </option>
                                        @endforeach

                                    </select>
                                    @if ($errors->has('shift_id'))
                                        <span class="text-danger">{{ $errors->first('shift_id') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-2">
                                    <label for="validationCustom04" class="form-label">Can Overtime</label>
                                    <select class="form-select" name="can_overtime" aria-label="Default select example"
                                        required>
                                        <option value="">Select One</option>
                                        <option value="0">No</option>
                                        <option value="1" selected>Yes</option>

                                    </select>
                                    @if ($errors->has('can_overtime'))
                                        <span class="text-danger">{{ $errors->first('can_overtime') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    <label for="validationCustom01" class="form-label">Overtime Start</label>
                                    <input type="text" name="start_time" class="form-control" id="start_timepicker">
                                    @if ($errors->has('start_time'))
                                        <span class="text-danger">{{ $errors->first('start_time') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    <label for="validationCustom01" class="form-label">Overtime End</label>
                                    <input type="text" name="end_time" class="form-control" id="end_timepicker">
                                    @if ($errors->has('end_time'))
                                        <span class="text-danger">{{ $errors->first('end_time') }}</span>
                                    @endif
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection


    @push('js')
        <script src="{{ asset('js/jquery-ui.js') }}"></script>

        <script src="{{ asset('js/timepicker.js') }}"></script>

        <script>
            $(function() {
                $("#datepicker").datepicker({
                    dateFormat: "yy-mm-dd"
                });
                $("#datepicker2").datepicker({
                    dateFormat: "yy-mm-dd"
                });
            });



            $(function() {
                $("#start_timepicker").timepicker({
                    timeFormat: 'h:mm p',
                    interval: 60,
                    minTime: '9',
                    maxTime: '6:00pm',
                    //defaultTime: '10',
                    startTime: '09:00',
                    dynamic: false,
                    dropdown: true,
                    scrollbar: true
                });
            });

            $(function() {
                $("#end_timepicker").timepicker({
                    timeFormat: 'h:mm p',
                    interval: 60,
                    minTime: '9',
                    maxTime: '6:00pm',
                    //defaultTime: '10',
                    startTime: '09:00',
                    dynamic: false,
                    dropdown: true,
                    scrollbar: true
                });
            });


            let fetchDepartment = (branch_id) => {

                $.ajax({
                    type: "GET",
                    url: "/department-branch/" + branch_id,
                    dataType: 'json',
                    success: function(data) {
                        //console.log(data);
                        let department = document.getElementById('departments');
                        let all_options = "<option selected>Select Department</option>";

                        data.forEach(element => {
                            all_options = all_options + "<option value='" + element['id'] + "'>" +
                                element['name'] + "</option>";
                        });

                        document.getElementById('departments').innerHTML = all_options;
                    }
                });
            }
        </script>
    @endpush
