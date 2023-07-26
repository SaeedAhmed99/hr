@extends('layouts.app')
@section('page-title')
    {{ __('Users') }}
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">All User</p>
                        <a href="{{ route('user.create') }}" class="btn btn-gray"><i class="fa-solid fa-plus"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="user" class="table table-condensed">
                        <thead>
                            <tr>
                                <th>{{ __('User Name') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Role') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    {{--  add modal start  --}}
    <div class="modal fade" tabindex="-1" id="add_user_modal">
        <div class="modal-dialog">
            <form action="" id="add_user_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Trip</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">



                                <div class="mt-2">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="text" name="start_date" class="form-control" id="start_date" required>
                                    <div id="start_date_invalid" class="invalid-feedback"></div>
                                </div>


                                <div class="mt-2">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="text" name="end_date" class="form-control" id="end_date" required>
                                    <div id="end_date_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="mt-2">
                                    <label for="purpose_of_visit" class="form-label">Purpose of Visit</label>
                                    <input type="text" class="form-control" id="purpose_of_visit" name="purpose_of_visit"
                                        placeholder="Enter Purpose" aria-describedby="description_invalid"></input>
                                    <div id="purpose_of_visit_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="mt-2">
                                    <label for="place_of_visit" class="form-label">Place of Visit</label>
                                    <input type="text" class="form-control" id="place_of_visit" name="place_of_visit"
                                        placeholder="Enter Visit" aria-describedby="description_invalid"></input>
                                    <div id="place_of_visit_invalid" class="invalid-feedback"></div>
                                </div>

                            </div>


                            <div>
                                <label for="description" class="form-label">Description</label>
                                <textarea type="text" class="form-control" id="description" name="description" placeholder="Enter Description"
                                    aria-describedby="description_invalid" row="3"></textarea>
                                <div id="description_invalid" class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{--  edit modal start  --}}
    {{--  <div class="modal fade" tabindex="-1" id="edit_user_modal">
        <div class="modal-dialog">
            <form action="" id="update_user_form">
                <input type="hidden" id="_method" name="_method" value="patch">
                <input type="hidden" name="user_id" id="user_id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit user</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="">
                                    <label for="name_update" class="form-label">Name</label>
                                    <input type="text" name="name_update" class="form-control" id="name_update"
                                        required>
                                    <div id="name_update_invalid" class="invalid-feedback"></div>
                                </div>


                                <div class="mt-2">
                                    <label for="email_update" class="form-label">Email</label>
                                    <input type="email" name="email_update" class="form-control" id="email_update"
                                        required>
                                    <div id="email_update_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="mt-2">
                                    <label for="password_update" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="password_update"
                                        name="password_update" placeholder="Enter password"></input>
                                    <div id="password_update_invalid" class="invalid-feedback"></div>
                                </div>


                                <div class="mt-2">
                                    <label for="role_update">
                                        Role
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Branch select"
                                        name="role_update" id="role_update">
                                        <option value=""> Select Employee</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"> {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="role_update_invalid" class="invalid-feedback"></div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>  --}}
@endsection

@push('js')
    <script>
        var userTable;
        $(document).ready(function() {



            $('#employee').select2({
                dropdownParent: $('#add_user_modal'),
                width: 'style',

            });
            $('#role_update').select2({
                dropdownParent: $('#edit_user_modal'),
                width: 'style',

            });




            userTable = $('#user').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('user.data') }}",
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'role',
                        name: 'role'
                    },
                    {
                        data: 'action', className: "dt-right",
                        name: 'action'
                    }
                ],
                columnDefs: [{

                }],
            });




            $('#add_user_form').on('submit', (e) => {
                e.preventDefault();
                let url = "{{ route('user.store') }}";
                let formData = new FormData(e.target);
                $.ajax({
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    url: url,
                    success: function success(data) {
                        $('#add_user_form').trigger("reset");
                        userTable.ajax.reload();
                        modalHide('add_user_modal');
                        show_toastr('Success', 'user successfully added.', 'success');
                    },
                    error: function error(data) {
                        handleFormValidation(data);
                        show_toastr('Error', 'Permission denied.', 'error');
                    }
                });
            });


            $('#user').on('draw.dt', function() {
                $('.user-delete').on('click', (e) => {
                    let user = e.currentTarget.dataset.id;
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You want to delete this item!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "post",
                                data: {
                                    _method: 'delete'
                                },
                                url: `{{ url('user') }}/${user}`,
                                success: function success(data) {
                                    userTable.ajax.reload();
                                    show_toastr('Success',
                                        'user successfully deleted.',
                                        'success');
                                },
                                error: function error(data) {
                                    console.error(data);
                                    show_toastr('Error', 'Permission denied.',
                                        'error');
                                }
                            });
                        }
                    })
                });


                $('.user-edit').on('click', (e) => {
                    let user = e.currentTarget.dataset.id;
                    //console.log('fdfs');
                    $.ajax({
                        type: "get",
                        url: `{{ url('user') }}/${user}/edit`,
                        success: function success(data) {
                            //console.log(data.id);
                            $('#user_id').val(data.id);
                            $('#name_update').val(data.user.name);
                            $('#email_update').val(data.user.email);
                            $('#role_update').val(data.role_name);
                        },
                        error: function error(data) {
                            console.error(data);
                        }
                    });
                });


                $('#update_user_form').on('submit', (e) => {
                    e.preventDefault();

                    let user_id = $('#user_id').val();
                    //console.log(e.target);
                    let formData = new FormData(e.target);
                    $.ajax({
                        type: "post",
                        data: formData,
                        processData: false,
                        contentType: false,
                        url: `{{ url('user') }}/${user_id}`,
                        success: function success(data) {
                            userTable.ajax.reload();
                            modalHide('edit_user_modal');
                            show_toastr('Success', 'user successfully updated.',
                                'success');
                        },
                        error: function error(data) {
                            handleFormValidation(data);
                            show_toastr('Error', 'Permission denied.', 'error');
                        }
                    });
                });



            });
        });
    </script>
@endpush
