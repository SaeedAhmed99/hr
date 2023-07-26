@extends('layouts.app')
@section('page-title')
    {{ __('Designation') }}
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">All Designation</p>
                        <button data-bs-toggle="modal" data-bs-target="#add_designation_modal" class="btn btn-gray"><i
                                class="fa-solid fa-plus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="designation" class="table table-condensed">
                        <thead>
                            <tr>
                                <th>{{ __('Designation') }}</th>
                                <th>{{ __('Grade') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    {{--  add modal start  --}}
    <div class="modal fade" tabindex="-1" id="add_designation_modal">
        <div class="modal-dialog">
            <form action="" id="add_designation_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Designation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                {{--  <div>
                                    <label for="department">
                                        Department*
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Department select"
                                        name="department" id="department">
                                        <option value="" selected>Select Department</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}"> {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="branch_invalid" class="invalid-feedback"></div>
                                </div>  --}}
                                <div class="col-12">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Name" aria-describedby="name_invalid">
                                    <div id="name_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="col-12 mt-2">
                                    <label for="grade" class="form-label">Grade</label>
                                    <input type="text" class="form-control" id="grade" name="grade"
                                        placeholder="Grade" aria-describedby="name_invalid">
                                    <div id="grade_invalid" class="invalid-feedback"></div>
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
    <div class="modal fade" tabindex="-1" id="edit_designation_modal">
        <div class="modal-dialog">
            <form action="" id="update_designation_form">
                <input type="hidden" id="_method" name="_method" value="patch">
                <input type="hidden" name="designation_id" id="designation_id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Training Type</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                {{--  <div>
                                    <label for="department_update">
                                        Department*
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Branch select"
                                        name="department_update" id="department_update">
                                        <option value="" selected>Select Department</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}"> {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="department_update_invalid" class="invalid-feedback"></div>
                                </div>  --}}
                                <div class="col-12">
                                    <label for="name_update" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name_update" name="name_update"
                                        placeholder="Name" aria-describedby="name_invalid">
                                    <div id="name_update_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="col-12 mt-2">
                                    <label for="grade_update" class="form-label">Grade</label>
                                    <input type="text" class="form-control" id="grade_update" name="grade_update"
                                        placeholder="Name" aria-describedby="name_invalid">
                                    <div id="grade_update_invalid" class="invalid-feedback"></div>
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
        var designationTable;
        $(document).ready(function() {

            $('#department').select2({
                dropdownParent: $('#add_designation_modal'),
                width: 'style'
            });

            $('#department_update').select2({
                dropdownParent: $('#edit_designation_modal'),
                width: 'style'
            });

            designationTable = $('#designation').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('designation.data') }}",
                columns: [
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'grade',
                        name: 'grade'
                    },
                    {
                        data: 'action', className: "dt-right",
                        name: 'action'
                    }
                ],
                columnDefs: [{

                }],
            });



            $('#add_designation_form').on('submit', (e) => {
                e.preventDefault();
                let url = "{{ route('designation.store') }}";
                let formData = new FormData(e.target);
                $.ajax({
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    url: url,
                    success: function success(data) {
                        $('#add_designation_form').trigger("reset");
                        designationTable.ajax.reload();
                        modalHide('add_designation_modal');
                        show_toastr('Success', 'Designation successfully added.', 'success');
                    },
                    error: function error(data) {
                        handleFormValidation(data);
                    }
                });
            });


            $('#designation').on('draw.dt', function() {
                $('.designation-delete').on('click', (e) => {
                    let designation = e.currentTarget.dataset.id;
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
                                url: `{{ url('designation') }}/${designation}`,
                                success: function success(data) {
                                    designationTable.ajax.reload();
                                    show_toastr('Success', 'Designation successfully deleted.', 'success');
                                },
                                error: function error(data) {
                                    console.error(data);
                                    show_toastr('Error', 'Permission denied.', 'error');
                                }
                            });
                        }
                    })
                });


                $('.designation-edit').on('click', (e) => {
                    let designation = e.currentTarget.dataset.id;
                    //console.log('fdfs');
                    $.ajax({
                        type: "get",
                        url: `{{ url('designation') }}/${designation}/edit`,
                        success: function success(data) {
                            //console.log(data.id);
                            $('#designation_id').val(data.id);
                            $('#department_update').val(data.department_id);
                            $('#department_update').trigger('change');
                            $('#name_update').val(data.name);
                            $('#grade_update').val(data.grade);



                        },
                        error: function error(data) {
                            console.error(data);
                        }
                    });
                });


                $('#update_designation_form').on('submit', (e) => {
                    e.preventDefault();

                    let designation_id = $('#designation_id').val();
                    //console.log(e.target);
                    let formData = new FormData(e.target);
                    $.ajax({
                        type: "post",
                        data: formData,
                        processData: false,
                        contentType: false,
                        url: `{{ url('designation') }}/${designation_id}`,
                        success: function success(data) {
                            designationTable.ajax.reload();
                            modalHide('edit_designation_modal');
                            show_toastr('Success', 'Designation successfully updated.', 'success');

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
