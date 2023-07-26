@can('Create Generate Salary')
    <button class="btn btn-primary generate-salary mb-md-0 mb-2">Generate</button>
@endcan
<table id="salary_preview_table" class="table table-condensed">
    <thead>
        <tr>
            <th>Name</th>
            <th>Designation</th>
            <th>Date of Joining</th>
            <th>Payment Type</th>
            <th>Basic Salary</th>
            <th>Comission</th>
            <th>Allowance</th>
            <th>Total Earning</th>
            <th>Deduction</th>
            <th>Loan</th>
            <th>Net Payable</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($salaries as $salary)
            <tr>
                <td> {{ $salary['data']->user->name }} </td>
                <td> {{ $salary['data']->designation->name }} </td>
                <td> {{ $salary['data']->date_of_joining }} </td>
                <td> {{ $salary['data']->salary_receive_type == '0' ? 'Cash' : 'Bank' }} </td>
                <td> {{ $salary['data']->salary }} </td>
                <td> {{ $salary['commission'] }} </td>
                <td> {{ $salary['allowance'] }} </td>
                <td> {{ $salary['data']->salary + $salary['commission'] + $salary['allowance'] }} </td>
                <td> {{ $salary['deduction'] }} </td>
                <td> {{ $salary['loan'] }} </td>
                <td> {{ $salary['data']->salary + $salary['commission'] + $salary['allowance'] - ($salary['deduction'] + $salary['loan']) }} </td>
            </tr>
        @endforeach
    </tbody>
</table>
