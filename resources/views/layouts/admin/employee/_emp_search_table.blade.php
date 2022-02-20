@if($data)
<tr>
    @if($data->profile_pic)
    <td><img src="{{url('image/employee/profile/'.$data->profile_pic)}}" alt="Image" height="20px"></td>
    @else
        <td style="font-size: 28px;"><i class="mdi mdi-account-box-outline"></i></td>
    @endif
    <td>{{$data->employee_id}}</td>
    <td>@if($data->grade_title) <span class="text-success"> {{$data->grade_title}} ({{$data->grade_short_title}})</span>@else <span class="text-danger"> Not-Define!</span> @endif</td>
    <td>{{$data->name}}</td>
    <td>{{$data->email}}</td>
</tr>
@else
<tr>
    <td colspan="5" class="text-center">Not Found!</td>
</tr>
@endif
