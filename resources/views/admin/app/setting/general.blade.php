@extends('layouts.admin.main')
@section('content')
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="d-inline-block"><i class="mdi mdi-settings "></i></h4><h4 class="card-title d-inline-block">General Setting </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 ">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Company Protocol</h4>
                <p class="card-description"> Set company basic protocol </p>
                <form class="forms-sample" method="post" action="{{route('save.protocol')}}">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="s_date">Salary Date</label>
                                <select name="s_date" id="s_date" class="form-control" required>
                                    @for($z=1;$z<=15;$z++)
                                    <option value="{{$z}}"@if(@$protocol && $protocol->salary_date == $z) selected @endif>Day-{{$z}} of month</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="entry_time">Daily Entry Time</label>
                                <select name="entry_time" id="entry_time" class="form-control" onchange="return leaveTime(this)" required>
                                    @for($z=7;$z<=11;$z++)
                                    <option value="{{$z<10? $nz ='0'.$z.':00:00': $nz=$z.':00:00' }}" @if(@$protocol && $protocol->daily_entry_time == $nz) selected @endif>@if($z<10)0{{$z}} @else {{$z}} @endif:00 am</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="w-hour">Daily Working Hour's</label>
                                <select name="w_hour" id="w-hour" class="form-control" onchange="return leaveTime(this)" required>
                                    @for($m=6;$m <= 10;$m++)
                                    <option value="{{$m}}" @if(@$protocol && $protocol->daily_working_hour == $m) selected @endif>{{$m++}}-hour's</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="leave_time">Daily Leave Time</label>
                                <select name="leave_time" id="leave_time" class="form-control" required>
                                    <option value="@if(@$protocol && $protocol->daily_leave_time) {{$protocol->daily_leave_time}}@else 13:00:00 @endif">@if(@$protocol && $protocol->daily_leave_time) {{($h = date('H',strtotime($protocol->daily_leave_time)) % 12)?($h<10)?'0'.$h:$h:'12'}}:00 {{$protocol->daily_leave_time >= 12?'pm':'am'}}  @else 01:00 pm @endif</option>
                                </select>
                                <small class="text-gray">Changing by Entry + working hours</small>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="working_day">Minimum working Day on month</label>
                                <select name="working_day" id="working_day" class="form-control" required>
                                    <option value="{{(30-($no_holiday->no_of_holiday*4))}}" @if($no_holiday ) selected @endif>{{(30-($no_holiday->no_of_holiday*4))}} days</option>
                                </select>
                                <small class="text-gray">Depending on weekly holiday</small>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="row float-right">
                                <button type="submit" class="btn btn-primary mr-2">{{$protocol?'Update':'Save'}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Add Public Holiday</h4>
                <form action="{{route('store.public.holiday')}}" class="" method="post">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label" for="h-name">Holiday Name</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control form-control" name="h_name" id="h-name" required="required" placeholder="Enter Holiday Name">
                                    <small class="float-right text-success">Required</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label" for="day">Day</label>
                                <div class="col-sm-12">
                                    <select class="form-control" name="day" id="day" required>
                                        <option value="">--Select Day--</option>
                                        @foreach($days as $d)
                                            <option value="{{$d->day_name}}">{{$d->day_name}}</option>

                                        @endforeach
                                    </select>
                                    <small class="float-right text-success">Required</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label" for="date">Date</label>
                                <div class="col-sm-12">
                                    <input type="date" class="form-control form-control" name="date" id="date" required="required" placeholder="Enter Holiday Date">
                                    <small class="float-right text-success">Required</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label" for="type">Type</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control form-control" name="type" id="type" placeholder="Enter Holiday Type">
                                    <small class="float-right text-primary">Optional</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label" for="comment">Comment</label>
                                <div class="col-sm-12">
                                    <textarea type="text" class="form-control form-control" name="comment" id="comment" placeholder="Enter Holiday Type" rows="5"></textarea>
                                    <small class="float-right text-primary">Optional</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                                <input class="btn btn-success float-right" type="submit" value="Add">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Set Weekly Holiday</h4>
                <form action="{{route('store.holiday')}}" class="" method="post">
                    <div class="form-group row">
                        <label class="col-sm-6 col-form-label" for="no_holiday">Number of Weekly Holiday</label>
                        <div class="col-sm-3">
                            <input type="hidden" value="{{@$no_holiday->wk_holiday_id}}" name="wk_h_id">
                            <input type="number" class="form-control form-control-sm" name="no_holiday" id="no_holiday" required="required" placeholder="Enter Number of weekly holiday" @if(@$no_holiday)value="{{@$no_holiday->no_of_holiday}}"@endif>
                            <small class="float-right text-success">Required</small>
                        </div>
                        <div class="col-sm-3">
                            <input class="btn btn-success float-right" type="submit" @if(@$no_holiday)value="Update" @else value="Save" @endif>
                        </div>
                    </div>
                </form>
                <hr class="border-dark">
                @if($no_holiday)
                    <label>Name of Holiday</label>
                    @if(count($w_h_n) == 0)
                        <div class="alert alert-warning alert-dismissible fade show w-auto" role="alert">
                            <div>Please select the name of holiday! Otherwise, holiday doesn't work!</div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    @endif
                    <form action="{{route('store.holiday.name')}}" method="post">
                        <div class="row">
                            <?php $a=0;?>
                            @for($i=1; $i<=$no_holiday->no_of_holiday; $i++)
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for="day{{$i}}" class="col-sm-4 col-form-label">Day {{$i}}</label>
                                        <div class="col-sm-8">
                                            <div @if(($i % 2)) class="row"@else style="margin-left: -15px;" @endif>
                                                <select class="form-control" name="day{{$i}}" id="day{{$i}}" required>
                                                    <option value="">--Select Day--</option>

                                                    @foreach($days as $d)
                                                        <option value="{{$d->day_name}}" @if(count($w_h_n) && ((@$w_h_n[@$a]->holiday_name) == $d->day_name)) selected @endif>{{$d->day_name}}</option>

                                                    @endforeach
                                                </select>
                                                <small class="float-right text-success">Required</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php $a++;?>
                            @endfor
                            <div @if(($no_holiday->no_of_holiday % 2)) class="col-sm-6" @else class="col-sm-12"@endif>
                                <input type="submit" @if(count($w_h_n)) value="Update" @else value="Save" @endif class="btn btn-success float-right">
                            </div>
                        </div>
                    </form>
                @endif
                @if(count($w_h_n))
                <hr class="border-dark">
                <h6 class="card-title">Weekly Holiday list</h6>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thade>
                            <tr>
                                <th>#</th>
                                <th>Holiday Name</th>
                            </tr>
                        </thade>
                        <tbody>
                        <?php $i=1;?>
                        @foreach($w_h_n as $h_name)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$h_name->holiday_name}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Public Holiday list</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thade>
                            <tr>
                                <th>#</th>
                                <th>Holiday Name</th>
                                <th>Day</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Comment</th>
                                <th>Action</th>
                            </tr>
                        </thade>
                        <tbody>
                        @if(count($public_holiday))
                        <?php $i=1;?>
                        @foreach($public_holiday as $ph)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$ph->p_h_name}}</td>
                                <td>{{$ph->p_h_day}}</td>
                                <td>{{date('d-m-Y', strtotime($ph->p_h_date))}}</td>
                                <td>{{$ph->p_h_type}}</td>
                                <td>{{$ph->p_h_comment}}</td>
                                <td><a href="{{url('admin/app/setting/delete-public-holiday/'.$ph->p_h_id )}}" class="btn btn-danger btn-sm" title="Delete Salary Grade" onclick="return confirm('Are you sure delete this day?')">Delete <i class="mdi mdi-delete"></i></a></td>
                            </tr>
                        @endforeach
                        @else
                            <tr>
                                <td class="text-center" colspan="8">Not Found</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    <div class="col-sm-12 position">
                        @if($public_holiday->links())
                            {{$public_holiday->links()}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

