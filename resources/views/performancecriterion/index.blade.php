@extends('layouts.app')
@section('page-title')
    {{ __('Performance Criteria') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">Performance Criteria</p>
                        @can('Create Performance Criterion')
                            <button data-bs-toggle="modal" data-bs-target="#add_performanceCriteria_modal" class="btn btn-gray"><i class="fa-solid fa-plus"></i></button>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <table id="performanceCriteria" class="table table-condensed">
                        <thead>
                            <tr>
                                <th>{{ __('Criteria') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{--  add modal start  --}}
    <div class="modal fade" tabindex="-1" id="add_performanceCriteria_modal">
        <div class="modal-dialog">
            <form action="" id="add_performanceCriteria_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Performance Criterion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Criterion" aria-describedby="name_invalid">
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
    <div class="modal fade" tabindex="-1" id="edit_performanceCriteria_modal">
        <div class="modal-dialog">
            <form action="" id="update_performanceCriteria_form">
                <input type="hidden" id="_method" name="_method" value="patch">
                <input type="hidden" name="performanceCriteria_id" id="performanceCriteria_id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Performance Criterion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <label for="name_update" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name_update" name="name_update" placeholder="Name" aria-describedby="name_invalid">
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
        var performanceCriteriaTable;
        $(document).ready(function() {

            performanceCriteriaTable = $('#performanceCriteria').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('performance.criterion.data') }}",
                columns: [{
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



            $('#add_performanceCriteria_form').on('submit', (e) => {
                e.preventDefault();
                let url = "{{ route('performance.criterion.store') }}";
                let formData = new FormData(e.target);
                $.ajax({
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    url: url,
                    success: function success(data) {
                        $('#add_performanceCriteria_form').trigger("reset");
                        performanceCriteriaTable.ajax.reload();
                        modalHide('add_performanceCriteria_modal');
                        show_toastr('Success', data, 'success');
                    },
                    error: function error(data) {
                        handleFormValidation(data);
                    }
                });
            });


            $('#performanceCriteria').on('draw.dt', function() {
                $('.performanceCriteria-delete').on('click', (e) => {
                    let performanceCriteria = e.currentTarget.dataset.id;
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
                                url: `{{ url('performance-criterion') }}/${performanceCriteria}`,
                                success: function success(data) {
                                    performanceCriteriaTable.ajax.reload();
                                    show_toastr('Success', data, 'success');
                                },
                                error: function error(data) {
                                    show_toastr('Error', 'Permission denied.', 'error');
                                }
                            });
                        }
                    })
                });


                $('.performanceCriteria-edit').on('click', (e) => {
                    let performanceCriteria = e.currentTarget.dataset.id;
                    //console.log('fdfs');
                    $.ajax({
                        type: "get",
                        url: `{{ url('performance-criterion') }}/${performanceCriteria}/edit`,
                        success: function success(data) {
                            //console.log(data.id);
                            $('#performanceCriteria_id').val(data.id);
                            $('#name_update').val(data.name);
                        },
                        error: function error(data) {
                            console.error(data);
                            handleFormValidation(data, 'update');
                        }
                    });
                });


                $('#update_performanceCriteria_form').on('submit', (e) => {
                    e.preventDefault();

                    let performanceCriteria_id = $('#performanceCriteria_id').val();
                    //console.log(e.target);
                    let formData = new FormData(e.target);
                    $.ajax({
                        type: "post",
                        data: formData,
                        processData: false,
                        contentType: false,
                        url: `{{ url('performance-criterion') }}/${performanceCriteria_id}`,
                        success: function success(data) {
                            performanceCriteriaTable.ajax.reload();
                            modalHide('edit_performanceCriteria_modal');
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
