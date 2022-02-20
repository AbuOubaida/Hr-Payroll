<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
        <a class="sidebar-brand brand-logo" href="{{url('/')}}"><img src="{{url("image/{$model->comp_logo}")}}" alt="logo" /></a>
        <a class="sidebar-brand brand-logo-mini" href="{{url('/')}}"><img src="{{url("image/{$model->comp_logo_sm}")}}" alt="logo" /></a>
    </div>
    <ul class="nav">
        <li class="nav-item profile">
            <div class="profile-desc">
                <div class="profile-pic">
                    <div class="count-indicator">
                        @if(\Illuminate\Support\Facades\Auth::user()->profile_pic)
                        <img class="img-xs rounded-circle " src="{{url('image/employee/profile/'.\Illuminate\Support\Facades\Auth::user()->profile_pic)}}" alt="">
                        @else
                            <div class="img-xs rounded-circle " style="font-size: 36px;"><i class="mdi mdi-account-box-outline"></i></div>
                        @endif
                        <span class="count bg-success"></span>
                    </div>
                    <div class="profile-name">
                        <h5 class="mb-0 font-weight-normal">{{\Illuminate\Support\Facades\Auth::user()->name}}</h5>
                        <span>{{\Illuminate\Support\Facades\Auth::user()->roles->first()->display_name}}</span>
                    </div>
                </div>
                <a href="#" id="profile-dropdown" data-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
                <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list" aria-labelledby="profile-dropdown">
                    <a href="{{url('admin/account-setting')}}" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-settings text-primary"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject ellipsis mb-1 text-small">Account settings</p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{url('admin/change-password')}}" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-onepassword  text-info"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject ellipsis mb-1 text-small">Change Password</p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
{{--                    <a href="#" class="dropdown-item preview-item">--}}
{{--                        <div class="preview-thumbnail">--}}
{{--                            <div class="preview-icon bg-dark rounded-circle">--}}
{{--                                <i class="mdi mdi-calendar-today text-success"></i>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </a>--}}
                </div>
            </div>
        </li>
        <li class="nav-item nav-category">
            <span class="nav-link">Navigation</span>
        </li>

        <li class="nav-item menu-items">
            <a class="nav-link" href="{{url("/dashboard")}}">
        <span class="menu-icon">
          <i class="mdi mdi-speedometer"></i>
        </span>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

