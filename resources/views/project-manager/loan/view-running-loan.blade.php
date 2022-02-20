@extends('layouts.project-manager.main')
@section('content')
<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="row">
                            <h4 class="card-title">Full View of Applied Loan</h4>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="row">
                            <table class="table-responsive">
                                <tbody>
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
                                            @if($loanApplication->loan_appl_approve_status) <span class="text-success">Active</span>
                                            @else <span class="text-danger">Inactive</span>
                                            @endif
                                        </td>
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
                                    <th>Installment</th>
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
@stop
