@extends('layouts.app')
@section('page-title')
    {{ __('Loan') }}
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <p class="card-heading">Loans</p>
                @can('Create Loan')
                    <button id="add_loan" data-bs-toggle="modal" data-bs-target="#add_loan_modal" class="btn btn-gray"><i class="fa-solid fa-plus"></i></button>
                @endcan
            </div>
        </div>
        <div class="card-body">
            <table id="loan_table" class="table table-condensed">
                <thead>
                    <tr>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Loan type</th>
                        <th>Payable amount</th>
                        <th>Installment month</th>
                        <th>Per installment</th>
                        <th>Paid amount</th>
                        <th>Activation date</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="add_loan_modal">
        <div class="modal-dialog modal-lg">
            <form action="" id="add_loan_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Loan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="col-12 mt-3">
                                    <label for="employee">
                                        Employee*
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Employee select" name="employee" id="employee">
                                        <option value="" selected>Select employee</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->user->name }}</option>
                                        @endforeach
                                    </select>
                                    <div id="employee_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="col-12 mt-3">
                                    <label for="employee">
                                        Loan Type*
                                    </label>
                                    <select style="width: 100%" class="form-select" aria-label="Loan type select" name="loan_type" id="loan_type">
                                        <option value="" selected>Select Loan Type</option>
                                        @foreach ($loan_types as $loan_type)
                                            <option value="{{ $loan_type->id }}">{{ $loan_type->name }}</option>
                                        @endforeach
                                    </select>
                                    <div id="employee_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="col-12 mt-3">
                                    <label for="loan_amount" class="form-label">Loan Amount</label>
                                    <input type="number" class="form-control" id="loan_amount" name="loan_amount" placeholder="Loan Amount" aria-describedby="loan_amount_invalid">
                                    <div id="loan_amount_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="col-12 mt-3">
                                    <label for="payable_amount" class="form-label">Total payable</label>
                                    <input type="number" class="form-control per-installment" id="payable_amount" name="payable_amount" placeholder="Total payable" aria-describedby="payable_amount_invalid">
                                    <div id="payable_amount_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="col-12 mt-3">
                                    <label for="installment_month" class="form-label">Installment month</label>
                                    <input type="text" class="form-control per-installment" id="installment_month" name="installment_month" placeholder="Installment month" aria-describedby="installment_month_invalid">
                                    <div id="installment_month_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="col-12 mt-3">
                                    <label for="per_installment_amount" class="form-label">Per installment amount</label>
                                    <input type="number" class="form-control" id="per_installment_amount" name="per_installment_amount" placeholder="Per installment amount" aria-describedby="per_installment_amount_invalid" disabled>
                                    <div id="per_installment_amount_invalid" class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="col-12 mt-3">
                                    <label for="reference_by" class="form-label">Reference by</label>
                                    <input type="text" class="form-control" id="reference_by" name="reference_by" placeholder="Reference by" aria-describedby="reference_by_invalid">
                                    <div id="reference_by_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="col-12 mt-3">
                                    <label for="reason" class="form-label">Reason</label>
                                    <input type="text" class="form-control" id="reason" name="reason" placeholder="Reason" aria-describedby="reason_invalid">
                                    <div id="reason_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="col-12 mt-3">
                                    <label for="activation_date" class="form-label">Activation date</label>
                                    <input type="text" class="form-control datepicker" id="activation_date" name="activation_date" placeholder="Activation date" aria-describedby="activation_date_invalid">
                                    <div id="activation_date_invalid" class="invalid-feedback"></div>
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
        $(function() {
            $(".datepicker").datepicker({
                dateFormat: "yy-mm-dd"
            });
        });

        $('#employee').select2({
            dropdownParent: $('#add_loan_modal'),
            width: 'style'
        });

        $('#loan_type').select2({
            dropdownParent: $('#add_loan_modal'),
            width: 'style'
        });

        let loan_table = $('#loan_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('loan.data') }}",
            columns: [{
                    data: 'employee.id',
                    name: 'employee.id'
                },{
                    data: 'employee.user.name',
                    name: 'employee.user.name'
                },
                {
                    data: 'loan_type.name',
                    name: 'loan_type.name'
                },
                {
                    data: 'payable_amount',
                    name: 'payable_amount'
                },
                {
                    data: 'installment_month',
                    name: 'installment_month'
                },
                {
                    data: 'installment_amount',
                    name: 'installment_amount'
                },
                {
                    data: 'paid_amount',
                    name: 'paid_amount'
                },
                {
                    data: 'activation_date',
                    name: 'activation_date'
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

        $('#add_loan_form').on('submit', (e) => {
            e.preventDefault();
            let formData = new FormData(e.target);
            $.ajax({
                type: "post",
                data: formData,
                processData: false,
                contentType: false,
                url: "{{ route('loan.store') }}",
                success: function success(data) {
                    loan_table.ajax.reload();
                    modalHide('add_loan_modal');
                },
                error: function error(data) {
                    handleFormValidation(data);
                }
            });
        });

        let calculatePerInstallment = () => {
            let totalPayable = $('#payable_amount').val();
            let installmentMonth = $('#installment_month').val();
            if (totalPayable != '' && installmentMonth != '') {
                $('#per_installment_amount').val(totalPayable / installmentMonth);

            }
        }

        $('.per-installment').on('keyup', calculatePerInstallment);
    </script>
@endpush