{{--        <li class="nav-item menu-items">--}}
{{--            <a class="nav-link" data-toggle="collapse" href="#report" aria-expanded="false" aria-controls="report">--}}
{{--        <span class="menu-icon">--}}
{{--          <i class="mdi mdi-chart-line"></i>--}}
{{--        </span>--}}
{{--                <span class="menu-title">Report</span>--}}
{{--                <i class="menu-arrow"></i>--}}
{{--            </a>--}}
{{--            <div class="collapse" id="report">--}}
{{--                <ul class="nav flex-column sub-menu">--}}
{{--                    <li class="nav-item"> <a class="nav-link" href="#">Attendance</a></li>--}}
{{--                    <li class="nav-item"> <a class="nav-link" href="#">Salary</a></li>--}}
{{--                    <li class="nav-item"> <a class="nav-link" href="#">Loan</a></li>--}}
{{--                </ul>--}}
{{--            </div>--}}
{{--        </li>--}}

        <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#employee" aria-expanded="false" aria-controls="employee">
        <span class="menu-icon">
          <i class="mdi mdi-account-multiple-outline"></i>
        </span>
                <span class="menu-title">Employee</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="employee">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{url('admin/employee/add-new')}}">Add Employee</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{url('admin/employee/all-list')}}">Employee List</a></li>

                    @if(\Illuminate\Support\Facades\Request::route('ViewEmpId'))
                        <li class="nav-item"> <a class="nav-link" href="{{url("admin/employee/view/")}}/{{\Illuminate\Support\Facades\Request::route('ViewEmpId')}}">View Employee</a></li>
                    @endif

                    @if(\Illuminate\Support\Facades\Request::route('editEmpId'))
                        <li class="nav-item"> <a class="nav-link" href="{{url("admin/employee/edit/")}}/{{\Illuminate\Support\Facades\Request::route('editEmpId')}}">Edit Employee</a></li>
                    @endif

                    <li class="nav-item"> <a class="nav-link" href="{{url('admin/employee/add-position')}}">Create Position</a></li>

                    <li class="nav-item"> <a class="nav-link" href="{{url('admin/employee/position-list')}}">Position list</a></li>

                    @if(\Illuminate\Support\Facades\Request::route('positionId'))
                        <li class="nav-item"> <a class="nav-link" href="{{url("admin/employee/edit-position/")}}/{{\Illuminate\Support\Facades\Request::route('positionId')}}">Edit Position</a></li>
                    @endif
                    <li class="nav-item"> <a class="nav-link" href="{{url('admin/employee/set-grade')}}">Set Salary Grade</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#department" aria-expanded="false" aria-controls="department">
        <span class="menu-icon">
          <i class="mdi mdi-bulletin-board"></i>
        </span>
                <span class="menu-title">Department</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="department">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{url('/')}}/admin/add-department">Add New</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{url('/')}}/admin/department-list">Department List</a></li>
                    @if(\Illuminate\Support\Facades\Request::route('depId'))
                    <li class="nav-item"> <a class="nav-link" href="{{url('/')}}/admin/view-department/{{\Illuminate\Support\Facades\Request::route('depId')}}">View Department</a></li>
                    @endif
                    @if(\Illuminate\Support\Facades\Request::route('editDepId'))
                    <li class="nav-item"> <a class="nav-link" href="{{url('/')}}/admin/edit-department/{{\Illuminate\Support\Facades\Request::route('editDepId')}}">Edit Department</a></li>
                    @endif
                </ul>
            </div>
        </li>

        <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#salary" aria-expanded="false" aria-controls="salary">
        <span class="menu-icon">
          <i class="mdi mdi-currency-usd"></i>
        </span>
                <span class="menu-title">Salary Grade</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="salary">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{url('admin/grade/salary/add-grade/')}}">Add New Grade</a></li>

                    @if(\Illuminate\Support\Facades\Request::route('gradeIdEdit'))
                        <li class="nav-item"> <a class="nav-link" href="{{url("admin/grade/salary/edit-grade/").'/'.\Illuminate\Support\Facades\Request::route('gradeIdEdit')}}">Edit Grade</a></li>
                    @endif

                    @if(\Illuminate\Support\Facades\Request::route('gradeIdView'))
                        <li class="nav-item"> <a class="nav-link" href="{{url("admin/grade/salary/view-grade/").'/'.\Illuminate\Support\Facades\Request::route('gradeIdView')}}">View Grade</a></li>
                    @endif

                    <li class="nav-item"> <a class="nav-link" href="{{url('admin/grade/salary/grade-list')}}">Grade List</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#attendance" aria-expanded="false" aria-controls="attendance">
        <span class="menu-icon">
{{--          <i class="mdi mdi-book-open"></i>--}}
          <i class="mdi mdi-fingerprint"></i>
        </span>
                <span class="menu-title">Attendance</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="attendance">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{url('admin/attendance/add-attendance')}}">Add Attendance</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{url('admin/attendance/attendance-list')}}">Attendance List</a></li>
                    @if(\Illuminate\Support\Facades\Request::route('attId'))
                        <li class="nav-item"> <a class="nav-link" href="{{url("admin/attendance/view-attendance/").'/'.\Illuminate\Support\Facades\Request::route('attId')}}">View Attendance</a></li>
                    @endif
                </ul>
            </div>
        </li>

        <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#payroll" aria-expanded="false" aria-controls="payroll">
        <span class="menu-icon">
          <i class="mdi mdi-android"></i>
        </span>
                <span class="menu-title">Payroll</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="payroll">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{url('admin/payroll/prepare-salary')}}">Prepare Monthly Salary</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{url('admin/payroll/salary-list')}}">Prepared Salary List</a></li>
                    @if(\Illuminate\Support\Facades\Request::route('sa_id'))
                        <li class="nav-item"> <a class="nav-link" href="{{url("admin/payroll/salary-view/").'/'.\Illuminate\Support\Facades\Request::route('sa_id')}}">View Salary</a></li>
                    @endif
                </ul>
            </div>
        </li>

        <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#loan" aria-expanded="false" aria-controls="loan">
        <span class="menu-icon">
          <i class="mdi mdi-code-string"></i>
        </span>
                <span class="menu-title">Loan</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="loan">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{url("admin/loan/add-loan")}}">Proposed New Loan</a></li>
                @if(\Illuminate\Support\Facades\Request::route('pLId'))
                    <li class="nav-item"> <a class="nav-link" href="{{url("admin/loan/view-proposed-loan/").'/'.\Illuminate\Support\Facades\Request::route('pLId')}}">View Proposed Loan</a></li>
                @endif
                @if(\Illuminate\Support\Facades\Request::route('pEditLId'))
                    <li class="nav-item"> <a class="nav-link" href="{{url("admin/loan/edit-proposed-loan/").'/'.\Illuminate\Support\Facades\Request::route('pEditLId')}}">Edit Proposed Loan</a></li>
                @endif
                @if(\Illuminate\Support\Facades\Request::route('loanTypeID'))
                    <li class="nav-item"> <a class="nav-link" href="{{url("admin/loan/edit-loan-type/").'/'.\Illuminate\Support\Facades\Request::route('loanTypeID')}}">Edit/View Loan Type</a></li>
                @endif
                    <li class="nav-item"> <a class="nav-link" href="{{url('admin/loan/loan-list')}}">Loan List</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{url('admin/loan/loan-request-list')}}">Request List</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{url('admin/loan/loan-running-list')}}">Running Loan List</a></li>
                @if(\Illuminate\Support\Facades\Request::route('runningLnID'))
                    <li class="nav-item"> <a class="nav-link" href="{{url("admin/loan/view-running-loan/").'/'.\Illuminate\Support\Facades\Request::route('runningLnID')}}">View Running Loan</a></li>
                @endif
                @if(\Illuminate\Support\Facades\Request::route('appLnID'))
                    <li class="nav-item"> <a class="nav-link" href="{{url("admin/loan/view-app-loan/").'/'.\Illuminate\Support\Facades\Request::route('appLnID')}}">View Loan Request</a></li>
                @endif
                    <li class="nav-item"> <a class="nav-link" href="#">Loan Terms & Policy</a></li>
                </ul>
            </div>
        </li>

