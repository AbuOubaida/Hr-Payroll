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
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-format-line-spacing"></span>
        </button>
    </div>
</nav>
