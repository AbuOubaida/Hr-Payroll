@extends('layouts.admin.main')
@section('content')
<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="card-title">Add New Project</h4>
                    <p class="card-description">New Project info </p>
                    <form class="form-sample" method="post" action="{{route('add.project')}}">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for="title">Project title</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="title" id="title" required placeholder="Enter project title" value="{{old('title')}}">
                                        <small class="float-right text-success">Required</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for="duration">Project Duration</label>
                                    <div class="col-sm-5">
                                        <div class="row-r">
                                            <select class="form-control" id="duration" name="duration" required onchange="calculateEndDate(this)">
                                                <option></option>
                                            @for($i=1;$i <= 12; $i++)
                                                <option value="{{$i}}" {{$i == old('duration')?'selected':''}} >{{$i}}</option>
                                            @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-7">
                                        <select class="form-control" id="monthYear" name="monthYear" required onchange="calculateEndDate(this)">
                                            <option></option>
                                            <option value="{{$i='months'}}" {{$i == old('monthYear')?'selected':''}} >{{$i}}</option>
                                            <option value="{{$i='years'}}" {{$i == old('monthYear')?'selected':''}} >{{$i}}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12">
                                        <small class="float-left text-secondary">6 months' / 1 year</small>
                                        <small class="float-right text-success">Required</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for="start">Project Start Date</label>
                                    <div class="col-sm-12">
                                        <input type="date" class="form-control" id="start" name="start" required value="{{old('start')}}" onchange="calculateEndDate(this)">
                                        <small class="float-right text-success">Required</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for="end">Project End Date </label>
                                    <div class="col-sm-12">
                                        <select class="form-control" id="end" name="end" required>
                                            <option></option>
                                        </select>
                                        <small class="float-left text-warning">(Start + Duration) auto</small>
                                        <small class="float-right text-success">Required</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="location" class="col-form-label">Project Location</label>
                                    <input type="text" class="form-control" name="location" id="location" required placeholder="Enter project location" value="{{old('location')}}">
                                    <small class="float-right text-success">Required</small>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="dep" class="col-form-label">Project Department</label>
                                    <select name="dep" id="dep" class="form-control" required>
                                        <option></option>
                                        @if(count($departments))
                                            @foreach($departments as $dep)
                                                <option value="{{$dep->dep_id}}">{{$dep->dep_name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <small class="float-right text-success">Required</small>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label" for="details">Project Details</label>
                                    <textarea name="details" class="form-control" id="details" rows="5" spellcheck="false" placeholder="Enter Project Details">{{old('details')}}</textarea>
                                    <small class="float-right text-primary">Optional</small>
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
                    <h4 class="card-title">Project list</h4>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend input-group-sm">
                                        <span class="input-group-text"><i class="mdi mdi-account-search"></i></span>
                                    </div>
                                    <input type="text" class="form-control " placeholder="Search by project name or location or department" onkeyup="return searchSmProject(this)">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="table-responsive" id="grade-table">
                                <table class="table table-sm table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Duration</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="project-sm-list">
                                    @include('layouts.admin.project._project_sm_list')
                                    </tbody>
                                </table>
                                <div class="col-sm-12 position">
                                    @if($projects->links())
                                        {{$projects->links()}}
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