{{--        <li class="nav-item menu-items">--}}
{{--            <a class="nav-link" data-toggle="collapse" href="#training" aria-expanded="false" aria-controls="training">--}}
{{--        <span class="menu-icon">--}}
{{--          <i class="mdi mdi-gift"></i>--}}
{{--        </span>--}}
{{--                <span class="menu-title">Training</span>--}}
{{--                <i class="menu-arrow"></i>--}}
{{--            </a>--}}
{{--            <div class="collapse" id="training">--}}
{{--                <ul class="nav flex-column sub-menu">--}}
{{--                    <li class="nav-item"> <a class="nav-link" href="#">Training Create</a></li>--}}
{{--                    <li class="nav-item"> <a class="nav-link" href="#">Set Training</a></li>--}}
{{--                    <li class="nav-item"> <a class="nav-link" href="#">Training List</a></li>--}}
{{--                    <li class="nav-item"> <a class="nav-link" href="#">Perform List</a></li>--}}
{{--                    <li class="nav-item"> <a class="nav-link" href="#">Training History</a></li>--}}
{{--                </ul>--}}
{{--            </div>--}}
{{--        </li>--}}

        <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#project" aria-expanded="false" aria-controls="project">
        <span class="menu-icon">
          <i class="mdi mdi-group"></i>
        </span>
                <span class="menu-title">Project</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="project">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{url("admin/project/add-project")}}">Add New Project</a></li>
                    @if(\Illuminate\Support\Facades\Request::route('pShowID'))
                        <li class="nav-item"> <a class="nav-link" href="{{url("admin/project/view-project/").'/'.\Illuminate\Support\Facades\Request::route('pShowID')}}">View Project</a></li>
                    @endif
                    @if(\Illuminate\Support\Facades\Request::route('pEditID'))
                        <li class="nav-item"> <a class="nav-link" href="{{url("admin/project/edit-project/").'/'.\Illuminate\Support\Facades\Request::route('pEditID')}}">Edit Project</a></li>
                    @endif
                    <li class="nav-item"> <a class="nav-link" href="{{url('admin/project/project-list')}}">Project List</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{url('admin/project/create-team')}}">Create Team</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{url('admin/project/team-list')}}">Team List</a></li>
                    @if(\Illuminate\Support\Facades\Request::route('teamID'))
                        <li class="nav-item"> <a class="nav-link" href="{{url("admin/project/edit-team").'/'.\Illuminate\Support\Facades\Request::route('teamID')}}">View/Edit Team</a></li>
                    @endif
                    <li class="nav-item"> <a class="nav-link" href="{{url('admin/project/set-team')}}">Set Project + Team</a></li>
{{--                    <li class="nav-item"> <a class="nav-link" href="#">Project Report</a></li>--}}
                </ul>
            </div>
        </li>

        <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#recruitment" aria-expanded="false" aria-controls="recruitment">
        <span class="menu-icon">
          <i class="mdi mdi-link-variant"></i>
        </span>
                <span class="menu-title">Recruitment</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="recruitment">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{url('admin/recruitment/create')}}">Create</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{url('admin/recruitment/recruitment-list')}}">List</a></li>
                    @if(\Illuminate\Support\Facades\Request::route('recrtID'))
                        <li class="nav-item"> <a class="nav-link" href="{{url("admin/recruitment/view-recruitment/").'/'.\Illuminate\Support\Facades\Request::route('recrtID')}}">View Recruitment </a></li>
                    @endif
                    @if(\Illuminate\Support\Facades\Request::route('recrtEditID'))
                        <li class="nav-item"> <a class="nav-link" href="{{url("admin/recruitment/edit-recruitment/").'/'.\Illuminate\Support\Facades\Request::route('recrtEditID')}}">Edit Recruitment </a></li>
                    @endif
                    @if(\Illuminate\Support\Facades\Request::route('cvID'))
                        <li class="nav-item"> <a class="nav-link" href="{{url("admin/recruitment/view-cv/").'/'.\Illuminate\Support\Facades\Request::route('cvID')}}">View CV </a></li>
                    @endif
                    <li class="nav-item"> <a class="nav-link" href="{{url('admin/recruitment/cv-list')}}">List of CV</a></li>
                </ul>
            </div>
        </li>

