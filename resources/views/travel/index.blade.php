@extends('layouts.app')
@section('page-title')
    {{ __('Travel') }}
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">All Travel</p>
                        @can('Create Travel')
                            <button data-bs-toggle="modal" data-bs-target="#add_travel_modal" class="btn btn-gray"><i
                                    class="fa-solid fa-plus"></i></button>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <table id="travel" class="table table-condensed">
                        <thead>
                            <tr>
                                <th>{{ __('Employee Name') }}</th>
                                <th>{{ __('Strat Date') }}</th>
                                <th>{{ __('End Date') }}</th>
                                <th>{{ __('Purpose of Travel') }}</th>
                                <th>{{ __('Place of Visit') }}</th>
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
    <div class="modal fade" tabindex="-1" id="add_travel_modal">
        <div class="modal-dialog">
            <form action="" id="add_travel_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Trip</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">

                                <div>
                                    <label for="employee">
                                        Employee
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Branch select"
                                        name="employee" id="employee">
                                        <option value=""> Select Employee</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}"> {{ $employee->user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="employee_invalid" class="invalid-feedback"></div>
                                </div>

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
    <div class="modal fade" tabindex="-1" id="edit_travel_modal">
        <div class="modal-dialog">
            <form action="" id="update_travel_form">
                <input type="hidden" id="_method" name="_method" value="patch">
                <input type="hidden" name="travel_id" id="travel_id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Travel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">

                                <div>
                                    <label for="employee_update">
                                        Employee
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Branch select"
                                        name="employee_update" id="employee_update">
                                        <option value=""> Select Employee</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}"> {{ $employee->user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="employee_update_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="mt-2">
                                    <label for="start_date_update" class="form-label">Start Date</label>
                                    <input type="text" name="start_date_update" class="form-control"
                                        id="start_date_update" required>
                                    <div id="start_date_update_invalid" class="invalid-feedback"></div>
                                </div>


                                <div class="mt-2">
                                    <label for="end_date_update" class="form-label">End Date</label>
                                    <input type="text" name="end_date_update" class="form-control"
                                        id="end_date_update" required>
                                    <div id="end_date_update_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="mt-2">
                                    <label for="purpose_of_visit_update" class="form-label">Purpose of Visit</label>
                                    <input type="text" class="form-control" id="purpose_of_visit_update"
                                        name="purpose_of_visit_update" placeholder="Enter Purpose"
                                        aria-describedby="description_invalid"></input>
                                    <div id="purpose_of_visit_update_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="mt-2">
                                    <label for="place_of_visit_update" class="form-label">Place of Visit</label>
                                    <input type="text" class="form-control" id="place_of_visit_update"
                                        name="place_of_visit_update" placeholder="Enter Visit"
                                        aria-describedby="description_invalid"></input>
                                    <div id="place_of_visit_update_invalid" class="invalid-feedback"></div>
                                </div>

                            </div>


                            <div>
                                <label for="description_update" class="form-label">Description</label>
                                <textarea type="text" class="form-control" id="description_update" name="description_update"
                                    placeholder="Enter Description" aria-describedby="description_invalid" row="3"></textarea>
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
        var transferTable;
        $(document).ready(function() {



            $('#employee').select2({
                dropdownParent: $('#add_travel_modal'),
                width: 'style',

            });
            $('#employee_update').select2({
                dropdownParent: $('#edit_travel_modal'),
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


            travelTable = $('#travel').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('travel.data') }}",
                columns: [{
                        data: 'employee.user.name',
                        name: 'employee.user.name'
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
                        data: 'purpose_of_visit',
                        name: 'purpose_of_visit'
                    },
                    {
                        data: 'place_of_visit',
                        name: 'place_of_visit'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'action', className: "dt-right",
                        name: 'action'
                    }
                ],
                columnDefs: [{

                }],
            });




            $('#add_travel_form').on('submit', (e) => {
                e.preventDefault();
                let url = "{{ route('travel.store') }}";
                let formData = new FormData(e.target);
                $.ajax({
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    url: url,
                    success: function success(data) {
                        $('#add_travel_form').trigger("reset");
                        travelTable.ajax.reload();
                        modalHide('add_travel_modal');
                        show_toastr('Success', 'Travel successfully added.', 'success');
                    },
                    error: function error(data) {
                        handleFormValidation(data);
                        show_toastr('Error', 'Permission denied.', 'error');
                    }
                });
            });


            $('#travel').on('draw.dt', function() {
                $('.travel-delete').on('click', (e) => {
                    let travel = e.currentTarget.dataset.id;
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
                                url: `{{ url('travel') }}/${travel}`,
                                success: function success(data) {
                                    travelTable.ajax.reload();
                                    show_toastr('Success',
                                        'Travel successfully deleted.',
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


                $('.travel-edit').on('click', (e) => {
                    let travel = e.currentTarget.dataset.id;
                    //console.log('fdfs');
                    $.ajax({
                        type: "get",
                        url: `{{ url('travel') }}/${travel}/edit`,
                        success: function success(data) {
                            //console.log(data.id);
                            $('#travel_id').val(data.id);
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


                $('#update_travel_form').on('submit', (e) => {
                    e.preventDefault();

                    let travel_id = $('#travel_id').val();
                    //console.log(e.target);
                    let formData = new FormData(e.target);
                    $.ajax({
                        type: "post",
                        data: formData,
                        processData: false,
                        contentType: false,
                        url: `{{ url('travel') }}/${travel_id}`,
                        success: function success(data) {
                            travelTable.ajax.reload();
                            modalHide('edit_travel_modal');
                            show_toastr('Success', 'Travel successfully updated.',
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
