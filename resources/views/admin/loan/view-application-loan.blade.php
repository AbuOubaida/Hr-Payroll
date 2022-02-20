@extends('layouts.admin.main')
@section('content')
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row">
                                <h4 class="card-title">Full View of Applied Loan</h4>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row float-right">
                                @if(!$request->loan_appl_approve_status)
{{--                                Approve Loan Request form submit--}}
                                <form method="post" action="{{route('loan.request.approve')}}" class="d-inline-block mr-1" onclick="return confirm('Are you sure Approve this Loan Application?')">
                                    <input type="hidden" value="{{$request->client_id}}" name="client_id">
                                    <input type="hidden" value="{{$request->loan_appl_id }}" name="loan_req_id">
                                    <button class="btn btn-sm btn-outline-primary btn-icon-text">Make Approved <i class="mdi mdi-file-check btn-icon-append"></i></button>
                                </form>
{{--                                Delete Loan Request form submit--}}
                                <form action="{{route('proposed.loan.delete')}}" method="post" class="d-inline-block">
                                    {!! method_field('delete') !!}
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="p_loan_id" value="{{$request->loan_appl_id}}">
                                    <button class="btn btn-sm d-inline-block btn-outline-danger" onclick="return confirm('Are you sure delete this Loan Application?')" type="submit"> Delete <i class="mdi mdi-delete"></i></button>
                                </form>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <p class="text-justify">If you <span class="text-primary">Make Approved </span> this loan, then the loan amount <span class="text-warning">({{$request->proposed_loan_amount}}/-)</span> will be added on next month with employees (<span class="text-warning">{{$request->client_name}}</span>) salary. The first installment <span class="text-warning">({{$ins_amount = ceil($request->proposed_loan_amount/$request->loan_type_installment)}})/-</span> will be taken from the employee's salary in the next month in which the employee has taken the loan. </p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <h4 class="text-info">Loan Information</h4>
                                <table class="table-responsive">
                                    <tbody>
                                    <tr>
                                        <th>Applied Loan Title</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">{{$request->proposed_loan_title}}</td>
                                    </tr>

                                    <tr>
                                        <th>Applied Loan Type</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">{{$request->loan_type_title}}</td>
                                    </tr>

                                    <tr>
                                        <th>Loan Applied Date</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">{{date('M-d,Y',strtotime($request->apply_date))}}</td>
                                    </tr>

                                    <tr>
                                        <th>Applied Loan Amount</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">{{$request->proposed_loan_amount}}/-</td>
                                    </tr>

                                    <tr>
                                        <th>Applied Loan Duration</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">{{$request->loan_type_duration}} @if($request->loan_type_year) Years @else Month @endif</td>
                                    </tr>

                                    <tr>
                                        <th>Number of Installment</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">{{$request->loan_type_installment}}</td>
                                    </tr>
                                    <tr>
                                        <th>Installment Amount</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">{{$ins_amount}}/-</td>
                                    </tr>

                                    <tr>
                                        <th>Loan Approved Status</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">
                                            @if($request->loan_appl_approve_status) <span class="text-success">Approved</span>
                                            @else <span class="text-danger">Pending</span>
                                            @endif
                                        </td>
                                    </tr>
                                @if($request->loan_appl_approve_status)
                                        <tr>
                                        <th>Loan Approved Date</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">{{date('M-d,Y',strtotime($request->response_date))}}</td>
                                    </tr>
                                @endif
                                @if($request->loan_appl_deatils)
                                    <tr>
                                        <th>Applied Loan Details</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">{{$request->loan_appl_deatils}}</td>
                                    </tr>
                                @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <h4 class="text-info">Employee Information</h4>
                                <table class="table-responsive">
                                    <tbody>
                                    <tr>
                                        <th>Applied Name</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td>
                                            <a href="{{url("admin/employee/view/{$request->client_id}")}}" target="_blank">{{$request->client_name}}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Applied Employee ID</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td>
                                            <a href="{{url("admin/employee/view/{$request->client_id}")}}" target="_blank">#{{$request->client_emp_id}}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Employee Department</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td>
                                            <a href="{{url("admin/view-department/{$request->client_dep_id}")}}" target="_blank">{{$request->client_dep_name}}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Employee Email</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td>
                                            {{$request->client_email}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Employee Phone</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td>
                                            {{$request->phone_code?"+".$request->phone_code:''}} {{$request->phone}}
                                        </td>
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

<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-6">
                            <h4 class="card-title">Applied Loan List</h4>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend input-group-sm">
                                        <span class="input-group-text">Search</span>
                                    </div>
                                    <input id="user" type="text" class="form-control " placeholder="Search by Employee Name or ID" aria-label="" aria-describedby="basic-addon1" onkeyup="return searchLoanApplication(this)">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend input-group-sm">
                                        <span class="input-group-text">Filter by status </span>
                                    </div>
                                    <select class="form-control text-white" id="status" name="status" onchange="return searchLoanApplication(this)">
                                        <option value="0">Pending</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend input-group-sm">
                                        <span class="input-group-text">Filter by title</span>
                                    </div>
                                    <select class="form-control text-white" id="title" name="title" onchange="return searchLoanApplication(this)">
                                        <option></option>
                                        @if(count($loans))
                                            @foreach($loans as $l)
                                                <option value="{{$l->proposed_loan_title}}">{{$l->proposed_loan_title}}</option>
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
                                        <span class="input-group-text">Order by</span>
                                    </div>
                                    <select class="form-control text-white" id="order" name="order" onchange="return searchLoanApplication(this)">
                                        <option></option>
                                        <option value="asc">A-Z</option>
                                        <option value="desc">Z-A</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="table-responsive" id="grade-table">
                                <table class="table table-sm table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Apply Date</th>
                                        <th>Client Name</th>
                                        <th>Employee ID</th>
                                        <th>Department</th>
                                        <th>Loan Title</th>
                                        <th>Amount</th>
                                        <th>Approve Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="application-loan-list">
                                    @include('layouts.admin.loan._application_loan_list')
                                    </tbody>
                                </table>
                                <div class="col-sm-12 position">
                                    @if($requests->links())
                                        {{$requests->links()}}
                                    @endif
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
