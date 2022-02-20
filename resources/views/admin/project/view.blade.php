@extends('layouts.admin.main')
@section('content')
<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="card-title">View Project</h4>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label" for="title">Project title</label>
                                <div class="col-sm-12">
                                    <input class="form-control text-dark" disabled value="{{@$project->p_title}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label" for="duration">Project Duration</label>
                                <div class="col-sm-5">
                                    <div class="row-r">
                                        <input class="form-control text-dark" disabled value="{{@$project->p_duration}}">
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <input class="form-control text-dark" disabled value="@if($project->p_month) {{'Months'}} @elseif($project->p_year) {{'Years'}} @endif">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label" for="start">Project Start Date</label>
                                <div class="col-sm-12">
                                    <input class="form-control text-dark" id="start" disabled value="{{date($project->p_start_date)}}" >
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label" for="end">Project End Date </label>
                                <div class="col-sm-12">
                                    <input class="form-control text-dark" id="start" disabled value="{{date($project->p_end_date)}}" >
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="location" class="col-form-label">Project Location</label>
                                <input class="form-control text-dark" id="location" disabled value="{{$project->p_location}}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="dep" class="col-form-label">Project Department</label>
                                <select id="dep" class="form-control text-dark" disabled>
                                    <option></option>
                                    @if(count($departments))
                                        @foreach($departments as $dep)
                                            <option value="{{$dep->dep_id}}" {{($dep->dep_id == $project->p_dep_id)?'selected':''}} >{{$dep->dep_name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="status" class="col-form-label">Project Status</label>
                                <select id="status" class="form-control text-dark" disabled>
                                    <option value="1" {{$project->p_status?'selected':''}}>Active</option>
                                    <option value="0" {{!$project->p_status?'selected':''}}>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label" for="details">Project Details</label>
                                <textarea class="form-control text-dark" id="details" rows="5" spellcheck="false"  disabled>{{$project->p_description}}</textarea>
                            </div>
                        </div>
                    </div>
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
