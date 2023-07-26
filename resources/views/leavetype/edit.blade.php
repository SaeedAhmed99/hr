@extends('layouts.app')

@section('content')
    <div class="mt-5 p-2">
        <form class="row g-3 needs-validation" novalidate method="POST"
            action="{{ route('leavetype.update', $leavetype->id) }}">
            @csrf
            @method('PUT')
            <div class="col-md-12">
                <label for="validationCustom01" class="form-label">Name</label>
                <input type="text" name="name" class="form-control"  value="{{ $leavetype->name }}"
                    required>
                @if ($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
            </div>
            <div class="col-md-3">
                <label for="validationCustom01" class="form-label">Days</label>
                <input type="number" name="days" class="form-control" value="{{ $leavetype->days }}"
                    required>
                @if ($errors->has('days'))
                    <span class="text-danger">{{ $errors->first('days') }}</span>
                @endif
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Update</button>
            </div>
        </form>
    </div>
@endsection
