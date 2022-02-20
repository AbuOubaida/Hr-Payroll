@extends('layouts.admin.main')
@section('content')
<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="row">
                            <h4 class="card-title">Full View of CV</h4>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <a href="{{url("admin/recruitment/delete-cv/{$cv->cv_id}")}}" class="float-right" onclick="return confirm('Are you sure delete this Department')"><button type="button" class="btn btn-outline-danger btn-icon-text"> Delete <i class="mdi mdi-delete btn-icon-append"></i></button></a>
                    @if($cv->seen_status == 1)
                        <form method="post" action="{{url("admin/employee/admit-employee")}}" class="float-right" style="margin-right: 5px;">
                            <input type="hidden" name="id" value="{{$cv->cv_id}}">
                            <input type="hidden" name="name" value="{{$cv->cv_name}}">
                            <input type="hidden" name="emp_email" value="{{$cv->cv_email}}">
                            <input type="hidden" name="emp_phone" value="{{$cv->cv_phone}}">
                            <input type="hidden" name="emp_dep" value="{{$cv->dep_id}}">
                            <input type="hidden" name="emp_position" value="{{$cv->cv_r_id}}">
                            <input type="hidden" name="emp_role" value="3">
                            <button onclick="return confirm('Are you sure, This candidate admit to employee? At first please open this person CV')" class="btn btn-outline-success btn-icon-text">Admit to employee <i class="mdi mdi-account-plus btn-icon-append"></i></button>
                        </form>
                    @endif
                    </div>
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="row">
                                    <h4 class="text-info">Applicant Info</h4>
                                    <table class="table-responsive">
                                        <tbody>
                                        <tr>
                                            <th>Applicant Name</th>
                                            <th>:&nbsp;&nbsp;</th>
                                            <td class="font-weight-light">{{$cv->cv_name}}</td>
                                        </tr>

                                        <tr>
                                            <th>Applicant Email</th>
                                            <th>:&nbsp;&nbsp;</th>
                                            <td class="font-weight-light">{{$cv->cv_email}}</td>
                                        </tr>

                                        <tr>
                                            <th>Applicant Phone</th>
                                            <th>:&nbsp;&nbsp;</th>
                                            <td class="font-weight-light">{{$cv->cv_phone}}</td>
                                        </tr>

                                        <tr>
                                            <th>Apply Date</th>
                                            <th>:&nbsp;&nbsp;</th>
                                            <td class="font-weight-light">{{date('d-m-Y',strtotime($cv->created_at))}}</td>
                                        </tr>

                                        <tr>
                                            <th>CV Seen Status</th>
                                            <th>:&nbsp;&nbsp;</th>
                                            <td class="font-weight-light">@if($cv->seen_status == 1) <span class="text-warning">Seen</span>
                                                <a href="{{url("admin/recruitment/unseen-cv/{$cv->cv_id}")}}" class="btn btn-sm btn-danger">Make Unseen</a>@else <span class="text-danger">Unseen</span> <a href="{{url("admin/recruitment/seen-cv/{$cv->cv_id}")}}" class="btn btn-sm btn-warning"> Make Seen</a> @endif</td>
                                        </tr>

                                        <tr>
                                            <th>Applicant CV PDF</th>
                                            <th>:&nbsp;&nbsp;</th>
                                            <td class="font-weight-light"><a href="{{url("file/admin/recruitments/cv/$cv->cv_file")}}" target="_blank" class="btn btn-sm btn-success">Click To Open CV</a></td>
                                        </tr>
                                        <tr>
                                            <th>Applicant Details</th>
                                            <th>:&nbsp;&nbsp;</th>
                                            <td class="font-weight-light text-justify">{{$cv->cv_details}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row">
                                    <h4 class="text-info">Recruitment Info</h4>
                                    <table class="table-responsive">
                                        <tbody>
                                        <tr>
                                            <th>Recruitment Title</th>
                                            <th>:&nbsp;&nbsp;</th>
                                            <td><a href="{{url("admin/recruitment/view-recruitment/{$cv->cv_r_id}")}}" target="_blank">{{$cv->r_title}}</a></td>
                                        </tr>

                                        <tr>
                                            <th>Recruitment Department</th>
                                            <th>:&nbsp;&nbsp;</th>
                                            <td><a href="{{url("admin/view-department/{$cv->dep_id}")}}" target="_blank"> {{$cv->dep_name}}</a></td>
                                        </tr>
                                        <tr>
                                            <th>Recruitment Vacancies</th>
                                            <th>:&nbsp;&nbsp;</th>
                                            <td>{{$cv->r_vacancies}}</td>
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
    </div>
</div>
@stop
