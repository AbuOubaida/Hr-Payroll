@extends('layouts.admin.main')
@section('content')
<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="card-title">Set Team For project</h4>
                    <p class="card-description">New Team info </p>
                    <form class="form-sample" method="post" action="{{route('save.set.team')}}">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for="team">Select a Team</label>
                                    <div class="col-sm-12">
                                        <select class="form-control" name="teamID" id="team" required>
                                            <option></option>
                                    @if(count(@$teams))
                                        @foreach($teams as $t)
                                            <option value="{{$t->team_id}}">{{$t->team_title}}</option>
                                        @endforeach
                                    @endif
                                        </select>
                                        <small class="float-right text-success">Required</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for="project">Select a Project</label>
                                    <div class="col-sm-12">
                                        <select class="form-control" name="projectID" id="project" required>
                                            <option></option>
                                    @if(count(@$projects))
                                        @foreach($projects as $p)
                                            <option value="{{$p->project_id}}">{{$p->p_title}}</option>
                                        @endforeach
                                    @endif
                                        </select>
                                        <small class="float-right text-success">Required</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group float-right mt-2">
                                    <input type="submit" value="Add" class="btn btn-success">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="card-title">Running Project + Team list</h4>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive" id="grade-table">
                                <table class="table table-sm table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Project Name</th>
                                        <th>Complete Status</th>
                                        <th>Status</th>
                                        <th>Team Name</th>
                                        <th>Team leader</th>
                                        <th>Team member</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="project-sm-list">
                                @if(count($set_team_info) && count($teamMembers))
                                    <?php $i=1;?>
                                    @foreach($set_team_info as $info)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td><a href="{{url("admin/project/view-project/{$info->p_id}")}}" target="_blank">{{$info->project_name}}</a></td>
                                            <td>
                                                @if($info->complete_status == 1)
                                                    <span class="text-warning">Completed</span>
                                                @elseif($info->complete_status == 2)
                                                    <span class="text-danger">Stopped</span>
                                                @else
                                                    <span class="text-info">Running</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($info->status)
                                                    <span class="text-success">Active</span>
                                                @else
                                                    <span class="text-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td><a href="{{url("admin/project/edit-team/{$info->t_id}")}}" target="_blank">{{$info->team_name}}</a></td>
                                            <td><a href="{{url("admin/employee/view/{$info->leader_id}")}}" target="_blank">{{$info->leader_name}}</a></td>
                                            <td>
                                                <?php $n =1;?>
                                                @foreach($teamMembers as $m)
                                                    @if($m->team_id == $info->t_id)
                                                        <?php $n += $m->total ?>
                                                    @endif
                                                @endforeach
                                                {{$n}}
                                            </td>
                                            <td><a href="{{url("admin/project/view-project/{$info->p_id}")}}" target="_blank">{{date('d-F-Y',strtotime($info->start_date))}}</a></td>

                                            <td><a href="{{url("admin/project/view-project/{$info->p_id}")}}" target="_blank">{{date('d-F-Y',strtotime($info->end_date))}}</a></td>
                                            <td>
                                                <a href="{{url("admin/project/set-team-delete/{$info->set_teams_id}")}}" class="text-danger" title="" onclick="return confirm('Are you sure delete this?')"><i class="mdi mdi-delete"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                    </tbody>
                                </table>
                                <div class="col-sm-12 position">
{{--                                    @if($teams->links())--}}
{{--                                        {{$teams->links()}}--}}
{{--                                    @endif--}}
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
