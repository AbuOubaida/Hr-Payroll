@extends('layouts.admin.main')
@section('content')
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-8">
                        <h4 class="card-title">Employee Attendance Call</h4>
                        <p class="card-description"> Set employee entry on leave time is here by employee ID or EMAIL</p>
                    </div>
                    <div class="col-sm-4">
                        <span><b class="text-info">Date: </b>{{date('d-m-Y',strtotime(now()))}}</span>
                        <span class="float-right"><b class="text-info">To Day: </b>{{date('l',strtotime(now()))}}</span>
                    </div>
                </div>
                @if($weekly_holiday)
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="alert alert-info alert-dismissible fade show w-auto" role="alert">
                                <span class="text-justify"> <i class=""> <h5> Happy {{$weekly_holiday->holiday_name }}.</h5></i> <b> To day is weekly holiday,</b> no need to call attendance </span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
                @if($public_holiday)
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="alert alert-info alert-dismissible fade show w-auto" role="alert">
                                <span class="text-justify"> <i class=""> <h5> Happy {{$public_holiday->p_h_name }}.</h5></i> <b> To day is Public holiday,</b> no need to call attendance </span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
                @if(!$weekly_holiday && !$public_holiday)
                <form class="form-sample" method="post" action="{{route('attendance.entry')}}">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group row">
                                        <label for="emp-id" class="col-sm-12 col-form-label">Employee ID or Email</label>
                                        <div class="col-sm-12">
                                            <input id="emp-id" name="v" type="text" class="form-control" required value="{{old('employee_id')}}" placeholder="Enter Employee ID or Email" onfocusout="return searchEmpForAttendance(this)">
                                            <small class="">e.g. 211212345/abc@abc.a</small>
                                            <small class="text-success float-right">Required</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group row">
                                        <label for="date" class="col-sm-12 col-form-label">Date</label>
                                        <div class="col-sm-12">
                                            <select id="date" class="form-control">
                                                <option> {{date('d-m-Y', strtotime(now()))}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group row">
                                        <label for="time" class="col-sm-12 col-form-label">Time</label>
                                        <div class="col-sm-12">
                                            <select id="time" class="form-control">
                                                <option class="clock">{{date('h:i:s a', strtotime(now()))}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group row">
                                        <label for="day" class="col-sm-12 col-form-label">Day</label>
                                        <div class="col-sm-12">
                                            <select id="day" class="form-control">
                                                <option>{{date('l', strtotime(now()))}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover" id="epm-info">
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group float-right">
                                        <button value="Leave" class="btn btn-outline-danger" type="submit" name="leave"> <i class="mdi mdi-logout-variant"></i> Leave</button>
                                        <button value="Entry" class="btn btn-outline-success" type="submit" {{--onclick="return attendanceEntry('#emp-id')"--}} name="entry"><i class="mdi mdi-login-variant"></i> Entry</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Attendance List of To Day</h4>
                <div class="row">
                    <br>
                    <div class="col-sm-12">
                        <div class="table-responsive" id="emp-table">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Profile</th>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Department</th>
                                    <th>Entry Time</th>
                                    <th>Leave Time</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($to_day_att)>0)
                                    @foreach($to_day_att as $att)
                                    <tr class="">
                                        @if($att->profile)
                                            <td><img src="{{url("image/employee/profile/{$att->profile}")}}" alt="" height="20px"></td>
                                        @else
                                        <td style="font-size: 28px;"><i class="mdi mdi-account-box-outline"></i></td>
                                        @endif
                                        <td>{{$att->emp_no}}</td>
                                        <td>{{$att->emp_name}}</td>
                                        <td>{{$att->email}}</td>
                                        <td>{{$att->dep_name}}</td>
                                        <td>{{date('h:i:s a',strtotime($att->entry_time))}}</td>
                                        <td>{{$att->leave_time?date('h:i:s a',strtotime($att->leave_time)):'NULL'}}</td>
                                        <td class="text-center">
                                            <a href="{{url("admin/attendance/view-attendance/{$att->attend_id}")}}" class="text-warning" title="View Employee Profile"> <i class="mdi mdi-eye"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8" class="text-center text-danger">Not Found</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                            <div class="col-sm-12 position">
                                @if($to_day_att->links())
                                    {{$to_day_att->links()}}
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop

