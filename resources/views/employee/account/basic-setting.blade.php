@extends('layouts.employee.main')
@section('content')
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title text-success"><i class="mdi mdi-android"></i> Basic Account Setting</h3>
            </div>
        </div>
    </div>
    {{--                Account Information--}}
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="company-info">
                    <h4>Account Information (Profile of {{$user->name}}) </h4>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="row text-center">
                                <img class="rounded mx-auto d-block" src="{{url("image/employee/profile/$user->profile_pic")}}" alt="No Image are found" width="100px">
                            </div>
                            <br>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Employee ID</span>
                                    </div>
                                    <input type="text" class="form-control text-dark" placeholder="User Name" aria-label="CompanyName" aria-describedby="basic-addon1" disabled value="@if($user->employee_id){{$user->employee_id}}@else{{'Not Define'}}@endif">
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Name</span>
                                    </div>
                                    <input type="text" class="form-control text-dark" placeholder="User Name" aria-label="CompanyName" aria-describedby="basic-addon1" disabled value="{{$user->name}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Email</span>
                                    </div>
                                    <input type="text" class="form-control text-dark" placeholder="User Email" aria-label="CompanyName" aria-describedby="basic-addon1" disabled value="{{$user->email}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Gender</span>
                                    </div>
                                    <input type="text" class="form-control text-dark" placeholder="User Gender" aria-label="CompanyName" aria-describedby="basic-addon1" disabled value="@if($user->gender == 1){{'Male'}}@elseif($user->gender == 2){{'Female'}}@elseif($user->gender == 3){{"Other"}}@else{{'Undefined'}}@endif">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Type</span>
                                    </div>
                                    <input type="text" class="form-control text-dark" placeholder="User Type" aria-label="" aria-describedby="basic-addon1" disabled value="{{$user->roles->first()->display_name}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Phone</span>
                                    </div>
                                    <input type="text" class="form-control text-dark" placeholder="User Phone" aria-label="CompanyName" aria-describedby="basic-addon1" disabled value="{{$user->phone}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Address</span>
                                    </div>
                                    <input type="text" class="form-control text-dark" placeholder="User Address" aria-label="CompanyName" aria-describedby="basic-addon1" disabled value="{{$user->address}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Post Code</span>
                                    </div>
                                    <input type="text" class="form-control text-dark" placeholder="User postcode" aria-label="postcode" aria-describedby="basic-addon1" disabled value="{{$user->postcode}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Country</span>
                                    </div>
                                    <input type="text" class="form-control text-dark" placeholder="User Country" aria-label="Country" aria-describedby="basic-addon1" disabled value="{{$user->country}}">
                                </div>
                            </div>


                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="company-details">Description</label>
                                <textarea class="form-control text-dark text-justify" id="company-details" rows="4" spellcheck="false" disabled>{{$user->description}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{--    Company Information--}}
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="company-info">
                    <h5>Company Information </h5>
                    <p>You (Admin/Project-manage/Employee) can not change company any Information.</p>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Name</span>
                                    </div>
                                    <input type="text" class="form-control text-dark" placeholder="Company Name" aria-label="CompanyName" aria-describedby="basic-addon1" disabled value="{{$company->comp_name}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Email</span>
                                    </div>
                                    <input type="text" class="form-control text-dark" placeholder="Company Name" aria-label="CompanyName" aria-describedby="basic-addon1" disabled value="{{$company->comp_email}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Phone</span>
                                    </div>
                                    <input type="text" class="form-control text-dark" placeholder="Company Name" aria-label="CompanyName" aria-describedby="basic-addon1" disabled value="{{$company->comp_phone}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Address</span>
                                    </div>
                                    <input type="text" class="form-control text-dark" placeholder="Company Name" aria-label="CompanyName" aria-describedby="basic-addon1" disabled value="{{$company->comp_location}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label for="">Company Logo</label>
                            <img class="w-100" src="{{url("image/$company->comp_logo")}}" alt="">
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="company-details">Company Description</label>
                                <textarea class="form-control text-dark text-justify" id="company-details" rows="4" spellcheck="false" disabled>{{$company->comp_details}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
