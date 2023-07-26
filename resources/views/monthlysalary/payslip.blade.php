@php
    $allowances = json_decode($paySlip->allowance);
    $commissions = json_decode($paySlip->commission);
    $deductions = json_decode($paySlip->deduction);
    $loans = json_decode($paySlip->loan);
    $salary = $paySlip->basic_salary;
@endphp
<div class="d-flex justify-content-center">
    <div class="text-center mb-5">
        <h1>{{ setting('company_title') }}</h1>
    </div>
</div>
<div class="d-flex justify-content-between mb-5">
    <div class="">
        <h5 class="text-muted">Employee details:</h5>
        <p class="p-0 m-0"><i class="fa-regular fa-user"></i> {{ $paySlip->employee->user->name }} ({{ $paySlip->employee->designation->name }})</p>
        <p class="p-0 m-0"><i class="fa-regular fa-envelope"></i> {{ $paySlip->employee->user->email }}</p>
        <p class="p-0 m-0"><i class="fa-regular fa-building"></i> {{ $paySlip->employee->branch->name }} Branch</p>
        <p class="p-0 m-0"><i class="fa-solid fa-briefcase"></i> {{ $paySlip->employee->department->name }} Department</p>
    </div>
    <div class="">
        <h5 class="text-muted">Payslip details:</h5>
        <p class="p-0 m-0">For month: {{ $paySlip->salary_month->format('F') }}</p>
        <p class="p-0 m-0">Payslip created at: {{ $paySlip->created_at->format('Y-m-d') }}</p>
        <p class="p-0 m-0">{{ $paySlip->employee->department->name }} Department</p>
    </div>
</div>
<div class="mt-5 d-flex justify-content-between">
    <p>Basic salary:</p>
    <p class="p-0 m-0">{{ number_format($paySlip->basic_salary) }} /-</p>
</div>

@foreach ($allowances as $allowance)
    <div class="d-flex justify-content-between">
        <p>{{ $allowance->title }}:</p>
        <p class="p-0 m-0">{{ number_format($allowance->amount) }} /-</p>
    </div>
    @php $salary += $allowance->amount; @endphp
@endforeach

@foreach ($commissions as $commission)
    <div class="d-flex justify-content-between">
        <p>{{ $commission->title }}:</p>
        <p class="p-0 m-0">{{ number_format($commission->amount) }} /-</p>
    </div>
    @php $salary += $commission->amount; @endphp
@endforeach
<hr>
<div class="d-flex justify-content-between">
    <p>Total Earning:</p>
    <p class="p-0 m-0">{{ number_format($salary) }} /-</p>
</div>
@foreach ($deductions as $deduction)
    <div class="d-flex justify-content-between">
        <p>{{ $deduction->title }}:</p>
        <p class="p-0 m-0">{{ number_format($deduction->amount) }} /-</p>
    </div>
    @php $salary -= $deduction->amount; @endphp
@endforeach

@foreach ($loans as $loan)
    @php
        $loanType = \App\Models\LoanType::find($loan->loan_type_id);
    @endphp
    <div class="d-flex justify-content-between">
        <p>{{ $loanType->name }}:</p>
        <p class="p-0 m-0">{{ number_format($loan->installment_amount) }} /-</p>
    </div>
    @php $salary -= $loan->amount; @endphp
@endforeach
<hr>
<div class="d-flex justify-content-between">
    <p>Net Payable:</p>
    <p class="p-0 m-0">{{ number_format($salary) }} /-</p>
</div>
