@if(count($projects))
    <?php $i=1;?>
    @foreach($projects as $p)
        <tr class="@if($p->project_id == \Illuminate\Support\Facades\Request::route('pEditID') || $p->project_id == \Illuminate\Support\Facades\Request::route('pShowID')){{'text-white'}}@endif">
            <td>{{$i++}}</td>
            <td>{{$p->p_title}}</td>
            <td>
                {{$p->p_duration}}
                @if(((int)$p->p_year) > 0){{'Years'}} @elseif((int)($p->p_month) > 0){{'Months'}} @endif
            </td>
            <td>{{$p->p_start_date}}</td>
            <td>{{$p->p_end_date}}</td>
            <td>{{$p->team_title}}</td>
            <td>{{$p->name}}</td>

            <td>
                @if($p->p_status == 1 && $p->status == 1 && $p->team_status == 1 && $p->complete_status != 2 && $p->complete_status == 0)
                    <label class="text-info">Running</label>
                @elseif($p->complete_status == 1)
                    <label class="text-success">Completed</label>
                @else
                    <label class="text-danger">Inactive</label>
                @endif
            </td>
            <td class="text-center">

                <a href="{{url('employee/project/view-project/'.$p->project_id)}}" class="text-warning" title="Full view of project"> <i class="mdi mdi-eye"></i></a>
            </td>
        </tr>
    @endforeach
    @else
    <tr>
        <td class="text-center text-danger" colspan="5">Not Found!</td>
    </tr>
@endif
