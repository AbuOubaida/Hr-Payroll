@extends('layouts.admin.main')
@section('content')
<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="card-title">Proposed New Loan</h4>
                    <p class="card-description">Proposed Loan info </p>
                    <form class="form-sample" method="post" action="{{route('save.loan')}}">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for="title">Loan title</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="title" id="title" required placeholder="Enter Loan title" value="{{old('title')}}">
                                        <small class="float-right text-success">Required</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for="amount">Proposed amount</label>
                                    <div class="col-sm-12">
                                        <input type="number" class="form-control" name="amount" id="amount" required placeholder="Enter proposed loan amount" value="{{old('amount')}}">
                                        <small class="float-right text-success">Required</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="type_id" class="col-form-label">Type of Loan</label>
                                    <select name="type_id" id="type_id" class="form-control" required>
                                        <option></option>
                                        @if(count($loan_types))
                                            @foreach($loan_types as $loan_type)
                                                @if($loan_type->loan_type_status)
                                                    <option value="{{$loan_type->loan_type_id}}" @if(old('type_id') == $loan_type->loan_type_id) selected @endif>{{$loan_type->loan_type_title}}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                    <small class="float-right text-success">Required</small>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label" for="details">Loan Details</label>
                                    <textarea name="details" class="form-control" id="details" rows="5" spellcheck="false" placeholder="Enter Loan Details">{{old('details')}}</textarea>
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
                    <h4 class="card-title">Proposed Loan List</h4>
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
<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="card-title">Add Loan Type</h4>
                    <form class="form-sample" method="post" action="{{route('save.loan.type')}}">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for="type">Loan Type</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="type" id="type" required placeholder="Enter loan type" value="{{old('type')}}">
                                        <small class="float-left text-secondary">Home / Car</small>
                                        <small class="float-right text-success">Required</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for="duration">Loan Duration</label>
                                    <div class="col-sm-5">
                                        <div class="row-r">
                                            <select class="form-control" id="duration" name="duration" required>
                                                <option></option>
                                            @for($i=1;$i <= 12; $i++)
                                                <option value="{{$i}}" {{$i == old('duration')?'selected':''}} >{{$i}}</option>
                                            @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-7">
                                        <select class="form-control" id="monthYear" name="monthYear" required>
                                            <option></option>
                                            <option value="{{$i='months'}}" {{$i == old('monthYear')?'selected':''}} >{{$i}}</option>
                                            <option value="{{$i='years'}}" {{$i == old('monthYear')?'selected':''}} >{{$i}}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12">
                                        <small class="float-left text-secondary">6 months' / 1 year</small>
                                        <small class="float-right text-success">Required</small>
                                    </div>
                                </div>
                            </div>
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="form-group row">--}}
{{--                                    <label class="col-sm-12 col-form-label" for="installment">No. of Installment</label>--}}
{{--                                    <div class="col-sm-12">--}}
{{--                                        <input type="number" class="form-control" id="installment" name="installment" required value="{{old('installment')}}">--}}
{{--                                        <small class="float-left text-secondary">1,2,3,.......n < Duration month/year</small>--}}
{{--                                        <small class="float-right text-success">Required</small>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="col-sm-12">
                                <div class="form-group float-right mt-2">
                                    <input type="submit" class="btn btn-success">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="card-title">Loan Type list</h4>
                        </div>

                        <div class="col-sm-12">
                            <div class="table-responsive" id="grade-table">
                                <table class="table table-sm table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Type</th>
                                        <th>Duration</th>
                                        <th>No. of Installment</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="project-sm-list">
                                    <?php $i=1;?>
                                    @if(count($loan_types))
                                        @foreach($loan_types as $lt)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{$lt->loan_type_title}}</td>
                                            <td> {{$lt->loan_type_duration}} @if($lt->loan_type_year) years @else months @endif </td>
                                            <td class="text-center">{{$lt->loan_type_installment}}</td>
                                            <td>@if($lt->loan_type_status) <span class="text-success">Active</span> @else <span class="text-danger">Inactive</span>  @endif</td>
                                            <td class="text-center">

                                                <a href="{{url('admin/loan/edit-loan-type/'.$lt->loan_type_id)}}" class="text-warning" title="Full view of Loan Type"> <i class="mdi mdi-eye"></i></a>

                                                <a href="{{url('admin/loan/edit-loan-type/'.$lt->loan_type_id)}}" class="text-info"><i class="mdi mdi-table-edit" title="Edit Loan Type"></i></a>

                                                <form action="{{route('loan.type.delete')}}" method="post" class="d-inline-block">
                                                    {!! method_field('delete') !!}
                                                    {!! csrf_field() !!}
                                                    <input type="hidden" name="typeDeleteID" value="{{$lt->loan_type_id}}">
                                                    <button class="btn-style-none d-inline-block text-danger" onclick="return confirm('Are you sure delete this Loan Type?')" type="submit"><i class="mdi mdi-delete"></i></button>
                                                </form>
{{--                                                <a href="#" class="text-danger" title="" onclick="return confirm('Are you sure delete this Loan Type?')"><i class="mdi mdi-delete"></i></a>--}}
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif
{{--                                    @include('layouts.admin.project._project_sm_list')--}}
                                    </tbody>
                                </table>
                                <div class="col-sm-12 position">
{{--                                    @if($projects->links())--}}
{{--                                        {{$projects->links()}}--}}
{{--                                    @endif--}}
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
