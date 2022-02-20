<?php $i=1;?>
@if(count($proposedLoans))
    @foreach($proposedLoans as $p_loan)
        <tr class="@if($p_loan->proposed_loan_id == \Illuminate\Support\Facades\Request::route('pLId') || $p_loan->proposed_loan_id == \Illuminate\Support\Facades\Request::route('pEditLId')){{'text-white'}}@endif">
            <td>{{$i++}}</td>
            <td>
                {{$p_loan->proposed_loan_title}}
            </td>
            <td>{{$p_loan->loan_type_title}}</td>
            <td>
                {{$p_loan->proposed_loan_amount}}
            </td>
            <td>
                {{$p_loan->loan_type_installment}}
            </td>
            <td>
                @if($p_loan->proposed_loan_status)
                    <span class="text-success">Active</span>
                @else
                    <span class="text-danger">Inactive</span>
                @endif
            </td>
            <td class="text-center">

                <a href="{{url('admin/loan/view-proposed-loan/'.$p_loan->proposed_loan_id)}}" class="text-warning" title="Full view of Loan Proposed Loan"> <i class="mdi mdi-eye"></i></a>

                <a href="{{url('admin/loan/edit-proposed-loan/'.$p_loan->proposed_loan_id)}}" class="text-info"><i class="mdi mdi-table-edit" title="Edit Proposed Loan"></i></a>

                <form action="{{route('proposed.loan.delete')}}" method="post" class="d-inline-block">
                    {!! method_field('delete') !!}
                    {!! csrf_field() !!}
                    <input type="hidden" name="p_loan_id" value="{{$p_loan->proposed_loan_id}}">
                    <button class="btn-style-none d-inline-block text-danger" onclick="return confirm('Are you sure delete this proposed Loan?')" type="submit"><i class="mdi mdi-delete"></i></button>
                </form>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td c colspan="7" class="text-center text-danger">Not Found!</td>
    </tr>
@endif
