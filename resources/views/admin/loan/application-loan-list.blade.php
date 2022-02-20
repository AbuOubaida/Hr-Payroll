@extends('layouts.admin.main')
@section('content')
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
