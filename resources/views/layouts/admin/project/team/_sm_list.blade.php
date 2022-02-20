@if(count($teams))
    <?php $i=1;?>
    @foreach($teams as $t)
        <tr class="@if($t->team_id == \Illuminate\Support\Facades\Request::route('teamID') || $t->team_id == \Illuminate\Support\Facades\Request::route('teamID')){{'text-white'}}@endif">
            <td>{{$i++}}</td>
            <td>{{$t->team_title}}</td>
            <td> {{$t->user_name}}</td>
            <td>
                @if($t->team_status == 1)
                    <label class="text-success">Active</label>
                @else
                    <label class="text-danger">Inactive</label>
                @endif
            </td>
            <td class="text-center">

                <a href="{{url('admin/project/edit-team/'.$t->team_id)}}" class="text-warning" title="Full view of Salary Grade"> <i class="mdi mdi-eye"></i></a>

                <a href="{{url('admin/project/edit-team/'.$t->team_id)}}" class="text-info"><i class="mdi mdi-table-edit" title="Edit Salary Grade"></i></a>

                <a href="{{url('admin/project/delete-team/'.$t->team_id)}}" class="text-danger" title="" onclick="return confirm('Are you sure delete this team?')"><i class="mdi mdi-delete"></i></a>
            </td>
        </tr>
    @endforeach
    @else
    <tr>
        <td class="text-center text-danger" colspan="5">Not Found!</td>
    </tr>
@endif
