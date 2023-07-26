@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <h2>Setting salary of <i>{{ $employee->user->name }} (#EMP{{ sprintf('%05d', $employee->employee_id) }})</i></h2>
        </div>
        <div class="col-xxl-6 col-12">
            <div class="card">
                <div class="card-header">
                    <p class="card-heading">Basic salary</p>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <input class="form-control" type="number" name="basic_salary" id="basic_salary" placeholder="Basic salary" disabled value="{{ $employee->salary }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-6 col-12 mt-xl-0 mt-2">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">Allowance</p>
                        <button id="add_allowance" data-bs-toggle="modal" data-bs-target="#add_allowance_modal" class="btn btn-gray"><i class="fa-solid fa-plus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="employee_allowance" class="table table-condensed">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Allowance type</th>
                                <th>Title</th>
                                <th>Amount</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xxl-6 col-12 mt-2">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">Commission</p>
                        <button id="add_commission" data-bs-toggle="modal" data-bs-target="#add_commission_modal" class="btn btn-gray"><i class="fa-solid fa-plus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="employee_commission" class="table table-condensed">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Recurrence</th>
                                <th>Title</th>
                                <th>Amount</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xxl-6 col-12 mt-2">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">Deduction</p>
                        <button id="add_deduction" data-bs-toggle="modal" data-bs-target="#add_deduction_modal" class="btn btn-gray"><i class="fa-solid fa-plus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="employee_deduction" class="table table-condensed">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Recurrence</th>
                                <th>Title</th>
                                <th>Amount</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="add_commission_modal">
        <div class="modal-dialog">
            <form action="" id="add_commission_form">
                <input type="hidden" id="_commission_method" name="_method" value="post">
                <input type="hidden" name="employee" value="{{ $employee->id }}">
                <input type="hidden" id="commission_id" name="commission_id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Commission</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="col-12 mt-3">
                                    <label for="commission_title" class="form-label">Commission title</label>
                                    <input type="text" class="form-control" id="commission_title" name="commission_title" placeholder="Title" aria-describedby="commission_title_invalid">
                                    <div id="commission_title_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="col-12 mt-3">
                                    <label for="commission_type"> Type* </label>
                                    <select name="commission_type" id="commission_type" class="form-control" aria-describedby="commission_type_invalid">
                                        <option value="0">Fixed</option>
                                        <option value="1">Percentage</option>
                                    </select>
                                    <div id="commission_type_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="col-12 mt-3">
                                    <label for="commission_recurring"> Recurrance* </label>
                                    <select name="commission_recurring" id="commission_recurring" class="form-control" aria-describedby="commission_recurring_invalid">
                                        <option value="0">One Time</option>
                                        <option value="1">Recurring</option>
                                    </select>
                                    <div id="commission_recurring_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="col-12 mt-3">
                                    <label for="commission_amount" class="form-label">Amount</label>
                                    <input type="number" class="form-control" id="commission_amount" name="commission_amount" placeholder="Amount" aria-describedby="commission_amount_invalid">
                                    <div id="commission_amount_invalid" class="invalid-feedback"></div>
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

    <div class="modal fade" tabindex="-1" id="add_allowance_modal">
        <div class="modal-dialog">
            <form action="" id="add_allowance_form">
                <input type="hidden" id="_method" name="_method" value="post">
                <input type="hidden" name="employee" value="{{ $employee->id }}">
                <input type="hidden" id="allowance_id" name="allowance_id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Allowance</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <label for="allowance_type">
                                    Allowances*
                                </label>
                                <select style="width: 100%" class="form-select" aria-label="Allowance select" name="allowance_type" id="allowance_type">
                                    <option value="" selected>Select allowance</option>
                                    @foreach ($allowance_options as $allowance)
                                        <option value="{{ $allowance->id }}">{{ $allowance->name }}</option>
                                    @endforeach
                                </select>
                                <div id="allowance_type_invalid" class="invalid-feedback"></div>
                                <div class="col-12 mt-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" placeholder="Title" aria-describedby="title_invalid">
                                    <div id="title_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="col-12 mt-3">
                                    <label for="type"> Type* </label>
                                    <select name="type" id="type" class="form-control" aria-describedby="type_invalid">
                                        <option value="0">Fixed</option>
                                        <option value="1">Percentage</option>
                                    </select>
                                    <div id="type_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="col-12 mt-3">
                                    <label for="amount" class="form-label">Amount</label>
                                    <input type="number" class="form-control" id="amount" name="amount" placeholder="Amount" aria-describedby="amount_invalid">
                                    <div id="amount_invalid" class="invalid-feedback"></div>
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

    <div class="modal fade" tabindex="-1" id="add_deduction_modal">
        <div class="modal-dialog">
            <form action="" id="add_deduction_form">
                <input type="hidden" id="_deduction_method" name="_method" value="post">
                <input type="hidden" name="employee" value="{{ $employee->id }}">
                <input type="hidden" id="deduction_id" name="deduction_id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Deduction</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="col-12 mt-3">
                                    <label for="deduction_title" class="form-label">Deduction title</label>
                                    <input type="text" class="form-control" id="deduction_title" name="deduction_title" placeholder="Title" aria-describedby="deduction_title_invalid">
                                    <div id="deduction_title_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="col-12 mt-3">
                                    <label for="deduction_type"> Type* </label>
                                    <select name="deduction_type" id="deduction_type" class="form-control" aria-describedby="deduction_type_invalid">
                                        <option value="0">Fixed</option>
                                        <option value="1">Percentage</option>
                                    </select>
                                    <div id="deduction_type_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="col-12 mt-3">
                                    <label for="deduction_recurring"> Recurrance* </label>
                                    <select name="deduction_recurring" id="deduction_recurring" class="form-control" aria-describedby="deduction_recurring_invalid">
                                        <option value="0">One Time</option>
                                        <option value="1">Recurring</option>
                                    </select>
                                    <div id="deduction_recurring_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="col-12 mt-3">
                                    <label for="deduction_amount" class="form-label">Amount</label>
                                    <input type="number" class="form-control" id="deduction_amount" name="deduction_amount" placeholder="Amount" aria-describedby="deduction_amount_invalid">
                                    <div id="deduction_amount_invalid" class="invalid-feedback"></div>
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
        var allowanceTable;
        var commissionTable;
        var deductionTable;
        $(document).ready(function() {
            $('#allowance_type').select2({
                dropdownParent: $('#add_allowance_modal'),
                width: 'style'
            });

            allowanceTable = $('#employee_allowance').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('employee.allowance.data', ['employee' => $employee->id]) }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'allowance_option.name',
                        name: 'allowance_option.name'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action', className: "dt-right",
                        name: 'action'
                    }
                ],
                columnDefs: [{
                    "targets": [3],
                    "createdCell": function(td, cellData, rowData, row, col) {
                        if (rowData.type == 1) {
                            $(td).html(cellData + '%');
                        }
                    }
                }],
            });

            commissionTable = $('#employee_commission').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('employee.commission.data', ['employee' => $employee->id]) }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'recurring',
                        name: 'recurring'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action', className: "dt-right",
                        name: 'action'
                    }
                ],
                columnDefs: [{
                        "targets": [3],
                        "createdCell": function(td, cellData, rowData, row, col) {
                            if (rowData.type == 1) {
                                $(td).html(cellData + '%');
                            }
                        }
                    },{
                        "targets": [2],
                        "createdCell": function(td, cellData, rowData, row, col) {
                            if (rowData.type == 0) {
                                $(td).html("One Time");
                            }else{
                                $(td).html("Recurring");
                            }
                        }
                    }
                ],
            });

            deductionTable = $('#employee_deduction').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('employee.deduction.data', ['employee' => $employee->id]) }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'recurring',
                        name: 'recurring'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action', className: "dt-right",
                        name: 'action'
                    }
                ],
                columnDefs: [{
                        "targets": [3],
                        "createdCell": function(td, cellData, rowData, row, col) {
                            if (rowData.type == 1) {
                                $(td).html(cellData + '%');
                            }
                        }
                    },{
                        "targets": [2],
                        "createdCell": function(td, cellData, rowData, row, col) {
                            if (rowData.type == 0) {
                                $(td).html("One Time");
                            }else{
                                $(td).html("Recurring");
                            }
                        }
                    }
                ],
            });
        });

        $('#add_allowance_form').on('submit', (e) => {
            e.preventDefault();
            let allowance_store = "{{ route('set.allowance.store', $employee->id) }}";
            let url = "";
            let formData = new FormData(e.target);
            if(formData.get('_method') == 'post'){
                url = allowance_store;
            }else{
                url = `{{ url('set-allowance') }}/${$('#allowance_id').val()}`
            }
            $.ajax({
                type: "post",
                data: formData,
                processData: false,
                contentType: false,
                url: url,
                success: function success(data) {
                    allowanceTable.ajax.reload();
                    modalHide('add_allowance_modal');
                },
                error: function error(data) {
                    handleFormValidation(data);
                }
            });
        });

        $('#add_allowance').on('click', function() {
            $('#_method').val('post');
            $('#title').val('');
            $('#amount').val('');
        });

        $('#employee_allowance').on('draw.dt', function() {
            $('.allowance-delete').on('click', (e) => {
                let allowance = e.currentTarget.dataset.id;
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
                            url: `{{ url('set-allowance') }}/${allowance}`,
                            success: function success(data) {
                                allowanceTable.ajax.reload();
                            },
                            error: function error(data) {
                                console.error(data);
                            }
                        });
                    }
                })
            });

            $('.allowance-edit').on('click', (e) => {
                let allowance = e.currentTarget.dataset.id;
                $.ajax({
                    type: "get",
                    url: `{{ url('set-allowance/show') }}/${allowance}`,
                    success: function success(data) {
                        $('#_method').val("patch");
                        $('#title').val(data.title);
                        $('#amount').val(data.amount);
                        $('#type').val(data.type);
                        $('#allowance_id').val(allowance);
                        $('#allowance_type').val(data.allowance_option_id);
                        $('#allowance_type').trigger('change');
                    },
                    error: function error(data) {
                        console.error(data);
                    }
                });
            });
        });

        $('#add_commission_form').on('submit', (e) => {
            e.preventDefault();
            let commission_store = "{{ route('set.commission.store', $employee->id) }}";
            let url = "";

            let formData = new FormData(e.target);

            if(formData.get('_method') == 'post'){
                url = commission_store;
            }else{
                url = `{{ url('set-commission') }}/${$('#commission_id').val()}`
            }

            $.ajax({
                type: "post",
                data: formData,
                processData: false,
                contentType: false,
                url: url,
                success: function success(data) {
                    commissionTable.ajax.reload();
                    modalHide('add_commission_modal');
                },
                error: function error(data) {
                    handleFormValidation(data);
                }
            });
        });

        $('#add_commission').on('click', function() {
            $('#_commission_method').val('post');
            $('#commission_title').val('');
            $('#commission_amount').val('');
        });

        $('#employee_commission').on('draw.dt', function() {
            $('.commission-delete').on('click', (e) => {
                let commission = e.currentTarget.dataset.id;
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
                            url: `{{ url('set-commission') }}/${commission}`,
                            success: function success(data) {
                                commissionTable.ajax.reload();
                            },
                            error: function error(data) {
                                console.error(data);
                            }
                        });
                    }
                })
            });

            $('.commission-edit').on('click', (e) => {
                let commission = e.currentTarget.dataset.id;
                $.ajax({
                    type: "get",
                    url: `{{ url('set-commission/show') }}/${commission}`,
                    success: function success(data) {
                        $('#_commission_method').val("patch");
                        $('#commission_title').val(data.title);
                        $('#commission_amount').val(data.amount);
                        $('#commission_type').val(data.type);
                        $('#commission_recurring').val(data.recurring);
                        $('#commission_id').val(commission);
                    },
                    error: function error(data) {
                        console.error(data);
                    }
                });
            });
        });

        $('#add_deduction_form').on('submit', (e) => {
            e.preventDefault();
            let deduction_store = "{{ route('set.deduction.store', $employee->id) }}";
            let url = "";

            let formData = new FormData(e.target);

            if(formData.get('_method') == 'post'){
                url = deduction_store;
            }else{
                url = `{{ url('set-deduction') }}/${$('#deduction_id').val()}`
            }

            $.ajax({
                type: "post",
                data: formData,
                processData: false,
                contentType: false,
                url: url,
                success: function success(data) {
                    deductionTable.ajax.reload();
                    modalHide('add_deduction_modal');
                },
                error: function error(data) {
                    handleFormValidation(data);
                }
            });
        });

        $('#add_deduction').on('click', function() {
            $('#_deduction_method').val('post');
            $('#deduction_title').val('');
            $('#deduction_amount').val('');
        });

        $('#employee_deduction').on('draw.dt', function() {
            $('.deduction-delete').on('click', (e) => {
                let deduction = e.currentTarget.dataset.id;
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
                            url: `{{ url('set-deduction') }}/${deduction}`,
                            success: function success(data) {
                                deductionTable.ajax.reload();
                            },
                            error: function error(data) {
                                console.error(data);
                            }
                        });
                    }
                })
            });

            $('.deduction-edit').on('click', (e) => {
                let deduction = e.currentTarget.dataset.id;
                $.ajax({
                    type: "get",
                    url: `{{ url('set-deduction/show') }}/${deduction}`,
                    success: function success(data) {
                        $('#_deduction_method').val("patch");
                        $('#deduction_title').val(data.title);
                        $('#deduction_amount').val(data.amount);
                        $('#deduction_type').val(data.type);
                        $('#deduction_recurring').val(data.recurring);
                        $('#deduction_id').val(deduction);
                    },
                    error: function error(data) {
                        console.error(data);
                    }
                });
            });
        });


    </script>
@endpush
