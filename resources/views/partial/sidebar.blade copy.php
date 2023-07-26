 <div class="sidebar" id="sidebar-menu">
     <div class="logo-details">
         <i class='bx bxl-c-plus-plus'></i>
         <span class="logo_name">CodeCloud</span>
     </div>
     <ul class="nav-links">
         <li>
             <a href="{{ route('home') }}">
                 <i class='bx bx-grid-alt'></i>
                 <span class="link_name">Dashboard</span>
             </a>
             <ul class="sub-menu blank">
                 <li><a class="link_name" href="#">Category</a></li>
             </ul>
         </li>
         @can('Manage User')
             <li class="{{ request()->is('user*') ? 'showMenu' : '' }} {{ request()->is('roles*') ? 'showMenu' : '' }} ">
                 <div class="iocn-link arrow">
                     <a href="#">
                         <i class='bx bx-collection'></i>
                         <span class="link_name">Staff</span>
                     </a>
                     <i class='bx bxs-chevron-down arrowicon'></i>
                 </div>
                 <ul class="sub-menu">
                     <li><a class="link_name" href="#">Category</a></li>
                     <li><a class="{{ request()->is('user*') ? 'active' : '' }}" href="{{ route('user.index') }}">User</a></li>
                     <li><a class="{{ request()->is('roles*') ? 'active' : '' }}" href="{{ route('roles.index') }}">Role</a></li>
                     {{--  <li><a href="#"></a></li>  --}}
                 </ul>
             </li>
         @endcan
         @can('Manage Employee')
             <li>
                 <a href="{{ route('employee.index') }}">
                     <i class='bx bx-user'></i>
                     <span class="link_name">Employee</span>
                 </a>
                 <ul class="sub-menu blank">
                     <li><a class="link_name" href="#">Employee</a></li>
                 </ul>
             </li>
         @endcan

         <li
             class="{{ request()->is('set-salary*') ? 'showMenu' : '' }} {{ request()->is('loan*') ? 'showMenu' : '' }} {{ request()->is('monthly-salary*') ? 'showMenu' : '' }}">
             <div class="iocn-link arrow">
                 <a href="#">
                     <i class='bx bx-note'></i>
                     <span class="link_name">Payroll</span>
                 </a>
                 <i class='bx bxs-chevron-down arrowicon'></i>
             </div>
             <ul class="sub-menu">
                 <li><a class="link_name" href="#">Payroll</a></li>
                 <li><a class="{{ request()->is('set-salary*') ? 'active' : '' }}"
                         href="{{ route('set.salary.index') }}">Set Salary</a></li>
                 <li><a class="{{ request()->is('monthly-salary') ? 'active' : '' }}"
                         href="{{ route('monthly.salary.index') }}">Generate Salary</a></li>
                 <li><a class="{{ request()->is('monthly-salary/show') ? 'active' : '' }}"
                         href="{{ route('monthly.salary.show') }}">View Generated Salary</a></li>
                 <li><a class="{{ request()->is('loan*') ? 'active' : '' }}"
                         href="{{ route('loan.index') }}">Loans</a></li>
             </ul>
         </li>

         <li class="{{ request()->is('leave*') ? 'showMenu' : '' }}">
             <div class="iocn-link arrow">
                 <a href="#">
                     <i class='bx bx-stopwatch'></i>
                     <span class="link_name">Timesheet</span>
                 </a>
                 <i class='bx bxs-chevron-down arrowicon'></i>
             </div>
             <ul class="sub-menu">
                 <li><a class="link_name" href="#">Timesheet</a></li>
                 <li><a class="{{ request()->is('leave*') ? 'active' : '' }}" href="{{ route('leave.index') }}">Manage Leave</a></li>

             </ul>
         </li>
         <li class="{{ request()->is('training*') ? 'showMenu' : '' }} {{ request()->is('trainer*') ? 'showMenu' : '' }}">
             <div class="iocn-link arrow">
                 <a href="#">
                     <i class='bx bxs-graduation'></i>
                     <span class="link_name">Training</span>
                 </a>
                 <i class='bx bxs-chevron-down arrowicon'></i>
             </div>
             <ul class="sub-menu">
                 <li><a class="link_name" href="#">Training</a></li>
                 <li><a class="{{ request()->is('training*') ? 'active' : '' }}" href="{{ route('training.index') }}">Training List</a></li>
                 <li><a class="{{ request()->is('trainer*') ? 'active' : '' }}" href="{{ route('trainer.index') }}">Trainer</a></li>
                 {{--  <li><a href="#">Card Design</a></li>  --}}
             </ul>
         </li>

         {{--  <li>
             <a href="{{ route('document.index') }}">
                 <i class='bx bx-note'></i>
                 <span class="link_name">Document</span>
             </a>
             <ul class="sub-menu blank">
                 <li><a class="link_name" href="#">Document</a></li>
             </ul>
         </li>  --}}

         <li
             class="{{ request()->is('award*') ? 'showMenu' : '' }} {{ request()->is('transfer*') ? 'showMenu' : '' }} {{ request()->is('resignation*') ? 'showMenu' : '' }} {{ request()->is('travel*') ? 'showMenu' : '' }} {{ request()->is('promotion*') ? 'showMenu' : '' }} {{ request()->is('termination*') ? 'showMenu' : '' }}">
             <div class="iocn-link arrow">
                 <a href="#">
                     <i class='bx bx-user-plus'></i>
                     <span class="link_name">Hr Admin Setup</span>
                 </a>
                 <i class='bx bxs-chevron-down arrowicon'></i>
             </div>
             <ul class="sub-menu">
                 <li><a class="link_name" href="#">Hr Admin Setup</a></li>
                 <li><a class="{{ request()->is('award*') ? 'active' : '' }}"
                         href="{{ route('award.index') }}">Award</a></li>
                 <li><a class="{{ request()->is('transfer*') ? 'active' : '' }}"
                         href="{{ route('transfer.index') }}">Transfer</a></li>
                 <li><a class="{{ request()->is('resignation*') ? 'active' : '' }}"
                         href="{{ route('resignation.index') }}">Resignation</a></li>
                 <li><a class="{{ request()->is('travel*') ? 'active' : '' }}"
                         href="{{ route('travel.index') }}">Trip</a></li>
                 <li><a class="{{ request()->is('promotion*') ? 'active' : '' }}"
                         href="{{ route('promotion.index') }}">Promotion</a></li>
                 <li><a class="{{ request()->is('termination*') ? 'active' : '' }}"
                         href="{{ route('termination.index') }}">Termination</a></li>
             </ul>
         </li>

         <li>
             <div class="iocn-link">
                 <a href="{{ route('meeting.index') }}">
                     <i class='bx bxs-timer'></i>
                     <span class="link_name">Meeting</span>
                 </a>
             </div>

         </li>

         <li class="{{ request()->is('branch*') ? 'showMenu' : '' }}
            {{ request()->is('department*') ? 'showMenu' : '' }}
            {{ request()->is('designation*') ? 'showMenu' : '' }}
            {{ request()->is('leavetype*') ? 'showMenu' : '' }}
            {{ request()->is('document*') ? 'showMenu' : '' }}
            {{ request()->is('allowance-option*') ? 'showMenu' : '' }}
            {{ request()->is('trainingtype*') ? 'showMenu' : '' }}
            {{ request()->is('awardtype*') ? 'showMenu' : '' }}
            {{ request()->is('terminationtype*') ? 'showMenu' : '' }}
            {{ request()->is('jobcategory*') ? 'showMenu' : '' }}
            {{ request()->is('jobstage*') ? 'showMenu' : '' }}
            ">
             <div
                 class="iocn-link arrow">
                 <a href="#">
                     <i class='bx bx-border-all'></i>
                     <span class="link_name">Hr System Setup</span>
                 </a>
                 <i class='bx bxs-chevron-down arrowicon'></i>
             </div>
             <ul class="sub-menu">
                 <li><a class="link_name " href="#">Hr System Setup</a></li>
                 <li><a class="{{ request()->is('branch*') ? 'active' : '' }}"
                         href="{{ route('branch.index') }}">Branch</a></li>
                 <li><a class="{{ request()->is('department*') ? 'active' : '' }}"
                         href="{{ route('department.index') }}">Department</a></li>
                 <li><a class="{{ request()->is('designation*') ? 'active' : '' }}" href="{{ route('designation.index') }}">Designation</a></li>
                 <li><a class="{{ request()->is('leavetype*') ? 'active' : '' }}" href="{{ route('leavetype.index') }}">Leave Type</a></li>
                 <li><a class="{{ request()->is('document*') ? 'active' : '' }}" href="{{ route('document.index') }}">Document Type</a></li>
                 <li><a class="{{ request()->is('allowance-option*') ? 'active' : '' }}" href="{{ route('allowance-option.index') }}">Allowance Option</a></li>
                 <li><a class="{{ request()->is('trainingtype*') ? 'active' : '' }}" href="{{ route('trainingtype.index') }}">Training Type</a></li>
                 <li><a class="{{ request()->is('awardtype*') ? 'active' : '' }}" href="{{ route('awardtype.index') }}">Award Type</a></li>
                 <li><a class="{{ request()->is('terminationtype*') ? 'active' : '' }}" href="{{ route('terminationtype.index') }}">Termination Type</a></li>
                 <li><a class="{{ request()->is('jobcategory*') ? 'active' : '' }}" href="{{ route('jobcategory.index') }}">Job Category</a></li>
                 <li><a class="{{ request()->is('jobstage*') ? 'active' : '' }}" href="{{ route('jobstage.index') }}">Job Stage</a></li>
             </ul>
         </li>
         {{--  <li>
             <a href="#">
                 <i class='bx bx-compass'></i>
                 <span class="link_name">Explore</span>
             </a>
             <ul class="sub-menu blank">
                 <li><a class="link_name" href="#">Explore</a></li>
             </ul>
         </li>  --}}
         {{--  <li>
             <a href="#">
                 <i class='bx bx-history'></i>
                 <span class="link_name">History</span>
             </a>
             <ul class="sub-menu blank">
                 <li><a class="link_name" href="#">History</a></li>
             </ul>
         </li>  --}}
         <li>
             <a href="#">
                 <i class='bx bx-cog'></i>
                 <span class="link_name">Setting</span>
             </a>
             <ul class="sub-menu blank">
                 <li><a class="link_name" href="#">Setting</a></li>
             </ul>
         </li>
         <li>
             <div class="profile-details">
                 <div class="profile-content">
                     <!--<img src="image/profile.jpg" alt="profileImg">-->
                 </div>
                 <div class="name-job">
                     <div class="profile_name">{{ Auth::user()->name }}</div>
                     <div class="job">{{ Auth::user()->email }}</div>
                 </div>
                 <div>
                     <a href="{{ route('logout') }}"
                         onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                             class='bx bx-log-out'></i></a>
                     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                         @csrf
                     </form>
                 </div>
             </div>
         </li>
     </ul>
 </div>

 @push('js')
     <script>
         let arrow = document.querySelectorAll(".arrow");
         for (var i = 0; i < arrow.length; i++) {
             arrow[i].addEventListener("click", (e) => {
                 let arrowParent = e.target.parentElement.parentElement
                     .parentElement; //selecting main parent of arrow
                 arrowParent.classList.toggle("showMenu");
             });
         }

         let arrowicon = document.querySelectorAll(".arrowicon");
         for (var i = 0; i < arrowicon.length; i++) {
             arrowicon[i].addEventListener("click", (e) => {
                 let arrowParent = e.target.parentElement.parentElement; //selecting main parent of arrow
                 arrowParent.classList.toggle("showMenu");
             });
         }

         let sidebar = document.querySelector(".sidebar");
         let sidebarBtn = document.querySelector(".bx-menu");
         //console.log(sidebarBtn);
         sidebarBtn.addEventListener("click", () => {
             sidebar.classList.toggle("close");
         });
     </script>
 @endpush
