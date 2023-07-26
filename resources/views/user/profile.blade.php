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
                        <p class="card-heading">My Profile</p>
                    </div>
                </div>
                <div class="user-profile mb-primary">
                    <div class="card-body py-4">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-5">
                                <div class="media border-right px-5 pr-xl-5 pl-xl-0 user-header-media">
                                    <div class="profile-pic-wrapper">
                                        <div class="custom-image-upload-wrapper circle mx-xl-auto">
                                            <div class="image-area d-flex "><img id="imageResult"
                                                    src="{{ !empty($userDetail->avater) ? $profile . '/' . $userDetail->avater : $profile . '/avatar.png' }}"
                                                    alt class="img-fluid mx-auto my-auto"></div>
                                            <div class="input-area">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="media-body user-info-header">
                                        <h4>
                                            {{ $userDetail->name }}
                                        </h4>
                                        @if ($userDetail->employee->status == 1)
                                            <span class="badge badge-pill badge-success user-status">Active</span>
                                        @else
                                            <span class="badge badge-pill badge-success user-status">Deactive</span>
                                        @endif
                                        <p class="text-muted mt-2 mb-0">{{ $userDetail->email }}</p>
                                        <p class="text-primary">
                                            {{ $userDetail->roles->first()->name }}
                                        </p>
                                        <p>Current Shift:
                                            @if (isset($userDetail->employee->shift))
                                                {{ $userDetail->employee->shift->name .' [' .\Carbon\Carbon::parse($userDetail->employee->shift->start_time)->timezone(Auth::user()->timezone)->format('h:i a') .'-' .\Carbon\Carbon::parse($userDetail->employee->shift->end_time)->timezone(Auth::user()->timezone)->format('h:i a') .']' }}
                                            @else
                                                <span>-</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-7">
                                <div
                                    class="user-details px-5 px-sm-5 px-md-5 px-lg-0 px-xl-0 mt-5 mt-sm-5 mt-md-0 mt-lg-0 mt-xl-0">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                                            <div class="border-right custom">
                                                <div class="media mb-4 mb-xl-5">
                                                    <div class="align-self-center mr-3"><svg xmlns="" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" class="feather feather-phone">
                                                            <path
                                                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                                            </path>
                                                        </svg></div>
                                                    <div class="media-body">
                                                        <p class="text-muted mb-0">Contact:</p>
                                                        <p class="mb-0">
                                                            {{ $userDetail->employee->phone ? $userDetail->employee->phone : '-' }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="media mb-4 mb-xl-0">
                                                    <div class="align-self-center mr-3"><svg xmlns="" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" class="feather feather-map-pin">
                                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                                            <circle cx="12" cy="10" r="3"></circle>
                                                        </svg></div>
                                                    <div class="media-body">
                                                        <p class="text-muted mb-0">Address:</p>
                                                        <p class="mb-0">
                                                            {{ $userDetail->employee->address ? $userDetail->employee->address : '-' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                                            <div class="media mb-4 mb-xl-5">
                                                <div class="align-self-center mr-3"><svg xmlns="" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" class="feather feather-calendar">
                                                        <rect x="3" y="4" width="18" height="18"
                                                            rx="2" ry="2"></rect>
                                                        <line x1="16" y1="2" x2="16" y2="6">
                                                        </line>
                                                        <line x1="8" y1="2" x2="8" y2="6">
                                                        </line>
                                                        <line x1="3" y1="10" x2="21" y2="10">
                                                        </line>
                                                    </svg></div>
                                                <div class="media-body">
                                                    <p class="text-muted mb-0">Created:</p>
                                                    <p class="mb-0">
                                                        {{ $userDetail->employee->created_at }}</p>
                                                </div>
                                            </div>
                                            <div class="media mb-0 mb-xl-0">
                                                <div class="align-self-center mr-3"><svg xmlns="" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" class="feather feather-gift">
                                                        <polyline points="20 12 20 22 4 22 4 12"></polyline>
                                                        <rect x="2" y="7" width="20"
                                                            height="5">
                                                        </rect>
                                                        <line x1="12" y1="22" x2="12"
                                                            y2="7">
                                                        </line>
                                                        <path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path>
                                                        <path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path>
                                                    </svg></div>
                                                <div class="media-body">
                                                    <p class="text-muted mb-0">Date of birth:</p>
                                                    <p class="mb-0">
                                                        {{ $userDetail->employee->dob ? $userDetail->employee->dob : '-' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

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
                                        <h5
                                            class="d-flex align-items-center text-capitalize mb-0 title tab-content-header">
                                            Personal Details</h5>
                                    </div>
                                    <hr>
                                    <form method="post" action="{{ route('profile.update', $userDetail->id) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="content py-primary">
                                            <div class="mb-3 row">
                                                <label for="name" class="col-sm-3 col-form-label">Name</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="name"
                                                        id="name" value="{{ $userDetail->name }}">
                                                    @error('name')
                                                        <span class="invalid-current_password" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="phone" class="col-sm-3 col-form-label">Phone Number</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="phone"
                                                        id="phone" value="{{ $userDetail->employee->phone }}">
                                                    @error('phone')
                                                        <span class="invalid-current_password" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                            </div>
                                            <div class="mb-3 row">
                                                <label for="address" class="col-sm-3 col-form-label">Address</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="address"
                                                        id="address"
                                                        value="{{ $userDetail->employee->address ? $userDetail->employee->address : '' }}">
                                                    @error('address')
                                                        <span class="invalid-current_password" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                            </div>
                                            <div class="mb-3 row">
                                                <label for="timezone" class="col-sm-3 col-form-label">Timezone</label>
                                                <div class="col-sm-8">
                                                    @if (isset($userDetail->timezone))
                                                        {{ $userDetail->timezone }}
                                                    @else
                                                        <span>-</span>
                                                    @endif
                                                    {{-- <input type="text" class="form-control" name="address" id="address" value="{{ $userDetail->employee->address }}">
                                                    @error('address')
                                                        <span class="invalid-current_password" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror --}}
                                                </div>

                                            </div>
                                            <div class="mb-3 row">
                                                <label for="address" class="col-sm-3 col-form-label">Date of
                                                    Birth</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="dob"
                                                        id="dob"
                                                        value="{{ $userDetail->employee->dob ? $userDetail->employee->dob : '' }}">
                                                    @error('dob')
                                                        <span class="invalid-current_password" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                            </div>
                                            <div class="mb-3 row">
                                                <label for="photo" class="col-sm-3 col-form-label">Profile
                                                    Photo</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control form-control-sm" id="photo"
                                                        name="photo" type="file" value="">
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                @if (!is_null($userDetail->employee->employee_documents))
                                                    <label for="photo"
                                                        class="col-sm-3 col-form-label">Documents</label>
                                                    <div class="col-sm-8">
                                                        @foreach ($userDetail->employee->employee_documents as $employee_document)
                                                            @if (is_null($employee_document->document))
                                                                @continue
                                                            @endif
                                                            <a target="_blank"
                                                                href="{{ route('employee.document', $employee_document->id) }}"><i
                                                                    class="fa-solid fa-download"></i>
                                                                {{ $employee_document->document->name }}</a>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <h5>No documents</h5>
                                                @endif
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
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="">
                    <div class="card-body ">
                        <div class="col-md-12 pl-md-3 pt-md-0 pt-sm-4 pt-4">
                            <div class="tab-content px-primary">
                                <div id="Personal Details-0" class="tab-pane fade active show">
                                    <div class="d-flex justify-content-between">
                                        <h5
                                            class="d-flex align-items-center text-capitalize mb-0 title tab-content-header">
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
