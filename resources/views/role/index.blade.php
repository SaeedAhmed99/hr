@extends('layouts.app')

@section('page-title')
    {{ __('Roles') }}
@endsection
{{--  <a type="button" class="btn btn-primary" href="{{ route('roles.create') }}">Create Role</a>  --}}

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">All Role</p>
                        <a href="{{ route('roles.create') }}" class="btn btn-gray"><i
                                class="fa-solid fa-plus"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="role" class="table table-condensed">
                        <thead>
                            <tr>
                                <th>{{ __('Role') }}</th>
                                <th>{{ __('Permission') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{--  <table class="table">
        <thead>
            <tr>
                <th scope="col">Role</th>
                <th scope="col">Permisson</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $role)
                <tr>
                    <td>{{ $role->name }}</td>
                    <td>
                        @foreach ($role->permissions()->pluck('name') as $permission)
                            <span class="badge rounded p-2 m-1 px-3 bg-primary ">
                                <a href="#" class="text-white">{{ $permission }}</a>
                            </span>
                        @endforeach
                    </td>
                    <td class="Action">
                        <div class="d-flex">
                            <div>
                                @can('Edit Role')
                                    <a type="button" href="{{ route('roles.edit', $role->id) }}" class="btn btn-info">Edit</a>
                                @endcan
                            </div>
                            <div>
                                @can('Delete Role')
                                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                @endcan
                            </div>


                        </div>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>  --}}




    {{--  <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Role</h5>
        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">...</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>  --}}
@endsection


@push('js')
    <script>
        var roleTable;
        $(document).ready(function() {








            roleTable = $('#role').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('role.data') }}",
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'permission',
                        name: 'permission'
                    },
                    {
                        data: 'action', className: "dt-right",
                        name: 'action'
                    }
                ],
                columnDefs: [{

                }],
            });




            $('#add_role_form').on('submit', (e) => {
                e.preventDefault();
                let url = "{{ route('roles.store') }}";
                let formData = new FormData(e.target);
                $.ajax({
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    url: url,
                    success: function success(data) {
                        $('#add_role_form').trigger("reset");
                        roleTable.ajax.reload();
                        modalHide('add_role_modal');
                        show_toastr('Success', 'role successfully added.', 'success');
                    },
                    error: function error(data) {
                        handleFormValidation(data);
                        show_toastr('Error', 'Permission denied.', 'error');
                    }
                });
            });


            $('#role').on('draw.dt', function() {
                $('.role-delete').on('click', (e) => {
                    let role = e.currentTarget.dataset.id;
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
                                url: `{{ url('roles') }}/${role}`,
                                success: function success(data) {
                                    roleTable.ajax.reload();
                                    show_toastr('Success',
                                        'Role successfully deleted.',
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


                $('.role-edit').on('click', (e) => {
                    let role = e.currentTarget.dataset.id;
                    //console.log('fdfs');
                    $.ajax({
                        type: "get",
                        url: `{{ url('roles') }}/${role}/edit`,
                        success: function success(data) {
                            //console.log(data.id);
                            $('#role_id').val(data.id);
                            $('#employee_update').val(data.employee_id);
                            $('#employee_update').trigger('change');
                            $('#start_date_update').val(data.start_date);
                            $('#end_date_update').val(data.end_date);
                            $('#purpose_of_visit_update').val(data.purpose_of_visit);
                            $('#place_of_visit_update').val(data.place_of_visit);
                            $('#description_update').val(data.description);
                        },
                        error: function error(data) {
                            console.error(data);
                        }
                    });
                });


                $('#update_role_form').on('submit', (e) => {
                    e.preventDefault();

                    let role_id = $('#role_id').val();
                    //console.log(e.target);
                    let formData = new FormData(e.target);
                    $.ajax({
                        type: "post",
                        data: formData,
                        processData: false,
                        contentType: false,
                        url: `{{ url('roles') }}/${role_id}`,
                        success: function success(data) {
                            roleTable.ajax.reload();
                            modalHide('edit_role_modal');
                            show_toastr('Success', 'role successfully updated.',
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
