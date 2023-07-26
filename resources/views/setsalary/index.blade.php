@extends('layouts.app')
@section('page-title')
    {{ __('Set Salary') }}
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <p class="card-heading">Employee salaries</p>
            </div>
        </div>
        <div class="card-body">
            <table id="salary_table" class="table table-condensed">
                <thead>
                    <tr>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Designation</th>
                        <th>Date of Joining</th>
                        <th>Basic salary</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('js')
    <script>
        let loan_table = $('#salary_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('set-salary.data') }}",
            columns: [
                {
                    data: 'employee_id',
                    name: 'employee_id'
                },
                {
                    data: 'user.name',
                    name: 'user.name'
                },
                {
                    data: 'department.name',
                    name: 'department.name'
                },
                {
                    data: 'designation.name',
                    name: 'designation.name'
                },
                {
                    data: 'date_of_joining',
                    name: 'date_of_joining'
                },
                {
                    data: 'salary',
                    name: 'salary'
                },
                {
                    data: 'action', className: "dt-right",
                    name: 'action'
                }
            ],
            // columnDefs: [{
            //     "targets": [3],
            //     "createdCell": function(td, cellData, rowData, row, col) {
            //         if (rowData.type == 1) {
            //             $(td).html(cellData + '%');
            //         }
            //     }
            // }],
        });
    </script>
@endpush
