<nav class="navbar p-0 fixed-top d-flex flex-row">
    <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
        <a class="navbar-brand brand-logo-mini" href="index.html"><img src="{{url('/')}}/image/logo payroll small.png" alt="logo" /></a>
    </div>
    <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
        </button>
        <ul class="navbar-nav w-100">
            <li class="nav-item w-100">
                <div class="row">
                    <div class="col-sm-4">
{{--                        <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search">--}}
{{--                            <input type="text" class="form-control w-100" placeholder="Search products">--}}
{{--                        </form>--}}
                    </div>
                    <div class="col-sm-4 text-info">
                        <b>Time: </b> <small class="clock"></small><br>
                        <b>Date: </b><small>{{date('d/m/Y', strtotime(now()))}}</small>
                    </div>
                    <div class="col-sm-4"></div>
                </div>

            </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item dropdown d-none d-lg-block">
                <a class="nav-link btn btn-success create-new-button" id="createbuttonDropdown" data-toggle="dropdown" aria-expanded="false" href="#">+ Create New</a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="createbuttonDropdown">
                    <h6 class="p-3 mb-0">Navigation</h6>
                    <div class="dropdown-divider"></div>
                    <a href="{{url("admin/employee/add-new")}}" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-account-multiple-outline text-warning"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject ellipsis mb-1">Add Employee</p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{url("admin/add-department")}}" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-bulletin-board text-danger"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject ellipsis mb-1">Add Department</p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{url("admin/grade/salary/add-grade")}}" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-currency-usd text-primary"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject ellipsis mb-1">Add New Salary Grade</p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{url("admin/attendance/add-attendance")}}" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-fingerprint text-success"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject ellipsis mb-1">Add Attendance</p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{url("admin/")}}"><p class="p-3 mb-0 text-center">See all projects</p></a>
                </div>
            </li>
{{--            <li class="nav-item nav-settings d-none d-lg-block">--}}
{{--                <a class="nav-link" href="#">--}}
{{--                    <i class="mdi mdi-view-grid"></i>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item dropdown border-left">--}}
{{--                <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">--}}
{{--                    <i class="mdi mdi-email"></i>--}}
{{--                    <span class="count bg-success"></span>--}}
{{--                </a>--}}
{{--                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">--}}
{{--                    <h6 class="p-3 mb-0">Messages</h6>--}}
{{--                    <div class="dropdown-divider"></div>--}}
{{--                    <a class="dropdown-item preview-item">--}}
{{--                        <div class="preview-thumbnail">--}}
{{--                            <img src="assets/images/faces/face4.jpg" alt="image" class="rounded-circle profile-pic">--}}
{{--                        </div>--}}
{{--                        <div class="preview-item-content">--}}
{{--                            <p class="preview-subject ellipsis mb-1">Mark send you a message</p>--}}
{{--                            <p class="text-muted mb-0"> 1 Minutes ago </p>--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                    <div class="dropdown-divider"></div>--}}
{{--                    <a class="dropdown-item preview-item">--}}
{{--                        <div class="preview-thumbnail">--}}
{{--                            <img src="assets/images/faces/face2.jpg" alt="image" class="rounded-circle profile-pic">--}}
{{--                        </div>--}}
{{--                        <div class="preview-item-content">--}}
{{--                            <p class="preview-subject ellipsis mb-1">Cregh send you a message</p>--}}
{{--                            <p class="text-muted mb-0"> 15 Minutes ago </p>--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                    <div class="dropdown-divider"></div>--}}
{{--                    <a class="dropdown-item preview-item">--}}
{{--                        <div class="preview-thumbnail">--}}
{{--                            <img src="assets/images/faces/face3.jpg" alt="image" class="rounded-circle profile-pic">--}}
{{--                        </div>--}}
{{--                        <div class="preview-item-content">--}}
{{--                            <p class="preview-subject ellipsis mb-1">Profile picture updated</p>--}}
{{--                            <p class="text-muted mb-0"> 18 Minutes ago </p>--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                    <div class="dropdown-divider"></div>--}}
{{--                    <p class="p-3 mb-0 text-center">4 new messages</p>--}}
{{--                </div>--}}
{{--            </li>--}}
{{--            <li class="nav-item dropdown border-left">--}}
{{--                <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">--}}
{{--                    <i class="mdi mdi-bell"></i>--}}
{{--                    <span class="count bg-danger"></span>--}}
{{--                </a>--}}
{{--                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">--}}
{{--                    <h6 class="p-3 mb-0">Notifications</h6>--}}
{{--                    <div class="dropdown-divider"></div>--}}
{{--                    <a class="dropdown-item preview-item">--}}
{{--                        <div class="preview-thumbnail">--}}
{{--                            <div class="preview-icon bg-dark rounded-circle">--}}
{{--                                <i class="mdi mdi-calendar text-success"></i>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="preview-item-content">--}}
{{--                            <p class="preview-subject mb-1">Event today</p>--}}
{{--                            <p class="text-muted ellipsis mb-0"> Just a reminder that you have an event today </p>--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                    <div class="dropdown-divider"></div>--}}
{{--                    <a class="dropdown-item preview-item">--}}
{{--                        <div class="preview-thumbnail">--}}
{{--                            <div class="preview-icon bg-dark rounded-circle">--}}
{{--                                <i class="mdi mdi-settings text-danger"></i>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="preview-item-content">--}}
{{--                            <p class="preview-subject mb-1">Settings</p>--}}
{{--                            <p class="text-muted ellipsis mb-0"> Update dashboard </p>--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                    <div class="dropdown-divider"></div>--}}
{{--                    <a class="dropdown-item preview-item">--}}
{{--                        <div class="preview-thumbnail">--}}
{{--                            <div class="preview-icon bg-dark rounded-circle">--}}
{{--                                <i class="mdi mdi-link-variant text-warning"></i>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="preview-item-content">--}}
{{--                            <p class="preview-subject mb-1">Launch Admin</p>--}}
{{--                            <p class="text-muted ellipsis mb-0"> New admin wow! </p>--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                    <div class="dropdown-divider"></div>--}}
{{--                    <p class="p-3 mb-0 text-center">See all notifications</p>--}}
{{--                </div>--}}
{{--            </li>--}}
            <li class="nav-item dropdown">
                <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                    <div class="navbar-profile">
                        @if(\Illuminate\Support\Facades\Auth::user()->profile_pic)
                            <img class="img-xs rounded-circle " src="{{url('image/employee/profile/'.\Illuminate\Support\Facades\Auth::user()->profile_pic)}}" alt="">
                        @else
                            <div class="img-xs rounded-circle " style="font-size: 36px;"><i class="mdi mdi-account-box-outline"></i></div>
                        @endif
                        <p class="mb-0 d-none d-sm-block navbar-profile-name">{{\Illuminate\Support\Facades\Auth::user()->name}}</p>
                        <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                    <h6 class="p-3 mb-0">Profile</h6>
                    <div class="dropdown-divider"></div>
                    <a href="{{url("admin/app/setting/general")}}" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-settings text-success"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject mb-1">Settings</p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item preview-item" href="{{route('logout')}}">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-logout text-danger"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject mb-1">Log out</p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <p class="p-3 mb-0 text-center">Advanced settings</p>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-format-line-spacing"></span>
        </button>
    </div>
</nav>
