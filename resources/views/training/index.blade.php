@extends('layouts.app')

@push('head')
    <style>
        .ml-10px{
            margin-left: 10px;
        }
    </style>
@endpush

@section('page-title')
    {{ __('Training') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">Training</p>
                        @can('Create Meeting')
                            <button data-bs-toggle="modal" data-bs-target="#add_training_modal" class="btn btn-gray"><i
                                    class="fa-solid fa-plus"></i></button>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <table id="training" class="table table-condensed">
                        <thead>
                            <tr>
                                <th>Branch</th>
                                <th>Training Type</th>
                                <th>Status</th>
                                <th>Employee</th>
                                <th>Trainer</th>
                                <th>Training Duration</th>
                                <th>Cost</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" tabindex="-1" id="add_training_modal">
        <div class="modal-dialog">
            <form action="" id="add_training_form">
                <input type="hidden" name="employee" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Training</h5>
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
                                <div class="ml-10px">
                                    <label for="trainer_option">
                                        Trainer Option*
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Option select"
                                        name="trainer_option" id="trainer_option">
                                        <option value="" selected>Select Option</option>
                                        @foreach ($options as $option)
                                            <option value="{{ $option }}"> {{ $option }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="trainer_option_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="ml-10px">
                                    <label for="training_type">
                                        Training type*
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Type select"
                                        name="training_type" id="training_type">
                                        <option value="" selected>Select Type</option>
                                        @foreach ($trainingTypes as $trainingType)
                                            <option value="{{ $trainingType->id }}"> {{ $trainingType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="training_type_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="ml-10px">
                                    <label for="trainer">
                                        Trainer*
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Trainer select"
                                        name="trainer" id="trainer">
                                        <option value="">Select Trainer</option>
                                        @foreach ($trainers as $trainer)
                                            <option value="{{ $trainer->id }}"> {{ $trainer->firstname }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="trainer_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="ml-10px">
                                    <label for="employee">
                                        Employee*
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Employee select"
                                        name="employee" id="employee">
                                        <option value="">Select Employee</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}"> {{ $employee->user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="employee_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="col-12 mt-2">
                                    <label for="training_cost" class="form-label">Training Cost</label>
                                    <input type="number" class="form-control" id="training_cost" name="training_cost"
                                        placeholder="Cost" aria-describedby="training_cost_invalid">
                                    <div id="training_cost_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="col-12 mt-2">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="text" class="form-control" id="start_date" name="start_date"
                                        placeholder="Start Date" aria-describedby="start_date_invalid">
                                    <div id="start_date_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="col-12 mt-2">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="text" class="form-control" id="end_date" name="end_date"
                                        placeholder="End Date" aria-describedby="end_date_invalid">
                                    <div id="end_date_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="col-12 mt-2">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea type="text" class="form-control" id="description" name="description" placeholder="Description"
                                        aria-describedby="description_invalid" rows="2"></textarea>
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

    <div class="modal fade" tabindex="-1" id="edit_training_modal">
        <div class="modal-dialog">
            <form action="" id="update_training_form">
                <input type="hidden" id="_method" name="_method" value="patch">
                <input type="hidden" name="training_id" id="training_id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Training</h5>
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
                                <div class="ml-10px">
                                    <label for="trainer_option_update">
                                        Trainer Option*
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Option select"
                                        name="trainer_option_update" id="trainer_option_update">
                                        <option value="" selected>Select Option</option>
                                        @foreach ($options as $option)
                                            <option value="{{ $option }}"> {{ $option }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="trainer_option_update_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="ml-10px">
                                    <label for="training_type_update">
                                        Training type*
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Type select"
                                        name="training_type_update" id="training_type_update">
                                        <option value="" selected>Select Type</option>
                                        @foreach ($trainingTypes as $trainingType)
                                            <option value="{{ $trainingType->id }}"> {{ $trainingType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="training_type_update_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="ml-10px">
                                    <label for="trainer_update">
                                        Trainer*
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Trainer select"
                                        name="trainer_update" id="trainer_update">
                                        <option value="">Select Trainer</option>
                                        @foreach ($trainers as $trainer)
                                            <option value="{{ $trainer->id }}"> {{ $trainer->firstname }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="trainer_update_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="ml-10px">
                                    <label for="employee_update">
                                        Employee*
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Employee select"
                                        name="employee_update" id="employee_update">
                                        <option value="">Select Employee</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}"> {{ $employee->user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="employee_update_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="col-12 mt-2">
                                    <label for="training_cost_update" class="form-label">Training Cost</label>
                                    <input type="number" class="form-control" id="training_cost_update"
                                        name="training_cost_update" placeholder="Cost"
                                        aria-describedby="training_cost_invalid">
                                    <div id="training_cost_update_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="col-12 mt-2">
                                    <label for="start_date_update" class="form-label">Start Date</label>
                                    <input type="text" class="form-control" id="start_date_update"
                                        name="start_date_update" placeholder="Start Date"
                                        aria-describedby="start_date_invalid">
                                    <div id="start_date_update_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="col-12 mt-2">
                                    <label for="end_date_update" class="form-label">End Date</label>
                                    <input type="text" class="form-control" id="end_date_update"
                                        name="end_date_update" placeholder="End Date"
                                        aria-describedby="end_date_invalid">
                                    <div id="end_date_update_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="col-12 mt-2">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea type="text" class="form-control" id="description_update" name="description" placeholder="Description"
                                        aria-describedby="description_invalid" rows="2"></textarea>
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
        var trainingTable;
        $(document).ready(function() {

            $('#branch').select2({
                dropdownParent: $('#add_training_modal'),
                width: 'style'
            });
            $('#trainer_option').select2({
                dropdownParent: $('#add_training_modal'),
                width: 'style'
            });
            $('#training_type').select2({
                dropdownParent: $('#add_training_modal'),
                width: 'style'
            });
            $('#trainer').select2({
                dropdownParent: $('#add_training_modal'),
                width: 'style'
            });
            $('#employee').select2({
                dropdownParent: $('#add_training_modal'),
                width: 'style'
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


            trainingTable = $('#training').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('training.data') }}",
                columns: [{
                        data: 'branch.name',
                        name: 'branch.name'
                    },
                    {
                        data: 'traningtype.name',
                        name: 'traningtype.name'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'employee.user.name',
                        name: 'employee.user.name'
                    },
                    {
                        data: 'trainer.firstname',
                        name: 'trainer.firstname'
                    },
                    {
                        data: 'duration',
                        name: 'duration'
                    },
                    {
                        data: 'training_cost',
                        name: 'training_cost'
                    },
                    {
                        data: 'action', className: "dt-right",
                        name: 'action'
                    }
                ],
                columnDefs: [{

                }],
            });



            $('#add_training_form').on('submit', (e) => {
                e.preventDefault();
                let url = "{{ route('training.store') }}";
                let formData = new FormData(e.target);
                $.ajax({
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    url: url,
                    success: function success(data) {
                        trainingTable.ajax.reload();
                        modalHide('add_training_modal');
                        show_toastr('Success', 'Traning successfully added.', 'success');
                    },
                    error: function error(data) {
                        handleFormValidation(data);
                        show_toastr('Error', 'Permission denied.', 'error');
                    }
                });
            });


            $('#training').on('draw.dt', function() {
                $('.training-delete').on('click', (e) => {
                    let training = e.currentTarget.dataset.id;
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
                                url: `{{ url('training') }}/${training}`,
                                success: function success(data) {
                                    trainingTable.ajax.reload();
                                    show_toastr('Success',
                                        'Traning successfully deleted.',
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


                $('.training-edit').on('click', (e) => {
                    let training = e.currentTarget.dataset.id;
                    //console.log('fdfs');
                    $.ajax({
                        type: "get",
                        url: `{{ url('training') }}/${training}/edit`,
                        success: function success(data) {
                            //console.log(data.id);
                            $('#training_id').val(data.id);
                            $('#branch_update').val(data.branch_id);
                            $('#trainer_option_update').val(data.trainer_option);
                            $('#training_type_update').val(data.training_type_id);
                            $('#trainer_update').val(data.trainer_id);
                            $('#employee_update').val(data.employee_id);
                            $('#training_cost_update').val(data.training_cost);
                            $('#start_date_update').val(data.start_date);
                            $('#end_date_update').val(data.end_date);
                            $('#description_update').val(data.description);

                        },
                        error: function error(data) {
                            console.error(data);
                        }
                    });
                });


                $('#update_training_form').on('submit', (e) => {
                    e.preventDefault();

                    let training_id = $('#training_id').val();
                    //console.log(e.target);
                    let formData = new FormData(e.target);
                    $.ajax({
                        type: "post",
                        data: formData,
                        processData: false,
                        contentType: false,
                        url: `{{ url('training') }}/${training_id}`,
                        success: function success(data) {
                            trainingTable.ajax.reload();
                            modalHide('edit_training_modal');
                            show_toastr('Success', 'Traning successfully updated.',
                                'success');
                        },
                        error: function error(data) {
                            handleFormValidation(data);
                            show_toastr('Error', 'Permission denied.', 'error');
                        }
                    });
                });


                $('.training-show').on('click', (e) => {
                    let training = e.currentTarget.dataset.id;
                    //console.log('fdfs');
                    $.ajax({
                        type: "get",
                        url: `{{ url('training') }}/${training}`,
                        success: function success(data) {


                        },
                        error: function error(data) {
                            console.error(data);
                        }
                    });
                });


            });
        });
    </script>
@endpush
