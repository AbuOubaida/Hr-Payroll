@extends('layouts.employee.main')
@section('content')
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="card-title">View Project (<span class="text-warning">{{$project->p_title}}</span>)</h4>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <h5 class="text-info">Project Information</h5>
                                <table class="table-responsive">
                                    <tbody>
                                    <tr>
                                        <th>Project Title</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">{{$project->p_title}}</td>
                                    </tr>
                                    <tr>
                                        <th>Project Complete Status</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">
                                            @if($project->st_complete)
                                            <span class="text-success">Completed</span>
                                            @else
                                            <span class="text-warning">Running</span>
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Project Duration</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">
                                            {{$project->p_duration}}
                                            @if(((int)$project->p_year) > 0){{'Years'}} @elseif((int)($project->p_month) > 0){{'Months'}} @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Project Start Date</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">{{$project->p_start_date}}</td>
                                    </tr>

                                    <tr>
                                        <th>Project End Date</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">{{$project->p_end_date}}</td>
                                    </tr>
                                    <tr>
                                        <th>Project Location</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">{{$project->p_location}}</td>
                                    </tr>
                                    @if($project->p_description)
                                        <tr>
                                            <th>Project Description</th>
                                            <th>:&nbsp;&nbsp;</th>
                                            <td class="font-weight-light">{{$project->p_description}}</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-6">
                                <h5 class="text-info">Team Information</h5>
                                <table class="table-responsive">
                                    <tbody>
                                    <tr>
                                        <th>Team Title</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">{{$project->team_title}}</td>
                                    </tr>
                                    <tr>
                                        <th>Team Leader</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">{{$project->name}} (Me)</td>
                                    </tr>

                                    <tr>
                                        <th>Team Status</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">
                                            @if($project->team_status)
                                                <span class="text-success">Active</span>
                                            @else
                                                <span class="text-danger">Inactive</span>
                                            @endif
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">My Task List For Project (<span class="text-warning">{{$project->p_title}}</span>)</h4>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive" id="grade-table">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Member</th>
                                        <th>Seen</th>
                                        <th>Complete</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="task-sm-list">
                                @include('layouts.employee.project.task._task_sm_list')
                                </tbody>
                            </table>
                            <div class="position">
{{--                                @if(@$tasks->links())--}}
{{--                                    {!! @$tasks->links() !!}--}}
{{--                                @endif--}}
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
@stop
