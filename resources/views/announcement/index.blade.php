@extends('layouts.app')
@section('page-title')
    {{ __('Annoucement') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">All Announcement</p>
                        <button data-bs-toggle="modal" data-bs-target="#add_announcement_modal" class="btn btn-gray"><i class="fa-solid fa-plus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="announcement" class="table table-condensed">
                        <thead>
                            <tr>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Start Date') }}</th>
                                <th>{{ __('End Date') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{--  add modal start  --}}
    <div class="modal fade" tabindex="-1" id="add_announcement_modal">
        <div class="modal-dialog">
            <form action="" id="add_announcement_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Announcement</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <label for="branch">
                                        Branch
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Branch select" name="branch[]" id="branch" multiple="multiple">
                                        {{--  <option value="0"> All Branch</option>  --}}
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}"> {{ $branch->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="branch_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="mt-2">
                                    <label for="department">
                                        Department
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Branch select" name="department[]" id="department" multiple="multiple">
                                    </select>
                                    <div id="department_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="mt-2">
                                    <label for="employee">
                                        Employee
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Branch select" name="employee[]" id="employee" multiple="multiple">
                                        {{--  <option value="0"> All Employee</option>  --}}
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}"> {{ $employee->user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="employee_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="mt-2">
                                    <label for="title" class="form-label">Announcement Title</label>
                                    <input type="text" name="title" class="form-control" id="title">
                                    <div id="title_invalid" class="invalid-feedback"></div>
                                </div>
                                <div>
                                    <label for="start_date" class="form-label">Announcement Start Date</label>
                                    <input type="text" name="start_date" class="form-control" id="start_date" required>
                                    <div id="start_date_invalid" class="invalid-feedback"></div>
                                </div>
                                <div>
                                    <label for="end_date" class="form-label">Announcement End Date</label>
                                    <input type="text" name="end_date" class="form-control" id="end_date" required>
                                    <div id="end_date_invalid" class="invalid-feedback"></div>
                                </div>
                            </div>

                            <div>
                                <label for="description" class="form-label">Description</label>
                                <textarea type="text" class="form-control" id="description" name="description" placeholder="Enter Description" aria-describedby="description_invalid" row="4"></textarea>
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
    <div class="modal fade" tabindex="-1" id="edit_announcement_modal">
        <div class="modal-dialog">
            <form action="" id="update_announcement_form">
                <input type="hidden" id="_method" name="_method" value="patch">
                <input type="hidden" name="announcement_id" id="announcement_id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit announcement</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <label for="title_update" class="form-label">Announcement Title</label>
                                    <input type="text" name="title_update" class="form-control" id="title_update">
                                    <div id="title_update_invalid" class="invalid-feedback"></div>
                                </div>
                                <div>
                                    <label for="start_date_update" class="form-label">Announcement Start Date</label>
                                    <input type="text" name="start_date_update" class="form-control" id="start_date_update" required>
                                    <div id="start_date_update_invalid" class="invalid-feedback"></div>
                                </div>
                                <div>
                                    <label for="end_date_update" class="form-label">Announcement End Date</label>
                                    <input type="text" class="form-control" id="end_date_update" name="end_date_update" placeholder="Enter time" aria-describedby="time_invalid">
                                    <div id="end_date_update_invalid" class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div>
                                <label for="description_update" class="form-label">Description</label>
                                <textarea type="text" class="form-control" id="description_update" name="description_update" placeholder="Enter Description" aria-describedby="description_invalid" row="3"></textarea>
                                <div id="description_update_invalid" class="invalid-feedback"></div>
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
        var announcementTable;
        $(document).ready(function() {            

            $('#branch').on('change', (e) => {
                console.log($('#branch').val());
                
                $.ajax({
                    type: "get",
                    data: {
                        'branches': $('#branch').val()
                    },
                    url: '{{ route("department.branches") }}',
                    success: function success(data) {
                        console.log(data);
                        $("#department").html(data);

                    },
                    error: function error(data) {
                        handleFormValidation(data);
                        show_toastr('Error', 'Permission denied.', 'error');
                    }
                });
            });

            $('#branch').select2({
                dropdownParent: $('#add_announcement_modal'),
                width: 'style',

            });
            $('#department').select2({
                dropdownParent: $('#add_announcement_modal'),
                width: 'style',

            });
            $('#employee').select2({
                dropdownParent: $('#add_announcement_modal'),
                width: 'style',

            });

            $("#start_date").datepicker({
                dateFormat: 'yy-mm-dd'
            });
            $("#end_date").datepicker({
                dateFormat: 'yy-mm-dd'
            });
            $("#start_date_update").datepicker({
                dateFormat: 'yy-mm-dd'
            });
            $("#end_date_update").datepicker({
                dateFormat: 'yy-mm-dd'
            });


            announcementTable = $('#announcement').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('announcement.data') }}",
                columns: [{
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'start_date',
                        name: 'start_date'
                    },
                    {
                        data: 'end_date',
                        name: 'end_date'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'action',
                        className: "dt-right",
                        name: 'action'
                    }
                ],
                columnDefs: [{

                }],
            });




            $('#add_announcement_form').on('submit', (e) => {
                e.preventDefault();
                let url = "{{ route('announcement.store') }}";
                let formData = new FormData(e.target);
                $.ajax({
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    url: url,
                    success: function success(data) {
                        $('#add_announcement_form').trigger("reset");
                        announcementTable.ajax.reload();
                        modalHide('add_announcement_modal');
                        show_toastr('Success', data, 'success');
                    },
                    error: function error(data) {
                        handleFormValidation(data);
                        show_toastr('Error', 'Permission denied.', 'error');
                    }
                });
            });


            $('#announcement').on('draw.dt', function() {
                $('.announcement-delete').on('click', (e) => {
                    let announcement = e.currentTarget.dataset.id;
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
                                url: `{{ url('announcement') }}/${announcement}`,
                                success: function success(data) {
                                    announcementTable.ajax.reload();
                                    show_toastr('Success', data, 'success');
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


                $('.announcement-edit').on('click', (e) => {
                    let announcement = e.currentTarget.dataset.id;
                    //console.log('fdfs');
                    $.ajax({
                        type: "get",
                        url: `{{ url('announcement') }}/${announcement}/edit`,
                        success: function success(data) {
                            //console.log(data.id);
                            $('#announcement_id').val(data.id);
                            $('#title_update').val(data.title);
                            $('#start_date_update').val(data.start_date);
                            $('#end_date_update').val(data.end_date);
                            $('#description_update').val(data.description);
                        },
                        error: function error(data) {
                            console.error(data);
                        }
                    });
                });

                $('#update_announcement_form').on('submit', (e) => {
                    e.preventDefault();

                    let announcement_id = $('#announcement_id').val();
                    //console.log(e.target);
                    let formData = new FormData(e.target);
                    $.ajax({
                        type: "post",
                        data: formData,
                        processData: false,
                        contentType: false,
                        url: `{{ url('announcement') }}/${announcement_id}`,
                        success: function success(data) {
                            announcementTable.ajax.reload();
                            modalHide('edit_announcement_modal');
                            show_toastr('Success', data,
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
