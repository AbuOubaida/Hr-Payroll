@extends('layouts.admin.main')
@section('content')
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Recruitment</h4>
                <form class="form-sample" action="{{route('updateRecruitment')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <p class="card-description"> Recruitment info </p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-6 col-form-label" for="title">Recruitment Title</label>
                                <label class="col-sm-6 col-form-label" for="vacancies">Number of vacancies</label>
                                <div class="col-sm-6">
                                    <input id="title" name="title" type="text" class="form-control" required value="{{$recruitment->r_title}}">
                                    <small class="float-left text-gray">e.g. SR</small>
                                    <small class="float-right text-success">Required</small>
                                </div>
                                <div class="col-sm-6">
                                    <input id="vacancies" name="vacancies" type="number" class="form-control" required value="{{$recruitment->r_vacancies}}">
                                    <small class="float-left text-gray">e.g. 1...n</small>
                                    <small class="float-right text-success">Required</small>
                                </div>
                            </div>
                            <input type="hidden" value="{{$recruitment->r_id}}" name="id">
                            <div class="form-group row">
                                <label class="col-sm-6 col-form-label" for="start">Apply Start Date</label>
                                <label class="col-sm-6 col-form-label" for="end">End Date</label>
                                <div class="col-sm-6">
                                    <input id="start" name="start" type="date" class="form-control" required value="{{$recruitment->r_start_at}}">
                                    <small class="float-right text-success">Required</small>
                                </div>
                                <div class="col-sm-6">
                                    <input id="end" name="end" type="date" class="form-control" required value="{{$recruitment->r_end_at}}">
                                    <small class="float-right text-success">Required</small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-sm-3 col-form-label">Contact Email</label>
                                <div class="col-sm-9">
                                    <input id="email" type="email" class="form-control" name="email" value="{{$recruitment->r_c_email}}">
                                    <small class="float-left text-gray">e.g. example@domain.ext</small>
                                    <small class="float-right text-success">Required</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="phone" class="col-sm-3 col-form-label">Contact Phone</label>
                                <div class="col-sm-3">
                                    <div class="row-r">
                                        @if($country)
                                            <select class="form-control text-white" id="PhoneCode" name="countryCode">
                                                @foreach($country as $c)
                                                    <option value="{{$c->phonecode}}" @if($recruitment->r_c_phone_code == $c->phonecode){{'selected'}}@endif>{{$c->iso}}-{{$c->phonecode}}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <input id="PhoneCode" class="form-control" type="number" name="countryCode" placeholder="Country Code" value="{{$recruitment->r_c_phone_code}}">
                                        @endif
                                        <small class="float-left text-gray">e.g. BD-880</small>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <input id="phone" type="number" class="form-control" name="phone" value="{{$recruitment->r_c_phone}}" placeholder="1512345678">
                                    <small class="float-left text-gray">Must be 10 digit</small>
                                    <small class="float-right text-success">Required</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-6 col-form-label" for="dep">Department</label>
                                <label class="col-sm-6 col-form-label" for="doc">Attest if any document</label>
                                <div class="col-sm-6">
                                    <select class="form-control" id="dep" name="dep" required>
                                        @if($departments)
                                            <option >--Select Department--</option>
                                            @foreach($departments as $d)
                                                <option value="{{$d->d_id}}" @if($recruitment->r_dep_id == $d->d_id) selected @endif>{{$d->d_name}}</option>
                                            @endforeach
                                        @else
                                            <option >Not Found</option>
                                        @endif
                                    </select>
                                    <small class="float-right text-success">Required</small>
                                </div>
                                <div class="col-sm-6">
                                    <input id="doc" type="file" class="form-control" name="doc">
                                    <small class="float-left text-gray">.jpg/.jpeg/.pdf/.text < 30mb</small>
                                    <small class="float-right text-primary">optional</small>
                                </div>
                                <div class="col-sm-12">
                                    <span class="text-warning">Selected Document:</span>
                                    @if($recruitment->r_doc)
                                    <a href="{{url("file/admin/recruitments/$recruitment->r_doc")}}">{{$recruitment->r_doc}}</a>
                                    @else
                                    <span class="text-danger">No Document are selected</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-6 col-form-label" for="salary">Offer Salary</label>
                                <label class="col-sm-6 col-form-label" for="end">Job Location</label>
                                <div class="col-sm-6">
                                    <input id="salary" name="salary" type="number" class="form-control" required value="{{$recruitment->salary_range}}">
                                    <small class="float-left text-gray">e.g. 20000</small>
                                    <small class="float-right text-success">Required</small>
                                </div>
                                <div class="col-sm-6">
                                    <input id="location" name="location" type="text" class="form-control" required value="{{$recruitment->location}}">
                                    <small class="float-left text-gray">e.g. city, country</small>
                                    <small class="float-right text-success">Required</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="details" class="col-sm-12 col-form-label">Recruitment Details</label>
                                <div class="col-sm-12">
                                    <textarea name="details" class="form-control" id="details" rows="19" spellcheck="false">{{$recruitment->r_details}}</textarea>
                                    <small class="float-right text-primary">optional</small>
                                </div>
                            </div>
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
{{--    @include('layouts.admin.department.active-list')--}}
@stop
