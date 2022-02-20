@extends('layouts.admin.main')
@section('content')
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-7">
                        <h4 class="card-title">Set Salary Grade</h4>
                        <p class="card-description"> Set salary grade for a employee </p>
                    </div>
                    <div class="col-sm-5">
                        <h4 class="card-title">List of Grade</h4>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend input-group-sm">
                                            <span class="input-group-text"><i class="mdi mdi-account-search"></i></span>
                                        </div>
                                        <input type="text" class="form-control " placeholder="Search by Position Title" onkeyup="return searchGrade(this)">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form class="form-sample" method="post" action="{{route('save.set-grade')}}">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for="emp-id" class="col-sm-12 col-form-label">Employee ID or Email</label>
                                        <div class="col-sm-12">
                                            <input id="emp-id" name="employee_id" type="text" class="form-control" required value="{{old('employee_id')}}" placeholder="Enter Employee ID or Email" onfocusout="return searchEmp(this)">
                                            <small class="">e.g. 211212345/abc@abc.a</small>
                                            <small class="text-success float-right">Required</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for="grade" class="col-sm-12 col-form-label">Select a Grade</label>
                                        <div class="col-sm-12">
                                            <select class="form-control" name="grade" id="grade">
                                            @if($activeGrades)
                                                <option>--Select a grade--</option>
                                                <option value="0">Not Define</option>
                                                @foreach($activeGrades as $g)
                                                <option value="{{$g->grade_id}}">{{$g->grade_title}}({{$g->grade_short_title}})</option>
                                                @endforeach
                                            @else
                                                    <option>Not Found</option>
                                            @endif
                                            </select>
                                            <small class="text-success float-right">Required</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <h6>Employee Info</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Image</th>
                                                    <th>ID</th>
                                                    <th>Grade</th>
                                                    <th>name</th>
                                                    <th>email</th>
                                                </tr>
                                            </thead>
                                            <tbody id="epm-info">
                                            <tr>
                                                <td colspan="5" class="text-center">Not Found!</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group float-right">
                                <button class="btn btn-info" type="button" onclick="return searchEmpByFind('#emp-id')">Find</button>
                                <input class="btn btn-success" type="submit" value="Save">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="table-responsive" id="grade-table">
                                @include('layouts.admin.grade.salary._grade-table')
                                <div class="col-sm-12 position">
                                    @if($grades->links())
                                        {{$grades->links()}}
                                    @endif
                                </div>
                                <div class="col-sm-12 position">

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
{{--Employee List--}}
    @include('layouts.admin.employee.employee-list')
@stop
