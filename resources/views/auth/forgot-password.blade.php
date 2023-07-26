@extends('layouts.auth')
@section('page-title')
    {{ __('Login') }}
@endsection

@push('css')
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

        @media only screen and (max-width: 425px) {
            .card-body {
                padding: 20px;
            }

            .panel-btn {
                margin: 10px;
            }

            .loginbtn {
                font-size: 1rem;
                width: 100px;
                height: 40px;
            }

            .panel-btn {
                width: 100px;
                height: 40px;
                font-size: 0.8rem;
            }

            .title-font{
                font-size: 24px;
            }
        }
    </style>
@endpush

@php
    $logo = asset(Storage::url('uploads/logo/'));
@endphp

@section('content')
    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12  d-md-block backcolor p-2">
        <div class="row align-items-center vh-100 justify-content-center">
            <div class="col-xl-4 col-md-9 col-12">
                <div class="card-body">

                    {{--  <div class="card-image">
                        <img src="images/vector2.svg">
                    </div>  --}}
                    <div class="">
                        <p class="mb-3 pb-4 f-w-600 title title-font">{{ setting('company_title') }}</p>
                    </div>
                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div>
                            <div class="form-group mb-3">
                                {{--  <label class="form-label">{{ __('Email') }}</label>  --}}
                                <input class="form-control @error('email') is-invalid @enderror" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Enter Your Email" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="error invalid-email text-danger" role="alert">
                                        <small>{{ $message }}</small>
                                    </span>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="login-do-btn btn btn-primary btn-block mt-2" tabindex="4">{{ __('Email Password Reset Link') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection