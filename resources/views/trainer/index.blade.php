@extends('layouts.app')

@section('page-title')
    {{ __('Trainer') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">All Trainer</p>
                        <button data-bs-toggle="modal" data-bs-target="#add_trainer_modal" class="btn btn-gray"><i
                                class="fa-solid fa-plus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="trainer" class="table table-condensed">
                        <thead>
                            <tr>
                                <th>{{ __('Trainer Name') }}</th>
                                <th>{{ __('Contact') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Expertise') }}</th>
                                @if (Gate::check('Edit Trainer') || Gate::check('Delete Trainer') || Gate::check('Show Trainer'))
                                    <th width="200px">{{ __('Action') }}</th>
                                @endif
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    {{--  add modal start  --}}
    <div class="modal fade" tabindex="-1" id="add_trainer_modal">
        <div class="modal-dialog">
            <form action="" id="add_trainer_form">
                <input type="hidden" name="employee" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Trainer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                {{--  <div>
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
                                </div>  --}}



                                <div class="col-12">
                                    <label for="firstname" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="firstname" name="firstname"
                                        placeholder="Name" aria-describedby="training_cost_invalid">
                                    <div id="firstname_invalid" class="invalid-feedback"></div>
                                </div>
                                {{--  <div class="col-12 mt-2">
                                    <label for="lastname" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="lastname" name="lastname"
                                        placeholder="Last Name" aria-describedby="training_cost_invalid">
                                    <div id="lastname_invalid" class="invalid-feedback"></div>
                                </div>  --}}
                                <div class="col-12 mt-2">
                                    <label for="contact" class="form-label">Contact</label>
                                    <input type="text" class="form-control" id="contact" name="contact"
                                        placeholder="Contact" aria-describedby="training_cost_invalid">
                                    <div id="contact_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="col-12 mt-2">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Email" aria-describedby="training_cost_invalid">
                                    <div id="email_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="col-12 mt-2">
                                    <label for="expertise" class="form-label">Expertise</label>
                                    <textarea type="text" class="form-control" id="expertise" name="expertise" placeholder="Expertise"
                                        aria-describedby="description_invalid" rows="2"></textarea>
                                    <div id="expertise_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="col-12 mt-2">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea type="text" class="form-control" id="address" name="address" placeholder="Address"
                                        aria-describedby="description_invalid" rows="2"></textarea>
                                    <div id="address_invalid" class="invalid-feedback"></div>
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
    <div class="modal fade" tabindex="-1" id="edit_trainer_modal">
        <div class="modal-dialog">
            <form action="" id="update_trainer_form">
                <input type="hidden" id="_method" name="_method" value="patch">
                <input type="hidden" name="trainer_id" id="trainer_id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Trainer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                {{--  <div>
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
                                </div>  --}}



                                <div class="col-12">
                                    <label for="firstname_update" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="firstname_update" name="firstname_update"
                                        placeholder="Name" aria-describedby="training_cost_invalid">
                                    <div id="firstname_update_invalid" class="invalid-feedback"></div>
                                </div>
                                {{--  <div class="col-12 mt-2">
                                    <label for="lastname_update" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="lastname_update" name="lastname_update"
                                        placeholder="Last Name" aria-describedby="training_cost_invalid">
                                    <div id="lastname_update_invalid" class="invalid-feedback"></div>
                                </div>  --}}
                                <div class="col-12 mt-2">
                                    <label for="contact_update" class="form-label">Contact</label>
                                    <input type="text" class="form-control" id="contact_update" name="contact_update"
                                        placeholder="Contact" aria-describedby="training_cost_invalid">
                                    <div id="contact_update_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="col-12 mt-2">
                                    <label for="email_update" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email_update" name="email_update"
                                        placeholder="Email" aria-describedby="training_cost_invalid">
                                    <div id="email_update_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="col-12 mt-2">
                                    <label for="expertise_update" class="form-label">Expertise</label>
                                    <textarea type="text" class="form-control" id="expertise_update" name="expertise_update" placeholder="Expertise"
                                        aria-describedby="description_invalid" rows="2"></textarea>
                                    <div id="expertise_update_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="col-12 mt-2">
                                    <label for="address_update" class="form-label">Address</label>
                                    <textarea type="text" class="form-control" id="address_update" name="address_update" placeholder="Address"
                                        aria-describedby="description_invalid" rows="2"></textarea>
                                    <div id="address_update_invalid" class="invalid-feedback"></div>
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
        var trainerTable;
        $(document).ready(function() {

            $('#branch').select2({
                dropdownParent: $('#add_trainer_modal'),
                width: 'style'
            });

            trainerTable = $('#trainer').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('trainer.data') }}",
                columns: [
                    {
                        data: 'firstname',
                        name: 'firstname'
                    },
                    {
                        data: 'contact',
                        name: 'contact'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'expertise',
                        name: 'expertise'
                    },
                    {
                        data: 'action', className: "dt-right",
                        name: 'action'
                    }
                ],
                columnDefs: [{

                }],
            });



            $('#add_trainer_form').on('submit', (e) => {
                e.preventDefault();
                let url = "{{ route('trainer.store') }}";
                let formData = new FormData(e.target);
                $.ajax({
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    url: url,
                    success: function success(data) {
                        $('#add_trainer_form').trigger("reset");
                        trainerTable.ajax.reload();
                        modalHide('add_trainer_modal');
                        show_toastr('Success', 'Trainer successfully added.', 'success');
                    },
                    error: function error(data) {
                        handleFormValidation(data);
                        show_toastr('Error', 'Permission denied.', 'error');
                    }
                });
            });


            $('#trainer').on('draw.dt', function() {
                $('.trainer-delete').on('click', (e) => {
                    let trainer = e.currentTarget.dataset.id;
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
                                url: `{{ url('trainer') }}/${trainer}`,
                                success: function success(data) {
                                    trainerTable.ajax.reload();
                                    show_toastr('Success', 'Trainer successfully deleted.', 'success');
                                },
                                error: function error(data) {
                                    console.error(data);
                                    show_toastr('Error', 'Permission denied.', 'error');
                                }
                            });
                        }
                    })
                });


                $('.trainer-edit').on('click', (e) => {
                    let trainer = e.currentTarget.dataset.id;
                    //console.log('fdfs');
                    $.ajax({
                        type: "get",
                        url: `{{ url('trainer') }}/${trainer}/edit`,
                        success: function success(data) {
                            //console.log(data.id);
                            $('#trainer_id').val(data.id);
                            $('#firstname_update').val(data.firstname);
                            $('#contact_update').val(data.contact);
                            $('#email_update').val(data.email);
                            $('#address_update').val(data.address);
                            $('#expertise_update').val(data.expertise);


                        },
                        error: function error(data) {
                            console.error(data);
                        }
                    });
                });


                $('#update_trainer_form').on('submit', (e) => {
                    e.preventDefault();

                    let trainer_id = $('#trainer_id').val();
                    //console.log(e.target);
                    let formData = new FormData(e.target);
                    $.ajax({
                        type: "post",
                        data: formData,
                        processData: false,
                        contentType: false,
                        url: `{{ url('trainer') }}/${trainer_id}`,
                        success: function success(data) {
                            trainerTable.ajax.reload();
                            modalHide('edit_trainer_modal');
                            show_toastr('Success', 'Trainer successfully updated.', 'success');
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
