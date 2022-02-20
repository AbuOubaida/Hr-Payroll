<?php $i= count($loans);?>
@if(count($loans))
    @foreach($loans as $loan)
        <tr class="@if($loan->proposed_loan_id == \Illuminate\Support\Facades\Request::route('pId')){{'text-white'}}@endif">
            <td>{{$i--}}</td>
            <td>
                {{$loan->proposed_loan_title}}
            </td>
            <td>{{$loan->loan_type_title}}</td>
            <td>
                {{$loan->proposed_loan_amount}}
            </td>
            <td>
                {{$loan->loan_type_installment}}
            </td>
            <td>
                @if($loan->proposed_loan_status)
                    <span class="text-success">Active</span>
                @else
                    <span class="text-warning">Inactive</span>
                @endif
            </td>
            <td class="text-center">

                <a href="{{url('project-manager/loan/view-proposed-loan-project/'.$loan->proposed_loan_id)}}" class="text-warning" title="Full view of Loan Proposed Loan"> <i class="mdi mdi-eye"></i></a>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td c colspan="7" class="text-center text-danger">Not Found!</td>
    </tr>
@endif
