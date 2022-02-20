<?php $i= count($loanApplications);?>
@if(count($loanApplications))
    @foreach($loanApplications as $l_app)
        <tr class="@if($l_app->loan_appl_id == \Illuminate\Support\Facades\Request::route('appLoanID')){{'text-white'}}@endif">
            <td>{{$i--}}</td>
            <td>
                {{$l_app->proposed_loan_title}}
            </td>
            <td>{{$l_app->loan_type_title}}</td>
            <td>
                {{$l_app->proposed_loan_amount}}
            </td>
            <td>
                @if($l_app->admin_seen_status)
                    <span class="text-success">Seen</span>
                @else
                    <span class="text-warning">Unseen</span>
                @endif
            </td>
            <td>
                @if($l_app->loan_appl_approve_status)
                    <span class="text-success">Approved</span>
                @else
                    <span class="text-warning">Pending</span>
                @endif
            </td>
            <td class="text-center">

                <a href="{{url('employee/loan/view-app-loan/'.$l_app->loan_appl_id)}}" class="text-warning" title="Full view of Loan Apply Loan"> <i class="mdi mdi-eye"></i></a>


                @if(!$l_app->loan_appl_approve_status)
                    <form action="{{route('proposed.loan.delete')}}" method="post" class="d-inline-block">
                        {!! method_field('delete') !!}
                        {!! csrf_field() !!}
                        <input type="hidden" name="p_loan_id" value="{{$l_app->loan_appl_id}}">
                        <button class="btn-style-none d-inline-block text-danger" onclick="return confirm('Are you sure delete this apply Loan?')" type="submit"><i class="mdi mdi-delete"></i></button>
                    </form>
                @endif
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td c colspan="7" class="text-center text-danger">Not Found!</td>
    </tr>
@endif
