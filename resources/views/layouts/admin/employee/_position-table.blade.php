<table class="table table-sm table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Description</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $i =1;
    ?>
    @if(!count($positions))
        <tr>
            <td colspan="5" class="text-center">Not Found!</td>
        </tr>
    @else
        @foreach($positions as $p)
            <tr @if(\Illuminate\Support\Facades\Request::route('positionId') == $p->position_id) class="text-white" @endif>
                <td>{{$i++}}</td>
                <td>{{$p->position_name}}</td>
                <td> {{substr($p->position_details,0,12)}}......</td>
                <td>@if($p->position_status ==1)<label class="text-success">Active</label>@else<label class="text-danger">Pending</label>@endif</td>
                <td class="text-center">
{{--                    Edit Position--}}
                    <a href="{{url("admin/employee/edit-position/{$p->position_id}")}}" class="text-info"><i class="mdi mdi-table-edit" title="Edit Position"></i></a>
{{--                    Delete Position--}}
                    <a method="post" href="{{url("admin/employee/delete-position/{$p->position_id}")}}" class="text-danger" title="Delete Position" onclick="return confirm('Are you sure delete this Position?')"><i class="mdi mdi-delete"></i></a>
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
