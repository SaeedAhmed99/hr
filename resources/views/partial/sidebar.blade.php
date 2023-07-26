<div class="wrapper">
    <!-- Sidebar Holder -->
    <nav id="sidebar" class="">
        <script>
            if (localStorage.getItem("sidebar") == "active") {
                document.getElementById("sidebar").classList.add("active");
            }
        </script>
        <a href="{{ route('dashboard') }}">
            <div class="sidebar-header">
                <h3><img src="{{ asset(setting('company_logo')) }}" class="logo logo-lg" /></h3>
                <strong><img style="height: 45px; width:45px !important; text" src="{{ asset(setting('company_logo')) }}"
                        class="" /></strong>
            </div>
        </a>

        <ul class="list-unstyled">
            <li class="{{ request()->is('home*') ? 'active' : '' }}">
                <a href="{{ route('home') }}">
                    <i class="fa fa-home"></i>
                    Dashboard
                </a>
            </li>
            @if (auth()->user()->can('Manage Hr'))
                <li class="">
                    <a href="#organizationSubmenu" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="fa-solid fa-building"></i>
                        Organization Setup
                    </a>
                    <ul class="collapse list-unstyled {{ request()->is('branch*') ? 'show' : '' }}
                        {{ request()->is('department*') ? 'show' : '' }}
                        {{ request()->is('designation*') ? 'show' : '' }}
                        {{ request()->is('roles*') ? 'show' : '' }}
                        {{ request()->is('setting*') ? 'show' : '' }}
                        {{ request()->is('ip-restrict*') ? 'show' : '' }}
                        {{ request()->is('holiday*') ? 'show' : '' }}
                        {{ request()->is('shift*') ? 'show' : '' }}
                        {{ request()->is('leavetype*') ? 'show' : '' }}
                        "
                        id="organizationSubmenu">

                        @if (auth()->user()->can('Manage System'))
                            <li><a class="{{ request()->is('setting*') ? 'activemenu' : '' }}"
                                    href="{{ route('setting.index') }}">Basic Info</a></li>
                        @endif
                        @if (auth()->user()->can('Manage Branch') or
                                auth()->user()->can('Create Branch') or
                                auth()->user()->can('Edit Branch') or
                                auth()->user()->can('Delete Branch'))
                            <li><a class="{{ request()->is('branch*') ? 'activemenu' : '' }}"
                                    href="{{ route('branch.index') }}">Branch</a></li>
                        @endif
                        @if (auth()->user()->can('Manage Department') or
                                auth()->user()->can('Create Department') or
                                auth()->user()->can('Edit Department') or
                                auth()->user()->can('Delete Department'))
                            <li><a class="{{ request()->is('department*') ? 'activemenu' : '' }}"
                                    href="{{ route('department.index') }}">Department</a></li>
                        @endif
                        @if (auth()->user()->can('Manage Designation') or
                                auth()->user()->can('Create Designation') or
                                auth()->user()->can('Edit Designation') or
                                auth()->user()->can('Delete Designation'))
                            <li><a class="{{ request()->is('designation*') ? 'activemenu' : '' }}"
                                    href="{{ route('designation.index') }}">Designation</a></li>
                        @endif
                        @if (auth()->user()->can('Manage Shift') or
                                auth()->user()->can('Create Shift') or
                                auth()->user()->can('Edit Shift') or
                                auth()->user()->can('Delete Shift'))
                            <li><a class="{{ request()->is('shift*') ? 'activemenu' : '' }}"
                                    href="{{ route('shift.index') }}">Shift Setup</a></li>
                        @endif
                        @if (auth()->user()->can('Manage Holiday') or
                                auth()->user()->can('Create Holiday') or
                                auth()->user()->can('Edit Holiday') or
                                auth()->user()->can('Delete Holiday'))
                            <li><a class="{{ request()->is('holiday*') ? 'activemenu' : '' }}"
                                    href="{{ route('holiday.index') }}">Holiday Setup</a></li>
                        @endif
                        @if (auth()->user()->can('Manage Leave Type') or
                                auth()->user()->can('Create Leave Type') or
                                auth()->user()->can('Edit Leave Type') or
                                auth()->user()->can('Delete Leave Type'))
                            <li><a class="{{ request()->is('leavetype*') ? 'activemenu' : '' }}"
                                    href="{{ route('leavetype.index') }}">Leave Type</a></li>
                        @endif
                        @if (auth()->user()->can('Manage Role') or
                                auth()->user()->can('Create Role') or
                                auth()->user()->can('Edit Role') or
                                auth()->user()->can('Delete Role'))
                            <li><a class="{{ request()->is('roles*') ? 'activemenu' : '' }}"
                                    href="{{ route('roles.index') }}">User Role</a></li>
                        @endif
                        @if (auth()->user()->can('Manage Ip') or
                                auth()->user()->can('Create Ip') or
                                auth()->user()->can('Edit Ip') or
                                auth()->user()->can('Delete Ip'))
                            <li><a class="{{ request()->is('ip-restrict*') ? 'activemenu' : '' }}"
                                    href="{{ route('ip-restrict.index') }}">Allowed IP addresses</a></li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (auth()->user()->can('Manage Hr'))
                <li class="">
                    <a href="#systemSubmenu" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="fa-solid fa-gears"></i>
                        HRM Setup
                    </a>
                    <ul class="collapse list-unstyled
                        {{ request()->is('leavetype*') ? 'show' : '' }}
                        {{ request()->is('document*') ? 'show' : '' }}
                        {{ request()->is('allowance-option*') ? 'show' : '' }}
                        {{ request()->is('trainingtype*') ? 'show' : '' }}
                        {{ request()->is('awardtype*') ? 'show' : '' }}
                        {{ request()->is('terminationtype*') ? 'show' : '' }}
                        {{ request()->is('jobcategory*') ? 'show' : '' }}
                        {{ request()->is('loantype*') ? 'show' : '' }}
                        {{ request()->is('performance-criterion*') ? 'show' : '' }}
                        {{ request()->is('performance-metric*') ? 'show' : '' }}
                    "
                        id="systemSubmenu">

                        @if (auth()->user()->can('Manage Loan Type') or
                                auth()->user()->can('Create Loan Type') or
                                auth()->user()->can('Edit Loan Type') or
                                auth()->user()->can('Delete Loan Type'))
                            <li><a class="{{ request()->is('loantype*') ? 'activemenu' : '' }}"
                                    href="{{ route('loan.type.index') }}">Loan Type</a></li>
                        @endif
                        {{-- @if (auth()->user()->can('Manage Leave Type') or
    auth()->user()->can('Create Leave Type') or
    auth()->user()->can('Edit Leave Type') or
    auth()->user()->can('Delete Leave Type'))
                            <li><a class="{{ request()->is('leavetype*') ? 'activemenu' : '' }}"
                                    href="{{ route('leavetype.index') }}">Leave Type</a></li>
                        @endif --}}
                        @if (auth()->user()->can('Manage Document Type') or
                                auth()->user()->can('Create Document Type') or
                                auth()->user()->can('Edit Document Type') or
                                auth()->user()->can('Delete Document Type'))
                            <li><a class="{{ request()->is('document*') ? 'activemenu' : '' }}"
                                    href="{{ route('document.index') }}">Document Type</a></li>
                        @endif
                        @if (auth()->user()->can('Manage Allowance Option') or
                                auth()->user()->can('Create Allowance Option') or
                                auth()->user()->can('Edit Allowance Option') or
                                auth()->user()->can('Delete Allowance Option'))
                            <li><a class="{{ request()->is('allowance-option*') ? 'activemenu' : '' }}"
                                    href="{{ route('allowance-option.index') }}">Allowance Option</a></li>
                        @endif
                        @if (auth()->user()->can('Manage Training Type') or
                                auth()->user()->can('Create Training Type') or
                                auth()->user()->can('Edit Training Type') or
                                auth()->user()->can('Delete Training Type'))
                            <li><a class="{{ request()->is('trainingtype*') ? 'activemenu' : '' }}"
                                    href="{{ route('trainingtype.index') }}">Training Type</a></li>
                        @endif
                        @if (auth()->user()->can('Manage Award Type') or
                                auth()->user()->can('Create Award Type') or
                                auth()->user()->can('Edit Award Type') or
                                auth()->user()->can('Delete Award Type'))
                            <li><a class="{{ request()->is('awardtype*') ? 'activemenu' : '' }}"
                                    href="{{ route('awardtype.index') }}">Award Type</a></li>
                        @endif
                        @if (auth()->user()->can('Manage Termination Type') or
                                auth()->user()->can('Create Termination Type') or
                                auth()->user()->can('Edit Termination Type') or
                                auth()->user()->can('Delete Termination Type'))
                            <li><a class="{{ request()->is('terminationtype*') ? 'activemenu' : '' }}"
                                    href="{{ route('terminationtype.index') }}">Termination Type</a></li>
                        @endif
                        @if (auth()->user()->can('Manage Performance Criteria') or
                                auth()->user()->can('Create Performance Criteria') or
                                auth()->user()->can('Edit Performance Criteria') or
                                auth()->user()->can('Delete Performance Criteria'))
                            <li><a class="{{ request()->is('performance-criterion*') ? 'activemenu' : '' }}"
                                    href="{{ route('performance.criterion.index') }}">Performance Criteria</a></li>
                        @endif
                        @if (auth()->user()->can('Manage Performance Metric') or
                                auth()->user()->can('Create Performance Metric') or
                                auth()->user()->can('Edit Performance Metric') or
                                auth()->user()->can('Delete Performance Metric'))
                            <li><a class="{{ request()->is('performance-metric*') ? 'activemenu' : '' }}"
                                    href="{{ route('performance-metric.index') }}">Performance Metric</a></li>
                        @endif

                    </ul>
                </li>
            @endif
            {{--  @can('Overview')
            <li class="{{ request()->is('Overview*') ? 'active' : '' }}">
                <a href="{{ route('overview.index') }}">
                    <i class="fa-brands fa-microsoft"></i>
                    Overview
                </a>
            </li>
            @endcan  --}}
            {{--  <!--@can('Manage User')-->
            <!--    <li class="">-->
            <!--        <a href="#staffSubmenu" data-bs-toggle="collapse" aria-expanded="false">-->
            <!--            <i class="fa fa-user"></i>-->
            <!--            Staff-->
            <!--        </a>-->
            <!--        <ul class="collapse list-unstyled {{ request()->is('user*') ? 'show' : '' }} {{ request()->is('roles*') ? 'show' : '' }}"-->
            <!--            id="staffSubmenu">-->
            <!--            <li><a class="{{ request()->is('user*') ? 'activemenu' : '' }}"-->
            <!--                    href="{{ route('user.index') }}">User</a></li>-->
            <!--            <li><a class="{{ request()->is('roles*') ? 'activemenu' : '' }}"-->
            <!--                    href="{{ route('roles.index') }}">Role</a></li>-->
            <!--        </ul>-->
            <!--    </li>-->
            <!--@endcan-->  --}}

            @can('Manage Employee')
                <li
                    class="{{ request()->is('employee') ? 'active' : '' }}{{ request()->is('employee/*') ? 'active' : '' }}">
                    <a href="{{ route('employee.index') }}">
                        <i class="fa-solid fa-users"></i>
                        Employee
                    </a>
                </li>
            @endcan
            @if (auth()->user()->can('Manage Project') or
                    auth()->user()->can('Create Project') or
                    auth()->user()->can('Update Project') or
                    auth()->user()->can('Delete Project'))
                <li
                    class="{{ request()->is('project') ? 'active' : '' }}{{ request()->is('project/*') ? 'active' : '' }}">
                    <a href="{{ route('project.index') }}">
                        <i class="fa-solid fa-users"></i>
                        Time Tracking
                    </a>
                </li>
            @endif

            @if (auth()->user()->can('Show Attendance') or
                    auth()->user()->can('Manage Attendance'))
                <li class="">
                    <a href="#attendanceMenu" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="fa-solid fa-clipboard-user"></i>
                        Attendance
                    </a>
                    <ul class="collapse list-unstyled {{ request()->is('attendance*') ? 'show' : '' }} {{ request()->is('report/daily-attendance-report') ? 'show' : '' }}"
                        id="attendanceMenu">
                        @if (auth()->user()->can('Show Attendance') or
                                auth()->user()->can('Manage Attendance'))
                            <li><a class="{{ request()->is('attendance*') ? 'activemenu' : '' }}"
                                    href="{{ route('attendance.index') }}">Manage Attendance</a></li>
                        @endif
                        @can('Manage Attendance')
                            <li><a class="{{ request()->is('report/daily-attendance-report') ? 'activemenu' : '' }}"
                                    href="{{ route('daily.attendance.report') }}">Daily Attendance Report</a></li>
                        @endcan
                    </ul>
                </li>
                {{-- <li class="{{ request()->is('attendance*') ? 'active' : '' }}">
                    <a href="{{ route('attendance.index') }}">
                        <i class="fa-solid fa-clipboard-user"></i>
                        Attendance
                    </a>
                </li> --}}
            @endif
            @if (auth()->user()->can('Show Leave') or
                    auth()->user()->can('Manage Leave'))
                {{-- <li class="{{ request()->is('leave*') ? 'active' : '' }}">
                    <a href="{{ route('leave.index') }}">
                        <i class="fa-solid fa-person-walking-arrow-right"></i>
                        Leave
                    </a>
                </li> --}}
                <li class="">
                    <a href="#leaveMenu" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="fa-solid fa-clipboard-user"></i>
                        Leave
                    </a>
                    <ul class="collapse list-unstyled {{ request()->is('leave*') ? 'show' : '' }} {{ request()->is('report/employee-leave-report') ? 'show' : '' }}"
                        id="leaveMenu">
                        @if (auth()->user()->can('Show Leave') or
                                auth()->user()->can('Manage Leave'))
                            <li><a class="{{ request()->is('leave*') ? 'activemenu' : '' }}"
                                    href="{{ route('leave.index') }}">Manage Leave</a></li>
                        @endif
                        @can('Manage Leave')
                            <li><a class="{{ request()->is('report/employee-leave-report') ? 'activemenu' : '' }}"
                                    href="{{ route('employee.leave.report') }}">Employee Leave Report</a></li>
                        @endcan
                    </ul>
                </li>
            @endif
            @can('Manage Payroll')
                <li class="">
                    <a href="#pyrollSubmenu" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="fa-solid fa-receipt"></i>
                        Payroll
                    </a>
                    <ul class="collapse list-unstyled {{ request()->is('set-salary*') ? 'show' : '' }} {{ request()->is('loan') ? 'show' : '' }} {{ request()->is('loan/*') ? 'show' : '' }} {{ request()->is('monthly-salary*') ? 'show' : '' }}"
                        id="pyrollSubmenu">
                        @can('Manage Set Salary')
                            <li><a class="{{ request()->is('set-salary*') ? 'activemenu' : '' }}"
                                    href="{{ route('set.salary.index') }}">Set Salary</a></li>
                        @endcan
                        @can('Manage Generate Salary')
                            <li><a class="{{ request()->is('monthly-salary') ? 'activemenu' : '' }}"
                                    href="{{ route('monthly.salary.index') }}">Generate Salary</a></li>
                        @endcan
                        @can('Show Generate Salary')
                            <li><a class="{{ request()->is('monthly-salary/show') ? 'activemenu' : '' }}"
                                    href="{{ route('monthly.salary.show') }}">View Generated Salary</a></li>
                        @endcan
                        @if (auth()->user()->can('Manage Loan') ||
                                auth()->user()->can('Show Loan'))
                            <li><a class="{{ request()->is('loan') ? 'activemenu' : '' }} {{ request()->is('loan/*') ? 'activemenu' : '' }}"
                                    href="{{ route('loan.index') }}">Loans</a></li>
                        @endif
                    </ul>
                </li>
            @endcan

            @if (auth()->user()->can('Show Performance') or
                    auth()->user()->can('Manage Performance'))
                <li class="{{ request()->is('employee-performance') ? 'active' : '' }} ">
                    <a href="{{ route('employee-performance.index') }}">
                        <i class="fa-solid fa-person-running"></i>
                        Performance
                    </a>
                </li>
            @endif

            {{--  <li class="">
                <a href="#timeSubmenu" data-bs-toggle="collapse" aria-expanded="false">
                    <i class="fa-solid fa-business-time"></i>
                    Timesheet
                </a>
                <ul class="collapse list-unstyled {{ request()->is('leave') ? 'show' : '' }} {{ request()->is('leave/*') ? 'show' : '' }} {{ request()->is('attendance*') ? 'show' : '' }}"
                    id="timeSubmenu">
                    @if (auth()->user()->can('Show Leave') or
    auth()->user()->can('Manage Leave'))
                        <li><a class="{{ request()->is('leave') ? 'activemenu' : '' }} {{ request()->is('leave/*') ? 'activemenu' : '' }}"
                                href="{{ route('leave.index') }}">Manage Leave</a></li>
                    @endif
                    @if (auth()->user()->can('Show Attendance') or
    auth()->user()->can('Manage Attendance'))
                        <li><a class="{{ request()->is('attendance*') ? 'activemenu' : '' }}"
                                href="{{ route('attendance.index') }}">Attendance</a></li>
                    @endif
                </ul>
            </li>  --}}
            @if (auth()->user()->can('Show Promotion') or
                    auth()->user()->can('Manage Promotion'))
                <li class="{{ request()->is('promotion*') ? 'active' : '' }}">
                    <a href=" {{ route('promotion.index') }}">
                        <i class="fa-solid fa-chalkboard-user"></i>
                        Promotion
                    </a>
                </li>
            @endif

            @if (auth()->user()->can('Show Award') or
                    auth()->user()->can('Manage Award'))
                <li class="{{ request()->is('award*') ? 'active' : '' }}">
                    <a href=" {{ route('award.index') }}">
                        <i class="fa-solid fa-award"></i>
                        Award
                    </a>
                </li>
            @endif
            @if (auth()->user()->can('Show Transfer') or
                    auth()->user()->can('Manage Transfer'))
                <li class="{{ request()->is('transfer*') ? 'active' : '' }}">
                    <a href=" {{ route('transfer.index') }}">
                        <i class="fa-solid fa-person-walking-arrow-loop-left"></i>
                        Transfer
                    </a>
                </li>
            @endif

            @if (auth()->user()->can('Show Resignation') or
                    auth()->user()->can('Manage Resignation'))
                <li class="{{ request()->is('resignation*') ? 'active' : '' }}">
                    <a href=" {{ route('resignation.index') }}">
                        <i class="fa-solid fa-note-sticky"></i>
                        Resignation
                    </a>
                </li>
            @endif
            @if (auth()->user()->can('Show Training') or
                    auth()->user()->can('Manage Training') or
                    auth()->user()->can('Manage Trainer'))
                <li class="">
                    <a href="#trainingSubmenu" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="fa-solid fa-graduation-cap"></i>
                        Training
                    </a>
                    <ul class="collapse list-unstyled {{ request()->is('training') ? 'show' : '' }} {{ request()->is('training/*') ? 'show' : '' }} {{ request()->is('trainer*') ? 'show' : '' }}"
                        id="trainingSubmenu">
                        @if (auth()->user()->can('Show Training') or
                                auth()->user()->can('Manage Training'))
                            <li><a class="{{ request()->is('training') ? 'activemenu' : '' }} {{ request()->is('training/*') ? 'activemenu' : '' }}"
                                    href="{{ route('training.index') }}">Training List</a></li>
                        @endif
                        @if (auth()->user()->can('Manage Trainer'))
                            <li><a class="{{ request()->is('trainer*') ? 'activemenu' : '' }}"
                                    href="{{ route('trainer.index') }}">Trainer</a></li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (auth()->user()->can('Show Travel') or
                    auth()->user()->can('Manage Travel'))
                <li class="{{ request()->is('travel*') ? 'active' : '' }}">
                    <a href=" {{ route('travel.index') }}">
                        <i class="fa-solid fa-plane"></i>
                        Travel
                    </a>
                </li>
            @endif
            @if (auth()->user()->can('Manage Termination'))
                <li
                    class="{{ request()->is('termination') ? 'active' : '' }} {{ request()->is('termination/*') ? 'active' : '' }}">
                    <a href=" {{ route('termination.index') }}">
                        <i class="fa-solid fa-person-walking-luggage"></i>
                        Termination
                    </a>
                </li>
            @endif
            @if (auth()->user()->can('Show Meeting') or
                    auth()->user()->can('Manage Meeting'))
                <li class="{{ request()->is('meeting*') ? 'active' : '' }}">
                    <a href="{{ route('meeting.index') }}">
                        <i class="fa-solid fa-handshake"></i>
                        Meeting
                    </a>
                </li>
            @endif
            @if (auth()->user()->can('Manage Announcement'))
                <li class="{{ request()->is('announcement*') ? 'active' : '' }}">
                    <a href=" {{ route('announcement.index') }}">
                        <i class="fa-solid fa-bullhorn"></i>
                        Announcement
                    </a>
                </li>
            @endif

            {{--  <li class="">
                <a href="#adminSubmenu" data-bs-toggle="collapse" aria-expanded="false">
                    <i class="fa-solid fa-user-tie"></i>
                    Employee Desk
                </a>
                <ul class="collapse list-unstyled {{ request()->is('award') ? 'show' : '' }} {{ request()->is('award/*') ? 'show' : '' }} {{ request()->is('transfer*') ? 'show' : '' }}{{ request()->is('resignation*') ? 'show' : '' }} {{ request()->is('travel*') ? 'show' : '' }} {{ request()->is('promotion*') ? 'show' : '' }} {{ request()->is('termination') ? 'show' : '' }} {{ request()->is('termination/*') ? 'show' : '' }} {{ request()->is('announcement') ? 'show' : '' }}"
                    id="adminSubmenu">

                    @if (auth()->user()->can('Show Award') or
    auth()->user()->can('Manage Award'))
                        <li><a class="{{ request()->is('award') ? 'activemenu' : '' }} {{ request()->is('award/*') ? 'activemenu' : '' }}"
                                href="{{ route('award.index') }}">Award</a></li>
                    @endif
                    @if (auth()->user()->can('Show Transfer') or
    auth()->user()->can('Manage Transfer'))
                        <li><a class="{{ request()->is('transfer*') ? 'activemenu' : '' }}"
                                href="{{ route('transfer.index') }}">Transfer</a></li>
                    @endif
                    @if (auth()->user()->can('Show Resignation') or
    auth()->user()->can('Manage Resignation'))
                        <li><a class="{{ request()->is('resignation*') ? 'activemenu' : '' }}"
                                href="{{ route('resignation.index') }}">Resignation</a></li>
                    @endif
                    @if (auth()->user()->can('Show Travel') or
    auth()->user()->can('Manage Travel'))
                        <li><a class="{{ request()->is('travel*') ? 'activemenu' : '' }}"
                                href="{{ route('travel.index') }}">Travel</a></li>
                    @endif
                    @if (auth()->user()->can('Show Promotion') or
    auth()->user()->can('Manage Promotion'))
                        <li><a class="{{ request()->is('promotion*') ? 'activemenu' : '' }}"
                                href="{{ route('promotion.index') }}">Promotion</a></li>
                    @endif
                    @if (auth()->user()->can('Manage Termination'))
                        <li><a class="{{ request()->is('termination') ? 'activemenu' : '' }} {{ request()->is('termination/*') ? 'activemenu' : '' }}"
                                href="{{ route('termination.index') }}">Termination</a></li>
                    @endif
                    @if (auth()->user()->can('Manage Announcement'))
                        <li><a class="{{ request()->is('announcement') ? 'activemenu' : '' }}"
                                href="{{ route('announcement.index') }}">Announcement</a></li>
                    @endif
                </ul>
            </li>  --}}

            {{--  @if (auth()->user()->can('Manage System'))
                <li class="">
                    <a href="#settingSubmenu" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="fa-solid fa-gears"></i>
                        System Settings
                    </a>
                    <ul class="collapse list-unstyled {{ request()->is('branch*') ? 'show' : '' }}"
                        id="settingSubmenu">
                        <li><a class="{{ request()->is('branch*') ? 'activemenu' : '' }}"
                                href="{{ route('branch.index') }}">Business Setting</a></li>


                    </ul>
                </li>
            @endif  --}}
            {{--  @if (auth()->user()->can('Manage System'))
                <li>
                    <a href="{{ route('setting.index') }}">
                        <i class="fa-solid fa-gears"></i>
                        System Settings
                    </a>
                </li>
            @endif  --}}

        </ul>
    </nav>

    <!-- Page Content Holder -->
    <div id="content">
        <nav class="navbar navbar-default">
            <div class="container-fluid">

                <div class="navbar-header">
                    <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn">
                        <i class="fa fa-bars"></i>
                        {{--  <span>Toggle Sidebar</span>  --}}
                    </button>
                </div>

                {{--  <div class="" id="">
                    <ul class="nav navbar-nav navbar-right">
                        <div class="" style="display: flex;">
                            <div class="name-job">
                                <div class="profile_name" style="margin-right: 10px;">{{ Auth::user()->name }}</div>
                                <div class="job">{{ Auth::user()->email }}</div>
                            </div>
                            <div>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa-solid fa-right-from-bracket"></i></a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>

                    </ul>
                </div>  --}}

                <div class="User-area">
                    <div class="User-avtar d-flex">
                        @php
                            $profile = asset('storage/avatar');
                            $userDetail = Auth::user();
                        @endphp
                        <div class="me-2"><img
                                src="{{ !empty($userDetail->avater) ? $profile . '/' . $userDetail->avater : $profile . '/avatar.png' }}" />
                        </div>
                        <div class="" style="margin-top: 10px">
                            <small class="profile_name">{{ Auth::user()->name }}<i class="fa-solid fa-angle-down"
                                    style="margin-left: 10px;"></i></small>
                            {{--  <small class="job">{{ Auth::user()->email }}</small>  --}}
                        </div>
                    </div>
                    <ul class="User-Dropdown">
                        <li><a href="{{ route('user.change-password') }}">Change Password</a></li>
                        @if (!Auth::user()->hasRole('Super Admin'))
                            <li><a href="{{ route('user.profile') }}">My Profile</a></li>
                        @endif
                        <li><a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        @push('js')
            <script>
                $(document).ready(function() {
                    $('#sidebarCollapse').on('click', function() {
                        if ($('#sidebar').hasClass('active')) {
                            localStorage.setItem("sidebar", "notactive");
                        } else {
                            localStorage.setItem("sidebar", "active");
                        }
                        $('#sidebar').toggleClass('active');
                    });
                });
            </script>

            <script>
                $('.User-avtar').click(function() {
                    if ($(".User-Dropdown").hasClass("U-open")) {
                        $('.User-Dropdown').removeClass("U-open");
                    } else {
                        $('.User-Dropdown').addClass("U-open");
                    }
                });
            </script>
        @endpush
