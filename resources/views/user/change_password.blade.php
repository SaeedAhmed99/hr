@extends('layouts.app')
@php
    $profile = asset('storage/avatar');
@endphp

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">Change Password</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="">
                    <div class="card-body ">
                        <div class="col-md-12 pl-md-3 pt-md-0 pt-sm-4 pt-4">
                            <div class="tab-content px-primary">
                                <div id="Personal Details-0" class="tab-pane fade active show">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="d-flex align-items-center text-capitalize mb-0 title tab-content-header">
                                            Password</h5>
                                    </div>
                                    <hr>
                                    <form method="post" action="{{ route('update.password') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="content py-primary">
                                            <div class="mb-3 row">
                                                <label for="current_password" class="col-sm-3 col-form-label">Current
                                                    Password</label>
                                                <div class="col-sm-8">
                                                    <input type="password" class="form-control" name="current_password"
                                                        id="current_password" value="">
                                                    @error('current_password')
                                                        <span class="invalid-current_password" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                            </div>
                                            <div class="mb-3 row">
                                                <label for="new_password" class="col-sm-3 col-form-label">New
                                                    Password</label>
                                                <div class="col-sm-8">
                                                    <input type="password" class="form-control" name="new_password"
                                                        id="new_password" value="">
                                                    @error('new_password')
                                                        <span class="invalid-current_password" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div id="new_password_invalid" class="invalid-feedback"></div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="confirm_password" class="col-sm-3 col-form-label">Confirm
                                                    Password</label>
                                                <div class="col-sm-8">
                                                    <input type="password" class="form-control" name="confirm_password"
                                                        id="confirm_password" value="">
                                                    @error('confirm_password')
                                                        <span class="invalid-current_password" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div id="confirm_password_invalid" class="invalid-feedback"></div>
                                            </div>

                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $("#dob").datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>
@endpush
