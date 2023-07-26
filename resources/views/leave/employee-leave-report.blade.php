@extends('layouts.app')
@section('page-title')
    {{ __('Employee Leave Report') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">Leave report</p>
                    </div>
                </div>
                <div class="card-body">
                    <x-year-selection/>
                    <div class="mt-3">
                        <table id="leave" class="table table-condensed">
                            <thead>
                                <tr>
                                    <th>{{ __('Employee') }}</th>
                                    <th>{{ __('Total Leave') }}</th>
                                    <th>{{ __('Total Approved') }}</th>
                                    <th>{{ __('Leave Remaining') }}</th>
                                    {{-- <th width="200px">{{ __('Action') }}</th> --}}
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        var leaveTable;
        $(document).ready(function() {
            leaveTable = $('#leave').DataTable({
                processing: true,
                serverSide: true,
                ajax: `{{ route('leave.report.data') }}?year=${$('#year').val()}`,
                columns: [{
                        data: 'user.name',
                        name: 'user.name'
                    },
                    {
                        data: 'totalLeave',
                        name: 'totalLeave'
                    },
                    {
                        data: 'approved',
                        name: 'approved'
                    },
                    {
                        data: 'leaveRemaining',
                        name: 'leaveRemaining'
                    },
                    // {
                    //     data: 'action',
                    //     name: 'action'
                    // }
                ],
                columnDefs: [{}],
            });

            $('#year').on('change', () => {
                leaveTable.ajax.url( `{{ route('leave.report.data') }}?year=${$('#year').val()}`).load();
            })
        });
    </script>
@endpush
