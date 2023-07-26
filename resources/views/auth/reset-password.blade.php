@extends('layouts.auth')
@section('page-title')
    {{ __('Login') }}
@endsection
@php
    $logo = asset(Storage::url('uploads/logo/'));
@endphp

@section('content')
    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12  d-md-block backcolor">
        <div class="row align-items-center vh-100 justify-content-center">
            <div class="col-12 col-md-6">
                <div class="card-body">
                    {{--  <div class="card-image">
                        <img src="images/vector2.svg">
                    </div>  --}}
                    <div class="">
                        <h2 class="mb-3 pb-4 f-w-600 title">{{ __('Cloud HR') }}</h2>
                    </div>
                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <!-- Email Address -->
                        <div>
                            <x-label for="email" :value="__('Email')" />

                            <x-input id="email" class="form-control block mt-1 w-full" type="email" name="email"
                                :value="old('email', $request->email)" required autofocus />
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-label for="password" :value="__('Password')" />

                            <x-input id="password" class="form-control block mt-1 w-full" type="password" name="password"
                                required />
                        </div>

                        <!-- Confirm Password -->
                        <div class="mt-4">
                            <x-label for="password_confirmation" :value="__('Confirm Password')" />

                            <x-input id="password_confirmation" class="form-control block mt-1 w-full" type="password"
                                name="password_confirmation" required />
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="login-do-btn btn btn-primary btn-block mt-2"
                                tabindex="4">{{ __('Reset Password') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('head')
    <style>
        .card-body {
            background-color: rgba(113, 110, 250, 0.5);
            box-shadow: 16px 16px 20px 10px rgba(0, 0, 0, 0.25);
            border-radius: 20px;
            background-image: url("images/vector1.svg");
            background-repeat: no-repeat;
            background-size: 100% 100%;
            text-align: center;
            color: white;
            position: relative;
            font-family: 'Poppins';
        }


        .backcolor {
            background: linear-gradient(225deg, #7929FF, #6842FF, #7099EA);
        }

        .loginbtn {
            width: 150px;
            height: 51px;
            background: #7099EA;
            box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
            border-radius: 5px;
            color: #FFFFFF;
            font-weight: 600;
            font-size: 24px;
        }

        .title {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 700;
            font-size: 40px;
            line-height: 48px;

            color: #FFFFFF;

            text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
        }

        .card-body {
            padding: 3rem 7rem 3rem 7rem;
        }

        .panel-btn {
            background: #6842FF;
            border-radius: 10px;
            width: 120px;
            height: 48px;
            margin: 20px;
            color: #FFFFFF
        }

        .card-image {
           position: absolute;
            right: 0;
            left: 575px;
            bottom: 0;
        }
    </style>
@endpush
