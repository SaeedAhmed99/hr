@extends('layouts.auth')
@section('page-title')
    {{ __('Installation') }}
@endsection

@push('css')
    <style>
        .backcolor {
            background: linear-gradient(225deg, #7929FF, #6842FF, #7099EA);
        }
        .save-credential{
            width: fit-content;
        }
    </style>
@endpush

@php
    $logo = asset(Storage::url('uploads/logo/'));
@endphp

@section('content')
    <div class="row justify-content-center vh-100 backcolor ">
        <div class="col-12 align-self-center align-items-center text-center">
            <img width="150px" src="{{ asset('storage/logo/logo.png') }}" alt="">
        </div>
        <div class="col-12 col-md-6">
            <form action="{{ route('install.server.config.create') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-body">
                        @if (Session::get('message'))
                            <h4 class="text-danger text-center">{{ Session::get('message') }}</h4>
                        @endif
                        <h4>Database credentials</h4>
                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label for="db_host">Database Host</label>
                                <input name="db_host" id="db_host" value="{{ old('db_host') }}" type="text" class="form-control @error('db_host') is-invalid @enderror" placeholder="Database host">
                                <div class="invalid-feedback">
                                    @error('db_host')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="db_port">Database Port</label>
                                <input name="db_port" id="db_port" value="{{ old('db_port') }}" type="text" class="form-control  @error('db_port') is-invalid @enderror" placeholder="Database port">
                                <div class="invalid-feedback">
                                    @error('db_port')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="db_database">Database Name</label>
                                <input name="db_database" id="db_database" value="{{ old('db_database') }}" type="text" class="form-control  @error('db_database') is-invalid @enderror" placeholder="Database name">
                                <div class="invalid-feedback">
                                    @error('db_database')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="db_username">Database User name</label>
                                <input name="db_username" id="db_username" value="{{ old('db_username') }}" type="text" class="form-control  @error('db_username') is-invalid @enderror" placeholder="Database user name">
                                <div class="invalid-feedback">
                                    @error('db_username')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="db_password">Database Password</label>
                                <input name="db_password" id="db_password" value="{{ old('db_password') }}" type="password" class="form-control  @error('db_password') is-invalid @enderror" placeholder="Database password">
                                <div class="invalid-feedback">
                                    @error('db_password')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-2">
                    <div class="card-body">
                        <h4>Email credentials</h4>
                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label for="mail_host">Email Host</label>
                                <input name="mail_host" id="mail_host" value="{{ old('mail_host') }}" type="text" class="form-control  @error('mail_host') is-invalid @enderror" placeholder="Email host">
                                <div class="invalid-feedback">
                                    @error('mail_host')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="mail_port">Email Port</label>
                                <input name="mail_port" id="mail_port" value="{{ old('mail_port') }}" type="text" class="form-control  @error('mail_port') is-invalid @enderror" placeholder="Email port">
                                <div class="invalid-feedback">
                                    @error('mail_port')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            {{-- <div class="form-group col-md-6 col-12">
                                <label for="mail_name">Email Name</label>
                                <input name="mail_name" id="mail_name" value="{{ old('mail_name') }}" type="text" class="form-control  @error('db_password') is-invalid @enderror" placeholder="Email name">
                            </div> --}}
                            <div class="form-group col-md-6 col-12">
                                <label for="mail_username">Email User name</label>
                                <input name="mail_username" id="mail_username" value="{{ old('mail_username') }}" type="text" class="form-control  @error('mail_username') is-invalid @enderror" placeholder="Email user name">
                                <div class="invalid-feedback">
                                    @error('mail_username')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="mail_password">Email Password</label>
                                <input name="mail_password" id="mail_password" value="{{ old('mail_password') }}" type="password" class="form-control  @error('mail_password') is-invalid @enderror" placeholder="Email password">
                                <div class="invalid-feedback">
                                    @error('mail_password')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="mail_encryption">Email Encryption</label>
                                <input name="mail_encryption" id="mail_encryption" value="{{ old('mail_encryption') }}" type="text" class="form-control  @error('mail_encryption') is-invalid @enderror" placeholder="Email encryption">
                                <div class="invalid-feedback">
                                    @error('mail_encryption')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="mail_from_address">Email Mail From Address</label>
                                <input name="mail_from_address" id="mail_from_address" value="{{ old('mail_from_address') }}" type="text" class="form-control  @error('mail_from_address') is-invalid @enderror"
                                    placeholder="Email mail from address">
                                <div class="invalid-feedback">
                                    @error('mail_from_address')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-end mt-3">
                    <button class="btn btn-success text-end me-3 save-credential">Save credentials</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        // $.ajax({
        //     type: "post",
        //     url: "{{ route('install.server.migrate') }}",
        //     data: {
        //         _token: "{{ csrf_token() }}"
        //     },
        //     success: function success(data) {
        //         location.href = "{{ url('/') }}";
        //     },
        //     error: function error(data) {
        //         show_toastr('Error', data.responseJSON.message, 'error');
        //     }
        // });
    </script>
@endpush
