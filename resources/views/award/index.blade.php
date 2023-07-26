@extends('layouts.app')
@section('page-title')
    {{ __('Award') }}
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">All Award</p>
                        @can('Create Award')
                            <button data-bs-toggle="modal" data-bs-target="#add_award_modal" class="btn btn-gray"><i
                                    class="fa-solid fa-plus"></i></button>
                        @endcan

                    </div>
                </div>
                <div class="card-body">
                    <table id="award" class="table table-condensed">
                        <thead>
                            <tr>
                                <th>{{ __('Employee') }}</th>
                                <th>{{ __('Award Type') }}</th>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Gift') }}</th>
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
    <div class="modal fade" tabindex="-1" id="add_award_modal">
        <div class="modal-dialog">
            <form action="" id="add_award_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Award</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="">
                                    <label for="employee">
                                        Employee
                                    </label>
                                    <div class="">
                                        <select style="width: 100%" class="form-select" aria-label="Branch select"
                                            name="employee" id="employee">
                                            <option value="">Select Employee</option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}"> {{ $employee->user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="employee_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="mt-2">
                                    <label for="awartype">
                                        Award Type
                                    </label>
                                    <div class="">
                                        <select style="width: 100%" class="form-select" aria-label="Branch select"
                                            name="awartype" id="awartype">
                                            <option value="">Select Type</option>
                                            @foreach ($awartypes as $awartype)
                                                <option value="{{ $awartype->id }}"> {{ $awartype->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="awartype_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="mt-2">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="text" class="form-control" id="date" name="date"
                                        placeholder="Select Date" aria-describedby="name_invalid">
                                    <div id="date_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="mt-2">
                                    <label for="gift" class="form-label">Gift</label>
                                    <input type="text" class="form-control" id="gift" name="gift"
                                        placeholder="Gift" aria-describedby="name_invalid">
                                    <div id="gift_invalid" class="invalid-feedback"></div>
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
    <div class="modal fade" tabindex="-1" id="edit_award_modal">
        <div class="modal-dialog">
            <form action="" id="update_award_form">
                <input type="hidden" id="_method" name="_method" value="patch">
                <input type="hidden" name="award_id" id="award_id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Award Type</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="">
                                    <label for="employee_update">
                                        Employee
                                    </label>
                                    <div class="">
                                        <select style="width: 100%" class="form-select" aria-label="Branch select"
                                            name="employee_update" id="employee_update">
                                            <option value="">Select Employee</option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}"> {{ $employee->user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="employee_update_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="mt-2">
                                    <label for="awartype_update">
                                        Award Type
                                    </label>
                                    <div class="">
                                        <select style="width: 100%" class="form-select" aria-label="Branch select"
                                            name="awartype_update" id="awartype_update">
                                            <option value="">Select Type</option>
                                            @foreach ($awartypes as $awartype)
                                                <option value="{{ $awartype->id }}"> {{ $awartype->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="awartype_update_invalid" class="invalid-feedback"></div>
                                </div>

                                <div class="mt-2">
                                    <label for="date_update" class="form-label">Date</label>
                                    <input type="text" class="form-control" id="date_update" name="date_update"
                                        placeholder="Select Date" aria-describedby="name_invalid">
                                    <div id="date_update_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="mt-2">
                                    <label for="gift_update" class="form-label">Gift</label>
                                    <input type="text" class="form-control" id="gift_update" name="gift_update"
                                        placeholder="Gift" aria-describedby="name_invalid">
                                    <div id="gift_update_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="mt-2">
                                    <label for="description_update" class="form-label">Description</label>
                                    <textarea type="text" class="form-control" id="description_update" name="description_update" cols="4"
                                        rows="4" placeholder="description" aria-describedby="name_invalid"></textarea>
                                    <div id="description_update_invalid" class="invalid-feedback"></div>
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
        $('#employee').select2({
            dropdownParent: $('#add_award_modal'),
            width: 'style'
        });

        $('#awartype').select2({
            dropdownParent: $('#add_award_modal'),
            width: 'style'
        });
        $('#employee_update').select2({
            dropdownParent: $('#edit_award_modal'),
            width: 'style'
        });

        $('#awartype_update').select2({
            dropdownParent: $('#edit_award_modal'),
            width: 'style'
        });
        $("#date").datepicker({
            dateFormat: 'yy-mm-dd',
        });
        $("#date_update").datepicker({
            dateFormat: 'yy-mm-dd',
        });
        var awardTable;
        $(document).ready(function() {

            awardTable = $('#award').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('award.data') }}",
                columns: [{
                        data: 'employee.user.name',
                        name: 'employee.user.name'
                    },
                    {
                        data: 'award_type.name',
                        name: 'award_type.name'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'gift',
                        name: 'gift'
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



            $('#add_award_form').on('submit', (e) => {
                e.preventDefault();
                let url = "{{ route('award.store') }}";
                let formData = new FormData(e.target);
                $.ajax({
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    url: url,
                    success: function success(data) {
                        $('#add_award_form').trigger("reset");
                        awardTable.ajax.reload();
                        modalHide('add_award_modal');
                        show_toastr('Success', data, 'success');
                    },
                    error: function error(data) {
                        handleFormValidation(data);
                        show_toastr('Error', 'Permission denied.', 'error');
                    }
                });
            });


            $('#award').on('draw.dt', function() {
                $('.award-delete').on('click', (e) => {
                    let award = e.currentTarget.dataset.id;
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
                                url: `{{ url('award') }}/${award}`,
                                success: function success(data) {
                                    awardTable.ajax.reload();
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


                $('.award-edit').on('click', (e) => {
                    let award = e.currentTarget.dataset.id;
                    //console.log('fdfs');
                    $.ajax({
                        type: "get",
                        url: `{{ url('award') }}/${award}/edit`,
                        success: function success(data) {
                            //console.log(data.id);
                            $('#award_id').val(data.id);
                            $('#employee_update').val(data.employee_id);
                            $('#employee_update').trigger('change');
                            $('#awartype_update').val(data.award_type_id);
                            $('#awartype_update').trigger('change');
                            $('#date_update').val(data.date);
                            $('#gift_update').val(data.gift);
                            $('#description_update').val(data.description);

                        },
                        error: function error(data) {
                            console.error(data);
                        }
                    });
                });


                $('#update_award_form').on('submit', (e) => {
                    e.preventDefault();

                    let award_id = $('#award_id').val();
                    //console.log(e.target);
                    let formData = new FormData(e.target);
                    $.ajax({
                        type: "post",
                        data: formData,
                        processData: false,
                        contentType: false,
                        url: `{{ url('award') }}/${award_id}`,
                        success: function success(data) {
                            awardTable.ajax.reload();
                            modalHide('edit_award_modal');
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
