@extends('layouts.app')
@section('page-title')
    {{ __('Shift Setup') }}
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">Shifts</p>
                        @can('Create Shift')
                            <button data-bs-toggle="modal" data-bs-target="#add_shift_modal" class="btn btn-gray"><i
                                    class="fa-solid fa-plus"></i></button>
                        @endcan

                    </div>
                </div>
                <div class="card-body">
                    <table id="shift" class="table table-condensed">
                        <thead>
                            <tr>
                                <th>{{ __('Shift Name') }}</th>
                                <th>{{ __('Start Time') }}</th>
                                <th>{{ __('End Time') }}</th>
                                <th>{{ __('Buffer Time(Minutes)') }}</th>
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
    <div class="modal fade" tabindex="-1" id="add_shift_modal">
        <div class="modal-dialog">
            <form action="" id="add_shift_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Shift</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="">
                                    <label for="name">
                                        Name
                                    </label>
                                    <div class="">
                                        <input type="text" name="name" class="form-control">
                                    </div>
                                    <div id="employee_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="mt-2">
                                    <label for="start_time">
                                        Start Time
                                    </label>
                                    <div class="">
                                        <input type="time" name="start_time" class="form-control">
                                    </div>
                                    <div id="awartype_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="mt-2">
                                    <label for="end_time">
                                        End Time
                                    </label>
                                    <div class="">
                                        <input type="time" name="end_time" class="form-control">
                                    </div>
                                    <div id="awartype_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="mt-2">
                                    <label for="buffer_time">
                                        Buffer Time(Minutes)
                                    </label>
                                    <div class="">
                                        <input type="number" name="buffer_time" class="form-control" value="15">
                                    </div>
                                    <div id="awartype_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="mt-2">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea type="text" class="form-control" id="description" name="description" cols="4" rows="4"
                                        placeholder="description" aria-describedby="name_invalid"></textarea>
                                    <div id="description_invalid" class="invalid-feedback"></div>
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
    <div class="modal fade" tabindex="-1" id="edit_shift_modal">
        <div class="modal-dialog">
            <form action="" id="update_shift_form">
                <input type="hidden" id="_method" name="_method" value="patch">
                <input type="hidden" name="shift_id" id="shift_id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Shift</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="">
                                    <label for="name">
                                        Name
                                    </label>
                                    <div class="">
                                        <input type="text" name="name" class="form-control" id="edit_name">
                                    </div>
                                    <div id="employee_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="mt-2">
                                    <label for="start_time">
                                        Start Time
                                    </label>
                                    <div class="">
                                        <input type="time" name="start_time" class="form-control"
                                            id="edit_start_time">
                                    </div>
                                    <div id="awartype_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="mt-2">
                                    <label for="end_time">
                                        End Time
                                    </label>
                                    <div class="">
                                        <input type="time" name="end_time" class="form-control" id="edit_end_time">
                                    </div>
                                    <div id="awartype_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="mt-2">
                                    <label for="buffer_time">
                                        Buffer Time(Minutes)
                                    </label>
                                    <div class="">
                                        <input type="number" name="buffer_time" class="form-control"
                                            id="edit_buffer_time">
                                    </div>
                                    <div id="awartype_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="mt-2">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea type="text" class="form-control" id="edit_description" name="description" cols="4"
                                        rows="4" placeholder="description" aria-describedby="name_invalid"></textarea>
                                    <div id="description_invalid" class="invalid-feedback"></div>
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
        $("#date").datepicker({
            dateFormat: 'yy-mm-dd',
        });
        $("#date_update").datepicker({
            dateFormat: 'yy-mm-dd',
        });
        var shiftTable;
        $(document).ready(function() {

            shiftTable = $('#shift').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('shift.data') }}",
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'start_time',
                        name: 'start_time'
                    },
                    {
                        data: 'end_time',
                        name: 'end_time'
                    },
                    {
                        data: 'buffer_time',
                        name: 'buffer_time'
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



            $('#add_shift_form').on('submit', (e) => {
                e.preventDefault();
                let url = "{{ route('shift.store') }}";
                let formData = new FormData(e.target);
                $.ajax({
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    url: url,
                    success: function success(data) {
                        $('#add_shift_form').trigger("reset");
                        shiftTable.ajax.reload();
                        modalHide('add_shift_modal');
                        show_toastr('Success', data, 'success');
                    },
                    error: function error(data) {
                        handleFormValidation(data);
                        show_toastr('Error', 'Please fill up the form with correct value.',
                            'error');
                    }
                });
            });


            $('#shift').on('draw.dt', function() {
                $('.shift-delete').on('click', (e) => {
                    let shift = e.currentTarget.dataset.id;
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
                                url: `{{ url('shift') }}/${shift}`,
                                success: function success(data) {
                                    shiftTable.ajax.reload();
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


                $('.shift-edit').on('click', (e) => {
                    let shift = e.currentTarget.dataset.id;

                    $.ajax({
                        type: "get",
                        url: `{{ url('shift') }}/${shift}/edit`,
                        success: function success(data) {
                            $('#shift_id').val(data.id);
                            $('#edit_name').val(data.name);
                            $('#edit_start_time').val(data.start_time);
                            $('#edit_end_time').val(data.end_time);
                            $('#edit_buffer_time').val(data.buffer_time);
                            $('#edit_description').val(data.description);
                        },
                        error: function error(data) {
                            console.error(data);
                        }
                    });
                });


                $('#update_shift_form').on('submit', (e) => {
                    e.preventDefault();

                    let shift_id = $('#shift_id').val();
                    //console.log(e.target);
                    let formData = new FormData(e.target);
                    $.ajax({
                        type: "post",
                        data: formData,
                        processData: false,
                        contentType: false,
                        url: `{{ url('shift') }}/${shift_id}`,
                        success: function success(data) {
                            shiftTable.ajax.reload();
                            modalHide('edit_shift_modal');
                            show_toastr('Success', data,
                                'success');

                        },
                        error: function error(data) {
                            handleFormValidation(data);
                            show_toastr('Error',
                                'Please fill up the form with correct value.',
                                'error');
                        }
                    });
                });



            });
        });
    </script>
@endpush
