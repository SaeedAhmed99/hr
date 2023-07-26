@extends('layouts.app')

@section('page-title')
    {{ __('Genarate Salary') }}
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <p class="card-heading">Generate month's salary</p>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 col-12">
                    <x-year-selection id="salary_year" name="salary_year" :selected="date('Y')" />
                </div>
                <div class="col-md-3 col-12 ms-md-1 ms-0">
                    <x-month-selection id="salary_month" name="salary_month" />
                </div>
                <div class="col-md-3 col-12 align-self-end ms-md-1 ms-0 mt-md-0 mt-1">
                    <button class="btn btn-info" id="show_salary">Show</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            <p class="card-heading">Preview before salary generation</p>
        </div>
        <div class="card-body" id="salary_preview">
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-header">
            <p class="card-heading">Generated history</p>
        </div>
        <div class="card-body">

            <ul class="list-group">
                @foreach ($generated_salary_history as $generated)
                    <li class="list-group-item">
                        <a href="{{ route('monthly.salary.show') }}?month={{ $generated->salary_month->format('n') }}" class="d-flex gap-1 flex-md-row flex-column">
                            <div>
                                <span class="text-muted">Generated at:</span> {{ $generated->created_at->format('Y-m-d h:i a') }}
                            </div>
                            <div>
                                <span class="border-md-start text-muted ps-md-1">Salary month:</span> {{ $generated->salary_month->format('Y') }}, {{ $generated->salary_month->format('F') }}
                            </div>
                            <div>
                                <span class="border-md-start text-muted ps-md-1">Total employee:</span> {{ $generated->total_employee }}
                            </div>
                            <div>
                                <span class="border-md-start text-muted ps-md-1">Total salary:</span> {{ $generated->sum_earning / 100 }}
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $('#show_salary').on('click', () => {
            $.ajax({
                type: "get",
                data: {
                    year: $('#salary_year').val(),
                    month: $('#salary_month').val(),
                },
                url: `{{ route('monthly.salary.create') }}`,
                success: function success(data) {
                    $('#salary_preview').html(data);
                    $('#salary_preview_table').DataTable({
                        "paging": false
                    });
                    $('.generate-salary').on('click', generate_salary);
                    show_toastr('Success', 'Preview generated!.', 'success');
                },
                error: function error(data) {
                    if (data.status == 401) {
                        show_toastr('Error', 'Permission Denied!.', 'error');
                    } else {
                        $('#salary_preview').html("");
                        show_toastr('Error', 'This months salary already generated.', 'error');
                    }
                }
            });
        });

        let generate_salary = () => {
            $.ajax({
                type: "post",
                data: {
                    year: $('#salary_year').val(),
                    month: $('#salary_month').val(),
                },
                url: `{{ route('monthly.salary.store') }}`,
                success: function success(data) {
                    $('.generate-salary').attr('disabled', true);
                    show_toastr('success', 'Salary generated successfully!.', 'success');
                },
                error: function error(data) {
                    show_toastr('Error', 'This months salary already generated.', 'error');
                }
            });
        }
    </script>
@endpush
