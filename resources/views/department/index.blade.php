@extends('layouts.app')
@section('page-title')
    {{ __('Department') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">All Department</p>
                        <button data-bs-toggle="modal" data-bs-target="#add_department_modal" class="btn btn-gray"><i
                                class="fa-solid fa-plus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="department" class="table table-condensed">
                        <thead>
                            <tr>
                                <th>{{ __('Department') }}</th>
                                <th>{{ __('Branch') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    {{--  add modal start  --}}
    <div class="modal fade" tabindex="-1" id="add_department_modal">
        <div class="modal-dialog">
            <form action="" id="add_department_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Department</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <label for="branch">
                                        Branch*
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Branch select"
                                        name="branch" id="branch">
                                        <option value="" selected>Select Branch</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}"> {{ $branch->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="branch_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="col-12 mt-2">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Name" aria-describedby="name_invalid">
                                    <div id="name_invalid" class="invalid-feedback"></div>
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
    </div>
    {{--  edit modal start  --}}
    <div class="modal fade" tabindex="-1" id="edit_department_modal">
        <div class="modal-dialog">
            <form action="" id="update_department_form">
                <input type="hidden" id="_method" name="_method" value="patch">
                <input type="hidden" name="department_id" id="department_id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Training Type</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <label for="branch_update">
                                        Branch*
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Branch select"
                                        name="branch_update" id="branch_update">
                                        <option value="" selected>Select Branch</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}"> {{ $branch->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="branch_update_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="col-12 mt-2">
                                    <label for="name_update" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name_update" name="name_update"
                                        placeholder="Name" aria-describedby="name_invalid">
                                    <div id="name_update_invalid" class="invalid-feedback"></div>
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
    </div>
@endsection

@push('js')
    <script>
        $('#branch').select2({
            dropdownParent: $('#add_department_modal'),
            width: 'style'
        });
        $('#branch_update').select2({
            dropdownParent: $('#edit_department_modal'),
            width: 'style'
        });

        var departmentTable;
        $(document).ready(function() {

            departmentTable = $('#department').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('department.data') }}",
                columns: [
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'branch.name',
                        name: 'branch.name'
                    },
                    {
                        data: 'action', className: "dt-right",
                        name: 'action'
                    }
                ],
                columnDefs: [{

                }],
            });



            $('#add_department_form').on('submit', (e) => {
                e.preventDefault();
                let url = "{{ route('department.store') }}";
                let formData = new FormData(e.target);
                $.ajax({
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    url: url,
                    success: function success(data) {
                        $('#add_department_form').trigger("reset");
                        departmentTable.ajax.reload();
                        modalHide('add_department_modal');
                        show_toastr('Success', 'Department successfully added.', 'success');
                    },
                    error: function error(data) {
                        handleFormValidation(data);
                        show_toastr('Error', 'Permission denied.', 'error');
                    }
                });
            });


            $('#department').on('draw.dt', function() {
                $('.department-delete').on('click', (e) => {
                    let department = e.currentTarget.dataset.id;
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
                                url: `{{ url('department') }}/${department}`,
                                success: function success(data) {
                                    departmentTable.ajax.reload();
                                    show_toastr('Success', 'Department successfully deleted.', 'success');
                                },
                                error: function error(data) {
                                    console.error(data);
                                    show_toastr('Error', 'Permission denied.', 'error');
                                }
                            });
                        }
                    })
                });


                $('.department-edit').on('click', (e) => {
                    let department = e.currentTarget.dataset.id;
                    //console.log('fdfs');
                    $.ajax({
                        type: "get",
                        url: `{{ url('department') }}/${department}/edit`,
                        success: function success(data) {
                            //console.log(data.id);
                            $('#department_id').val(data.id);
                            $('#branch_update').val(data.branch_id);
                            $('#branch_update').trigger('change');
                            $('#name_update').val(data.name);


                        },
                        error: function error(data) {
                            console.error(data);
                        }
                    });
                });


                $('#update_department_form').on('submit', (e) => {
                    e.preventDefault();

                    let department_id = $('#department_id').val();
                    //console.log(e.target);
                    let formData = new FormData(e.target);
                    $.ajax({
                        type: "post",
                        data: formData,
                        processData: false,
                        contentType: false,
                        url: `{{ url('department') }}/${department_id}`,
                        success: function success(data) {
                            departmentTable.ajax.reload();
                            modalHide('edit_department_modal');
                            show_toastr('Success', 'Department successfully updated.', 'success');
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
