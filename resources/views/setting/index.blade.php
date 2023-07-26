@extends('layouts.app')
@push('head')
    <style>
        .company_logo-w {
            filter: drop-shadow(2px 3px 7px #011c4b);
        }
    </style>
@endpush
@section('page-title')
    {{ __('Setting') }}
@endsection

{{--  <a type="button" class="btn btn-primary" href="{{ route('roles.create') }}">Create Role</a>  --}}

@section('content')
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-md-6">
            <div class="card">
                <div class="card-header">
                    <p class="card-heading">{{ __('Basic Information') }}</p>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('business.setting') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>{{ __('Logo') }}</h5>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="text-center">
                                            <div class="logo-content mt-4">
                                                <img id="image1" src="{{ asset(setting('company_logo')) }}"
                                                    class="company_logo company_logo-w">
                                            </div>
                                            <div class="mt-5">
                                                <label for="company_logo">
                                                    <input type="file" class="form-control file" name="company_logo"
                                                        id="company_logo">
                                                </label>
                                            </div>

                                            @error('company_logo')
                                                <div class="row">
                                                    <span class="invalid-company_logo" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>{{ __('Favicon') }}</h5>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="text-center">
                                            <div class="logo-content mt-4">
                                                <img src="{{ asset(setting('company_favicon')) }}" width="50px"
                                                    class="logo">
                                            </div>

                                            <div class="choose-files mt-5">
                                                <label for="company_favicon">
                                                    <input type="file" class="form-control file" name="company_favicon"
                                                        id="company_favicon">
                                                </label>
                                            </div>


                                            @error('company_favicon')
                                                <div class="row">
                                                    <span class="invalid-logo" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-6 mt-3">
                                <label for="company_title" class="form-label">Company Name</label>
                                <input type="text" name="company_title" class="form-control" id="company_title"
                                    value="{{ setting('company_title') }}">
                                @error('company_title')
                                    <span class="invalid-company_title" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 mt-3">
                                <label for="footer_text" class="form-label">Timezone</label>
                                <select name="timezone" id="" class="form-control">
                                    <option value="">Select Timezone</option>
                                    @foreach ($timezonelist as $timezone)
                                        <option value="{{ $timezone }}"
                                            {{ setting('timezone') == $timezone ? 'selected' : '' }}>{{ $timezone }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('timezone')
                                    <span class="invalid-timezone" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            @php
                                $start_time = json_decode(setting('company_start_time'));
                                //print_r($area); // this is your area from json response
                            @endphp
                            <div class="form-group col-md-6 mt-3">
                                <label for="company_start_time" class="form-label">{{ __('Company Start Time') }}</label>
                                <input type="time" name="company_start_time" class="form-control" id="company_start_time"
                                    value="{{ $start_time->start_time }}">
                                @error('company_start_time')
                                    <span class="invalid-company_start_time" role="alert">
                                        <small class="text-danger">{{ $message }}</small>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 mt-3">
                                <label for="duration" class="form-label">{{ __('Duration in Hours') }}</label>

                                <input type="text" name="duration" class="form-control" id="duration"
                                    value="{{ $start_time->duration }}">
                                @error('duration')
                                    <span class="invalid-duration" role="alert">
                                        <small class="text-danger">{{ $message }}</small>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 mt-3">
                                <label for="website_title" class="form-label">{{ __('Website Title') }}</label>

                                <input type="text" name="website_title" class="form-control" id="website_title"
                                    value="{{ setting('website_title') }}">
                                @error('website_title')
                                    <span class="invalid-website_title" role="alert">
                                        <small class="text-danger">{{ $message }}</small>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 mt-3">
                                <label for="footer_text" class="form-label">Footer Text</label>
                                <input type="text" name="footer_text" class="form-control" id="footer_text"
                                    value="{{ setting('footer_text') }}">
                                @error('footer_text')
                                    <span class="invalid-footer_text" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                </div>
                <div class="card-footer ">
                    <div class="col-sm-12 px-2">
                        <div class="text-end">
                            <button class="btn btn-primary" type="submit">Save Change</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
