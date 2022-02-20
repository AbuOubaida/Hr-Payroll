@extends('layouts.admin.main')
@section('content')
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <h4 class="card-title"><span class="badge badge-info">Step-2</span> (<span class="text-success">Requeired</span>)</h4>
                        <p class="card-description text-justify">If you do not fillup this step-2 then your recently added grade will not active.</p>
                        <form class="form-sample" method="post" action="{{route('add.grade.2')}}">
                            <input type="hidden" name="grade_id" value="@if(@$grade){{$grade->grade_id}}@endif"->
                            <div class="row">
                                @if(@$grade->grade_hra)
                                <div class="col-sm-6">
                                    <div class="form-group row" title="House Rent Allowance">
                                        <label class="col-sm-12 col-form-label" for="hra">HRA</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" name="hra" id="hra" required placeholder="Amount of HRA" value="{{old('hra')}}">
                                            <small class="float-right text-success">Required</small>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if(@$grade->grade_mda)
                                <div class="col-sm-6">
                                    <div class="form-group row" title="Medical Allowence">
                                        <label class="col-sm-12 col-form-label" for="mda">MDA</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="mda" name="mda" required placeholder="Amount of MDA" value="{{old('mda')}}">
                                            <small class="float-right text-success">Required</small>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if(@$grade->grade_bonus)
                                <div class="col-sm-6">
                                    <div class="form-group row" title="Yearly Bonus Number">
                                        <label class="col-sm-12 col-form-label" for="b_no">Yearly Bonus No.</label>
                                        <div class="col-sm-12">
                                            <input type="number" class="form-control" id="b_no" name="b_no" required placeholder="Yearly bonus Number" value="{{old('b_no')}}">
                                            <small class="float-right text-success">Required</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group row" title="Yearly Bonus Amount">
                                        <label class="col-sm-12 col-form-label" for="b_amount">Yearly Bonus Amount</label>
                                        <div class="col-sm-12">
                                            <input type="number" class="form-control" id="b_amount" name="b_amount" required placeholder="Yearly bonus amount" value="{{old('b_amount')}}">
                                            <small class="float-right text-success">Required</small>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if(@$grade->grade_prd_fund)
                                <div class="col-sm-6">
                                    <div class="form-group row" title="Provident Fund">
                                        <label class="col-sm-12 col-form-label" for="pf">Provident Fund Amount</label>
                                        <div class="col-sm-12">
                                            <input type="number" class="form-control" id="pf" name="pf" required placeholder="YProvident Fund Amount" value="{{old('pf')}}">
                                            <small class="float-right text-success">Required</small>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if(@$grade->grade_pro_tax)
                                <div class="col-sm-6">
                                    <div class="form-group row" title="Professional Tax Amount">
                                        <label class="col-sm-12 col-form-label" for="pt">Professional Tax Amount</label>
                                        <div class="col-sm-12">
                                            <input type="number" class="form-control" id="pt" name="pt" required placeholder="Professional Tax Amount" value="{{old('pt')}}">
                                            <small class="float-right text-success">Required</small>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="col-sm-12">
                                    <div class="float-right">
                                        <input type="submit" value="Next" class="btn btn-success">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-6">
                        <h4 class="card-title">Salary Grade list</h4>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend input-group-sm">
                                            <span class="input-group-text"><i class="mdi mdi-account-search"></i></span>
                                        </div>
                                        <input type="text" class="form-control " placeholder="Search by Grade Title or Range or Short Name" onkeyup="return searchGrade(this)">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
