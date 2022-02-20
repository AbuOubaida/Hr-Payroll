<table class="table">
    @if(count($departments))
        <thead>
        <tr>
            <th>DESC</th>
            <th>Code</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Status</th>
            <th class="text-center">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php $i=1;?>
        @if($departments)
            @foreach($departments as $d)
                <tr class="@if($d->dep_id == \Illuminate\Support\Facades\Request::route('editDepId') || $d->dep_id == \Illuminate\Support\Facades\Request::route('depId')){{'text-white'}}@endif">
                    <td>{{$i++}}</td>
                    <td>{{$d->dep_code}}</td>
                    <td>{{$d->dep_name}}</td>
                    <td>{{$d->dep_email}}</td>
                    <td>{{$d->dep_phone}}</td>
                    <td>@if($d->status == 1)<span class="text-success">Active</span>@else<span class="text-danger">Inactive</span>@endif</td>
                    <td class="text-center">
                        {{--                                    view Button--}}
                        <a href="{{url("admin/view-department/$d->dep_id")}}" class="text-warning" title="Full view of Department"> <i class="mdi mdi-eye"></i></a>
                        {{--                                    Edit Button--}}
                        @if($d->owner_id == \Illuminate\Support\Facades\Auth::user()->id)
                            <a href="{{url("admin/edit-department/$d->dep_id")}}" class="text-info"><i class="mdi mdi-table-edit" title="Edit Department"></i></a>
                            {{--                                    Delete button--}}
                            <a href="{{url("admin/delete-department/$d->dep_id")}}" class="text-danger" title="Delete Department" onclick="return confirm('Are you sure delete this Department?')"><i class="mdi mdi-delete"></i></a>
                        @endif
                    </td>
                </tr>
            @endforeach
        @endif

        </tbody>
    @else
        <tbody>
        <tr>
            <td colspan="6" class="text-center">Not Found!</td>
        </tr>
        </tbody>
    @endif
</table>

