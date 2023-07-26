@extends('layouts.app')
@section('page-title')
    {{ __('Ip Restrict') }}
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">All Ip Address</p>
                        <button data-bs-toggle="modal" data-bs-target="#add_ipRestrict_modal" class="btn btn-gray"><i
                                class="fa-solid fa-plus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="ipRestrict" class="table table-condensed">
                        <thead>
                            <tr>
                                <th>{{ __('Ip') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    {{--  add modal start  --}}
    <div class="modal fade" tabindex="-1" id="add_ipRestrict_modal">
        <div class="modal-dialog">
            <form action="" id="add_ipRestrict_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Ip Address</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <label for="ip" class="form-label">Ip Address</label>
                                <input type="text" class="form-control" id="ip" name="ip"
                                    placeholder="Enter a IP" aria-describedby="ip_invalid">
                                <div id="ip_invalid" class="invalid-feedback"></div>
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
    <div class="modal fade" tabindex="-1" id="edit_ipRestrict_modal">
        <div class="modal-dialog">
            <form action="" id="update_ipRestrict_form">
                <input type="hidden" id="_method" name="_method" value="patch">
                <input type="hidden" name="ipRestrict_id" id="ipRestrict_id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Ip Address</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <label for="ip_update" class="form-label">Ip</label>
                                <input type="text" class="form-control" id="ip_update" name="ip_update"
                                    placeholder="Ip" aria-describedby="name_invalid">
                                <div id="ip_update_invalid" class="invalid-feedback"></div>
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
        var ipRestrictTable;
        $(document).ready(function() {

            ipRestrictTable = $('#ipRestrict').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('ip.data') }}",
                columns: [{
                        data: 'ip',
                        name: 'ip'
                    },
                    {
                        data: 'action', className: "dt-right",
                        name: 'action'
                    }
                ],
                columnDefs: [{

                }],
            });



            $('#add_ipRestrict_form').on('submit', (e) => {
                e.preventDefault();
                let url = "{{ route('ip-restrict.store') }}";
                let formData = new FormData(e.target);
                $.ajax({
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    url: url,
                    success: function success(data) {
                        $('#add_ipRestrict_form').trigger("reset");
                        ipRestrictTable.ajax.reload();
                        modalHide('add_ipRestrict_modal');
                        show_toastr('Success', 'Ip successfully added.', 'success');
                    },
                    error: function error(data) {
                        handleFormValidation(data);
                        show_toastr('Error', 'Permission denied.', 'error');
                    }
                });
            });


            $('#ipRestrict').on('draw.dt', function() {
                $('.ipRestrict-delete').on('click', (e) => {
                    let ipRestrict = e.currentTarget.dataset.id;
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
                                url: `{{ url('ip-restrict') }}/${ipRestrict}`,
                                success: function success(data) {
                                    ipRestrictTable.ajax.reload();
                                    show_toastr('Success', 'Job Category successfully deleted.', 'success');
                                },
                                error: function error(data) {
                                    console.error(data);
                                    show_toastr('Error', 'Permission denied.', 'error');
                                }
                            });
                        }
                    })
                });


                $('.ipRestrict-edit').on('click', (e) => {
                    let ipRestrict = e.currentTarget.dataset.id;
                    //console.log('fdfs');
                    $.ajax({
                        type: "get",
                        url: `{{ url('ip-restrict') }}/${ipRestrict}/edit`,
                        success: function success(data) {
                            //console.log(data.id);
                            $('#ipRestrict_id').val(data.id);
                            $('#ip_update').val(data.ip);



                        },
                        error: function error(data) {
                            console.error(data);
                        }
                    });
                });


                $('#update_ipRestrict_form').on('submit', (e) => {
                    e.preventDefault();

                    let ipRestrict_id = $('#ipRestrict_id').val();
                    //console.log(e.target);
                    let formData = new FormData(e.target);
                    $.ajax({
                        type: "post",
                        data: formData,
                        processData: false,
                        contentType: false,
                        url: `{{ url('ip-restrict') }}/${ipRestrict_id}`,
                        success: function success(data) {
                            ipRestrictTable.ajax.reload();
                            modalHide('edit_ipRestrict_modal');
                            show_toastr('Success', 'Ip successfully updated.', 'success');
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
