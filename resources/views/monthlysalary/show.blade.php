@extends('layouts.app')
@section('page-title')
    {{ __('View Genarate Salary') }}
@endsection
@push('head')
    <style>
        .payslip > i {
            width: 20px;
            height: 20px;
            font-size: 0.5rem;
        }
        #salary_table{
            width:100%;
        }
    </style>
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <p class="card-heading">Show Salary</p>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-3 col-12">
                    <x-year-selection id="salary_year" name="salary_year" :selected="date('Y')" />
                </div>
                <div class="col-md-3 col-12">
                    <x-month-selection id="salary_month" name="salary_month" :selected="$selected_month" />
                </div>
            </div>
            <table id="salary_table" class="table table-striped">
                <thead>
                    <tr>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Salary Month</th>
                        <th>Payment Type</th>
                        <th>Net Payable</th>
                        <th>Basic Salary</th>
                        <th>Comission</th>
                        <th>Allowance</th>
                        <th>Total Earning</th>
                        <th>Deduction</th>
                        <th>Loan</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="salarySlip" tabindex="-1" aria-labelledby="salarySlipLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                {{-- <div class="modal-header">
                    <h5 class="modal-title" id="salarySlipLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> --}}
                <div class="modal-body p-2 payslip" id="salarySlipBody">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary print">Print</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        let allowanceTable;

        $('.print').on('click', () => {
            $('#salarySlipBody').printThis();
        });

        let show_payslip = (e) => {
            let slip = e.currentTarget.dataset.id;
            console.log(slip);
            $.ajax({
                type: "get",
                url: `{{ url('monthly-salary/show') }}/${slip}`,
                success: function success(data) {
                    $('#salarySlipBody').html(data);
                    $('#salarySlip').modal('show');
                    // notice_table.ajax.reload();
                    // show_toastr('Success', data, 'success');
                },
                error: function error(data) {
                    show_toastr('Error', data.responseJSON.message, 'error');
                }
            });
        }

        $('#salary_table').on('draw.dt', function() {

            $('.show-payslip').on('click', show_payslip);

            allowanceTable.on('responsive-display', function(e, datatable, row, showHide, update) {
                $('.show-payslip').on('click', show_payslip);
            });
        });
        $(document).ready(() => {
            // alert($('#salary_table').innter);
            let year = $('#salary_year').val();
            let month = $('#salary_month').val();
            // console.log(year, month);
            allowanceTable = $('#salary_table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: `{{ url('data/monthly-salary') }}/${year}/${month}`,
                columns: [{
                        data: 'employee_id',
                        name: 'employee_id'
                    },
                    {
                        data: 'employee.user.name',
                        name: 'employee.user.name'
                    },
                    {
                        data: 'employee.designation.name',
                        name: 'employee.designation.name'
                    },
                    {
                        data: 'salary_month',
                        name: 'salary_month'
                    },
                    {
                        data: 'employee.salary_receive_type',
                        name: 'employee.salary_receive_type'
                    },
                    {
                        data: 'net_payable',
                        name: 'net_payable'
                    },
                    {
                        data: 'basic_salary',
                        name: 'basic_salary'
                    },
                    {
                        data: 'commission',
                        name: 'commission'
                    },
                    {
                        data: 'allowance',
                        name: 'allowance'
                    },
                    {
                        data: 'total_earning',
                        name: 'total_earning'
                    },
                    {
                        data: 'deduction',
                        name: 'deduction'
                    },
                    {
                        data: 'loan',
                        name: 'loan'
                    },
                    {
                        data: 'action', className: "dt-right",
                        name: 'action'
                    }
                ],
                dom: '<"d-flex justify-content-end"<"mb-2"B>><"container-fluid"<"row"<"col"l><"col"f>>>rtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ],
                "lengthChange": true
            });
        });

        let changeSalaryTable = () => {
            let year = $('#salary_year').val();
            let month = $('#salary_month').val();
            allowanceTable.ajax.url(`{{ url('data/monthly-salary') }}/${year}/${month}`).load();
        }

        $('#salary_year').on('change', changeSalaryTable);
        $('#salary_month').on('change', changeSalaryTable);
    </script>
@endpush
