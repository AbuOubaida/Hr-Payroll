@extends('layouts.admin.main')
@section('content')
<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="card-title">Edit Proposed Loan</h4>
                    <form class="form-sample" method="post" action="{{route('update.proposed.loan')}}">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for="title">Proposed loan title</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="title" id="title" required placeholder="Enter Loan title" value="{{$proposedLoan->proposed_loan_title}}">
                                        <small class="float-right text-success">Required</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for="amount">Proposed loan amount</label>
                                    <div class="col-sm-12">
                                        <input type="number" class="form-control" name="amount" id="amount" required placeholder="Enter proposed loan amount" value="{{$proposedLoan->proposed_loan_amount}}">
                                        <small class="float-right text-success">Required</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="type_id" class="col-form-label">Type of proposed loan</label>
                                    <select name="type_id" id="type_id" class="form-control" required>
                                        <option></option>
                                        @if(count($loan_types))
                                            @foreach($loan_types as $loan_type)
                                                @if($loan_type->loan_type_status)
                                                    <option value="{{$loan_type->loan_type_id}}" @if($proposedLoan->proposed_loan_type_id == $loan_type->loan_type_id) selected @endif>{{$loan_type->loan_type_title}}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                    <small class="float-right text-success">Required</small>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="status" class="col-form-label">Proposed loan Status</label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="0" @if($proposedLoan->proposed_loan_status != 1) selected @endif>Inactive</option>
                                        <option value="1" @if($proposedLoan->proposed_loan_status) selected @endif>Active</option>
                                    </select>
                                    <small class="float-right text-success">Required</small>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label" for="details">Proposed loan Details</label>
                                    <input type="hidden" name="id" value="{{$proposedLoan->proposed_loan_id}}">
                                    <textarea name="details" class="form-control" id="details" rows="5" spellcheck="false" placeholder="Enter Loan Details">{{$proposedLoan->proposed_loan_details}}</textarea>
                                    <small class="float-right text-primary">Optional</small>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group float-right mt-2">
                                    <input type="submit" value="Update" class="btn btn-success">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-sm-6">
                    <h4 class="card-title">Project list</h4>
                    <div class="row">
                        <div class="col-sm-12">
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
</div>
@stop
