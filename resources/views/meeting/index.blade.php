@extends('layouts.app')
@section('page-title')
    {{ __('Meeting') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">All Meeting</p>
                        @can('Create Meeting')
                            <button data-bs-toggle="modal" data-bs-target="#add_meeting_modal" class="btn btn-gray"><i class="fa-solid fa-plus"></i></button>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <table id="meeting" class="table table-condensed">
                        <thead>
                            <tr>
                                <th>{{ __('Meeting Title') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th>{{ __('Meeting Date') }}</th>
                                <th>{{ __('Meeting Time') }}</th>
                                <th>{{ __('Employees') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{--  add modal start  --}}
    <div class="modal fade" tabindex="-1" id="add_meeting_modal">
        <div class="modal-dialog">
            <form action="" id="add_meeting_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Meeting</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="">
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
                                <div>
                                    <label for="title" class="form-label">Meeting Title</label>
                                    <input type="text" name="title" class="form-control" id="title">
                                    <div id="title_invalid" class="invalid-feedback"></div>
                                </div>
                                <div>
                                    <label for="description" class="form-label">Description</label>
                                    <textarea type="text" class="form-control" id="description" name="description" placeholder="Enter Description" aria-describedby="description_invalid" row="3"></textarea>
                                    <div id="description_invalid" class="invalid-feedback"></div>
                                </div>
                                <div>
                                    <label for="date" class="form-label">Meeting Date</label>
                                    <input type="text" name="date" class="form-control" id="date" required>
                                    <div id="date_invalid" class="invalid-feedback"></div>
                                </div>
                                <div>
                                    <label for="time" class="form-label">Metting Time</label>
                                    <input type="time" class="form-control" id="time" name="time" placeholder="Enter time" aria-describedby="time_invalid">
                                    <div id="time_invalid" class="invalid-feedback"></div>
                                </div>
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
                                        {{--  <option value="0"> All Department</option>  --}}
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}"> {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="department_invalid" class="invalid-feedback"></div>
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
    <div class="modal fade" tabindex="-1" id="edit_meeting_modal">
        <div class="modal-dialog">
            <form action="" id="update_meeting_form">
                <input type="hidden" id="_method" name="_method" value="patch">
                <input type="hidden" name="meeting_id" id="meeting_id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Meeting</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <label for="title_update" class="form-label">Meeting Title</label>
                                    <input type="text" name="title_update" class="form-control" id="title_update">
                                    <div id="title_update_invalid" class="invalid-feedback"></div>
                                </div>
                                <div>
                                    <label for="date_update" class="form-label">Meeting Date</label>
                                    <input type="text" name="date_update" class="form-control" id="date_update" required>
                                    <div id="date_update_invalid" class="invalid-feedback"></div>
                                </div>
                                <div>
                                    <label for="time_update" class="form-label">Metting Time</label>
                                    <input type="time" class="form-control" id="time_update" name="time_update" placeholder="Enter time" aria-describedby="time_invalid">
                                    <div id="time_update_invalid" class="invalid-feedback"></div>
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

    <div class="modal fade" tabindex="-1" id="show_meeting_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Meeting details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="show_meeting_body"></div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        var meetingTable;
        $(document).ready(function() {


            $('#branch').select2({
                dropdownParent: $('#add_meeting_modal'),
                width: 'style',

            });
            $('#department').select2({
                dropdownParent: $('#add_meeting_modal'),
                width: 'style',

            });
            $('#employee').select2({
                dropdownParent: $('#add_meeting_modal'),
                width: 'style',

            });

            $("#date").datepicker({
                dateFormat: 'yy-mm-dd'
            });
            $("#date_update").datepicker({
                dateFormat: 'yy-mm-dd'
            });


            meetingTable = $('#meeting').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('meeting.data') }}",
                columns: [{
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'time',
                        name: 'time'
                    },
                    {
                        data: 'employee_list',
                        name: 'employee_list'
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




            $('#add_meeting_form').on('submit', (e) => {
                e.preventDefault();
                let url = "{{ route('meeting.store') }}";
                let formData = new FormData(e.target);
                $.ajax({
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    url: url,
                    success: function success(data) {
                        $('#add_meeting_form').trigger("reset");
                        meetingTable.ajax.reload();
                        modalHide('add_meeting_modal');
                        show_toastr('Success', 'Meeting successfully added.', 'success');
                    },
                    error: function error(data) {
                        handleFormValidation(data);
                        show_toastr('Error', 'Permission denied.', 'error');
                    }
                });
            });

            let meetingDelete = (e) => {
                let meeting = e.currentTarget.dataset.id;
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
                            url: `{{ url('meeting') }}/${meeting}`,
                            success: function success(data) {
                                meetingTable.ajax.reload();
                                show_toastr('Success',
                                    'Meeting successfully deleted.',
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
            }

            let meetingEdit = (e) => {
                let meeting = e.currentTarget.dataset.id;
                //console.log('fdfs');
                $.ajax({
                    type: "get",
                    url: `{{ url('meeting') }}/${meeting}/edit`,
                    success: function success(data) {
                        //console.log(data.id);
                        $('#meeting_id').val(data.id);
                        $('#title_update').val(data.title);
                        $('#date_update').val(data.date);
                        $('#time_update').val(data.time);
                        $('#description_update').val(data.description);
                    },
                    error: function error(data) {
                        console.error(data);
                    }
                });
            }

            let meetingFormSubmit = (e) => {
                e.preventDefault();

                let meeting_id = $('#meeting_id').val();
                //console.log(e.target);
                let formData = new FormData(e.target);
                $.ajax({
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    url: `{{ url('meeting') }}/${meeting_id}`,
                    success: function success(data) {
                        meetingTable.ajax.reload();
                        modalHide('edit_meeting_modal');
                        show_toastr('Success', 'Meeting successfully updated.',
                            'success');

                    },
                    error: function error(data) {
                        handleFormValidation(data);
                        show_toastr('Error', 'Permission denied.', 'error');
                    }
                });
            }

            let getMeetingDetails = (e) => {
                let meeting = e.currentTarget.dataset.id;
                $.ajax({
                    type: "get",
                    url: `{{ url('meeting') }}/${meeting}`,
                    success: function success(data) {
                        $('#show_meeting_body').html(data);
                        $('#show_meeting_modal').modal('show');

                    },
                    error: function error(data) {
                        show_toastr('Error', data, 'error');
                    }
                });
            }

            $('#meeting').on('draw.dt', function() {
                $('.meeting-delete').on('click', meetingDelete);

                $('.meeting-edit').on('click', meetingEdit);

                $('.show-meeting-modal').on('click', getMeetingDetails);

                $('#update_meeting_form').on('submit', meetingFormSubmit);
            });

            meetingTable.on('responsive-display', function(e, datatable, row, showHide, update) {
                $('.meeting-delete').on('click', meetingDelete);
                $('.meeting-edit').on('click', meetingEdit);
                $('#update_meeting_form').on('submit', meetingFormSubmit);
                $('.show-meeting-modal').on('click', getMeetingDetails);
            });
        });
    </script>
@endpush
