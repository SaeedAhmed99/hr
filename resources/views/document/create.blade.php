@extends('layouts.app')

@section('content')
    <div class="mt-5 p-2">
        <form class="row g-3 needs-validation" novalidate method="post" action="{{ route('document.store') }}">
            @csrf
            <div class="col-md-12">
                <label for="validationCustom01" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" id="validationCustom01" required>
                @if ($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
            </div>

            <div class="col-md-3">
                <label for="validationCustom04" class="form-label">Required Field</label>
                <select class="form-select" name="is_required" aria-label="Default select example" required>
                    <option value="">Select One</option>
                    <option value="1">Is Requrired</option>

                    <option value="0">Not Requrired</option>

                </select>
                @if ($errors->has('is_required'))
                    <span class="text-danger">{{ $errors->first('is_required') }}</span>
                @endif
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Submit</button>
            </div>
        </form>
    </div>
@endsection
