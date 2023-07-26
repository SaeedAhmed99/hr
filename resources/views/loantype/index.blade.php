@extends('layouts.app')
@section('page-title')
    {{ __('Loan Type') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">All Loan Types</p>
                        @can('Create Loan Type')
                            <button data-bs-toggle="modal" data-bs-target="#add_loanType_modal" class="btn btn-gray"><i class="fa-solid fa-plus"></i></button>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <table id="loanType" class="table table-condensed">
                        <thead>
                            <tr>
                                <th>{{ __('Loan Type') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    {{--  add modal start  --}}
    <div class="modal fade" tabindex="-1" id="add_loanType_modal">
        <div class="modal-dialog">
            <form action="" id="add_loanType_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Loan Type</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Loan Type" aria-describedby="name_invalid">
                                <div id="name_invalid" class="invalid-feedback"></div>
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
    <div class="modal fade" tabindex="-1" id="edit_loanType_modal">
        <div class="modal-dialog">
            <form action="" id="update_loanType_form">
                <input type="hidden" id="_method" name="_method" value="patch">
                <input type="hidden" name="loanType_id" id="loanType_id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Leave Type</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <label for="name_update" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name_update" name="name"
                                    placeholder="Name" aria-describedby="name_invalid">
                                <div id="name_update_invalid" class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        var loanTypeTable;
        $(document).ready(function() {

            loanTypeTable = $('#loanType').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('loan.type.data') }}",
                columns: [
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'action', className: "dt-right",
                        name: 'action'
                    }
                ],
                columnDefs: [{

                }],
            });



            $('#add_loanType_form').on('submit', (e) => {
                e.preventDefault();
                let url = "{{ route('loan.type.store') }}";
                let formData = new FormData(e.target);
                $.ajax({
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    url: url,
                    success: function success(data) {
                        $('#add_loanType_form').trigger("reset");
                        loanTypeTable.ajax.reload();
                        modalHide('add_loanType_modal');
                        show_toastr('Success', data, 'success');
                    },
                    error: function error(data) {
                        handleFormValidation(data);
                    }
                });
            });


            $('#loanType').on('draw.dt', function() {
                $('.loanType-delete').on('click', (e) => {
                    let loanType = e.currentTarget.dataset.id;
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
                                url: `{{ url('loantype') }}/${loanType}`,
                                success: function success(data) {
                                    loanTypeTable.ajax.reload();
                                    show_toastr('Success', data, 'success');
                                },
                                error: function error(data) {
                                    show_toastr('Error', 'Permission denied.', 'error');
                                }
                            });
                        }
                    })
                });


                $('.loanType-edit').on('click', (e) => {
                    let loanType = e.currentTarget.dataset.id;
                    //console.log('fdfs');
                    $.ajax({
                        type: "get",
                        url: `{{ url('loantype') }}/${loanType}/edit`,
                        success: function success(data) {
                            //console.log(data.id);
                            $('#loanType_id').val(data.id);
                            $('#name_update').val(data.name);
                        },
                        error: function error(data) {
                            console.error(data);
                            handleFormValidation(data, 'update');
                        }
                    });
                });


                $('#update_loanType_form').on('submit', (e) => {
                    e.preventDefault();

                    let loanType_id = $('#loanType_id').val();
                    //console.log(e.target);
                    let formData = new FormData(e.target);
                    $.ajax({
                        type: "post",
                        data: formData,
                        processData: false,
                        contentType: false,
                        url: `{{ url('loantype') }}/${loanType_id}`,
                        success: function success(data) {
                            loanTypeTable.ajax.reload();
                            modalHide('edit_loanType_modal');
                            show_toastr('Success', data, 'success');
                        },
                        error: function error(data) {
                            handleFormValidation(data, 'update');
                        }
                    });
                });



            });
        });
    </script>
@endpush
