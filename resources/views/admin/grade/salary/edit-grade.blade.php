@extends('layouts.admin.main')
@section('content')
<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="row">
                            <h4 class="card-title">Edit Salary Grade</h4>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row float-right">
                            <a href="{{url('admin/grade/salary/view-grade/').'/'.$joinGrades->root_id}}" class="mr-2"><button type="button" class="btn btn-outline-info btn-icon-text"> View <i class="mdi mdi-eye btn-icon-append"></i></button></a>
                        </div>
                    </div>
                </div>
            </div>
            <form class="form-sample" method="post" action="{{route('edit.grade',['editID'=>$joinGrades->root_id])}}">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-12">
                                <p class="text-gray">Basic</p>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for="title">Grade title</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="title" id="title" required placeholder="Enter Title" value="{{$joinGrades->grade_title}}">
                                        <small class="float-right text-success">Required</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for="title-sm">Grade Short Name</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="title-sm" name="short_name" required placeholder="Enter Short Name" value="{{$joinGrades->grade_short_title}}">
                                        <small class="float-right text-success">Required</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for="basic">Basic</label>
                                    <div class="col-sm-12">
                                        <input type="number" class="form-control" id="basic" name="basic" required placeholder="Enter Basic" value="{{$joinGrades->grade_basic}}">
                                        <small class="float-right text-success">Required</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label" for="grade_details">Grade Details</label>
                                    <textarea name="details" class="form-control" id="grade_details" rows="5" spellcheck="false" placeholder="Enter Grade Details">{{$joinGrades->grade_details}}</textarea>
                                    <small class="float-right text-primary">Optional</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="col-form-label">Including</label>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="form-check edit-check form-check-success">
                                        <label class="form-check-label text-success" title="Travel Allowance">
                                            <input value="1" type="checkbox" class="form-check-input" name="ta" @if($joinGrades->grade_ta){{'checked'}}@endif> TA<i class="input-helper"></i></label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="form-check edit-check form-check-primary">
                                        <label class="form-check-label text-primary" title="Daily Allowance">
                                            <input value="1" type="checkbox" class="form-check-input" name="da" @if($joinGrades->grade_da){{'checked'}}@endif> DA <i class="input-helper"></i></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="form-check edit-check form-check-info">
                                        <label class="form-check-label text-info" title="House Rent Allowance">
                                            <input value="1" type="checkbox" class="form-check-input" name="hra" @if($joinGrades->grade_hra){{'checked'}}@endif> HRA <i class="input-helper"></i></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="form-check edit-check form-check-danger">
                                        <label class="form-check-label text-danger" title="Medical Allowance">
                                            <input value="1" type="checkbox" class="form-check-input" name="mda" @if($joinGrades->grade_mda){{'checked'}}@endif> MDA <i class="input-helper"></i></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="form-check edit-check form-check-warning">
                                        <label class="form-check-label text-warning" title="Yearly Bonus">
                                            <input value="1" type="checkbox" class="form-check-input" name="bonus" @if($joinGrades->grade_bonus){{'checked'}}@endif> Bonus <i class="input-helper"></i></label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="form-check edit-check form-check-secondary">
                                        <label class="form-check-label text-secondary" title="Provident Fund">
                                            <input value="1" type="checkbox" class="form-check-input" name="pf" @if($joinGrades->grade_prd_fund){{'checked'}}@endif> PF <i class="input-helper"></i></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="form-check edit-check form-check-success">
                                        <label class="form-check-label text-success" title="Professional Tax">
                                            <input value="1" type="checkbox" class="form-check-input" name="pt" @if($joinGrades->grade_pro_tax){{'checked'}}@endif> PT <i class="input-helper"></i></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-12">
                                <p class="text-gray">Included</p>
                            </div>
{{--                                @if(@$joinGrades->grade_hra)--}}
                            <div class="col-sm-6 hra" >
                                <div class="form-group row" title="House Rent Allowance">
                                    <label class="col-sm-12 col-form-label" for="hra">HRA</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="hra_val" id="hra" @if(@$joinGrades->grade_hra){{'required'}}@else{{'disabled'}} @endif placeholder="Amount of HRA" value="{{$joinGrades->hra}}">
                                        @if(@$joinGrades->grade_hra)
                                        <small class="float-right text-success" id="hra_RO">Required</small>
                                        @else
                                            <small class="float-right text-primary" id="hra_RO">Optional</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
{{--                                @endif--}}
{{--                                @if(@$joinGrades->grade_mda)--}}
                            <div class="col-sm-6 mda">
                                <div class="form-group row" title="Medical Allowence">
                                    <label class="col-sm-12 col-form-label" for="mda">MDA</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="mda" name="mda_val" @if(@$joinGrades->grade_mda){{'required'}}@else{{'disabled'}}@endif placeholder="Amount of MDA" value="{{$joinGrades->mda}}">
                                        @if(@$joinGrades->grade_mda)
                                        <small id="mda_RO" class="float-right text-success">Required</small>
                                        @else
                                            <small id="mda_RO" class="float-right text-primary">Optional</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
{{--                                @endif--}}
{{--                                @if(@$joinGrades->grade_bonus)--}}
                            <div id="bonus" class="col-sm-12 bonus">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group row" title="Yearly Bonus Number">
                                            <label class="col-sm-12 col-form-label" for="b_no">Yearly Bonus No.</label>
                                            <div class="col-sm-12">
                                                <input type="number" class="form-control" id="b_no" name="b_no_val"
                                                       @if(@$joinGrades->grade_bonus){{'required'}}@else{{'disabled'}} @endif placeholder="Yearly bonus Number" value="{{$joinGrades->grade_bonus_no}}">
                                                @if(@$joinGrades->grade_bonus)
                                                <small id="b_no_RO" class="float-right text-success">Required</small>
                                                @else
                                                <small id="b_no_RO" class="float-right text-primary">Optional</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row" title="Yearly Bonus Amount">
                                            <label class="col-sm-12 col-form-label" for="b_amount">Yearly Bonus Amount</label>
                                            <div class="col-sm-12">
                                                <input type="number" class="form-control" id="b_amount" name="b_amount_val" @if(@$joinGrades->grade_bonus){{'required'}} @else{{'disabled'}} @endif placeholder="Yearly bonus amount" value="{{$joinGrades->bonus}}">
                                                @if(@$joinGrades->grade_bonus)
                                                    <small id="b_amount_RO" class="float-right text-success">Required</small>
                                                @else
                                                    <small id="b_amount_RO" class="float-right text-primary">Optional</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
{{--                                @endif--}}
{{--                                @if(@$joinGrades->grade_prd_fund)--}}
                            <div class="col-sm-6 pf">
                                <div class="form-group row" title="Provident Fund">
                                    <label class="col-sm-12 col-form-label" for="pf">Provident Fund Amount</label>
                                    <div class="col-sm-12">
                                        <input type="number" class="form-control" id="pf" name="pf_val" @if(@$joinGrades->grade_prd_fund){{'required'}}@else{{'disabled'}} @endif placeholder="Provident Fund Amount" value="{{$joinGrades->pf}}">
                                        @if(@$joinGrades->grade_prd_fund)
                                        <small id="pf_RO" class="float-right text-success">Required</small>
                                        @else
                                        <small id="pf_RO" class="float-right text-primary">Optional</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
{{--                                @endif--}}
{{--                                @if(@$joinGrades->grade_pro_tax)--}}
                            <div class="col-sm-6 pt">
                                <div class="form-group row" title="Professional Tax Amount">
                                    <label class="col-sm-12 col-form-label" for="pt">Professional Tax Amount</label>
                                    <div class="col-sm-12">
                                        <input type="number" class="form-control" id="pt" name="pt_val" @if(@$joinGrades->grade_pro_tax){{'required'}}@else{{'disabled'}}@endif placeholder="Professional Tax Amount" value="{{$joinGrades->pt}}">
                                        @if(@$joinGrades->grade_pro_tax)
                                        <small id="pt_RO" class="float-right text-success">Required</small>
                                        @else
                                            <small id="pt_RO" class="float-right text-primary">Optional</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
{{--                                @endif--}}
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group float-right mt-2">
                            <input type="submit" class="btn btn-success" value="Update">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-6">
                            <h4 class="card-title">Salary Grade list</h4>
                        </div>
                        <div class="col-sm-6">
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
