@extends('layouts.app')
@section('page-title')
    {{ __('Holiday') }}
@endsection
@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">Weekly holiday</p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="">
                            <form action="" id="weekend_form">
                                <input type="hidden" name="_method" value="patch">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="weekend[]" type="checkbox" id="saturday" value="saturday" {{ (!empty($weekends) AND in_array('saturday', $weekends)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="saturday">Saturday</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="weekend[]" type="checkbox" id="sunday" value="sunday" {{ (!empty($weekends) AND in_array('sunday', $weekends)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="sunday">Sunday</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="weekend[]" type="checkbox" id="monday" value="monday" {{ (!empty($weekends) AND in_array('monday', $weekends)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="monday">Monday</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="weekend[]" type="checkbox" id="tuesday" value="tuesday" {{ (!empty($weekends) AND in_array('tuesday', $weekends)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="tuesday">Tuesday</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="weekend[]" type="checkbox" id="wednesday" value="wednesday" {{ (!empty($weekends) AND in_array('wednesday', $weekends)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="wednesday">Wednesday</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="weekend[]" type="checkbox" id="thursday" value="thursday" {{ (!empty($weekends) AND in_array('thursday', $weekends)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="thursday">Thursday</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="weekend[]" type="checkbox" id="friday" value="friday" {{ (!empty($weekends) AND in_array('friday', $weekends)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="friday">Friday</label>
                                </div>
                            </form>
                        </div>
                        <div>
                            @can('Create Holiday')
                                <button id="update_weekends" class="btn btn-gray"><i class="fa-solid fa-check"></i> Save</button>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">Holidays</p>
                        @can('Create Holiday')
                            <button data-bs-toggle="modal" data-bs-target="#add_holiday_modal" class="btn btn-gray"><i class="fa-solid fa-plus"></i></button>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    @php
                        $current_year = now()->format('Y');
                    @endphp
                    <x-year-selection :selected="$current_year" />
                    <h5 class="mt-3">Holidays</h5>
                    <div id="holidays_div"></div>
                </div>
            </div>
        </div>
    </div>

    {{--  add modal start  --}}
    <div class="modal fade" tabindex="-1" id="add_holiday_modal">
        <div class="modal-dialog modal-lg">
            <form action="" id="add_holiday_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Holiday</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <button type="button" class="btn btn-info btn-xs mb-1 add-new">Add new <i class="fas fa-plus"></i></button>
                        <div id="holiday_add_form">
                            <div class="form-group d-flex gap-2">
                                <div>
                                    <label for="holidate.0" class="form-label">Holidate</label>
                                    <input type="text" class="form-control datepicker" id="holidate.0 " name="holidate[]" placeholder="Holidate" aria-describedby="holidate.0_invalid" autocomplete="off">
                                    <div id="holidate.0_invalid" class="invalid-feedback"></div>
                                </div>
                                <div>
                                    <label for="name.0" class="form-label">Holiday name</label>
                                    <input type="text" class="form-control" id="name.0 " name="name[]" placeholder="Holiday name" aria-describedby="name.0_invalid">
                                    <div id="name.0_invalid" class="invalid-feedback"></div>
                                </div>
                                <div>
                                    <label for="duration.0" class="form-label">Duration</label>
                                    <input type="number" class="form-control" id="duration.0 " name="duration[]" placeholder="Duration" aria-describedby="duration.0_invalid" value="1">
                                    <div id="duration.0_invalid" class="invalid-feedback"></div>
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
    <div class="modal fade" tabindex="-1" id="edit_holiday_modal">
        <div class="modal-dialog modal-lg">
            <form action="" id="update_holiday_form">
                <input type="hidden" id="_method" name="_method" value="patch">
                <input type="hidden" name="holiday_id" id="holiday_id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Holiday</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group d-flex gap-2">
                                    <div>
                                        <label for="holidate_edit" class="form-label">Holidate</label>
                                        <input type="text" class="form-control datepicker" id="holidate_edit" name="holidate" placeholder="Holidate" aria-describedby="holidate_edit_invalid">
                                        <div id="holidate_edit_invalid" class="invalid-feedback"></div>
                                    </div>
                                    <div>
                                        <label for="name_edit" class="form-label">Holiday name</label>
                                        <input type="text" class="form-control" id="name_edit" name="name" placeholder="Holiday name" aria-describedby="name_edit_invalid">
                                        <div id="name_edit_invalid" class="invalid-feedback"></div>
                                    </div>
                                    <div>
                                        <label for="duration_edit" class="form-label">Duration</label>
                                        <input type="number" class="form-control" id="duration_edit" name="duration" placeholder="Duration" aria-describedby="duration_invalid">
                                        <div id="duration_edit_invalid" class="invalid-feedback"></div>
                                    </div>
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
        let holiday_input_number = 1;
        $(".datepicker").datepicker({
            dateFormat: "yy-mm-dd"
        });

        let fetchHoliday = () => {
            let year = $('#year').val();
            $.ajax({
                type: "get",
                url: "{{ route('holiday.data') }}",
                data: {
                    year
                },
                success: function success(data) {
                    $('#holidays_div').html(data);

                    $('.holiday-update').on('click', (e) => {
                        let holiday = e.currentTarget.dataset.id;
                        $('#holiday_id').val(holiday);
                        $.ajax({
                            type: "get",
                            url: `{{ url('holiday') }}/${holiday}`,
                            success: function success(data) {
                                $("#holidate_edit").val(data.holidate);
                                $("#name_edit").val(data.name);
                                $("#duration_edit").val(data.duration);
                            },
                            error: function error(data) {
                                handleFormValidation(data);
                            }
                        });
                    });

                    $('.holiday-delete').on('click', (e) => {
                        let holiday = e.currentTarget.dataset.id;
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
                                    url: `{{ url('holiday') }}/${holiday}`,
                                    success: function success(data) {
                                        fetchHoliday();
                                        show_toastr('Success', data, 'success');
                                    },
                                    error: function error(data) {
                                        show_toastr('Error', data.responseJSON.message, 'error');
                                    }
                                });
                            }
                        })
                    });
                },
                error: function error(data) {
                    show_toastr('Error', data.responseJSON.message, 'error');
                }
            });
        }

        $('#year').on('change', fetchHoliday);

        $('.add-new').on('click', () => {
            $("#holiday_add_form").append(`<div class="form-group d-flex gap-2 mt-2 holiday-extra-${holiday_input_number}">
                                <div>
                                    <label for="holidate.${holiday_input_number}" class="form-label">Holidate</label>
                                    <input type="text" class="form-control datepicker" id="holidate.${holiday_input_number} " name="holidate[]" placeholder="Holidate" aria-describedby="holidate.${holiday_input_number}_invalid">
                                    <div id="holidate.${holiday_input_number}_invalid" class="invalid-feedback"></div>
                                </div>
                                <div>
                                    <label for="name.${holiday_input_number}" class="form-label">Holiday name</label>
                                    <input type="text" class="form-control" id="name.${holiday_input_number} " name="name[]" placeholder="Holiday name" aria-describedby="name.${holiday_input_number}_invalid">
                                    <div id="name.${holiday_input_number}_invalid" class="invalid-feedback"></div>
                                </div>
                                <div>
                                    <label for="duration.${holiday_input_number}" class="form-label">Duration</label>
                                    <input type="number" class="form-control" id="duration.${holiday_input_number} " name="duration[]" placeholder="Duration" aria-describedby="duration.${holiday_input_number}_invalid" value="1">
                                    <div id="duration.${holiday_input_number}_invalid" class="invalid-feedback"></div>
                                </div>
                                <div class="align-self-end">
                                    <button type="button" data-idx="${holiday_input_number}" class="btn btn-danger btn-xs mb-1 rounded-circle remove-holiday"><i class="fas fa-times font-1"></i></button>
                                </div>
                            </div>`);
            holiday_input_number++;
            $(".datepicker").datepicker({
                dateFormat: "yy-mm-dd"
            });
            $('.remove-holiday').on('click', (e) => {
                $(`.holiday-extra-${e.currentTarget.dataset.idx}`).remove();
            })
        })

        $('#add_holiday_form').on('submit', (e) => {
            e.preventDefault();
            let formData = new FormData(e.target);
            $.ajax({
                type: "post",
                data: formData,
                processData: false,
                contentType: false,
                url: "{{ route('holiday.store') }}",
                success: function success(data) {
                    show_toastr('Success', data, 'success');
                    fetchHoliday();
                    $('#add_holiday_modal').modal('hide');
                },
                error: function error(data) {
                    show_toastr('Error', data.responseJSON.message, 'error');
                }
            });
        })

        $('#update_holiday_form').on('submit', (e) => {
            e.preventDefault();
            let formData = new FormData(e.target);
            let holiday = $('#holiday_id').val();
            $.ajax({
                type: "post",
                data: formData,
                processData: false,
                contentType: false,
                url: `{{ url('holiday') }}/${holiday}`,
                success: function success(data) {
                    show_toastr('Success', data, 'success');
                    fetchHoliday();
                    $('#edit_holiday_modal').modal('hide');
                },
                error: function error(data) {
                    show_toastr('Error', "Provide all input fields", 'error');
                }
            });
        })

        $("#update_weekends").on('click', () => {
            let formData = new FormData(document.querySelector('#weekend_form'));
            $.ajax({
                type: "post",
                data: formData,
                processData: false,
                contentType: false,
                url: `{{ route('weekend.update') }}`,
                success: function success(data) {
                    show_toastr('Success', data, 'success');
                    fetchHoliday();
                    $('#edit_holiday_modal').modal('hide');
                },
                error: function error(data) {
                    if (data.status == 422) {
                        show_toastr('Error', "Please check at-least one option!", 'error');
                    } else {
                        show_toastr('Error', data.responseJSON.message, 'error');
                    }
                }
            });
        });

        $(document).ready(() => {
            fetchHoliday();
        });
    </script>
@endpush
