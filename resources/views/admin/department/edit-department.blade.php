@extends('layouts.admin.main')
@section('content')
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title d-inline-block">Update Department</h4>
                <a href="{{url('/')}}/admin/view-department/{{$department->dep_id}}" class="float-right">
                    <button type="button" class="btn btn-outline-warning btn-icon-text">
                    <i class="mdi mdi-eye"></i> View </button>
                </a>
                <form class="form-sample" action="{{url('/')}}/admin/update-department/{{$department->dep_id}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <p class="card-description"> Department info </p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-6 col-form-label" for="depName">Dep. Name</label>
                                <label class="col-sm-6 col-form-label" for="depCode">Dep. Code</label>
                                <div class="col-sm-6">
                                    <input id="depName" name="depName" type="text" class="form-control" required value="{{$department->dep_name}}">
                                    <small class="float-left text-gray">e.g. CSE</small>
                                    <small class="float-right text-success">Required</small>
                                </div>
                                <div class="col-sm-6">
                                    <input id="depCode" name="depCode" type="number" class="form-control" required value="{{$department->dep_code}}" onkeyup="return checkCode(this)">
                                    <small class="float-left text-gray">e.g. 123 (must be 3 disit)</small>
                                    <small class="float-right text-success">Required</small>
                                </div>
                            </div>
{{--                            <div class="form-group row">--}}
{{--                                <label class="col-sm-3 col-form-label" for="depName">Dep. Name</label>--}}
{{--                                <div class="col-sm-9">--}}
{{--                                    <input id="depName" name="depName" type="text" class="form-control" required value="{{$department->dep_name}}">--}}
{{--                                    <small class="float-right text-success">Required</small>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="form-group row">
                                <label for="depEmail" class="col-sm-3 col-form-label">Dep. Email</label>
                                <div class="col-sm-9">
                                    <input id="depEmail" type="email" class="form-control" name="depEmail" value="{{$department->dep_email}}">
                                    <small class="float-left text-gray">e.g. example@domain.ext</small>
                                    <small class="float-right text-primary">optional</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="Phone" class="col-sm-3 col-form-label">Dep. Phone</label>
                                <div class="col-sm-3">
                                    <div class="row-r">
                                        @if($country)
                                            <select class="form-control text-white" id="PhoneCode" name="countryCode">
                                                @foreach($country as $c)
                                                    <option value="{{$c->id}}" @if($department->country_code == $c->phonecode){{'selected'}}@endif>{{$c->iso}}-{{$c->phonecode}}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <input id="PhoneCode" class="form-control" type="number" name="countryCode" placeholder="Country Code">
                                        @endif
                                            <small class="float-left text-gray">e.g. BD-880</small>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <input id="Phone" type="number" class="form-control" name="depPhone" value="{{$department->dep_phone}}">
                                    <small class="float-right text-primary">optional</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="depDetails" class="col-sm-3 col-form-label">Details</label>
                                <div class="col-sm-9">
                                    <textarea name="depDetails" class="form-control text-justify" id="depDetails" rows="14" spellcheck="false">{{$department->dep_description}}</textarea>
                                    <small class="float-right text-primary">optional</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="depProfile" class="col-sm-12 col-form-label">Dep. Profile Image</label>
                                <div class="col-sm-12">
                                    <input preview="profile-preview" id="depProfile" type="file" class="form-control" name="depProfile" onchange="previewFile(this)">
                                    <small class="float-left text-gray">.jpg/.jpeg/.png/.gif and size<1Mb</small>
                                    <small class="float-right text-primary">optional</small>
                                </div>
                                <div class="col-md-3">
                                    <img id="profile-preview" src="{{url('/')}}/image/department/profile/{{$department->dep_profile_pic}}" alt="No Image are found" width="100%">
                                </div>
                                <div class="col-md-9">
                                    <table>
                                        <tr>
                                            <th>Type: </th>
                                            <td>Profile Image</td>
                                        </tr>
                                        <tr>
                                            <th>Name: </th>
                                            <td>{{$department->dep_profile_pic}}</td>
                                        </tr>
                                        <tr>
                                            <th>Full View: </th>
                                            <td><a href="{{url('/')}}/image/department/profile/{{$department->dep_profile_pic}}" target="_blank">{{$department->dep_profile_pic}}</a></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="depCover" class="col-sm-12 col-form-label">Dep. Cover Image</label>
                                <div class="col-sm-12">
                                    <input onchange="return previewFile(this)" preview="cover-preview" id="depCover" type="file" class="form-control" name="depCover">
                                    <small class="float-left text-gray">.jpg/.jpeg/.png/.gif and size<1.5Mb</small>
                                    <small class="float-right text-primary">optional</small>
                                </div>
                                <div class="col-md-3">
                                    <img id="cover-preview" src="{{url('/')}}/image/department/cover/{{$department->dep_cover_pic}}" alt="No Image are found" height="100%" width="100%">
                                </div>
                                <div class="col-md-9">
                                    <table>
                                        <tr>
                                            <th>Type: </th>
                                            <td>Cover Image</td>
                                        </tr>
                                        <tr>
                                            <th>Name: </th>
                                            <td>{{$department->dep_cover_pic}}</td>
                                        </tr>
                                        <tr>
                                            <th>Full View: </th>
                                            <td><a href="{{url('/')}}/image/department/cover/{{$department->dep_cover_pic}}" target="_blank">{{$department->dep_cover_pic}}</a></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group float-right">
                                <input type="submit" class="btn btn-success" value="Update" onclick="emptyField(this)">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
{{--    For Show all department--}}
@include('layouts.admin.department.active-list')
@stop
