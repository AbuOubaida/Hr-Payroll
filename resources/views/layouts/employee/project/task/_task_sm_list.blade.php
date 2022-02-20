@if(($n = count($tasks)))
    @foreach($tasks as $tsk)
        <tr>
            <td>{{$n--}}</td>
            <td>{{$tsk->task_title}}</td>
            <td>{{\Illuminate\Support\Facades\Auth::user()->name}}</td>
            <td>
                @if($tsk->task_seen_status)
                    <span class="text-warning">Seen</span>
                @else
                    <span class="text-danger">Unseen</span>
                @endif
            </td>
            <td>
                @if($tsk->task_complete_status)
                    <span class="text-warning">Completed</span>
                @else
                    @if($tsk->task_running_status)
                        <span class="text-success">Running</span>
                    @else
                        <span class="text-danger">Not Started</span>
                    @endif
                @endif
            </td>
            <td class="text-center">

                <a href="{{url('employee/project/view-task/'.$tsk->task_id)}}" class="text-warning" title="Full view of Task"> <i class="mdi mdi-eye"></i></a>

            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="6" class="text-center text-danger">Not Found!</td>
    </tr>
@endif
