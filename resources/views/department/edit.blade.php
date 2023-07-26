@extends('layouts.app')

@section('content')
<div class="mt-5 p-2">
    <form class="row g-3 needs-validation" novalidate method="POST" action="{{ route('department.update', $department->id) }}">
        @csrf
        @method('PUT')
        <div class="col-md-12">
          <label for="validationCustom01" class="form-label">Name</label>
          <input type="text" name="name" class="form-control" id="validationCustom01" value="{{  $department->name }}"  required>
          @if ($errors->has('name'))
          <span class="text-danger">{{ $errors->first('name') }}</span>
          @endif
        </div>
        <div class="col-md-3">
            <label for="validationCustom04" class="form-label">Branch</label>
            <select class="form-select" name="branch" aria-label="Default select example">
              <option value="">Select Branch</option>
              @foreach ($branches as $branch)
                  <option value="{{ $branch->id }}" {{ ($branch->name === $department->branch->name ) ? 'selected' : '' }}>{{ $branch->name }}</option>
              @endforeach
            </select>
            @if ($errors->has('branch'))
          <span class="text-danger">{{ $errors->first('branch') }}</span>
          @endif
          </div>
        <div class="col-12">
          <button class="btn btn-primary" type="submit">Update</button>
        </div>
      </form>
</div>





@endsection

