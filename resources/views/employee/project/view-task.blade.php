@extends('layouts.employee.main')
@section('content')
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-6">
                                <a href="{{url()->previous()}}" class="btn btn-sm btn-outline-warning"><i class="mdi mdi-keyboard-return"></i> click to back</a>
                            </div>


                            <div class="col-sm-6">
                            @if(!$task->task_running_status && !$task->task_complete_status)
                                <form action="{{route('start.task.save')}}" class="d-inline-block float-right" method="post">
                                    <input type="hidden" name="task_id" value="{{$task->task_id}}">
                                    <button onclick="return confirm('Are you sure, you will start this task now?')" type="submit" class="btn btn-sm btn-outline-primary">Click to start task <i class="mdi mdi-update"></i></button>
                                </form>
                            @elseif($task->task_running_status && !$task->task_complete_status)
                                <form action="{{route('complete.task.save')}}" class="d-inline-block float-right" method="post">
                                    <input type="hidden" name="task_id" value="{{$task->task_id}}">
                                    <button onclick="return confirm('Are you sure, Your task is complete?')" type="submit" class="btn btn-sm btn-outline-success">Make complete task <i class="mdi mdi-update"></i></button>
                                </form>
                            @else
                                <h5 class="text-info">Thank you for complete your task</h5>
                            @endif
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="card-title">View Task <span class="text-warning"> ({{$task->task_title}})</span></h4>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
