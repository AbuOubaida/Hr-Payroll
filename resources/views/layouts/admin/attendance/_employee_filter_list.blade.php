@if(count($attendance) >0)
    @foreach($attendance as $att)
        <tr class="">
            @if($att->profile)
                <td><img src="{{url("image/employee/profile/{$att->profile}")}}" alt="" height="20px"></td>
            @else
                <td style="font-size: 28px;"><i class="mdi mdi-account-box-outline"></i></td>
            @endif
            <td>{{$att->emp_no}}</td>
            <td>{{$att->emp_name}}</td>
            <td>{{$att->dep_name}}</td>
            <td>{{date('h:i:s a',strtotime($att->entry_time))}}</td>
            <td>{{$att->leave_time?date('h:i:s a',strtotime($att->leave_time)):'NULL'}}</td>
            <td>{{date('d-m-Y',strtotime($att->entry_time))}}</td>
            <td>{{date('l',strtotime($att->entry_time))}}</td>
            <td class="text-center">
                <a href="{{url("admin/attendance/view-attendance/{$att->attend_id}")}}" class="text-warning" title="View Employee Profile"> <i class="mdi mdi-eye"></i></a>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="9" class="text-center text-danger">Not Found</td>
    </tr>
@endif
