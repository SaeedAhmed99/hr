@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">Create User</p>
                        {{--  <button data-bs-toggle="modal" data-bs-target="#add_travel_modal" class="btn btn-gray"><i
                                class="fa-solid fa-plus"></i></button>  --}}
                    </div>
                </div>
                <div class="card-body">
                    <div class="p-2">
                        <form class="row g-3 needs-validation" novalidate method="post" action="{{ route('user.store') }}">
                            @csrf
                            <div class="col-md-12">
                                <label for="validationCustom01" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" id="validationCustom01" required>
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <label for="validationCustom02" class="form-label">Email</label>
                                <input type="eamil" name="email" class="form-control" id="validationCustom02" required>
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label for="validationCustom03" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="validationCustom03"
                                    required>
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="col-md-3">
                                <label for="validationCustom04" class="form-label">Role</label>
                                <select class="form-select" name="role" aria-label="Default select example">
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach

                                </select>
                                @if ($errors->has('role'))
                                    <span class="text-danger">{{ $errors->first('role') }}</span>
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
