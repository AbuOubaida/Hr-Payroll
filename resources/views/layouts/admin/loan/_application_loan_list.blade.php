<?php $i= count($requests);?>
@if(count($requests))
    @foreach($requests as $l_app)
        <tr class="@if($l_app->loan_appl_id == \Illuminate\Support\Facades\Request::route('appLoanID') || $l_app->loan_appl_id == \Illuminate\Support\Facades\Request::route('appLnID')){{'text-white'}}@endif">
            <td>{{$i--}}</td>
            <td>{{date('M-d,Y',strtotime($l_app->apply_date))}}</td>
            <td>
                <a href="{{url("admin/employee/view/{$l_app->client_id}")}}" target="_blank">{{$l_app->client_name}}</a>
            </td>
            <td>
                <a href="{{url("admin/employee/view/{$l_app->client_id}")}}" target="_blank">{{$l_app->client_emp_id}}</a>
            </td>
            <td>
                <a href="{{url("admin/view-department/{$l_app->client_dep_id}")}}" target="_blank">{{$l_app->client_dep_name}}</a>
            </td>
            <td>
                <a href="{{url("admin/loan/view-proposed-loan/{$l_app->proposed_loan_id}")}}" target="_blank">{{$l_app->proposed_loan_title}}</a>
            </td>
            <td>{{$l_app->proposed_loan_amount}}</td>
            <td>
                @if($l_app->loan_appl_approve_status)
                    <span class="text-success">Approved</span>
                @else
                    <span class="text-warning">Pending</span>
                @endif
            </td>
            <td class="text-center">

                <a href="{{url('admin/loan/view-app-loan/'.$l_app->loan_appl_id)}}" class="text-warning" title="Full view of Loan Apply Loan"> <i class="mdi mdi-eye"></i></a>


                <form action="{{route('proposed.loan.delete')}}" method="post" class="d-inline-block">
                    {!! method_field('delete') !!}
                    {!! csrf_field() !!}
                    <input type="hidden" name="p_loan_id" value="{{$l_app->loan_appl_id}}">
                    <button class="btn-style-none d-inline-block text-danger" onclick="return confirm('Are you sure delete this Apply Loan?')" type="submit"><i class="mdi mdi-delete"></i></button>
                </form>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td c colspan="9" class="text-center text-danger">Not Found!</td>
    </tr>
@endif
