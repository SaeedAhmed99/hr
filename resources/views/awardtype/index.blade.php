@extends('layouts.app')
@section('page-title')
    {{ __('Award Type') }}
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">All Award Type</p>
                        <button data-bs-toggle="modal" data-bs-target="#add_awardType_modal" class="btn btn-gray"><i
                                class="fa-solid fa-plus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="awardType" class="table table-condensed">
                        <thead>
                            <tr>
                                <th>{{ __('Award Type') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    {{--  add modal start  --}}
    <div class="modal fade" tabindex="-1" id="add_awardType_modal">
        <div class="modal-dialog">
            <form action="" id="add_awardType_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Award Type</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">

                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter Award Type Name" aria-describedby="name_invalid">
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
    <div class="modal fade" tabindex="-1" id="edit_awardType_modal">
        <div class="modal-dialog">
            <form action="" id="update_awardType_form">
                <input type="hidden" id="_method" name="_method" value="patch">
                <input type="hidden" name="awardtype_id" id="awardtype_id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Award Type</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <label for="name_update" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name_update" name="name_update"
                                    placeholder="Name" aria-describedby="name_invalid">
                                <div id="name_update_invalid" class="invalid-feedback"></div>
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
        var awardTypeTable;
        $(document).ready(function() {

            awardTypeTable = $('#awardType').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('award.type.data') }}",
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



            $('#add_awardType_form').on('submit', (e) => {
                e.preventDefault();
                let url = "{{ route('awardtype.store') }}";
                let formData = new FormData(e.target);
                $.ajax({
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    url: url,
                    success: function success(data) {
                        $('#add_awardType_form').trigger("reset");
                        awardTypeTable.ajax.reload();
                        modalHide('add_awardType_modal');
                        show_toastr('Success', 'Award Type successfully added.', 'success');
                    },
                    error: function error(data) {
                        handleFormValidation(data);
                        show_toastr('Error', 'Permission denied.', 'error');
                    }
                });
            });


            $('#awardType').on('draw.dt', function() {
                $('.awardType-delete').on('click', (e) => {
                    let awardType = e.currentTarget.dataset.id;
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
                                url: `{{ url('awardtype') }}/${awardType}`,
                                success: function success(data) {
                                    awardTypeTable.ajax.reload();
                                    show_toastr('Success', 'Award Type successfully deleted.', 'success');
                                },
                                error: function error(data) {
                                    console.error(data);
                                    show_toastr('Error', 'Permission denied.', 'error');
                                }
                            });
                        }
                    })
                });


                $('.awardType-edit').on('click', (e) => {
                    let awardType = e.currentTarget.dataset.id;
                    //console.log('fdfs');
                    $.ajax({
                        type: "get",
                        url: `{{ url('awardtype') }}/${awardType}/edit`,
                        success: function success(data) {
                            //console.log(data.id);
                            $('#awardtype_id').val(data.id);
                            $('#name_update').val(data.name);



                        },
                        error: function error(data) {
                            console.error(data);
                        }
                    });
                });


                $('#update_awardType_form').on('submit', (e) => {
                    e.preventDefault();

                    let awardtype_id = $('#awardtype_id').val();
                    //console.log(e.target);
                    let formData = new FormData(e.target);
                    $.ajax({
                        type: "post",
                        data: formData,
                        processData: false,
                        contentType: false,
                        url: `{{ url('awardtype') }}/${awardtype_id}`,
                        success: function success(data) {
                            awardTypeTable.ajax.reload();
                            modalHide('edit_awardType_modal');
                            show_toastr('Success', 'Award Type successfully updated.', 'success');

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