{{--        <li class="nav-item menu-items">--}}
{{--            <a class="nav-link" data-toggle="collapse" href="#award" aria-expanded="false" aria-controls="award">--}}
{{--        <span class="menu-icon">--}}
{{--          <i class="mdi mdi-trophy"></i>--}}
{{--        </span>--}}
{{--                <span class="menu-title">Award</span>--}}
{{--                <i class="menu-arrow"></i>--}}
{{--            </a>--}}
{{--            <div class="collapse" id="award">--}}
{{--                <ul class="nav flex-column sub-menu">--}}
{{--                    <li class="nav-item"> <a class="nav-link" href="#">Create</a></li>--}}
{{--                    <li class="nav-item"> <a class="nav-link" href="#">List</a></li>--}}
{{--                    <li class="nav-item"> <a class="nav-link" href="#">List of CV</a></li>--}}
{{--                </ul>--}}
{{--            </div>--}}
{{--        </li>--}}

        <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#app-setting" aria-expanded="false" aria-controls="app-setting">
        <span class="menu-icon">
          <i class="mdi mdi-settings text-success"></i>
        </span>
                <span class="menu-title">App Setting</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="app-setting">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{url("admin/app/setting/general")}}">General</a></li>
                </ul>
            </div>
        </li>
{{--        <li class="nav-item menu-items">--}}
{{--            <a class="nav-link" href="documentation">--}}
{{--        <span class="menu-icon">--}}
{{--          <i class="mdi mdi-file-document-box"></i>--}}
{{--        </span>--}}
{{--                <span class="menu-title">Documentation</span>--}}
{{--            </a>--}}
{{--        </li>--}}
    </ul>
</nav>
