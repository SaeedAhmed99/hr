@extends('layouts.app')
@section('page-title')
    {{ __('Import Employee') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">Import Employee</p>

                    </div>
                </div>
                <div class="card-body">
                    <div class="container mt-5 text-center">
                        <h2 class="mb-4">
                             Import Excel File for Employee
                        </h2>
                        <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-4">
                                <div class="custom-file text-left">
                                    <input type="file" name="file" class="custom-file-input" id="customFile">
                                    {{--  <label class="custom-file-label" for="customFile">Choose file</label>  --}}
                                </div>
                            </div>
                            <button class="btn btn-primary">Import Employees</button>
                            <a class="btn btn-success" href="{{ asset('file/sample.xlsx') }}">Sample File Download</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
