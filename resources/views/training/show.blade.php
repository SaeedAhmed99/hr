@extends('layouts.app')

@push('head')
    <style>
        .list-item-border{
            border:0px;
        }
    </style>
@endpush

@section('page-title')
    {{ __('Show Training') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive ">
                        <table class="table ">
                            <tbody>
                                <tr>
                                    <td>{{ __('Training Type') }}</td>
                                    <td class="text-right">
                                        {{ !empty($training->traningtype) ? $training->traningtype->name : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('Trainer') }}</td>
                                    <td class="text-right">
                                        {{ !empty($training->trainer) ? $training->trainer->firstname : '--' }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('Training Cost') }}</td>
                                    <td class="text-right">{{ $training->training_cost }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('Start Date') }}</td>
                                    <td class="text-right">{{ $training->start_date }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('End Date') }}</td>
                                    <td class="text-right">{{ $training->end_date }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('Date') }}</td>
                                    <td class="text-right">{{ $training->created_at }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="text-sm mt-4 p-2"> {{ $training->description }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h6>{{ __('Training Employee') }}</h6>
                            <hr>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item list-item-border">
                                    <div class="d-flex align-items-center">
                                        <a href="{{ !empty($training->employee) ? (!empty($training->employee->user->avatar) ? asset(Storage::url('avatar')) . '/' . $training->employee->user->avatar : asset(Storage::url('avatar')) . '/avatar.png') : asset(Storage::url('avatar')) . '/avatar.png' }}"
                                            target="_blank">
                                            <img src="{{ !empty($training->employee) ? (!empty($training->employee->user->avatar) ? asset(Storage::url('uploads/avatar')) . '/' . $training->employee->user->avatar : asset(Storage::url('avatar')) . '/avatar.png') : asset(Storage::url('avatar')) . '/avatar.png' }}"
                                                class="user-image-hr-prj ui-w-30 rounded-circle" width="50px"
                                                height="50px">
                                        </a>
                                        <div class="media-body px-2 text-sm">
                                            {{--  <a href="{{ route('employee.show', !empty($training->employees) ? \Illuminate\Support\Facades\Crypt::encrypt($training->employees->id) : 0) }}"
                                                class="text-dark">  --}}
                                            {{ !empty($training->employee) ? $training->employee->user->name : '' }}
                                            <br>
                                            {{ !empty($training->employee) ? (!empty($training->employee->designation->name) ? $training->employee->designation->name : '') : '' }}
                                            {{--  </a>  --}}
                                            <br>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <form method="post" action="{{ route('training.status', $training->id) }}">
                            @csrf
                            {{--  <h6>{{ __('Update Status') }}</h6>  --}}
                            <hr>
                            <div class="row col-md-12">
                                <div class="col-md-6">
                                    <input type="hidden" value="{{ $training->id }}" name="id">
                                    <div class="form-group">
                                        <label for="validationCustom04" class="form-label text-dark">Performance</label>
                                        <select class="form-select" name="performance" aria-label="Default select example"
                                            >
                                            <option value="">Select</option>
                                            @foreach ($performances as $performance)
                                                <option value="{{ $performance }}"
                                                    {{ $performance === $training->performance ? 'selected' : '' }}>
                                                    {{ $performance }}
                                                </option>
                                            @endforeach

                                        </select>
                                        @if ($errors->has('performance'))
                                            <span class="text-danger">{{ $errors->first('performance') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="form-label text-dark">Status</label>
                                        <select class="form-select" name="status" aria-label="Default select example"
                                            required>
                                            <option value="">Select</option>
                                            @foreach ($allstatus as $status)
                                                <option value="{{ $status }}"
                                                    {{ $status === $training->status ? 'selected' : '' }}>
                                                    {{ $status }}
                                                </option>
                                            @endforeach

                                        </select>
                                        @if ($errors->has('status'))
                                            <span class="text-danger">{{ $errors->first('status') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row col-md-12">

                                <div class="form-group">
                                    <label for="validationCustom01" class="form-label text-dark mt-4">Remark</label>
                                    <textarea name="remarks" class="form-control" id="remarks" rows="3" value="{{ old('remarks') }}"></textarea>
                                    @if ($errors->has('remarks'))
                                        <span class="text-danger">{{ $errors->first('remarks') }}</span>
                                    @endif
                                </div>
                                <div class="form-group text-end">
                                    <button type="submit" value="{{ __('Save') }}"
                                        class="btn  btn-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
