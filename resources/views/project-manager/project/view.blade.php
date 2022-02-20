@extends('layouts.project-manager.main')
@section('content')
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-6">
                                <h4 class="card-title">View Project (<span class="text-warning">{{$project->p_title}}</span>)</h4>
                            </div>
                            <div class="col-sm-6">
                                @if(!$project->st_complete)
                                <form action="{{route('update.complete.status')}}" method="post" class="d-inline-block float-right">
                                    {!! method_field('post') !!}
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="project_id" value="{{$project->project_id }}">
                                    <input type="hidden" name="set_team_id" value="{{$project->set_teams_id}}">
                                    <button class="btn btn-sm btn-outline-warning d-inline-block" onclick="return confirm('Are you sure completed this Project?')" type="submit">Make Complete <i class="mdi mdi-update"></i></button>
                                </form>
                                @endif
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
                                    <tr>
                                        <th>Project Department Name</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">{{$project->dep_name}}</td>
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
                                        <td class="font-weight-light">{{\Illuminate\Support\Facades\Auth::user()->name}} (Me)</td>
                                    </tr>
                                    <tr>
                                        <th>Team Member</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">{{$project->team_member?$project->team_member+1:1}}</td>
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
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="card-title">Team Member list of project this project (<span class="text-warning">{{$project->p_title}}</span>)</h4>
                        <p class="text-secondary">Team Member list Without Project Leader</p>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive" id="grade-table">
                                    <table class="table table-sm table-hover">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Member Name</th>
                                            <th>Member Employee ID</th>
                                            <th>Member Email</th>
                                            <th>Member Phone</th>
                                            <th>Member Department</th>
                                            <th>Team Title</th>
                                        </tr>
                                        </thead>
                                        <tbody id="project-sm-list">
                                        <?php $n=1;?>
                                        @if(count(@$teamMembers))
                                            @foreach($teamMembers as $member)
                                                <tr>
                                                    <td>{{$n++}}</td>
                                                    <td>{{$member->name}}</td>
                                                    <td>#{{$member->employee_id}}</td>
                                                    <td>{{$member->email}}</td>
                                                    <td>{{$member->phone_code}}-{{$member->phone}}</td>
                                                    <td>{{$member->dep_name}}</td>
                                                    <td>{{$member->team_title}}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="7" class="text-center text-danger">Not found!</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
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
</div>
<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Create Task For Project (<span class="text-warning">{{$project->p_title}}</span>)</h4>
                <p class="card-description"> Set task for your team member</p>
                <form class="forms-sample" method="post" action="{{route('save.task')}}" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="t_title">Task Title</label>
                                <input type="text" id="t_title" name="t_title" class="form-control" required value="{{old('t_title')}}">
                                <small class="text-success float-right">Required</small>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="deadline">Dead Line</label>
                                <input type="datetime-local" id="deadline" name="deadline" class="form-control" value="{{old('deadline')}}">
                                <small class="text-primary float-right">Optional</small>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" value="{{$project->set_teams_id}}" name="project_set_id">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="member">Team Member Name</label>
                                <select name="member_id" id="member" class="form-control" required>
                                    <option></option>
                                    @if(count(@$teamMembers))
                                        @foreach($teamMembers as $member)
                                            <option value="{{$member->id}}"@if(old('member_id') == $member->id) selected @endif>
                                                {{$member->name}} (#{{$member->employee_id}})
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <small class="text-success float-right">Required</small>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="team">Team Name</label>
                                <select name="team" id="team" class="form-control" required>
                                    <option value="{{$project->team_id}}">{{$project->team_title}}</option>

                                </select>
                                <small class="text-success float-right">Required</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="document">Task document</label>
                                <input class="form-control" type="file" name="document" id="document">
                                <small class="text-secondary">only .pdf / .text/.doc/.docx</small>
                                <small class="text-primary float-right">Optional</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="details">Task Details</label>
                                <textarea name="details" id="details" class="form-control" rows="8">{{old('details')}}</textarea>
                                <small class="text-primary float-right">Optional</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-success float-right">Add Task</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Task List For Project (<span class="text-warning">{{$project->p_title}}</span>)</h4>
{{--                <p class="card-description"> All task list which you create by descending order</p>--}}
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend input-group-sm">
                                    <span class="input-group-text">Search</span>
                                </div>
                                <input type="text" class="form-control " placeholder="Search task name or member name" aria-label="" abc="{{$project->set_teams_id}}" aria-describedby="basic-addon1" onkeyup="return searchTaskForProjectManager(this)">
                            </div>
                        </div>
                    </div>
                </div>
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
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="task-sm-list">
                                @include('layouts.project-manager.project.task._task_sm_list')
                                </tbody>
                            </table>
                            <div class="position">
                                @if(@$tasks->links())
                                    {!! @$tasks->links() !!}
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
@stop
