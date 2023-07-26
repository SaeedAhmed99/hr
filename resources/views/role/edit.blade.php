@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="card-heading">Edit Permission</p>
                        {{--  <a href="{{ route('roles.create') }}" class="btn btn-gray"><i
                                class="fa-solid fa-plus"></i></a>  --}}
                    </div>
                </div>
                <div class="card-body">
                    <div class="">
                        <form class="row g-3 needs-validation" method="Post" action="{{ route('roles.update', $role->id) }}">
                            @csrf
                            <input type="hidden" id="_method" name="_method" value="patch">
                            <div class="col-md-12">
                                <label for="name" class="form-label">Role Name</label>
                                <input type="text" name="name" value="{{ $role->name }}" class="form-control"
                                    id="name" required>
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>


                            <div class="form-group">
                                @if (!empty($permissions))
                                    <h6 class="my-3">{{ __('Assign Permission to Roles') }} </h6>
                                    <table class="table  mb-0" id="dataTable-1">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <input type="checkbox"
                                                        class="align-middle checkbox_middle form-check-input"
                                                        name="checkall" id="checkall">
                                                </th>
                                                <th>{{ __('Module') }} </th>
                                                <th>{{ __('Permissions') }} </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $modules = ['User', 'Role', 'Award', 'Transfer', 'Resignation', 'Travel', 'Promotion', 'Termination', 'Department', 'Designation', 'Document Type', 'Branch', 'Award Type', 'Termination Type', 'Employee', 'Allowance Option', 'Set Salary', 'Generate Salary', 'Loan', 'Loan Type', 'Announcement', 'Leave Type', 'Leave', 'Meeting', 'Attendance', 'Trainer', 'Training', 'Training Type', 'Performance', 'Performance Criteria', 'Performance Metric', 'Payroll', 'Holiday', 'Hr', 'System', 'Project', 'Shift'];
                                                if (Auth::user()->type == 'super admin') {
                                                    $modules[] = 'Language';
                                                }
                                                
                                            @endphp
                                            @foreach ($modules as $module)
                                                <tr>
                                                    <td><input type="checkbox" class="align-middle ischeck form-check-input"
                                                            name="checkall" data-id="{{ str_replace(' ', '', $module) }}">
                                                    </td>
                                                    <td><label class="ischeck form-label"
                                                            data-id="{{ str_replace(' ', '', $module) }}">{{ ucfirst($module) }}</label>
                                                    </td>
                                                    <td>
                                                        <div class="row ">
                                                            @if (in_array('Manage ' . $module, (array) $permissions))
                                                                @if ($key = array_search('Manage ' . $module, $permissions))
                                                                    <div class="col-md-3 custom-control custom-checkbox">
                                                                        <input
                                                                            class="form-check-input isscheck isscheck_{{ str_replace(' ', '', $module) }}"
                                                                            type="checkbox" name="permissions[]"
                                                                            value="{{ $key }}"
                                                                            id="permission{{ $key }}"
                                                                            @if ($role->hasPermissionTo('Manage ' . $module)) checked @endif>
                                                                        <label class="form-check-label"
                                                                            for="flexCheckDefault">
                                                                            Manage
                                                                        </label><br>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                            @if (in_array('Create ' . $module, (array) $permissions))
                                                                @if ($key = array_search('Create ' . $module, $permissions))
                                                                    <div class="col-md-3 custom-control custom-checkbox">
                                                                        <input
                                                                            class="form-check-input isscheck isscheck_{{ str_replace(' ', '', $module) }}"
                                                                            type="checkbox" name="permissions[]"
                                                                            value="{{ $key }}"
                                                                            id="permission{{ $key }}"
                                                                            @if ($role->hasPermissionTo('Create ' . $module)) checked @endif>
                                                                        <label class="form-check-label"
                                                                            for="flexCheckDefault">
                                                                            Create
                                                                        </label><br>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                            @if (in_array('Edit ' . $module, (array) $permissions))
                                                                @if ($key = array_search('Edit ' . $module, $permissions))
                                                                    <div class="col-md-3 custom-control custom-checkbox">
                                                                        <input
                                                                            class="form-check-input isscheck isscheck_{{ str_replace(' ', '', $module) }}"
                                                                            type="checkbox" name="permissions[]"
                                                                            value="{{ $key }}"
                                                                            id="permission{{ $key }}"
                                                                            @if ($role->hasPermissionTo('Edit ' . $module)) checked @endif>
                                                                        <label class="form-check-label"
                                                                            for="flexCheckDefault">
                                                                            Edit
                                                                        </label><br>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                            @if (in_array('Delete ' . $module, (array) $permissions))
                                                                @if ($key = array_search('Delete ' . $module, $permissions))
                                                                    <div class="col-md-3 custom-control custom-checkbox">
                                                                        <input
                                                                            class="form-check-input isscheck isscheck_{{ str_replace(' ', '', $module) }}"
                                                                            type="checkbox" name="permissions[]"
                                                                            value="{{ $key }}"
                                                                            id="permission{{ $key }}"
                                                                            @if ($role->hasPermissionTo('Delete ' . $module)) checked @endif>
                                                                        <label class="form-check-label"
                                                                            for="flexCheckDefault">
                                                                            Delete
                                                                        </label><br>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                            @if (in_array('Show ' . $module, (array) $permissions))
                                                                @if ($key = array_search('Show ' . $module, $permissions))
                                                                    <div class="col-md-3 custom-control custom-checkbox">
                                                                        <input
                                                                            class="form-check-input isscheck isscheck_{{ str_replace(' ', '', $module) }}"
                                                                            type="checkbox" name="permissions[]"
                                                                            value="{{ $key }}"
                                                                            id="permission{{ $key }}"
                                                                            @if ($role->hasPermissionTo('Show ' . $module)) checked @endif>
                                                                        <label class="form-check-label"
                                                                            for="flexCheckDefault">
                                                                            Show
                                                                        </label><br>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                            {{--  @if (in_array('Move ' . $module, (array) $permissions))
                                                @if ($key = array_search('Move ' . $module, $permissions))
                                                    <div class="col-md-3 custom-control custom-checkbox">
                                                        {{ Form::checkbox('permissions[]', $key, false, ['class' => 'form-check-input isscheck isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                        {{ Form::label('permission' . $key, 'Move', ['class' => 'form-label font-weight-500']) }}<br>
                                                    </div>
                                                @endif
                                            @endif
                                            @if (in_array('Client Permission', (array) $permissions))
                                                @if ($key = array_search('Client Permission ' . $module, $permissions))
                                                    <div class="col-md-3 custom-control custom-checkbox">
                                                        {{ Form::checkbox('permissions[]', $key, false, ['class' => 'form-check-input isscheck isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                        {{ Form::label('permission' . $key, 'Client Permission', ['class' => 'form-label font-weight-500']) }}<br>
                                                    </div>
                                                @endif
                                            @endif
                                            @if (in_array('Invite User', (array) $permissions))
                                                @if ($key = array_search('Invite User ' . $module, $permissions))
                                                    <div class="col-md-3 custom-control custom-checkbox">
                                                        {{ Form::checkbox('permissions[]', $key, false, ['class' => 'form-check-input isscheck isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                        {{ Form::label('permission' . $key, 'Invite User ', ['class' => 'form-label font-weight-500']) }}<br>
                                                    </div>
                                                @endif
                                            @endif

                                            @if (in_array('Buy ' . $module, (array) $permissions))
                                                @if ($key = array_search('Buy ' . $module, $permissions))
                                                    <div class="col-md-3 custom-control custom-checkbox">
                                                        {{ Form::checkbox('permissions[]', $key, false, ['class' => 'form-check-input isscheck isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                        {{ Form::label('permission' . $key, 'Buy', ['class' => 'form-label font-weight-500']) }}<br>
                                                    </div>
                                                @endif
                                            @endif
                                            @if (in_array('Add ' . $module, (array) $permissions))
                                                @if ($key = array_search('Add ' . $module, $permissions))
                                                    <div class="col-md-3 custom-control custom-checkbox">
                                                        {{ Form::checkbox('permissions[]', $key, false, ['class' => 'form-check-input isscheck isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                        {{ Form::label('permission' . $key, 'Add', ['class' => 'form-label font-weight-500']) }}<br>
                                                    </div>
                                                @endif
                                            @endif  --}}

                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $("#checkall").click(function() {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });
            $(".ischeck").click(function() {
                var ischeck = $(this).data('id');
                $('.isscheck_' + ischeck).prop('checked', this.checked);
            });
        });
    </script>
@endpush
