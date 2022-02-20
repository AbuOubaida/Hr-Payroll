@extends('layouts.project-manager.main')
@section('content')
<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="row">
                            <h4 class="card-title">Full View of Proposed Loan</h4>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="row">
                            <table class="table-responsive">
                                <tbody>
                                    <tr>
                                        <th>Proposed Loan Title</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">{{$proposedLoan->proposed_loan_title}}</td>
                                    </tr>

                                    <tr>
                                        <th>Proposed Loan Type</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">{{$proposedLoan->loan_type_title}}</td>
                                    </tr>

                                    <tr>
                                        <th>Proposed Loan Amount</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">{{$proposedLoan->proposed_loan_amount}}</td>
                                    </tr>

                                    <tr>
                                        <th>Proposed Loan Duration</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">{{$proposedLoan->loan_type_duration}} @if($proposedLoan->loan_type_year) Years @else Month @endif</td>
                                    </tr>

                                    <tr>
                                        <th>Number of Installment</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">{{$proposedLoan->loan_type_installment}}</td>
                                    </tr>

                                    <tr>
                                        <th>Proposed Loan Status</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">
                                            @if($proposedLoan->proposed_loan_status) <span class="text-success">Active</span>
                                            @else <span class="text-danger">Inactive</span>
                                            @endif
                                        </td>
                                    </tr>

                                    @if($proposedLoan->proposed_loan_details)
                                    <tr>
                                        <th>Proposed Loan Details</th>
                                        <th>:&nbsp;&nbsp;</th>
                                        <td class="font-weight-light">{{$proposedLoan->proposed_loan_details}}</td>
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
                        <h4 class="card-title">Proposed Loan List</h4>
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
                                @include('layouts.project-manager.loan._proposed_loan_list')
                                </tbody>
                            </table>
                            <div class="col-sm-12 position">
                                @if($loans->links())
                                    {{$loans->links()}}
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
@stop
