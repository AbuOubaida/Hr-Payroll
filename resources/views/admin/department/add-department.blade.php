@extends('layouts.admin.main')
@section('content')
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Add New Department</h4>
                <form class="form-sample" action="{{route('addDepartment')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <p class="card-description"> Department info </p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-6 col-form-label" for="depName">Dep. Name</label>
                                <label class="col-sm-6 col-form-label" for="depCode">Dep. Code</label>
                                <div class="col-sm-6">
                                    <input id="depName" name="depName" type="text" class="form-control" required value="{{old('depName')}}">
                                    <small class="float-left text-gray">e.g. CSE</small>
                                    <small class="float-right text-success">Required</small>
                                </div>
                                <div class="col-sm-6">
                                    <input id="depCode" name="depCode" type="number" class="form-control" required value="{{old('depCode')}}" onkeyup="return checkCode(this)">
                                    <small class="float-left text-gray">e.g. 123 (must be 3 disit)</small>
                                    <small class="float-right text-success">Required</small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="depEmail" class="col-sm-3 col-form-label">Dep. Email</label>
                                <div class="col-sm-9">
                                    <input id="depEmail" type="email" class="form-control" name="depEmail" value="{{old('depEmail')}}">
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
                                                    <option value="{{$c->id}}" @if($userLocation && $userLocation->countryCode == $c->iso){{'selected'}}@endif>{{$c->iso}}-{{$c->phonecode}}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <input id="PhoneCode" class="form-control" type="number" name="countryCode" placeholder="Country Code">
                                        @endif
                                        <small class="float-left text-gray">e.g. BD-880</small>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <input id="Phone" type="number" class="form-control" name="depPhone" value="{{old('depPhone')}}">
                                    <small class="float-left text-gray">Must be 10 digit</small>
                                    <small class="float-right text-primary">optional</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="depProfile" class="col-sm-3 col-form-label">Dep. Profile Image</label>
                                <div class="col-sm-9">
                                    <input id="depProfile" type="file" class="form-control" name="depProfile">
                                    <small class="float-left text-gray">.jpg/.jpeg/.png/.gif and size<1Mb</small>
                                    <small class="float-right text-primary">optional</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="depCover" class="col-sm-3 col-form-label">Dep. Cover Image</label>
                                <div class="col-sm-9">
                                    <input id="depCover" type="file" class="form-control" name="depCover">
                                    <small class="float-left text-gray">.jpg/.jpeg/.png/.gif and size<1.5Mb</small>
                                    <small class="float-right text-primary">optional</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="depDetails" class="col-sm-12 col-form-label">Department Details</label>
                                <div class="col-sm-12">
                                    <textarea name="depDetails" class="form-control" id="depDetails" rows="19" spellcheck="false">{{old('depDetails')}}</textarea>
                                    <small class="float-right text-primary">optional</small>
                                </div>
                            </div>
                            <div class="form-group float-right">
                                <input type="submit" class="btn btn-success" value="submit" onclick="emptyField(this)">
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
