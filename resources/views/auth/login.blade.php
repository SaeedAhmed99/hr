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
            box-shadow: 16px 16px 20px 10px rgba(0, 0, 0, 0.25);
            border-radius: 5px;
            color: #FFFFFF;
            font-weight: 600;
            font-size: 1.5rem;
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
            background-color: #6842FF;
            box-shadow: 16px 16px 20px 10px rgba(0, 0, 0, 0.25);
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
                padding: 10px;
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
        }

        .title-font {
            font-size: 27px;
        }

        .company-title-font {
            font-size: 20px;
        }

        .remember-me-checkbox {
            float: unset;
        }
    </style>
@endpush

@php
    $logo = asset(Storage::url('uploads/logo/'));
@endphp

@section('content')
    <div class="row align-items-center justify-content-center m-0 backcolor vh-100 w-100">
        <div class="col-xl-5 col-md-9 col-12 m-0">
            <div class="card-body">
                <div class="card-image ">
                    <img src="images/vector2.svg">
                </div>
                <div class="">
                    <p class="mb-3 pb-1 f-w-600 title company-title-font">{{ setting('company_title') }}</p>
                </div>
                <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="" id="form_data">
                    @csrf
                    <div>
                        <div class="form-group mb-3 ">
                            {{--  <label class="form-label">{{ __('Email') }}</label>  --}}
                            <input class="form-control @error('email') is-invalid @enderror text-center" id="email"
                                type="email" name="email" value="{{ old('email') }}" placeholder="Enter Your Email"
                                required autocomplete="email" autofocus>
                            @error('email')
                                <span class="error invalid-email text-danger" role="alert">
                                    <small>{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            {{--  <label class="form-label">{{ __('Password') }}</label>  --}}
                            <input class="form-control @error('password') is-invalid @enderror text-center" id="password"
                                type="password" name="password" placeholder="Enter Your Password" required
                                autocomplete="current-password">
                            @error('password')
                                <span class="error invalid-password text-danger" role="alert">
                                    <small>{{ $message }}</small>
                                </span>
                            @enderror

                            @if (Route::has('password.request'))
                                <div class="mb-3 mt-3">
                                    <a href="{{ route('password.request') }}"
                                        class="text-white">{{ __('Forgot Your Password?') }}</a>
                                </div>
                                <div class="form-check d-flex gap-2 justify-content-center">
                                    <input class="form-check-input remember-me-checkbox" type="checkbox" id="remember"
                                        value="1" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        Remember Me
                                    </label>
                                </div>
                            @endif
                        </div>
                        {{--  @if (env('RECAPTCHA_MODULE') == 'yes')
                                <div class="form-group col-lg-12 col-md-12 mt-3">
                                    {!! NoCaptcha::display() !!}
                                    @error('g-recaptcha-response')
                                        <span class="error small text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            @endif  --}}

                        <div class="">
                            <button type="submit" class="mt-2 loginbtn" tabindex="3">{{ __('Login') }}</button>
                        </div>

                        {{--  @if (Utility::getValByName('disable_signup_button') == 'on')
                            <p class="my-4 text-center">{{ __("Don't have an account?") }}
                                <a href="{{route('register',$lang)}}" class="my-4 text-primary">{{__('Register')}}</a>
                            </p>
                        @endif  --}}
                    </div>
                </form>

            </div>

        </div>

    </div>
@endsection

@push('js')
    <script type="text/javascript">
        function fillSuperAdmin() {
            $('#email').val('admin@gmail.com');
            $('#password').val('admin#123');
        }

        function fillAdmin() {
            $('#email').val('hr@gmail.com');
            $('#password').val('hr#123');
        }

        function fillEmployee() {
            $('#email').val('employee@gmail.com');
            $('#password').val('employee#123');
        }
    </script>
@endpush
