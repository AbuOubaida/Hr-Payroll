@extends('layouts.admin.main')
@section('content')
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-6">
                            <h4 class="card-title">Approved Loan List</h4>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend input-group-sm">
                                        <span class="input-group-text">Search</span>
                                    </div>
                                    <input id="user" type="text" class="form-control " placeholder="Search by Employee Name or ID or InvoiceID" aria-label="" aria-describedby="basic-addon1" onkeyup="return searchLoanRunning(this)">
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
                                        <th>Many Received</th>
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
