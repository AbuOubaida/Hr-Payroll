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
                                <a href="{{url("project-manager/project/view-project/$task->task_team_set_id")}}" class="btn btn-sm btn-outline-warning"><i class="mdi mdi-keyboard-return"></i> click to back</a>
                            </div>
                            <div class="col-sm-6">
                                @if(!$task->task_complete_status || !$task->task_running_status)
                                <form action="{{route('task.delete')}}" method="post" class="d-inline-block float-right">
                                    {!! method_field('delete') !!}
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="task_id" value="{{$task->task_id}}">
                                    <button class="btn btn-sm btn-outline-danger d-inline-block" onclick="return confirm('Are you sure delete this Task?')" type="submit">Delete <i class="mdi mdi-delete"></i></button>
                                </form>
                                @endif
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="card-title">View Task <span class="text-warning"> ({{$task->task_title}})</span> for project <span class="text-uppercase text-primary">
                                <a
                                    href="{{url("project-manager/project/view-project/$task->task_team_set_id")}}"> ({{$task->p_title}})</a>
                            </span></h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <h5 class="text-info">Task Information</h5>
                                <table class="table-responsive">
                                    <tbody>
                                    <tr>
                                        <th>Title</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">{{$task->task_title}}</td>
                                    </tr>
                                    <tr>
                                        <th>Start Date</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">{{date('M-d, Y',strtotime($task->task_start_at))}} at {{date('h:i:s A',strtotime($task->task_start_at))}}</td>
                                    </tr>
                                    <tr>
                                        <th>End Date</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">
                                            @if($task->task_dead_line)
                                            {{date('M-d, Y',strtotime($task->task_dead_line))}} at {{date('h:i:s A',strtotime($task->task_dead_line))}}
                                            @else
                                            <span class="text-info">Undefined</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Task Status</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">
                                            @if($task->task_status)
                                                <span class="text-success">Active</span>
                                            @else
                                            <span class="text-danger">Inactive</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Member Seen Status</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">
                                            @if($task->task_seen_status)
                                                <span class="text-success">Seen</span>
                                            @else
                                            <span class="text-danger">Unseen</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Complete Status</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">
                                            @if($task->task_running_status && !$task->task_complete_status)
                                                <span class="text-success">Running</span>
                                            @elseif($task->task_complete_status)
                                                <span class="text-warning">Completed</span>
                                            @else
                                                <span class="text-danger">Not start</span>
                                            @endif
                                        </td>
                                    </tr>
                                @if($task->task_complete_status)
                                    <tr>
                                        <th>Task Completed Date</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">
                                            @if($task->task_complete_date)
                                                {{date('M-d, Y',strtotime($task->task_complete_date))}} at {{date('h:i:s A',strtotime($task->task_complete_date))}}
                                            @else
                                                <span class="text-info">Undefined</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                                @if($task->task_document)
                                    <tr>
                                        <th>Task Document</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">
                                            <a href="{{url("file/project-manager/task/$task->task_document")}}"><button class="btn btn-sm btn-outline-success">Click To Download</button></a>
                                        </td>
                                    </tr>
                                @endif
                                @if($task->task_details)
                                    <tr>
                                        <th>Task Details</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light text-justify">
                                            {{$task->task_details}}
                                        </td>
                                    </tr>
                                @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-6">
                                <h5 class="text-info">Team and Member Information</h5>
                                <table class="table-responsive">
                                    <tbody>
                                        <tr>
                                            <th>Team Title</th>
                                            <th>:&nbsp;&nbsp;</th>
                                            <td class="font-weight-light">{{$task->team_title}}</td>
                                        </tr>
                                        <tr>
                                            <th>Member Name</th>
                                            <th>:&nbsp;&nbsp;</th>
                                            <td class="font-weight-light">{{$task->member_name}}</td>
                                        </tr>
                                        <tr>
                                            <th>Member Employee ID</th>
                                            <th>:&nbsp;&nbsp;</th>
                                            <td class="font-weight-light text-primary"> <b> #{{$task->member_id}}</b></td>
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
@stop
