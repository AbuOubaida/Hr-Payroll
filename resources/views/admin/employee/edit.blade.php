@extends('layouts.admin.main')
@section('content')
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="card-title d-inline-block">Edit Employee Profile</h4>
                        <a href="{{url("admin/employee/view/{$employee->emp_id}")}}" class="btn btn-outline-warning btn-sm float-right">View <i class="mdi mdi-eye btn-icon-append"></i></a>
                        @if(($employee->role_id > \Illuminate\Support\Facades\Auth::user()->roles->first()->id) || ($employee->emp_id == \Illuminate\Support\Facades\Auth::user()->id))

                        <form action="{{route('employee.password.change')}}" method="post" class="d-inline-block float-right mr-1">
                            <input type="hidden" name="emp_id" value="{{$employee->emp_id}}">
                            <button class="btn btn-outline-success btn-sm" onclick="return confirm('Are you want to change this employee password?')" type="submit"> Change Employee Password <i class="mdi mdi-account-key btn-icon-append"></i></button>
                        </form>
{{--                        <a href="{{url("admin/employee/change-password/{$employee->emp_id}")}}" class="btn btn-outline-success btn-sm float-right mr-1"></a>--}}
                        @endif
                    </div>
                </div>
                <b class="text-info">Profile Status:
                    @if($employee->emp_status == 1)
                        <span class="text-success" id="status">Active</span>
                        @if(($employee->emp_no) && ($employee->emp_id != \Illuminate\Support\Facades\Auth::user()->id))
                        <button type="button" status="0" class="btn btn-sm btn-outline-danger" value="{{$employee->emp_id}}" onclick="changeEmpStatue(this)">Make Inactive</button>
                        @endif
                    @else
                        <span class="text-danger" id="status">Inactive </span>
                        @if(($employee->emp_no) && ($employee->emp_id != \Illuminate\Support\Facades\Auth::user()->id))
                        <button type="button" class="btn btn-sm btn-outline-success" status="1" value="{{$employee->emp_id}}" onclick="changeEmpStatue(this)">Make Active</button>
                         @endif
                    @endif
                </b>

                <b class="text-info float-right">Employee ID @if($employee->emp_no) <span class="text-success" id="employee-id"> #{{$employee->emp_no}}</span>@else <span class="text-danger">Not Defined</span>@endif</b>

                @if(!$employee->emp_no)
                <div class="alert alert-danger alert-dismissible fade show w-auto pb-0" role="alert">
                    <span class="text-justify"> <b> <h3 style="vertical-align:-webkit-baseline-middle;" class="d-inline-block"><i class="mdi mdi-alert-circle"></i></h3> Be careful Handle this profile,</b> Because it is not from an authentic source! </span>

                    <span class="float-right"><b class="text-success">Recommend for</b> <a href="{{url("admin/employee/delete/{$employee->emp_id}")}}" class="btn btn-outline-danger btn-sm">Delete</a></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <form class="form-sample" method="post" action="{{route('update.employee')}}" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group row">
                                <label for="name" class="col-sm-12 col-form-label">First Name</label>
                                <div class="col-sm-12">
                                    <input id="name" type="text" class="form-control" placeholder="Employee Your Name" required name="name" value="{{$employee->emp_name}}">
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
                                                    <option value="{{$c->phonecode}}" @if($employee->phone_code == $c->phonecode){{'selected'}}@endif>{{$c->iso}}-{{$c->phonecode}}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <input id="PhoneCode" class="form-control" type="number" name="countryCode" placeholder="Country Code" required value="{{$employee->phone_code}}">
                                        @endif
                                        <small class="float-right text-success">Require</small>
                                        <small class="float-left text-gray">e.g. BD-880</small>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" required name="emp_phone" placeholder="Employee Phone Number" value="{{$employee->phone}}">
                                    <small class="float-left text-gray">e.g. 1578 123456</small>
                                    <small class="float-right text-success">Require</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="email" class="col-sm-12 col-form-label">Email</label>
                                <div class="col-sm-12">
                                    <input type="email" class="form-control" id="email" name="emp_email" required placeholder="Employee Email Address" value="{{$employee->email}}" onfocusout="return checkEmpEmail(this)">
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
                                        <option value="1" @if($employee->gender == 1) selected @endif>Male</option>
                                        <option value="2" @if($employee->gender == 2) selected @endif>Female</option>
                                        <option value="3" @if($employee->gender == 3) selected @endif>Other</option>
                                    </select>
                                    <small class="float-right text-success">Require</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group row">
                                <label for="dob" class="col-sm-12 col-form-label">Date of Birth</label>
                                <div class="col-sm-12">
                                    <input id="dob" class="form-control" type="date" placeholder="dd/mm/yyyy" name="emp_dob"@if($employee->dob)value="{{Carbon\Carbon::parse($employee->dob)->format('Y-m-d')}}" @endif>
                                    <small class="float-right text-primary">Optional</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <input type="hidden" name="emp_id" value="{{$employee->emp_id}}">
                            <div class="form-group row">
                                <label for="dep" class="col-sm-12 col-form-label text-warning">Department <small class="text-info float-right">Usually no need to change Department</small></label>
                                <div class="col-sm-12">
                                    <select data="{{$employee->emp_id}}" class="form-control" id="dep" onfocus="this.setAttribute('PrvSelectedValue',this.value);"  onchange="if(idGeneratorByDep(this) == false){ this.value=this.getAttribute('PrvSelectedValue');return false; }">
                                        @if($departments)
                                            <option value="0">--Select Department--</option>
                                            @foreach($departments as $d)
                                                <option value="{{$d->d_id}}" @if($employee->dep_id == $d->d_id) selected @endif>{{$d->d_name}}</option>
                                            @endforeach
                                        @else
                                            <option >Not Found</option>
                                        @endif
                                    </select>
                                    <small class="float-left text-info">Changes will be updated Instantly</small>
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
                                        <option value="{{$p->p_id}}" @if($employee->p_id == $p->p_id) selected @endif>{{$p->p_name}}</option>
                                        @endforeach
                                    @else
                                        <option >Not Found</option>
                                    @endif
                                    </select>
                                    <small class="float-right text-success">Require</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="address" class="col-sm-12 col-form-label">Address</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" required name="emp_address" value="{{$employee->address}}" id="address" placeholder="Employee Address">
                                    <small class="float-left text-gray">e.g. Mirpur, Dhaka</small>
                                    <small class="float-right text-success">Required</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="postcode" class="col-sm-12 col-form-label">Postcode</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" name="postcode" value="{{$employee->postcode}}" id="postcode" placeholder="Employee Postcode" required>
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
                                                <option value="{{$cnt->nicename}}" @if($employee->country == $cnt->nicename) selected @endif>{{$cnt->nicename}}</option>
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
                                        <label for="emp-id" class="col-sm-12 col-form-label text-warning">Employee ID</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control text-dark text-center font-weight-bold" value="#{{$employee->emp_no}}" id="emp-id" disabled>
                                            <small class="float-left text-info">Can't Change Manually</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="text-justify col-form-label text-warning"> <b class="text-info">Note: </b> If You Change Employee Department Then Employee ID Will Auto Generate</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-6">
                                    <img id="profile-preview" src="{{url("image/employee/profile/{$employee->profile}")}}" alt="No Image are Selected" height="100px">
                                </div>
                                <div class="col-sm-6">
                                    <img id="cover-preview" src="{{url("image/employee/cover/{$employee->cover}")}}" alt="No Image are Selected" height="100px">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-success float-right">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--Employee List--}}
    @include('layouts.admin.employee.employee-list')
@stop
