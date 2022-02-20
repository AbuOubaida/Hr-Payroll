@if(count($projects))
    <?php $i=1;?>
    @foreach($projects as $p)
        <tr class="@if($p->project_id == \Illuminate\Support\Facades\Request::route('pEditID') || $p->project_id == \Illuminate\Support\Facades\Request::route('pShowID')){{'text-white'}}@endif">
            <td>{{$i++}}</td>
            <td>{{$p->p_title}}</td>
            <td> {{$p->p_duration}}
                @if(((int)$p->p_year) > 0){{'Years'}} @elseif((int)($p->p_month) > 0){{'Months'}} @endif</td>
            <td>
                @if($p->p_status == 1)
                    <label class="text-success">Active</label>
                @else
                    <label class="text-danger">Inactive</label>
                @endif
            </td>
            <td class="text-center">

                <a href="{{url('admin/project/view-project/'.$p->project_id)}}" class="text-warning" title="Full view of Salary Grade"> <i class="mdi mdi-eye"></i></a>

                <a href="{{url('admin/project/edit-project/'.$p->project_id)}}" class="text-info"><i class="mdi mdi-table-edit" title="Edit Salary Grade"></i></a>

                <a href="{{url('admin/project/delete/'.$p->project_id)}}" class="text-danger" title="Delete Salary Grade" onclick="return confirm('Are you sure delete this Position?')"><i class="mdi mdi-delete"></i></a>
            </td>
        </tr>
    @endforeach
    @else
    <tr>
        <td class="text-center text-danger" colspan="5">Not Found!</td>
    </tr>
@endif
