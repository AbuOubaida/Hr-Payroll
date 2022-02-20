@extends('layouts.admin.main')
@section('content')
<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-7">
                    <h4 class="card-title">Edit / View Team</h4>
                    <form class="form-sample" method="post" action="{{route('update.team')}}">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for="title">Team title</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="title" id="title" required placeholder="Enter team title" value="{{@$team->team_title}}">
                                        <small class="float-right text-success">Required</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for="leader">Team Leader</label>
                                    <div class="col-sm-12">
                                        <select name="leader" id="leader" class="form-control">
                                            <option></option>
                                            @if(count($project_managers))
                                                @foreach($project_managers as $p)
                                                    <option value="{{$p->user_id}}"  @if(@$team->team_leader_id && @$team->team_leader_id == $p->user_id)selected @endif>{{$p->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <small class="float-right text-success">Required</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for="status">Team Status</label>
                                    <div class="col-sm-12">
                                        <select name="status" id="status" class="form-control">
                                            <option></option>
                                            <option value="1" @if($team->team_status == 1) selected @endif>Active</option>
                                            <option value="0" @if($team->team_status == 0) selected @endif>Inactive</option>
                                        </select>
                                        <small class="float-right text-success">Required</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label" for="details">Team Details</label>
                                    <textarea name="details" class="form-control" id="details" rows="5" spellcheck="false" placeholder="Enter Team Details">{{@$team->team_details}}</textarea>
                                    <small class="float-right text-primary">Optional</small>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <input type="hidden" value="{{@$team->team_id}}" name="team_id">
                                <div class="form-group float-right mt-2">
                                    <input type="submit" class="btn btn-success" value="Update">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-sm-5">
                    <h4 class="card-title">Team list</h4>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend input-group-sm">
                                        <span class="input-group-text"><i class="mdi mdi-account-search"></i></span>
                                    </div>
                                    <input type="text" class="form-control " placeholder="Search by team title or team leader name" onkeyup="return searchSmTeam(this)">
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
                                        <th>Team Leader</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="project-sm-list">
                                    @include('layouts.admin.project.team._sm_list')
                                    </tbody>
                                </table>
                                <div class="col-sm-12 position">
                                    @if($teams->links())
                                        {{$teams->links()}}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($team->team_status == 1)
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <h4 class="card-title">Add this team member</h4>
                        <form class="form-sample" method="post" action="{{route('add.team.member')}}">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for="title">Team title</label>
                                        <div class="col-sm-12">
                                            <input class="form-control text-dark" id="title" value="{{@$team->team_title}}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for="leader">Team Leader</label>
                                        <div class="col-sm-12">
                                            <select id="leader" class="form-control text-dark" disabled>
                                                @if(count($project_managers))
                                                    <option></option>
                                                    @foreach($project_managers as $p)
                                                        <option value="{{$p->user_id}}"  @if(@$team->team_leader_id == $p->user_id)selected @endif>{{$p->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for="status">Team Status</label>
                                        <div class="col-sm-12">
                                            <select disabled id="status" class="form-control text-dark">
                                                <option></option>
                                                <option value="1" @if($team->team_status == 1) selected @endif>Active</option>
                                                <option value="0" @if($team->team_status == 0) selected @endif>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label" for="details">Add Member Information</label>
                                        <select required name="memberInfo" id="memberInfo" class="form-control">
                                            <option></option>
                                            @if(count(@$employees))
                                                @foreach($employees as $emp)
                                                    <option value="{{$emp->user_id}}"> {{$emp->user_name}}&nbsp;&nbsp; (ID: {{$emp->employee_id}}) &nbsp;&nbsp;(Department: {{$emp->dep_name}})
                                                @endforeach
                                            @endif
                                        </select>
                                        <small class="float-right text-success">Required</small>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <input type="hidden" value="{{@$team->team_id}}" name="team_id">
                                    <div class="form-group float-right mt-2">
                                        <input type="submit" class="btn btn-success" value="Add member">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-6">
                        <h4 class="card-title">Team list</h4>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive" id="grade-table">
                                    <table class="table table-sm table-hover">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Team</th>
                                            <th>Attribute</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="project-sm-list">
                                        <tr>
                                            <td>{{$i=1}}</td>
                                            <td><a href="{{url("admin/employee/view/{$projectLeader->leaderID}")}}" target="_blank">{{$projectLeader->projectLeader}}</a></td>
                                            <td>{{$team->team_title}}</td>
                                            <td>Leader</td>
                                            <td class="text-center">

                                            </td>
                                        </tr>
                                        @if(count(@$teamMembers))
                                            @foreach($teamMembers as $member)
                                            <tr>
                                                <td>{{++$i}}</td>
                                                <td><a href="{{url("admin/employee/view/{$member->user_id}")}}" target="_blank">{{$member->member_name}}</a></td>
                                                <td>{{$member->team_name}}</td>
                                                <td>Member</td>
                                                <td class="text-center">
                                                    <a href="{{url('admin/project/delete-team-member/'.$member->team_members_id)}}" class="text-danger" title="" onclick="return confirm('Are you sure delete this member?')"><i class="mdi mdi-delete"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                    <div class="col-sm-12 position">
                                        @if($teams->links())
                                            {{$teams->links()}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@stop
