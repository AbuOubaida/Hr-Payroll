@extends('layouts.admin.main')
@section('content')
<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="row">
                            <h4 class="card-title">Full View of Recruitment</h4>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <a href="#" class="float-right" onclick="return confirm('Are you sure delete this Department')"><button type="button" class="btn btn-outline-danger btn-icon-text"> Delete <i class="mdi mdi-delete btn-icon-append"></i></button></a>

                        <a href="{{url("admin/recruitment/edit-recruitment/{$recruitment->r_id}")}}" class="float-right mr-2"><button type="button" class="btn btn-outline-primary btn-icon-text"> Edit <i class="mdi mdi-file-check btn-icon-append"></i></button></a>
                    </div>
                    <div class="col-sm-12">
                        <div class="row">
                            <table class="table-responsive">
                                <tbody>
                                    <tr>
                                        <th>Recruitment Title</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">{{$recruitment->r_title}}</td>
                                    </tr>

                                    <tr>
                                        <th>Number of vacancies</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">{{$recruitment->r_vacancies}}</td>
                                    </tr>

                                    <tr>
                                        <th>Email</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">{{$recruitment->r_c_email}}</td>
                                    </tr>

                                    <tr>
                                        <th>Phone</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">({{$recruitment->r_c_phone_code}}) {{$recruitment->r_c_phone}}</td>
                                    </tr>

                                    <tr>
                                        <th>Start Date</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">{{$recruitment->r_start_at}}</td>
                                    </tr>

                                    <tr>
                                        <th>End Date</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">{{$recruitment->r_end_at}}</td>
                                    </tr>

                                    <tr>
                                        <th>Recrt. Department</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">{{$recruitment->dep_name}}</td>
                                    </tr>
                                    <tr>
                                        <th>Salary Range</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">{{$recruitment->salary_range}}</td>
                                    </tr>
                                    <tr>
                                        <th>Job Location</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">{{$recruitment->location}}</td>
                                    </tr>
                                    @if($recruitment->r_doc)
                                    <tr>
                                        <th>Recruitment Doc</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light"><a target="_blank" href="{{url("file/admin/recruitments/$recruitment->r_doc")}}" alt="">{{$recruitment->r_doc}}</a></td>
                                    </tr>
                                    @endif
                                    @if($recruitment->r_details)
                                    <tr>
                                        <th>Recruitment Details</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">{{$recruitment->r_details}}</td>
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
