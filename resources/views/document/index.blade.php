@extends('layouts.app')
@section('page-title')
    {{ __('Document') }}
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">All Document Type</p>
                        <button data-bs-toggle="modal" data-bs-target="#add_document_modal" class="btn btn-gray"><i
                                class="fa-solid fa-plus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="document" class="table table-condensed">
                        <thead>
                            <tr>
                                <th>{{ __('Document') }}</th>
                                <th>{{ __('Required Field') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    {{--  add modal start  --}}
    <div class="modal fade" tabindex="-1" id="add_document_modal">
        <div class="modal-dialog">
            <form action="" id="add_document_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Document Type</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter Document Type" aria-describedby="name_invalid">
                                <div id="name_invalid" class="invalid-feedback"></div>
                            </div>

                            <div class="mt-2">
                                <label for="required">
                                    Required Field*
                                </label>
                                <select style="width: 100%" class="form-select" aria-label="required select" name="required"
                                    id="required">
                                    <option value="" selected>Select One</option>
                                    <option value="1">Is Requrired</option>
                                    <option value="0">Not Requrired</option>
                                </select>
                                <div id="required_invalid" class="invalid-feedback"></div>
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
    <div class="modal fade" tabindex="-1" id="edit_document_modal">
        <div class="modal-dialog">
            <form action="" id="update_document_form">
                <input type="hidden" id="_method" name="_method" value="patch">
                <input type="hidden" name="document_id" id="document_id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit document Type</h5>
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

                            <div class="mt-2">
                                <label for="required_update">
                                    Required Field*
                                </label>
                                <select style="width: 100%" class="form-select" aria-label="required select" name="required_update"
                                    id="required_update">
                                    <option value="" selected>Select One</option>
                                    <option value="1">Is Requrired</option>
                                    <option value="0">Not Requrired</option>
                                </select>
                                <div id="required_update_invalid" class="invalid-feedback"></div>
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
        var documentTable;
        $(document).ready(function() {

            documentTable = $('#document').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('document.data') }}",
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'is_required',
                        name: 'is_required'
                    },
                    {
                        data: 'action', className: "dt-right",
                        name: 'action'
                    }
                ],
                columnDefs: [{

                }],
            });



            $('#add_document_form').on('submit', (e) => {
                e.preventDefault();
                let url = "{{ route('document.store') }}";
                let formData = new FormData(e.target);
                $.ajax({
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    url: url,
                    success: function success(data) {
                        $('#add_document_form').trigger("reset");
                        documentTable.ajax.reload();
                        modalHide('add_document_modal');
                        show_toastr('Success', 'Document successfully added.', 'success');
                    },
                    error: function error(data) {
                        handleFormValidation(data);
                        show_toastr('Error', 'Permission denied.', 'error');
                    }
                });
            });


            $('#document').on('draw.dt', function() {
                $('.document-delete').on('click', (e) => {
                    let document_id = e.currentTarget.dataset.id;
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
                                url: `{{ url('document') }}/${document_id}`,
                                success: function success(data) {
                                    documentTable.ajax.reload();
                                    show_toastr('Success', 'Document successfully deleted.', 'success');
                                },
                                error: function error(data) {
                                    console.error(data);
                                    show_toastr('Error', 'Permission denied.', 'error');
                                }
                            });
                        }
                    })
                });


                $('.document-edit').on('click', (e) => {
                    let document_id = e.currentTarget.dataset.id;
                    //console.log('fdfs');
                    $.ajax({
                        type: "get",
                        url: `{{ url('document') }}/${document_id}/edit`,
                        success: function success(data) {
                            //console.log(data.id);
                            $('#document_id').val(data.id);
                            $('#name_update').val(data.name);
                            $('#required_update').val(data.is_required);



                        },
                        error: function error(data) {
                            console.error(data);
                        }
                    });
                });


                $('#update_document_form').on('submit', (e) => {
                    e.preventDefault();

                    let document_id = $('#document_id').val();
                    //console.log(e.target);
                    let formData = new FormData(e.target);
                    $.ajax({
                        type: "post",
                        data: formData,
                        processData: false,
                        contentType: false,
                        url: `{{ url('document') }}/${document_id}`,
                        success: function success(data) {
                            documentTable.ajax.reload();
                            modalHide('edit_document_modal');
                            show_toastr('Success', 'Document successfully updated.', 'success');
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
