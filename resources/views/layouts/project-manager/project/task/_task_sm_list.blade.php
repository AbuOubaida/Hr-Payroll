@if(($n = count($tasks)))
    @foreach($tasks as $tsk)
        <tr>
            <td>{{$n--}}</td>
            <td>{{$tsk->task_title}}</td>
            <td>{{$tsk->member_name}}</td>
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

                <a href="{{url('project-manager/project/view-task/'.$tsk->task_id)}}" class="text-warning" title="Full view of Task"> <i class="mdi mdi-eye"></i></a>

{{--                <a href="" class="text-info"><i class="mdi mdi-table-edit" title="Edit Task"></i></a>--}}

                @if(!$tsk->task_complete_status || !$tsk->task_running_status)
                <form action="{{route('task.delete')}}" method="post" class="d-inline-block">
                    {!! method_field('delete') !!}
                    {!! csrf_field() !!}
                    <input type="hidden" name="task_id" value="{{$tsk->task_id}}">
                    <button class="btn-style-none d-inline-block text-danger" onclick="return confirm('Are you sure delete this Task?')" type="submit"><i class="mdi mdi-delete"></i></button>
                </form>
                @endif
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="6" class="text-center text-danger">Not Found!</td>
    </tr>
@endif
