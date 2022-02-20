@extends('layouts.admin.main')
@section('content')
<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="row">
                            <h4 class="card-title">Full View of Salary Grade</h4>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row float-right">
                            <a href="{{url('admin/grade/salary/edit-grade/').'/'.$joinGrades->root_id}}" class="mr-2"><button type="button" class="btn btn-outline-primary btn-icon-text"> Edit <i class="mdi mdi-file-check btn-icon-append"></i></button></a>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="row">
                            <p class="text-gray">Basic Information of grade ({{$joinGrades->grade_short_title}})</p>
                            <table class="table-responsive">
                                <tbody>
                                    <tr>
                                        <th>Title</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">{{$joinGrades->grade_title}}</td>
                                    </tr>
                                    <tr>
                                        <th>Short Title</th>
                                        <th>:</th>
                                        <td class="font-weight-light">{{$joinGrades->grade_short_title}}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <th>:</th>
                                        <td class="font-weight-light">
                                            @if($joinGrades->grade_status == 1) <span class="text-success">Active</span> @else <span class="text-danger">Inactive</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Basic</th>
                                        <th>:</th>
                                        <td class="font-weight-light">{{$joinGrades->grade_basic}}/=</td>
                                    </tr>
                                    <tr>
                                        <th>Added By</th>
                                        <th>:</th>
                                        <td class="font-weight-light">{{$createAt->name}}</td>
                                    </tr>
                                    <tr>
                                        <th>Updated By</th>
                                        <th>:</th>
                                        <td class="font-weight-light">{{$updateAt->name}}</td>
                                    </tr>
                                    <tr>
                                        <th>Description</th>
                                        <th>:</th>
                                        <td class="text-justify font-weight-light">{{$joinGrades->grade_details}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row">
                            <p class="text-gray">Included (If any allowance)</p>
                            <table class="table-responsive">
                                <tbody style="border-left: 5px solid #191c24">
                                    <tr>
                                        <th>Travel Allowance</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light"> @if($joinGrades->grade_ta) <span class="text-success"> Included </span>  @else <span class="text-danger"> Not Included </span>@endif</td>
                                    </tr>
                                    <tr>
                                        <th>Daily Allowance</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light"> @if($joinGrades->grade_da) <span class="text-success"> Included </span>  @else <span class="text-danger"> Not Included </span>@endif</td>
                                    </tr>
                                    <tr>
                                        <th>House Rent Allowance</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light"> @if($joinGrades->hra) <span class=""> {{$joinGrades->hra}}/= </span>  @else <span class="text-danger"> Not Included </span>@endif</td>
                                    </tr>
                                    <tr>
                                        <th>Medical Allowance</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light"> @if($joinGrades->mda) <span class=""> {{$joinGrades->mda}}/= </span>  @else <span class="text-danger"> Not Included </span>@endif</td>
                                    </tr>
                                    <tr>
                                        <th>Yearly Bonus No.</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light"> @if($joinGrades->grade_bonus_no) <span class="text-success"> {{$joinGrades->grade_bonus_no}} </span>  @else <span class="text-danger"> Not Included </span>@endif</td>
                                    </tr>
                                    <tr>
                                        <th>Bonus Amount</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light"> @if($joinGrades->bonus) <span class=""> {{$joinGrades->bonus}}/= </span>  @else <span class="text-danger"> Not Included </span>@endif</td>
                                    </tr>
                                    <tr>
                                        <th>Provident Fund</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light"> @if($joinGrades->pf) <span class=""> {{$joinGrades->pf}}/= </span>  @else <span class="text-danger"> Not Included </span>@endif</td>
                                    </tr>
                                    <tr>
                                        <th>Professional Tax</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light"> @if($joinGrades->pt) <span class=""> {{$joinGrades->pt}}/= </span>  @else <span class="text-danger"> Not Included </span>@endif</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="row">
                            <p class="text-gray">Total</p>
                            <table class="table-responsive">
                                <tbody style="border-left: 5px solid #2c2e33">
                                    <tr>
                                        <th>Basic</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <th class="text-success">(+)&nbsp;&nbsp;</th>
                                        <td class="font-weight-light"> @if($joinGrades->grade_basic) <span class=""> {{$joinGrades->grade_basic}}/= </span>  @else --- @endif</td>
                                    </tr>
                                    <tr>
                                        <th>HRA</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <th class="text-success">(+)&nbsp;&nbsp;</th>
                                        <td class="font-weight-light"> @if($joinGrades->hra) <span class=""> {{$joinGrades->hra}}/= </span>  @else --- @endif</td>
                                    </tr>
                                    <tr>
                                        <th>MDA</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <th class="text-success">(+)&nbsp;&nbsp;</th>
                                        <td class="font-weight-light"> @if($joinGrades->mda) <span class=""> {{$joinGrades->mda}}/= </span>  @else --- @endif</td>
                                    </tr>
                                    <tr class="border-top text-info border-bottom">
                                        <th>Sub Total</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <th class="text-success"></th>
                                        <td class="font-weight-light"> {{$sub = (($joinGrades->grade_basic)+($joinGrades->hra)+($joinGrades->mda))}}/=</td>
                                    </tr>
                                    <tr>
                                        <th>PF</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <th class="text-danger">(-)&nbsp;&nbsp;</th>
                                        <td class="font-weight-light"> @if($joinGrades->pf) <span class=""> {{$joinGrades->pf}}/= </span>  @else --- @endif</td>
                                    </tr>
                                    <tr>
                                        <th>PT</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <th class="text-danger">(-)&nbsp;&nbsp;</th>
                                        <td class="font-weight-light"> @if($joinGrades->pt) <span class=""> {{$joinGrades->pt}}/= </span>  @else --- @endif</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">&nbsp;</td>
                                    </tr>
                                    <tr class="border-top text-primary border-bottom">
                                        <th>Total</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <th class="text-success"></th>
                                        <td> {{($sub - (($joinGrades->pf) + ($joinGrades->pt)))}}/=</td>
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
