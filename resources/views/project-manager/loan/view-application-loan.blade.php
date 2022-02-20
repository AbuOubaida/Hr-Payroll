@extends('layouts.project-manager.main')
@section('content')
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <h4 class="card-title">Full View of Approved Loan</h4>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-borderless text-white table-sm">
                                        <tbody>
                                        <tr>
                                            <th>Invoice ID</th>
                                            <th>:&nbsp;&nbsp;</th>
                                            <td class="font-weight-light text-success">#{{$loanApplication->invoice_id}}</td>
                                        </tr>
                                        <tr>
                                            <th>Applied Loan Title</th>
                                            <th>:&nbsp;&nbsp;</th>
                                            <td class="font-weight-light">{{$loanApplication->proposed_loan_title}}</td>
                                        </tr>

                                        <tr>
                                            <th>Applied Loan Type</th>
                                            <th>:&nbsp;&nbsp;</th>
                                            <td class="font-weight-light">{{$loanApplication->loan_type_title}}</td>
                                        </tr>

                                        <tr>
                                            <th>Loan Applied Date</th>
                                            <th>:&nbsp;&nbsp;</th>
                                            <td class="font-weight-light">{{date('M-d,Y',strtotime($loanApplication->apply_date))}}</td>
                                        </tr>

                                        <tr>
                                            <th>Applied Loan Amount</th>
                                            <th>:&nbsp;&nbsp;</th>
                                            <td class="font-weight-light">{{$loanApplication->proposed_loan_amount}}</td>
                                        </tr>

                                        <tr>
                                            <th>Applied Loan Duration</th>
                                            <th>:&nbsp;&nbsp;</th>
                                            <td class="font-weight-light">{{$loanApplication->loan_type_duration}} @if($loanApplication->loan_type_year) Years @else Month @endif</td>
                                        </tr>

                                        <tr>
                                            <th>Number of Installment</th>
                                            <th>:&nbsp;&nbsp;</th>
                                            <td class="font-weight-light">{{$loanApplication->loan_type_installment}}</td>
                                        </tr>

                                        <tr>
                                            <th>Loan Approved Status</th>
                                            <th>:&nbsp;&nbsp;</th>
                                            <td class="font-weight-light">
                                                @if($loanApplication->loan_appl_approve_status) <span class="text-success">Approved</span>
                                                @else <span class="text-danger">Pending</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @if($loanApplication->loan_appl_approve_status)
                                            <tr>
                                                <th>Loan Approved Date</th>
                                                <th>:&nbsp;&nbsp;</th>
                                                <td class="font-weight-light">{{date('M-d,Y',strtotime($loanApplication->response_date))}}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th>Many Received Status</th>
                                            <th>:&nbsp;&nbsp;</th>
                                            <td class="text-justify font-weight-light">
                                                @if($loanApplication->many_received_status) <span class="text-success">Received</span>
                                                <i><small class="text-info">Your Loan amount is added on your salary</small></i>
                                                @else <span class="text-danger">
                                            Not Received
                                            <i><small class="text-warning">This transaction will be complete next salary time.</small></i>
                                        </span>
                                                @endif
                                            </td>
                                        </tr>
                                        @if($loanApplication->many_received_status)
                                            <tr>
                                                <th>Many Received Date</th>
                                                <th>:&nbsp;&nbsp;</th>
                                                <td class="font-weight-light">{{date('M-d,Y',strtotime($loanApplication->many_received_date))}}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th>Loan Complete Status</th>
                                            <th>: </th>
                                            <th class="font-weight-light">
                                                @if($loanApplication->loan_complete_status)
                                                    <b class="text-success">All Installment are paid</b>
                                                @else
                                                    <b class="text-danger">{{$loanApplication->complete_installment}} Installment are completed in {{$loanApplication->loan_type_installment}}</b>
                                                @endif
                                            </th>
                                        </tr>
                                        @if($loanApplication->loan_appl_deatils)
                                            <tr>
                                                <th>Applied Loan Details</th>
                                                <th>:&nbsp;&nbsp;</th>
                                                <td class="font-weight-light">{{$loanApplication->loan_appl_deatils}}</td>
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
    </div>
</div>

    @if($loanApplication->many_received_status && count($installments))
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <h4 class="card-title d-block w-100">Installment List for this loan</h4>
                                        <p class="card-description"> The installment will be deducted from your salary for the next {{$loanApplication->loan_type_duration}} @if($loanApplication->loan_type_year) Years @else Month @endif to repay the loan</p>
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
                            <div class="col-sm-12">
                                <div class="table-responsive" id="grade-table">
                                    <table class="table table-sm table-hover">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Type</th>
                                            <th>Amount</th>
                                            <th>Admin Seen Status</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="proposed-loan-list">
                                        @include('layouts.project-manager.loan._application_loan_list')
                                        </tbody>
                                    </table>
                                    <div class="col-sm-12 position">
                                        @if($loanApplications->links())
                                            {{$loanApplications->links()}}
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
