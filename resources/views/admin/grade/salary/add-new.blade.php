@extends('layouts.admin.main')
@section('content')
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <h4 class="card-title">Add New Salary Grade</h4>
                        <p class="card-description">New Grade info </p>
                        <form class="form-sample" method="post" action="{{route('add.grade')}}">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for="title">Grade title</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" name="title" id="title" required placeholder="Enter Title" value="{{old('title')}}">
                                            <small class="float-right text-success">Required</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for="title-sm">Grade Short Name</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="title-sm" name="short_name" required placeholder="Enter Short Name" value="{{old('short_name')}}">
                                            <small class="float-right text-success">Required</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for="basic">Basic</label>
                                        <div class="col-sm-12">
                                            <input type="number" class="form-control" id="basic" name="basic" required placeholder="Enter Basic" value="{{old('basic')}}">
                                            <small class="float-right text-success">Required</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label" for="grade_details">Grade Details</label>
                                        <textarea name="details" class="form-control" id="grade_details" rows="5" spellcheck="false" placeholder="Enter Grade Details">{{old('grade_details')}}</textarea>
                                        <small class="float-right text-primary">Optional</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <label class="col-form-label">Including</label>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-check form-check-success">
                                            <label class="form-check-label text-success" title="Travel Allowance">
                                                <input value="1" type="checkbox" class="form-check-input" name="ta"> TA<i class="input-helper"></i></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-check form-check-primary">
                                            <label class="form-check-label text-primary" title="Daily Allowance">
                                                <input value="1" type="checkbox" class="form-check-input" name="da"> DA <i class="input-helper"></i></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-check form-check-info">
                                            <label class="form-check-label text-info" title="House Rent Allowance">
                                                <input value="1" type="checkbox" class="form-check-input" name="hra"> HRA <i class="input-helper"></i></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-check form-check-danger">
                                            <label class="form-check-label text-danger" title="Medical Allowance">
                                                <input value="1" type="checkbox" class="form-check-input" name="mda"> MDA <i class="input-helper"></i></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-check form-check-warning">
                                            <label class="form-check-label text-warning" title="Yearly Bonus">
                                                <input value="1" type="checkbox" class="form-check-input" name="bonus"> Bonus <i class="input-helper"></i></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-check form-check-secondary">
                                            <label class="form-check-label text-secondary" title="Provident Fund">
                                                <input value="1" type="checkbox" class="form-check-input" name="pf"> PF <i class="input-helper"></i></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-check form-check-success">
                                            <label class="form-check-label text-success" title="Professional Tax">
                                                <input value="1" type="checkbox" class="form-check-input" name="pt"> PT <i class="input-helper"></i></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group float-right mt-2">
                                        <input type="submit" class="btn btn-success">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-6">
                        <h4 class="card-title">Salary Grade list</h4>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend input-group-sm">
                                            <span class="input-group-text"><i class="mdi mdi-account-search"></i></span>
                                        </div>
                                        <input type="text" class="form-control " placeholder="Search by Grade Title or Range or Short Name" onkeyup="return searchGrade(this)">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="table-responsive" id="grade-table">
                                    @include('layouts.admin.grade.salary._grade-table')
                                    <div class="col-sm-12 position">
                                    @if($grades->links())
                                        {{$grades->links()}}
                                    @endif
                                    </div>
                                    <div class="col-sm-12 position">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
