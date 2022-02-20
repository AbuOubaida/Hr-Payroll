<table class="table">
    @if(count($employees))
        <thead>
        <tr>
{{--            <th>#</th>--}}
            <th>Profile</th>
            <th>Employee ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Department</th>
            <th>Post</th>
            <th>Status</th>
            <th class="text-center">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php $i=1;?>
        @if($employees)
            @foreach($employees as $e)
                <tr class="@if($e->emp_id == \Illuminate\Support\Facades\Request::route('editEmpId') || $e->emp_id == \Illuminate\Support\Facades\Request::route('ViewEmpId')){{'text-white'}}@endif">
{{--                    <td>{{$i++}}</td>--}}
                    @if($e->profile)
                    <td><img src="{{url('image/employee/profile/'.$e->profile)}}" alt="Image" height="20px"></td>
                    @else
                        <td style="font-size: 28px;"><i class="mdi mdi-account-box-outline"></i></td>
                    @endif
                    <td>{{$e->emp_no}}</td>
                    <td>{{$e->emp_name}}</td>
                    <td>{{$e->email}}</td>
                    <td>{{$e->phone_code}}-{{$e->phone}}</td>
                    <td>{{$e->dep_name}}</td>
                    <td>{{$e->p_name}}</td>
                    <td>@if($e->emp_status == 1)<span class="text-success">Active</span>@else<span class="text-danger">Inactive</span>@endif</td>
                    <td class="text-center">
                        {{--view Button--}}
                        <a href="{{url("admin/employee/view/$e->emp_id")}}" class="text-warning" title="View Employee Profile"> <i class="mdi mdi-eye"></i></a>
                        {{--                                    Edit Button--}}
                        @if($e->role_id > \Illuminate\Support\Facades\Auth::user()->roles->first()->id)
                            <a href="{{url("admin/employee/edit/$e->emp_id")}}" class="text-info"><i class="mdi mdi-table-edit" title="Edit Employee"></i></a>
                            {{--                                    Delete button--}}
                            <a href="{{url("admin/employee/delete/$e->emp_id")}}" class="text-danger" title="Delete Department" onclick="return confirm('Are you sure delete this Department?')"><i class="mdi mdi-delete"></i></a>
                        @elseif($e->emp_id == \Illuminate\Support\Facades\Auth::user()->id)
                            <a href="{{url("admin/employee/edit/$e->emp_id")}}" class="text-info"><i class="mdi mdi-table-edit" title="Edit Employee"></i></a>
                        @endif
                    </td>
                </tr>
            @endforeach
        @endif

        </tbody>
    @else
        <tbody>
        <tr>
            <td colspan="9" class="text-center">Not Found!</td>
        </tr>
        </tbody>
    @endif
</table>
