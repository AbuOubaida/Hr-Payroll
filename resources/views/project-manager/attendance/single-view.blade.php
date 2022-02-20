@extends('layouts.project-manager.main')
@section('content')
<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="row">
                            <h4 class="card-title">Full View of Attendance</h4>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <span><b class="text-info">Date: </b>{{date('d-m-Y',strtotime(now()))}}</span>
                        <span class="float-right"><b class="text-info">To Day: </b>{{date('l',strtotime(now()))}}</span>
                    </div>
                    <div class="col-sm-5">
                        <div class="row">
                            <p class="text-gray">Employee Information</p>
                            <table class="table-responsive">
                                <tbody>
                                    <tr>
                                        <th>Employee Name</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">{{$data->emp_name}}</td>
                                    </tr>
                                    <tr>
                                        <th>Employee ID</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light"><a class="text-success" href="{{url("admin/employee/view/{$data->employee_id}")}}" target="_blank"> #{{$data->emp_no}}</a></td>
                                    </tr>
                                    <tr>
                                        <th>Employee Email</th>
                                        <th>:</th>
                                        <td class="font-weight-light">{{$data->email}}</td>
                                    </tr>
                                    <tr>
                                        <th>Employee Phone</th>
                                        <th>:</th>
                                        <td class="font-weight-light">({{$data->phone_code}}) {{$data->phone}}</td>
                                    </tr>
                                    <tr>
                                        <th>Emp. Department</th>
                                        <th>:</th>
                                        <td class="font-weight-light">{{$data->dep_name}}</td>
                                    </tr>
                                    <tr>
                                        <th>Employee Position</th>
                                        <th>:</th>
                                        <td class="font-weight-light">{{$data->p_name}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-1"></div>
                    <div class="col-sm-6">
                        <div class="row">
                            <p class="text-gray">Attendance Information</p>
                            <table class="table-responsive">
                                <tbody>
                                    <tr>
                                        <th>Attendance Year</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">{{$data->year}}</td>
                                    </tr>
                                    <tr>
                                        <th>Attendance Date</th>
                                        <th>:</th>
                                        <td class="font-weight-light">{{date('d-m-Y',strtotime($data->entry_time))}} ({{$data->day_name}}) ({{$data->month_name}})</td>
                                    </tr>
                                    <tr>
                                        <th>Entry Time</th>
                                        <th>:</th>
                                        <td class="font-weight-light">{{date('h:i:s a',strtotime($data->entry_time))}}</td>
                                    </tr>
                                    <tr>
                                        <th>Leave Time</th>
                                        <th>:</th>
                                        <td class="font-weight-light">{{$data->leave_time? date('h:i:s a',strtotime($data->leave_time)):''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Worked Hour's</th>
                                        <th>:</th>
                                        <td class="font-weight-light">{{$data->working_hour_in_day?$data->working_hour_in_day:''}}</td>
                                    </tr>
                                    @if(@$first)
                                    <tr>
                                        <th>First Entry</th>
                                        <th>:</th>
                                        <td class="font-weight-light">{{$first['hour']}}h : {{$first['min']}}m : {{$first['sec']}}s</td>
                                    </tr>
                                    @elseif($late)
                                    <tr>
                                        <th>Late Entry</th>
                                        <th>:</th>
                                        <td class="font-weight-light">{{$late['hour']}}h : {{$late['min']}}m : {{$late['sec']}}s</td>
                                    </tr>
                                    @else
                                    <tr>
                                        <th>Entry Time</th>
                                        <th>:</th>
                                        <td class="font-weight-light">On Time</td>
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
@stop
