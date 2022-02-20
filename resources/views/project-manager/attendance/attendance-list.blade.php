@extends('layouts.project-manager.main')
@section('content')
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5">
                        <div class="">
                            <h4 class="card-title">Attendance List of To Day</h4>
                        </div>
                    </div>
                    <div class="col-sm-7">

                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend input-group-sm">
                                    <span class="input-group-text">Year</span>
                                </div>
                                <select class="form-control text-white" id="year" name="order" onchange="return searchAttendanceProjectManager(this)">
                                    <option value="">All</option>
                                    @if($year)
                                        @foreach($year as $y)
                                            <option value="{{$y->year}}">{{$y->year}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend input-group-sm">
                                    <span class="input-group-text">Month</span>
                                </div>
                                <select class="form-control text-white" id="month" name="order" onchange="return searchAttendanceProjectManager(this)">
                                    <option value="">All</option>
                                    @if($month)
                                        @foreach($month as $m)
                                            <option value="{{$m->month_name}}">{{$m->month_name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend input-group-sm">
                                    <span class="input-group-text">Date</span>
                                </div>
                                <select class="form-control text-white" id="date" name="order" onchange="return searchAttendanceProjectManager(this)">
                                    <option value="">All</option>
                                    @if($date)
                                        @foreach($date as $d)
                                            <option value="{{$d->date}}">{{$d->date}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
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
                                    <th>Department</th>
                                    <th>Entry Time</th>
                                    <th>Leave Time</th>
                                    <th>Date</th>
                                    <th>Day</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody id="att-data">
                                @include('layouts.project-manager.attendance._filter_list')
                                </tbody>
                            </table>
                            <div class="col-sm-12 position">
                                @if($attendance->links())
                                    {{$attendance->links()}}
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop

