@extends('layouts.admin.main')
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
                    <div class="col-sm-4">

                        <form action="{{route('proposed.loan.delete')}}" method="post" class="d-inline-block float-right">
                            {!! method_field('delete') !!}
                            {!! csrf_field() !!}
                            <input type="hidden" name="p_loan_id" value="{{$proposedLoan->proposed_loan_id}}">
                            <button class="btn btn-outline-danger btn-icon-text" onclick="return confirm('Are you sure delete this proposed Loan?')" type="submit"><i class="mdi mdi-delete"></i> Delete</button>
                        </form>
{{--                        <a href="#" class="float-right" onclick="return confirm('Are you sure delete this Department')"><button type="button" class="btn btn-outline-danger btn-icon-text"> Delete <i class="mdi mdi-delete btn-icon-append"></i></button></a>--}}

                        <a href="{{url('admin/loan/edit-proposed-loan/'.$proposedLoan->proposed_loan_id)}}" class="float-right mr-2"><button type="button" class="btn btn-outline-primary btn-icon-text"> Edit <i class="mdi mdi-file-check btn-icon-append"></i></button></a>
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
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend input-group-sm">
                                    <span class="input-group-text"><i class="mdi mdi-account-search"></i></span>
                                </div>
                                <input type="text" class="form-control " placeholder="Search by Loan title or amount" onkeyup="return searchProposedLoan(this)">
                            </div>
                        </div>
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
                                @include('layouts.admin.loan._proposed_loan_list')
                                </tbody>
                            </table>
                            <div class="col-sm-12 position">
                                @if($proposedLoans->links())
                                    {{$proposedLoans->links()}}
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
