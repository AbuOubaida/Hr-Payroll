@extends('layouts.admin.main')
@section('content')
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="">
                            <h4 class="card-title">Prepare Salary Here <div class="d-inline-block text-success"> [Recommend: Between {{$protocol?($protocol->salary_date .'th'):'11th'}} to {{$protocol?($protocol->salary_date + 5 .'th'):'16th'}} date on a month prepare salary]</div></h4>
                            <p class="text-warning text-justify">Salary will be prepared previous month date {{$protocol?($protocol->salary_date+1 .'th'):'11th'}} to this (selected) month date {{$protocol?($protocol->salary_date .'th'):'1th'}}, depend on employee attendance</p>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <form action="{{route('prepare.save.salary')}}" method="post">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend input-group-sm">
                                                <span class="input-group-text">Prepare Year</span>
                                            </div>
                                            <select class="form-control text-white" id="year" name="year"  required>
                                                @if($year)
                                                    @foreach($year as $y)
                                                        <option value="{{$y->year}}" @if($y->year == date('Y'))selected  @endif>{{$y->year}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <small class="float-right text-success">Required</small>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend input-group-sm">
                                                <span class="input-group-text">Prepare Month</span>
                                            </div>
                                            <select class="form-control text-white" id="month" name="month"  required>
                                                @if($month)
                                                    @foreach($month as $m)
                                                        <option value="{{$m->month_name}}" @if($m->month_name == date('F',strtotime(now())))selected  @endif>{{$m->month_name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <small class="float-right text-success">Required</small>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend input-group-sm">
                                                <span class="input-group-text">Department</span>
                                            </div>
                                            <select class="form-control text-white" id="dep" name="dep">
                                                @if($department)
                                                    <option value="0">All</option>
                                                    @foreach($department as $dep)
                                                        <option value="{{$dep->dep_id}}">{{$dep->dep_name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <small class="float-right text-primary">Optional</small>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-check form-check-info mt-0">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="bonus" value="1"> If Bonus Include This Month Then Please check The Box. <i class="input-helper"></i></label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-outline-success btn-icon-text float-right">
                                        <i class="mdi mdi-file-check btn-icon-prepend"></i> Prepare </button>
                                </div>
                            </div>
                        </form>
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
                    <div class="col-sm-8">
                        <div class="">
                            <h4 class="card-title">Last Month Salary List</h4>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <button onclick="return deleteListMonthSalary()" type="button" class="btn btn-outline-danger btn-icon-text float-right">All Delete <i class="mdi mdi-delete btn-icon-append"></i></button>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Department</span>
                                </div>
                                <select class="form-control text-white" id="dep_id" name="" onchange="return fiendSalaryData(this)">
                                    <option value="0">All</option>
                                    @if($department)
                                        @foreach($department as $dep)
                                            <option value="{{$dep->dep_id}}">{{$dep->dep_name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2"></div>
                    <div class="col-sm-7">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Search</span>
                                </div>
                                <input id="emp" type="text" class="form-control" placeholder="Search by Employee ID or Email" aria-label="Username" aria-describedby="basic-addon1" onkeyup="return fiendSalaryData(this)">
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
                                    <th>Salary Month</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th title="Total Working Hour">Total W.Hour</th>
                                    <th>Amount</th>
                                    <th>Paid Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody id="salary-data">
                                @include('layouts.admin.payroll._last_salary_table')
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="col-sm-12 position">
                            @if(@$salary->links())
                                {{@$salary->links()}}
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@stop

