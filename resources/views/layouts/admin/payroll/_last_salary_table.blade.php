@if(count($salary))
    @foreach($salary as $s)
        <tr>
            @if($s->profile_pic)
                <td>
                    <img src="{{url("/image/employee/profile/{$s->profile_pic}")}}" alt="" height="20px">
                </td>
            @else
                <td style="font-size: 28px;"><i class="mdi mdi-account-box-outline"></i></td>
            @endif
            <td>{{$s->employee_id}}</td>
            <td>{{$s->name}}</td>
            <td>{{$s->sa_month}}</td>
            <td>{{$s->start_date}}</td>
            <td>{{$s->end_date}}</td>
            <td>{{$s->total_hour}}h</td>
            <td>{{$s->sa_amount}}/=</td>
            <td>
                @if($s->paid_status == 1)
                    <span class='text-success'>Paid</span>
                @else
                    <span class='text-danger'>Unpaid</span>
                @endif
            </td>
            <td class="text-center">
                <a href="{{url("admin/payroll/salary-view/{$s->sa_id}")}}" class="text-warning" title="View Employee Profile"> <i class="mdi mdi-eye"></i></a>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="10" class="text-center text-danger">Not Found</td>
    </tr>
@endif
