@extends('layouts.admin.main')
@section('content')
    <div class="row">
        <div class="cover-image-section cover-image-section" style='background-image: linear-gradient(rgba(0, 0, 255, 0.5), rgb(255 255 255 / 97%)), url("{{url('/')}}/image/department/cover/{{$department->dep_cover_pic}}")'>
            <div class="row">
                <div class="col-md-12 text-center">
                        @if($department->dep_profile_pic)
                        <br>
                        <img class="thumbnail profile-pic-lg" src="{{url('/')}}/image/department/profile/{{$department->dep_profile_pic}}">
                        @else
                        <br><br><br><br>
                        @endif
                </div>
            </div>
            <h1 class="text-center department-title">Welcome to Department of {{$department->dep_name}}</h1>
        </div>
        <div class="bg-grd-white-black d-block w-100 p-5 dep-info">
            <h3 class="text-info">Department Information</h3>
            @if($department->owner_id == \Illuminate\Support\Facades\Auth::user()->id)
{{--            Delete--}}
            <a href="{{url("admin/delete-department/$department->dep_id")}}" class="float-right" onclick="return confirm('Are you sure delete this Department')"><button type="button" class="btn btn-outline-danger btn-icon-text"> Delete <i class="mdi mdi-delete btn-icon-append"></i></button></a>
{{--            Edit--}}
            <a href="{{url('/')}}/admin/edit-department/{{$department->dep_id}}" class="float-right mr-2"><button type="button" class="btn btn-outline-primary btn-icon-text"> Edit <i class="mdi mdi-file-check btn-icon-append"></i></button></a>
            @endif
            <table class="text-dark">
                <tbody>
                    <tr>
                        <th>Name </th>
                        <th>: </th>
                        <td> {{$department->dep_name}}</td>
                    </tr>
                    <tr>
                        <th>Code </th>
                        <th>: </th>
                        <td> {{$department->dep_code}}</td>
                    </tr>
                    <tr>
                        <th>Email </th>
                        <th>: </th>
                        <td> {{$department->dep_email}}</td>
                    </tr>
                    <tr>
                        <th>Phone </th>
                        <th>: </th>
                        <td> {{$department->country_code}}{{$department->dep_phone}}</td>
                    </tr>
                    <tr>
                        <th>Status </th>
                        <th>: </th>
                        <td> @if($department->status == 1) <b class="text-success">Active</b>@else <b class="text-danger">Inactive</b>@endif</td>
                    </tr>
                    <tr>
                        <th>Create by </th>
                        <th>: </th>
                        <td> {{$department->owner_name}}</td>
                    </tr>
                    <tr>
                        <th>Description </th>
                        <th>: </th>
                        <td class="text-justify"> {{$department->dep_description}}</td>
                    </tr>

                </tbody>
            </table>
            <br><br>
        </div>
    @include('layouts.admin.department.active-list')
    </div>
    <style>
        .content-wrapper{
            padding: 0;
        }
    </style>
@stop
