@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">User Update</p>

                    </div>
                </div>
                <div class="card-body">
                    <div class=" p-2">
                        <form class="row g-3 needs-validation" novalidate method="POST"
                            action="{{ route('user.update', $user->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="col-md-12">
                                <label for="validationCustom01" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" id="validationCustom01"
                                    value="{{ $user->name }}" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="validationCustom02" class="form-label">Email</label>
                                <input type="eamil" name="email" class="form-control" id="validationCustom02"
                                    value="{{ $user->email }}" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="validationCustom03" class="form-label">New Password</label>
                                <input type="password" name="password" class="form-control" id="validationCustom03">
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>

                            <div class="col-md-3">
                                <label for="validationCustom04" class="form-label">Role</label>
                                <select class="form-select" name="role" aria-label="Default select example">
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ $role->name === $user->getRoleNames()[0] ? 'selected' : '' }}>
                                            {{ $role->name }}</option>
                                    @endforeach



                                </select>
                            </div>


                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
@endsection
