@extends('layouts.admin.main')
@section('content')
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <h3 class="card-title">Full View of Approved Loan</h3>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="row">
                                <h5 class="card-title text-info">Approved Loan Information</h5>
                                <div class="table-responsive">
                                    <table class="table table-borderless text-white table-sm">
                                        <tbody>
                                        <tr>
                                            <th>Invoice ID</th>
                                            <th>:&nbsp;&nbsp;</th>
                                            <td class="font-weight-light text-success">#{{$request->invoice_id}}</td>
                                        </tr>
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
                                            <td class="font-weight-light">{{$request->proposed_loan_amount}}</td>
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
                                        <tr>
                                            <th>Many Received Status</th>
                                            <th>:&nbsp;&nbsp;</th>
                                            <td class="font-weight-light">
                                                @if($request->many_received_status) <span class="text-success">Received</span>
                                                @else <span class="text-danger">
                                                Not Received
                                                <i><small class="text-warning">This transaction will be complete next salary time.</small></i>
                                            </span>
                                                @endif
                                            </td>
                                        </tr>
                                        @if($request->many_received_status)
                                            <tr>
                                                <th>Many Received Date</th>
                                                <th>:&nbsp;&nbsp;</th>
                                                <td class="font-weight-light">{{date('M-d,Y',strtotime($request->many_received_date))}}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th>Loan Complete Status</th>
                                            <th>: </th>
                                            <th class="font-weight-light">
                                                @if($request->loan_complete_status)
                                                    <b class="text-success">All Installment are paid</b>
                                                @else
                                                    <b class="text-danger">{{$request->complete_installment}} Installment are completed in {{$request->loan_type_installment}}</b>
                                                @endif
                                            </th>
                                        </tr>
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
                        </div>
                        <div class="col-sm-5">
                            <div class="row">
                                <h5 class="card-title text-info">Employee Information</h5>
                                <div class="table-responsive">
                                    <table class="table table-borderless text-white table-sm">
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
                                                {{$request->phone_code?"+".$request->phone_code:''}}-{{$request->phone}}
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
</div>
@if($request->loan_appl_approve_status)
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <h4 class="card-title">Installment List for this loan</h4>
                                <div class="table-responsive" id="grade-table">
                                    <table class="table table-sm">
                                        <thead>
                                        <tr class="bg-success text-white">
                                            <th>Installment Number</th>
                                            <th>Installment Paid Status</th>
                                            <th>Installment Paid Date</th>
                                            <th>Installment Amount</th>
                                            <th class="text-center">Total Loan Amount</th>
                                        </tr>
                                        </thead>
                                        <tbody id="ins-loan-list">
                                        @if(($n=count($installments)))
                                            <?php
                                            $totalPaidIns = 0;
                                            $total = 0;
                                            ?>
                                            @foreach($installments as $ins)
                                                <?php
                                                $total += $ins->ins_amount;
                                                ?>
                                                <tr>
                                                    <td>{{$ins->ins_number}}</td>
                                                    <td>
                                                        @if($ins->ins_paid_status)
                                                            <?php
                                                            $totalPaidIns += $ins->ins_amount;
                                                            ?>
                                                            <span class="text-success">Paid</span>
                                                        @else
                                                            <span class="text-danger">Unpaid</span>
                                                        @endif
                                                    </td>
                                                    <td>@if($ins->ins_paid_date) {{$ins->ins_paid_date}} @else NULL @endif</td>
                                                    <td class="text-right">{{$ins->ins_amount}}/-</td>
                                                    @if($ins->ins_number < 2)
                                                        <td rowspan="{{$n}}" class="text-center bg-dark">{{$t = $ins->loan_amount}}/-</td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                            <tr class="bg-primary text-white">
                                                <td>Total Paid Installment Amount</td>
                                                <td colspan="3" class="text-right">{{$totalPaidIns}}/-</td>
                                                <td class="text-center">{{$totalPaidIns}}/-</td>
                                            </tr>
                                            <tr class="bg-danger text-warning">
                                                <td colspan="4">Total Unpaid Installment Amount</td>
                                                <td class="text-center">{{(($total-$totalPaidIns))}}/-</td>

                                            </tr>
                                        @else
                                            <tr>
                                                <td>Not Found</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                    <div class="col-sm-12 position">
                                        {{--                                    @if($requests->links())--}}
                                        {{--                                        {{$requests->links()}}--}}
                                        {{--                                    @endif--}}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

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
                                    <input id="user" type="text" class="form-control " placeholder="Search by Employee Name or ID" aria-label="" aria-describedby="basic-addon1" onkeyup="return searchLoanRunning(this)">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend input-group-sm">
                                        <span class="input-group-text">Filter by status </span>
                                    </div>
                                    <select class="form-control text-white" id="status" name="status" onchange="return searchLoanRunning(this)">
                                        <option value="1">Approved</option>
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
                                    <select class="form-control text-white" id="title" name="title" onchange="return searchLoanRunning(this)">
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
                                    <select class="form-control text-white" id="order" name="order" onchange="return searchLoanRunning(this)">
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
                                        <th>Invoice ID</th>
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
                                    @include('layouts.admin.loan._running_loan_list')
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
