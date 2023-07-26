@extends('layouts.app')

@section('content')
    <div class="mt-5 p-2">
        <form class="row g-3 needs-validation" novalidate method="post" action="{{ route('trainer.store') }}">
            @csrf
            <div class="col-md-2">
                <label for="validationCustom04" class="form-label">Employee</label>
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
                <label for="validationCustom01" class="form-label">First Name</label>
                <input type="text" name="firstname" class="form-control" value="{{ old('firstname') }}" >
                </input>
                @if ($errors->has('firstname'))
                    <span class="text-danger">{{ $errors->first('firstname') }}</span>
                @endif
            </div>
             <div class="col-md-2">
                <label for="validationCustom01" class="form-label">Last Name</label>
                <input type="text" name="lastname" class="form-control"  value="{{ old('lastname') }}">
                </input>
                @if ($errors->has('lastname'))
                    <span class="text-danger">{{ $errors->first('lastname') }}</span>
                @endif
            </div>
            <div class="col-md-2">
                <label for="validationCustom01" class="form-label">Contact</label>
                <input type="text" name="contact" class="form-control" value="{{ old('contact') }}">
                </input>
                @if ($errors->has('contact'))
                    <span class="text-danger">{{ $errors->first('contact') }}</span>
                @endif
            </div>
            <div class="col-md-2">
                <label for="validationCustom01" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" >
                </input>
                @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <hr>

            <div class="col-md-4">
                <label for="validationCustom01" class="form-label">Expertise</label>
                <textarea name="expertise" class="form-control" id="expertise" rows="3" value="{{ old('expertise') }}">
                </textarea>
                @if ($errors->has('expertise'))
                    <span class="text-danger">{{ $errors->first('expertise') }}</span>
                @endif
            </div>
            <div class="col-md-4">
                <label for="validationCustom01" class="form-label">Leave Reason</label>
                <textarea name="address" class="form-control" id="address" rows="3" value="{{ old('address') }}">
                </textarea>
                @if ($errors->has('address'))
                    <span class="text-danger">{{ $errors->first('address') }}</span>address
                @endif
            </div>


            <div class="col-12">
                <button class="btn btn-primary" type="submit">Submit</button>
            </div>
        </form>
    </div>
@endsection


@push('js')

    <script type="text/javascript">

    </script>
@endpush
