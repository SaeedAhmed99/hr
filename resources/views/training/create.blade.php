@extends('layouts.app')

@section('content')
    <div class="mt-5 p-2">
        <form class="row g-3 needs-validation" novalidate method="post" action="{{ route('training.store') }}">
            @csrf
            <div class="col-md-2">
                <label for="validationCustom04" class="form-label">Branch</label>
                <select class="form-select" name="branch" aria-label="Default select example" required>
                    <option value="">Select Branch</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}"> {{ $branch->name }}
                        </option>
                    @endforeach

                </select>
                @if ($errors->has('branch'))
                    <span class="text-danger">{{ $errors->first('branch') }}</span>
                @endif
            </div>

            <div class="col-md-2">
                <label for="validationCustom04" class="form-label">Trainer Option</label>
                <select class="form-select" name="trainer_option" aria-label="Default select example" required>
                    <option value="">Select Option</option>
                    @foreach ($options as $option)
                        <option value="{{ $option }}"> {{ $option }}
                        </option>
                    @endforeach

                </select>
                @if ($errors->has('trainer_option'))
                    <span class="text-danger">{{ $errors->first('trainer_option') }}</span>
                @endif
            </div>

            <div class="col-md-2">
                <label for="validationCustom04" class="form-label">Training Type</label>
                <select class="form-select" name="training_type" aria-label="Default select example" required>
                    <option value="">Select Type</option>
                    @foreach ($trainingTypes as $trainingType)
                        <option value="{{ $trainingType->id }}"> {{ $trainingType->name }}
                        </option>
                    @endforeach

                </select>
                @if ($errors->has('training_type'))
                    <span class="text-danger">{{ $errors->first('training_type') }}</span>
                @endif
            </div>
            <div class="col-md-2">
                <label for="validationCustom04" class="form-label">Trainer</label>
                <select class="form-select" name="trainer" aria-label="Default select example" required>
                    <option value="">Select Trainer</option>
                    @foreach ($trainers as $trainer)
                        <option value="{{ $trainer->id }}"> {{ $trainer->firstname }}
                        </option>
                    @endforeach

                </select>
                @if ($errors->has('trainer'))
                    <span class="text-danger">{{ $errors->first('trainer') }}</span>
                @endif
            </div>

            <div class="col-md-2">
                <label for="validationCustom01" class="form-label">Training Cost</label>
                <input type="number" name="training_cost" class="form-control" value="{{ old('training_cost') }}">
                </input>
                @if ($errors->has('training_cost'))
                    <span class="text-danger">{{ $errors->first('training_cost') }}</span>
                @endif
            </div>
            <hr>

            <div class="col-md-2">
                <label for="validationCustom04" class="form-label">Employee</label>
                <select class="form-select" name="employee" aria-label="Default select example" required>
                    <option value="">Select Employee</option>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}"> {{ $employee->user->name }}
                        </option>
                    @endforeach

                </select>
                @if ($errors->has('employee'))
                    <span class="text-danger">{{ $errors->first('employee') }}</span>
                @endif
            </div>

            <div class="col-md-2">
                <label for="validationCustom01" class="form-label">Start Date</label>
                <input type="text" name="start_date" class="form-control" id="start_datepicker" required>
                @if ($errors->has('start_date'))
                    <span class="text-danger">{{ $errors->first('start_date') }}</span>
                @endif
            </div>
            <div class="col-md-2">
                <label for="validationCustom01" class="form-label">End Date</label>
                <input type="text" name="end_date" class="form-control" id="end_datepicker" required>
                @if ($errors->has('end_date'))
                    <span class="text-danger">{{ $errors->first('end_date') }}</span>
                @endif
            </div>
            <div class="col-md-4">
                <label for="validationCustom01" class="form-label">Description</label>
                <textarea name="description" class="form-control" id="description" rows="3" value="{{ old('description') }}">
                </textarea>
                @if ($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>address
                @endif
            </div>


            <div class="col-12">
                <button class="btn btn-primary" type="submit">Submit</button>
            </div>
        </form>
    </div>
@endsection


@push('js')


    <script>
        $(function() {
            $("#start_datepicker").datepicker({
                dateFormat: 'yy-mm-dd'
             });
            $("#end_datepicker").datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>
@endpush
