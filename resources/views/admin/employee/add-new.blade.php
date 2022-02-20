@extends('layouts.admin.main')
@section('content')
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Add New Employee</h4>
                    <form class="form-sample" method="post" action="{{route('store-employee')}}" enctype="multipart/form-data">
                        <p class="card-description"> Personal info </p>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-12 col-form-label">First Name</label>
                                    <div class="col-sm-12">
                                        <input id="name" type="text" class="form-control" placeholder="Employee Your Name" required name="name" value="{{old('name')}}">
                                        <small class="float-left text-gray">e.g. Muhammad</small>
                                        <small class="float-right text-success">Require</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group row">
                                    <label for="c-code" class="col-sm-12 col-form-label">Phone</label>
                                    <div class="col-sm-4">
                                        <div class="row-r">
                                            @if($countries)
                                                <select class="form-control text-white" id="c-code" name="countryCode" required>
                                                    <option>Country Code</option>
                                                    @foreach($countries as $c)
                                                        <option value="{{$c->id}}" @if($userLocation && $userLocation->countryCode == $c->iso){{'selected'}} @elseif(old('countryCode') == $c->id){{'selected'}}@endif>{{$c->iso}}-{{$c->phonecode}}</option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <input id="PhoneCode" class="form-control" type="number" name="countryCode" placeholder="Country Code" required value="{{old('countryCode')}}">
                                            @endif
                                            <small class="float-right text-success">Require</small>
                                            <small class="float-left text-gray">e.g. BD-880</small>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control" required name="emp_phone" placeholder="Employee Phone Number" value="{{old('emp_phone')}}">
                                        <small class="float-left text-gray">e.g. 1578 123456</small>
                                        <small class="float-right text-success">Require</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label for="email" class="col-sm-12 col-form-label">Email</label>
                                    <div class="col-sm-12">
                                        <input type="email" class="form-control" id="email" name="emp_email" required placeholder="Employee Email Address" value="{{old('emp_email')}}" onfocusout="return checkEmpEmail(this)">
                                        <small class="float-left text-gray">e.g. example@domain.ext</small>
                                        <small class="float-right text-success">Require</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group row">
                                    <label for="gender" class="col-sm-12 col-form-label">Gender</label>
                                    <div class="col-sm-12">
                                        <select class="form-control" name="emp_gender" required id="gender">
                                            <option>--Select Gender--</option>
                                            <option value="1" @if(old('emp_gender') == 1) selected @endif>Male</option>
                                            <option value="2" @if(old('emp_gender') == 2) selected @endif>Female</option>
                                            <option value="3" @if(old('emp_gender') == 3) selected @endif>Other</option>
                                        </select>
                                        <small class="float-right text-success">Require</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group row">
                                    <label for="dob" class="col-sm-12 col-form-label">Date of Birth</label>
                                    <div class="col-sm-12">
                                        <input id="dob" class="form-control" type="date" placeholder="dd/mm/yyyy" name="emp_dob" value="{{old('emp_dob')}}">
                                        <small class="float-right text-primary">Optional</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label for="dep" class="col-sm-12 col-form-label">Department</label>
                                    <div class="col-sm-12">
                                        <select class="form-control" id="dep" name="emp_dep" required>
                                            @if($departments)
                                                <option >--Select Department--</option>
                                                @foreach($departments as $d)
                                                    <option value="{{$d->d_id}}" @if(old('emp_dep') == $d->d_id) selected @endif>{{$d->d_name}}</option>
                                                @endforeach
                                            @else
                                                <option >Not Found</option>
                                            @endif
                                        </select>
                                        <small class="float-right text-success">Require</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label for="position" class="col-sm-12 col-form-label">Position</label>
                                    <div class="col-sm-12">
                                        <select class="form-control" id="position" name="emp_position" required>
                                            @if($positions)
                                                <option >--Select Position--</option>
                                                @foreach($positions as $p)
                                                    <option value="{{$p->p_id}}" @if(old('emp_position') == $p->p_id) selected @endif>{{$p->p_name}}</option>
                                                @endforeach
                                            @else
                                                <option >Not Found</option>
                                            @endif
                                        </select>
                                        <small class="float-right text-success">Require</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group row">
                                    <label for="role" class="col-sm-12 col-form-label">Login Role</label>
                                    <div class="col-sm-12">
                                        <select class="form-control" name="emp_role" required id="role">
                                            @if($roles)
                                                <option>--Select Role--</option>
                                                @foreach($roles as $role)
                                                    <option value="{{$role->role_id}}" @if(old('emp_role') == $role->role_id) selected @endif>{{$role->name}}</option>
                                                @endforeach
                                            @else
                                                <option> Not Found</option>
                                            @endif
                                        </select>
                                        <small class="float-right text-success">Required</small>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label for="address" class="col-sm-12 col-form-label">Address</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" required name="emp_address" value="{{old('emp_address')}}" id="address" placeholder="Employee Address">
                                        <small class="float-left text-gray">e.g. Mirpur, Dhaka</small>
                                        <small class="float-right text-success">Required</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label for="postcode" class="col-sm-12 col-form-label">Postcode</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="postcode" value="{{old('postcode')}}" id="postcode" placeholder="Employee Postcode" required>
                                        <small class="float-left text-gray">e.g. Dhaka-1216</small>
                                        <small class="float-right text-success">Required</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label for="emp-country" class="col-sm-12 col-form-label">Country</label>
                                    <div class="col-sm-12">
                                        <select class="form-control" name="emp_country" required id="emp-country">
                                            @if($countries)
                                                <option>--Select Country--</option>
                                                @foreach($countries as $cnt)
                                                    <option value="{{$cnt->nicename}}" @if(old('emp_country') == $cnt->nicename) selected @endif>{{$cnt->nicename}}</option>
                                                @endforeach
                                            @else
                                                <option> Not Found</option>
                                            @endif
                                        </select>
                                        <small class="float-left text-gray">e.g. Bangladesh</small>
                                        <small class="float-right text-success">Required</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="profile" class="col-sm-12 col-form-label">Profile Image</label>
                                            <div class="col-sm-12">
                                                <input preview="profile-preview" type="file" class="form-control" name="emp_profile" id="profile" onchange="previewFile(this)">
                                                <small class="float-right text-primary">Optional</small>
                                                <small class="float-left text-gray">.jpg/.jpeg/.png/.gif < 1Mb</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="cover" class="col-sm-12 col-form-label">Cover Image</label>
                                            <div class="col-sm-12">
                                                <input preview="cover-preview" type="file" class="form-control" name="emp_cover" id="cover" onchange="previewFile(this)">
                                                <small class="float-left text-gray">.jpg/.jpeg/.png/.gif < 1.5Mb</small>
                                                <small class="float-right text-primary">Optional</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="npass" class="col-sm-7 col-form-label">New Password</label>
                                            <label class="col-sm-5 col-form-label"><a class="text-info" style="cursor: pointer" id="" onclick="return generatePassword()">Generate</a></label>
                                            <div class="col-sm-12">
                                                <input type="password" class="form-control" name="emp_npass" id="npass" required placeholder="Employee New Password">
                                                <small class="float-right text-success">Required</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="cpass" class="col-sm-8 col-form-label">Conform Password</label>
                                            <label class="col-sm-4 col-form-label"><a class="text-info" style="cursor: pointer" id="toggol" onclick="return showPassword(this)">Show</a></label>
                                            <div class="col-sm-12">
                                                <input type="password" class="form-control" name="emp_cpass" id="cpass" required placeholder="Employee Conform Password">
                                                <small class="float-right text-success">Required</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <small class="d-block w-100 text-center position-absolute" style="top: -20px" id="message"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <img id="profile-preview" src="" alt="No Image are Selected" height="100px">
                                    </div>
                                    <div class="col-sm-6">
                                        <img id="cover-preview" src="" alt="No Image are Selected" height="100px">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success float-right">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{--Employee List--}}
    <div class="row">
        @include('layouts.admin.employee.employee-list')
    </div>

@stop
