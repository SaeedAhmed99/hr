@extends('layouts.app')

{{--  <a type="button" class="btn btn-primary" href="{{ route('jobstage.create') }}">Create Job Stage</a>  --}}

@section('content')
 <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">All Job Category</p>
                        <a  href="{{ route('jobstage.create') }}" class="btn btn-gray"><i
                                class="fa-solid fa-plus"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-group conversations-list sortable">
                @foreach ($jobstages as $jobstage)
                    <li class="list-group-item border-0 d-flex justify-content-between " data-id="{{ $jobstage->id }}">

                        <div class="d-flex justify-content-start">
                            <h6 class=" pe-3 ps-0 mb-0 "> {{ $jobstage->name }}</h6>

                        </div>
                        <div class="d-flex ">
                            <div>
                                @can('Edit Job Stage')
                                    <a type="button" href="{{ route('jobstage.edit', $jobstage->id) }}"
                                        class="btn btn-info">Edit</a>
                                @endcan
                            </div>
                            <div>
                                @can('Delete Job Stage')
                                    <form action="{{ route('jobstage.destroy', $jobstage->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <a href="#" type="button" class="btn btn-danger bs-pass-para">Delete</a>
                                    </form>
                                @endcan
                            </div>

                        </div>
                    </li>
                @endforeach

            </ul>

            <small class="text-muted"> {{ __('Note') }}
                :{{ __('You can easily order change of job stage using drag & drop.') }}</small>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('js')
<script src="{{ asset('js/jquery-ui.js') }}"></script>

<script>
    $(function() {
        $(".sortable").sortable();
        $(".sortable").disableSelection();
        $(".sortable").sortable({
            stop: function() {
                var order = [];
                $(this).find('li').each(function(index, data) {
                    order[index] = $(data).attr('data-id');
                });

                $.ajax({
                    url: "{{ route('jobstage.order') }}",
                    data: {
                        order: order,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    success: function(data) {},
                    error: function(data) {
                        data = data.responseJSON;
                        toastr('Error', data.error, 'error')
                    }
                })
            }
        });
    });
</script>

@endpush

