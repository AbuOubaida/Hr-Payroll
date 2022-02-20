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
                    <a href="{{url('employee/account-setting')}}" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-settings text-primary"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject ellipsis mb-1 text-small">Profile</p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{url('employee/change-password')}}" class="dropdown-item preview-item">
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

        <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#project" aria-expanded="true" aria-controls="project">
                <span class="menu-icon">
                  <i class="mdi mdi-group"></i>
                </span>
                <span class="menu-title">Project</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="project">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{url('employee/project/project-list')}}">Project List</a></li>
                    @if(\Illuminate\Support\Facades\Request::route('pShowID'))
                        <li class="nav-item"> <a class="nav-link" href="{{url("employee/project/view-project/").'/'.\Illuminate\Support\Facades\Request::route('pShowID')}}">View Project</a></li>
                    @endif
                    @if(\Illuminate\Support\Facades\Request::route('taskID'))
                        <li class="nav-item"> <a class="nav-link" href="{{url("employee/project/view-task/").'/'.\Illuminate\Support\Facades\Request::route('taskID')}}">View Task</a></li>
                    @endif
{{--                    <li class="nav-item"> <a class="nav-link" href="{{url('employee/project/team/team-list')}}">Team Member List</a></li>--}}
                </ul>
            </div>
        </li>

        <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#loan" aria-expanded="true" aria-controls="loan">
                <span class="menu-icon">
                  <i class="mdi mdi-code-string"></i>
                </span>
                <span class="menu-title">Loan</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="loan">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{url('employee/loan/loan-application')}}">Loan Lists</a></li>
                    @if(\Illuminate\Support\Facades\Request::route('pId'))
                        <li class="nav-item"> <a class="nav-link" href="{{url("employee/loan/view-proposed-loan-project/").'/'.\Illuminate\Support\Facades\Request::route('pId')}}">View Proposed Loan</a></li>
                    @endif
                    @if(\Illuminate\Support\Facades\Request::route('appLoanID'))
                        <li class="nav-item"> <a class="nav-link" href="{{url("employee/loan/view-app-loan/").'/'.\Illuminate\Support\Facades\Request::route('appLoanID')}}">View Apply Loan</a></li>
                    @endif

                </ul>
            </div>
        </li>

        <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#report" aria-expanded="false" aria-controls="report">
                <span class="menu-icon">
                  <i class="mdi mdi-chart-line"></i>
                </span>
                <span class="menu-title">Report</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="report">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{url('employee/attendance/list')}}">Attendance</a></li>
                    @if(\Illuminate\Support\Facades\Request::route('attID'))
                        <li class="nav-item"> <a class="nav-link" href="{{url("employee/attendance/view-attendance/").'/'.\Illuminate\Support\Facades\Request::route('attID')}}">View Attendance</a></li>
                    @endif
                    <li class="nav-item"> <a class="nav-link" href="{{url('employee/salary/all')}}">Salary</a></li>
                    @if(\Illuminate\Support\Facades\Request::route('sa_id'))
                        <li class="nav-item"> <a class="nav-link" href="{{url("employee/salary/salary-view/").'/'.\Illuminate\Support\Facades\Request::route('sa_id')}}">View Salary</a></li>
                    @endif
                </ul>
            </div>
        </li>


    </ul>
</nav>
