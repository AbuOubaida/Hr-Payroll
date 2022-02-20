@extends('layouts.admin.main')
@section('content')
    <div class="row">
        <div class="cover-image-section cover-image-section" style='background-image: linear-gradient(rgba(0, 0, 255, 0.5), rgb(255 255 255 / 97%)), url("{{url("image/employee/cover/{$employee->cover}")}}")'>
            <div class="row">
                <div class="col-md-12 text-center">
                        @if($employee->profile)
                        <br>
                        <img class="thumbnail profile-pic-lg" src="{{url("image/employee/profile/{$employee->profile}")}}">
                        @else
                        <br><br><br><br>
                        @endif
                </div>
            </div>
            <h1 class="text-center department-title" style="color: #2d89b0;">Welcome to Profile of {{$employee->emp_name}}</h1>
            <h2 class="text-center department-title text-dark">ID #{{$employee->emp_no}}</h2>
            @if($employee->emp_id == \Illuminate\Support\Facades\Auth::user()->id)
                <h3 class="text-danger text-center">Your Profile</h3>
            @endif
        </div>
        <div class="bg-white d-block w-100 p-5 dep-info">
            <div class="row">
                <div class="col-sm-4">
                    @if($employee->emp_id != \Illuminate\Support\Facades\Auth::user()->id && $employee->emp_no)
                    <form action="{{route('change.role')}}" method="post">
                        <div class="row">
                            <div class="col-sm-9">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend input-group-sm">
                                            <span class="input-group-text">Login Role</span>
                                        </div>
                                        <input type="hidden" name="id" value="{{$employee->emp_id}}">
                                        <select class="form-control text-white" id="role" name="role" onchange="return filterEmp(this)">
                                            @foreach($roles as $role)
                                                <option value="{{$role->role_id}}" @if($employee->role_id == $role->role_id) selected @endif >{{$role->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row">
                                    <button class="btn btn-success form-control">Change</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    @endif
                </div>
                <div class="col-sm-2">

                </div>
                <div class="col-sm-6">
                    @if($employee->role_id > \Illuminate\Support\Facades\Auth::user()->roles->first()->id)
                        {{--                                Delete--}}
                        <a href="{{url("admin/employee/delete/$employee->emp_id")}}" class="float-right" onclick="return confirm('Are you sure delete this Department')"><button type="button" class="btn btn-outline-danger btn-icon-text"> Delete <i class="mdi mdi-delete btn-icon-append"></i></button></a>
                        {{--                                Edit--}}
                        <a href="{{url("admin/employee/edit/$employee->emp_id")}}" class="float-right mr-2"><button type="button" class="btn btn-outline-primary btn-icon-text"> Edit <i class="mdi mdi-file-check btn-icon-append"></i></button></a>
{{--                        Change Password--}}
                        <a href="{{url("admin/employee/change-password/{$employee->emp_id}")}}" class="btn btn-outline-success float-right mr-1">Change Password <i class="mdi mdi-account-key btn-icon-append"></i></a>
                    @elseif($employee->emp_id == \Illuminate\Support\Facades\Auth::user()->id)
                        <a href="{{url("admin/employee/edit/$employee->emp_id")}}" class="float-right mr-2"><button type="button" class="btn btn-outline-primary btn-icon-text"> Edit <i class="mdi mdi-file-check btn-icon-append"></i></button></a>
                        {{--                        Change Password--}}
                        <a href="{{url("admin/employee/change-password/{$employee->emp_id}")}}" class="btn btn-outline-success float-right mr-1">Change Password <i class="mdi mdi-account-key btn-icon-append"></i></a>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    @if(!$employee->emp_no)
                        <div class="alert alert-danger alert-dismissible fade show w-auto pb-0" role="alert">
                            <span class="text-justify"> <b> <h3 style="vertical-align:-webkit-baseline-middle;" class="d-inline-block"><i class="mdi mdi-alert-circle"></i></h3> Be careful Handle this profile,</b> Because it is not from an authentic source! </span>

                            <span class="float-right"><b class="text-success">Recommend for</b> <a href="{{url("admin/employee/delete/{$employee->emp_id}")}}" class="btn btn-outline-danger btn-sm">Delete</a></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="">
                        <h3 class="text-info">Personal Information</h3>
                        <table class="text-dark">
                            <tbody>
                            <tr>
                                <th>Name </th>
                                <th>: </th> <th>&nbsp;</th>
                                <td> {{$employee->emp_name}}</td>
                            </tr>
                            <tr>
                                <th>Email </th>
                                <th>: </th> <th>&nbsp;</th>
                                <td> {{$employee->email}}</td>
                            </tr>
                            <tr>
                                <th>Phone </th>
                                <th>: </th> <th>&nbsp;</th>
                                <td> {{$employee->phone_code}}{{$employee->phone}}</td>
                            </tr>
                            <tr>
                                <th>Date of Birth </th>
                                <th>: </th> <th>&nbsp;</th>
                                <td>
                                    @if($employee->dob)
                                        {{--                                {{$employee->dob->format('Y-m-d')}}--}}
                                        {{date('d-m-Y', strtotime($employee->dob))}}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Gender </th>
                                <th>: </th> <th>&nbsp;</th>
                                <td>
                                    @if($employee->gender == 1)
                                        Male
                                    @elseif($employee->gender == 2)
                                        Female
                                    @elseif($employee->gender == 3)
                                        Other
                                    @else
                                        <span class="text-danger">Not Define</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Address </th>
                                <th>: </th> <th>&nbsp;</th>
                                <td>
                                    {{$employee->address}}
                                    @if($employee->country)
                                        {{$employee->country}}
                                    @endif
                                </td>
                            </tr>

                            </tbody>
                        </table>
                        <br><br>
                    </div>
                </div>
                <div class="col-sm-6">
                    <h3 class="text-info">Official Information</h3>
                    <table class="text-dark">
                        <tbody>
                        <tr>
                            <th>Employee ID </th>
                            <th>: </th> <th>&nbsp;</th>
                            <td> {{$employee->emp_no}}</td>
                        </tr>
                        <tr>
                            <th>Status </th>
                            <th>: </th> <th>&nbsp;</th>
                            <td>
                                @if($employee->emp_status == 1)
                                    <b class="text-success">Active</b>
                                @else
                                    <b class="text-danger">Inactive</b>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Join Date </th>
                            <th>: </th> <th>&nbsp;</th>
                            <td>
                                @if($employee->emp_create)
                                    {{--                                {{$employee->emp_create->format('Y-m-d')}}--}}
                                    {{date('d-m-Y', strtotime($employee->emp_create))}}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Department </th>
                            <th>: </th> <th>&nbsp;</th>
                            <td class="text-justify"><a href="{{url("admin/view-department/{$employee->dep_id}")}}" target="_blank">{{$employee->dep_name}} ({{$employee->dep_name}}-{{$employee->dep_code}})</a></td>
                        </tr>
                        <tr>
                            <th>Employee Post </th>
                            <th>: </th> <th>&nbsp;</th>
                            <td class="text-justify"><a href="{{url("admin/employee/edit-position/{$employee->p_id}")}}" target="_blank">{{$employee->p_name}}</a></td>
                        </tr>
                        <tr>
                            <th>Salary Grade </th>
                            <th>: </th> <th>&nbsp;</th>
                            <td class="text-justify"><a href="{{url("/admin/grade/salary/view-grade/{$employee->grd_id}")}}" target="_blank">{{$employee->grd_name}} ({{$employee->grd_short}})</a></td>
                        </tr>
                        <tr>
                            <th>Salary Basic </th>
                            <th>: </th> <th>&nbsp;</th>
                            <td class="text-justify"><a href="{{url("/admin/grade/salary/view-grade/{$employee->grd_id}")}}" target="_blank">{{$employee->grade_basic}}</a></td>
                        </tr>
                        <tr>
                            <th>Login Role </th>
                            <th>: </th> <th>&nbsp;</th>
                            <td class="text-justify text-info">As {{$employee->role_name}}</td>
                        </tr>

                        </tbody>
                    </table>
                    <br><br>
                </div>
            </div>
        </div>

    </div>
    {{--Employee List--}}
    <div class="row">
        @include('layouts.admin.employee.employee-list')
    </div>
    <style>
        .content-wrapper{
            padding: 0;
        }
    </style>
@stop
