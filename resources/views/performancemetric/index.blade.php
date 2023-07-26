@extends('layouts.app')
@section('page-title')
    {{ __('Performance Metric') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">All Performance Metric</p>
                        <button data-bs-toggle="modal" data-bs-target="#add_performancemetric_modal" class="btn btn-gray"><i
                                class="fa-solid fa-plus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="performancemetric" class="table table-condensed">
                        <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Performance Criteria') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    {{--  add modal start  --}}
    <div class="modal fade" tabindex="-1" id="add_performancemetric_modal">
        <div class="modal-dialog">
            <form action="" id="add_performancemetric_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Performance Metric</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <label for="performanceCriterion">
                                        Performance Criteria
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Branch select"
                                        name="performanceCriterion" id="performanceCriterion">
                                        <option value="" selected>Select Criteria</option>
                                        @foreach ($performanceCriterions as $performanceCriterion)
                                            <option value="{{ $performanceCriterion->id }}"> {{ $performanceCriterion->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="performanceCriterion_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="col-12 mt-2">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Name" aria-describedby="name_invalid">
                                    <div id="name_invalid" class="invalid-feedback"></div>
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
    <div class="modal fade" tabindex="-1" id="edit_performancemetric_modal">
        <div class="modal-dialog">
            <form action="" id="update_performancemetric_form">
                <input type="hidden" id="_method" name="_method" value="patch">
                <input type="hidden" name="performancemetric_id" id="performancemetric_id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Training Type</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <label for="performanceCriterion_update">
                                        Performance Criteria
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Branch select"
                                        name="performanceCriterion_update" id="performanceCriterion_update">
                                        <option value="" selected>Select Branch</option>
                                         @foreach ($performanceCriterions as $performanceCriterion)
                                            <option value="{{ $performanceCriterion->id }}"> {{ $performanceCriterion->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="performanceCriterion_update_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="col-12 mt-2">
                                    <label for="name_update" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name_update" name="name_update"
                                        placeholder="Name" aria-describedby="name_invalid">
                                    <div id="name_update_invalid" class="invalid-feedback"></div>
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
        $('#performanceCriterion').select2({
            dropdownParent: $('#add_performancemetric_modal'),
            width: 'style'
        });
        $('#performanceCriterion_update').select2({
            dropdownParent: $('#edit_performancemetric_modal'),
            width: 'style'
        });

        var performancemetricTable;
        $(document).ready(function() {

            performancemetricTable = $('#performancemetric').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('performance.metric.data') }}",
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'performance_criterion.name',
                        name: 'performance_criterion.name'
                    },
                    {
                        data: 'action', className: "dt-right",
                        name: 'action'
                    }
                ],
                columnDefs: [{

                }],
            });



            $('#add_performancemetric_form').on('submit', (e) => {
                e.preventDefault();
                let url = "{{ route('performance-metric.store') }}";
                let formData = new FormData(e.target);
                $.ajax({
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    url: url,
                    success: function success(data) {
                        $('#add_performancemetric_form').trigger("reset");
                        performancemetricTable.ajax.reload();
                        modalHide('add_performancemetric_modal');
                        show_toastr('Success', data, 'success');
                    },
                    error: function error(data) {
                        handleFormValidation(data);
                        show_toastr('Error', 'Permission denied.', 'error');
                    }
                });
            });


            $('#performancemetric').on('draw.dt', function() {
                $('.performancemetric-delete').on('click', (e) => {
                    let performancemetric = e.currentTarget.dataset.id;
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
                                url: `{{ url('performance-metric') }}/${performancemetric}`,
                                success: function success(data) {
                                    performancemetricTable.ajax.reload();
                                    show_toastr('Success', data, 'success');
                                },
                                error: function error(data) {
                                    console.error(data);
                                    show_toastr('Error', 'Permission denied.', 'error');
                                }
                            });
                        }
                    })
                });


                $('.performancemetric-edit').on('click', (e) => {
                    let performancemetric = e.currentTarget.dataset.id;
                    //console.log('fdfs');
                    $.ajax({
                        type: "get",
                        url: `{{ url('performance-metric') }}/${performancemetric}/edit`,
                        success: function success(data) {
                            //console.log(data.id);
                            $('#performancemetric_id').val(data.id);
                            $('#performanceCriterion_update').val(data.performance_criterion_id);
                            $('#performanceCriterion_update').trigger('change');
                            $('#name_update').val(data.name);
                        },
                        error: function error(data) {
                            console.error(data);
                        }
                    });
                });


                $('#update_performancemetric_form').on('submit', (e) => {
                    e.preventDefault();

                    let performancemetric_id = $('#performancemetric_id').val();
                    //console.log(e.target);
                    let formData = new FormData(e.target);
                    $.ajax({
                        type: "post",
                        data: formData,
                        processData: false,
                        contentType: false,
                        url: `{{ url('performance-metric') }}/${performancemetric_id}`,
                        success: function success(data) {
                            performancemetricTable.ajax.reload();
                            modalHide('edit_performancemetric_modal');
                            show_toastr('Success', data, 'success');
                        },
                        error: function error(data) {
                            handleFormValidation(data);
                            show_toastr('Error', 'Please Fill Up the field', 'error');
                        }
                    });
                });


            });
        });
    </script>
@endpush
