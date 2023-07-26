@extends('layouts.auth')
@section('page-title')
    {{ __('Installation') }}
@endsection

@push('css')
    <style>
        .backcolor {
            background: linear-gradient(225deg, #7929FF, #6842FF, #7099EA);
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
        <div class="col-12 col-md-4">
            <div class="card card-body">
                <h4>Server Requirements</h4>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item text-semibold">
                        <div class="d-flex justify-content-between align-items-center gap-5">
                            <p class="m-0">PHP version 8.1 +</p>
                            @php
                                $phpVersion = number_format((float) phpversion(), 2, '.', '');
                            @endphp
                            @if ($phpVersion >= 8.1)
                                <i class="fas fa-check text-success"></i>
                            @else
                                <i class="fas fa-times text-danger"></i>
                            @endif
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center gap-5">
                            <p class="p-0 m-0">CURL enabled</p>
                            @if ($permission['curl_enabled'])
                                <i class="fas fa-check text-success"></i>
                            @else
                                <i class="fas fa-times text-danger"></i>
                            @endif
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center gap-5">
                            <p class="p-0 m-0">File write permission</p>
                            @if ($permission['db_file_write_perm'])
                                <i class="fas fa-check text-success"></i>
                            @else
                                <i class="fas fa-times text-danger"></i>
                            @endif
                        </div>
                    </li>
                    <li class="list-group-item text-end">
                        @if ($phpVersion >= 7.2 and $permission['curl_enabled'] and $permission['db_file_write_perm'])
                            <a class="btn" href="{{ route('install.server.config.show') }}">Next step <i class="fa-solid fa-arrow-right"></i></a>
                        @endif
                    </li>
                </ul>
            </div>

        </div>

        <div class="col-12">
        </div>
    </div>
@endsection
