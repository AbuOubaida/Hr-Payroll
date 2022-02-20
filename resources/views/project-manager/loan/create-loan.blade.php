@extends('layouts.project-manager.main')
@section('content')
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="card-title">Proposed Loan List</h4>
                            <div class="row">
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
        </div>
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <h4 class="card-title">Application Form for loan</h4>
                            <form class="form-sample" method="post" action="{{route('save.loan.application')}}">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="loan" class="col-form-label">Type of Loan</label>
                                            <select name="loan" id="loan" class="form-control" required>
                                                <option></option>
                                                @if(count($loans))
                                                    @foreach($loans as $loan)
                                                        @if($loan->loan_type_status)
                                                            <option value="{{$loan->proposed_loan_id }}" @if(old('type_id') == $loan->proposed_loan_id ) selected @endif>{{$loan->proposed_loan_title}} (BDT-{{$loan->proposed_loan_amount}}/=)</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                            <small class="float-right text-success">Required</small>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label" for="details">Details</label>
                                            <textarea name="details" class="form-control" id="details" rows="5" spellcheck="false" placeholder="Enter reason of loan application details">{{old('details')}}</textarea>
                                            <small class="float-right text-primary">Optional</small>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group float-right mt-2">
                                            <input type="submit" class="btn btn-success">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-6">
                            <h4 class="card-title">Loan Application List</h4>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive" id="grade-table">
                                        <table class="table table-sm table-hover">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Title</th>
                                                <th>Type</th>
                                                <th>Amount</th>
                                                <th>Admin Seen</th>
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
    </div>
@stop
