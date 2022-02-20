@extends('layouts.employee.main')
@section('content')
<div class="row" id="content">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row">
                                <h4 class="card-title">Full View of salary of {{$salary->sa_month}}-{{$salary->sa_year}}</h4>
                            </div>
                        </div>
                        <div class="col-sm-6 text-right">
                            <span><b class="text-info">Salary Prepared Date at: </b>{{date('F-d,Y',strtotime($salary->created_at))}}</span>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <p class="text-gray">Salary Information</p>
                                <div class="table-responsive">
                                    <table class="table table-borderless text-white table-sm">
                                        <tbody>
                                        <tr>
                                            <th>Employee Name</th>
                                            <th>:&nbsp;&nbsp;</th>
                                            <td class="font-weight-light"><a href="{{url("admin/employee/view//$salary->emp_id")}}" target="_blank"> {{$salary->name}}</a></td>
                                        </tr>
                                        <tr>
                                            <th>Employee ID</th>
                                            <th>:&nbsp;&nbsp;</th>
                                            <td class="font-weight-light">#{{$salary->employee_id}}</td>
                                        </tr>
                                        <tr>
                                            <th>Employee Email</th>
                                            <th>:&nbsp;&nbsp;</th>
                                            <td class="font-weight-light">{{$salary->email}}</td>
                                        </tr>
                                        <tr>
                                            <th>Salary Month</th>
                                            <th>:&nbsp;&nbsp;</th>
                                            <td class="font-weight-light">{{$salary->sa_month}}-{{$salary->sa_year}}</td>
                                        </tr>
                                        <tr>
                                            <th>Salary Start Date</th>
                                            <th>:&nbsp;&nbsp;</th>
                                            <td class="font-weight-light">{{date('F-d,Y',strtotime($salary->start_date))}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Salary End Date</th>
                                            <th>:&nbsp;&nbsp;</th>
                                            <td class="font-weight-light">{{date('F-d,Y',strtotime($salary->end_date))}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>This month working Hour's</th>
                                            <th>:&nbsp;&nbsp;</th>
                                            <td class="font-weight-light">{{$salary->total_hour}} h</td>
                                        </tr>
                                        <tr>
                                            <th>Per Hour rate for this month</th>
                                            <th>:&nbsp;&nbsp;</th>
                                            <td class="font-weight-light">
                                                {{$salary->per_h_rate}}/-
                                                @if($salary->include_bonus) <span class="text-warning">(<i> Include Bonus</i> )</span> @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Required working Hour's</th>
                                            <th>:&nbsp;&nbsp;</th>
                                            <td class="font-weight-light">{{$companyProtocol->daily_working_hour*$companyProtocol->	monthly_working_day}} h</td>
                                        </tr>
                                        <tr>
                                            <th>Total Salary </th>
                                            <th>:&nbsp;&nbsp;</th>
                                            <td class="font-weight-light">
                                                @if($runningLoan && $salary->add_loan)
                                                    {{($salary->sa_amount-$runningLoan->loan_amount)}}/-
                                                @else
                                                    {{$salary->sa_amount}}/-
                                                @endif
                                                @if($salary->include_bonus) <span class="text-warning">(<i> Include Bonus</i> )</span> @endif
                                            </td>
                                        </tr>
                                        @if($salary->add_loan)
                                            <tr>
                                                <th>Total Loan Amount</th>
                                                <th>:&nbsp;&nbsp;</th>
                                                <td class="font-weight-light">
                                                    {{$runningLoan->loan_amount}}/-
                                                </td>
                                            </tr>
                                        @endif
                                        @if($salary->add_loan_installment)
                                            <tr>
                                                <th>Loan {{$runningLoan->complete_installment}}th Installment</th>
                                                <th>:&nbsp;&nbsp;</th>
                                                <td class="font-weight-light">
                                                    {{$runningLoan->installment_amount}}/-
                                                </td>
                                            </tr>
                                        @endif
                                        @if($pf)
                                            <tr>
                                                <th>Provident Amount</th>
                                                <th>:&nbsp;&nbsp;</th>
                                                <td class="font-weight-light">
                                                    {{$pf->pf_amount}}/-
                                                </td>
                                            </tr>
                                        @endif
                                        @if($pt)
                                            <tr>
                                                <th>Professional Taxes Amount</th>
                                                <th>:&nbsp;&nbsp;</th>
                                                <td class="font-weight-light">
                                                    {{$pt->pt_amount}}/-
                                                </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th>Paid Status</th>
                                            <th>:&nbsp;&nbsp;</th>
                                            <td>
                                                @if($salary->paid_status)
                                                    <b class="text-success">Paid</b>
                                                @else
                                                    <b class="text-danger">Unpaid</b>
                                                @endif
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <p class="text-gray">Salary Calculation</p>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr class="bg-dark">
                                            <th class="text-danger">#</th>
                                            <th class="text-danger">Description</th>
                                            <th class="text-right text-danger">OP</th>
                                            <th class="text-danger">Amount</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>#</td>
                                            <td>{{$salary->total_hour}}h x {{$salary->per_h_rate}}/-</td>
                                            <td class="text-right">+</td>
                                            <td>{{$w_salary = ceil($salary->total_hour * $salary->per_h_rate)}}/-</td>
                                        </tr>
                                        <?php
                                        $subTotal = $w_salary;
                                        ?>
                                    @if($pf)
                                        <tr>
                                            <td>#</td>
                                            <td>Provident Amount</td>
                                            <td class="text-right">-</td>
                                            <td>
                                                {{$pf->pf_amount}}/-
                                            </td>
                                        </tr>
                                        <?php
                                        $subTotal -= $pf->pf_amount;
                                        ?>
                                    @endif
                                    @if($pt)
                                        <tr>
                                            <td>#</td>
                                            <td>Professional Taxes Amount</td>
                                            <td class="text-right">-</td>
                                            <td>
                                                {{$pt->pt_amount}}/-
                                            </td>
                                        </tr>
                                        <?php
                                        $subTotal -= $pt->pt_amount;
                                        ?>
                                    @endif
                                    @if($salary->add_loan)
                                        <tr class="bg-primary text-white">
                                            <td>#</td>
                                            <td>Subtotal Amount</td>
                                            <td class="text-right">=</td>
                                            <td>
                                                {{$subTotal}}/-
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>#</td>
                                            <td>Loan Amount</td>
                                            <td class="text-right">+</td>
                                            <td class="font-weight-light">
                                                {{$runningLoan->loan_amount}}/-
                                            </td>
                                        </tr>
                                        <?php
                                        $subTotal += $runningLoan->loan_amount;
                                        ?>

                                    @elseif($salary->add_loan_installment)
                                        <tr class="bg-primary text-white">
                                            <td>#</td>
                                            <td>Subtotal Amount</td>
                                            <td class="text-right">=</td>
                                            <td>
                                                {{$subTotal}}/-
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>#</td>
                                            <td>Loan {{$runningLoan->complete_installment}}th Installment</td>
                                            <td class="text-right">-</td>
                                            <td class="font-weight-light">
                                                {{$runningLoan->installment_amount}}/-
                                            </td>
                                        </tr>
                                        <?php
                                        $subTotal -= $runningLoan->installment_amount;
                                        ?>
                                    @endif
                                        <tr class="bg-danger text-white">
                                            <td>#</td>
                                            <td>Total Salary Amount</td>
                                            <td class="text-right">=</td>
                                            <td>
                                                {{$subTotal}}/-
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
<div class="row">
    <div class="col-12">
        <button  value="{{$salary->employee_id}}_{{$salary->sa_month}}_{{$salary->sa_year}}" onclick="HTMLtoPDF('content')" class="btn btn-outline-warning">Download Report</button>
    </div>
</div>
@stop
