<table class="table table-sm table-hover">
    <thead>
    <tr>
        <th>#</th>
        <th>Title</th>
        <th>Basic</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @if(count($grades))
        <?php $i=1; ?>
        @foreach($grades as $g)
            <tr @if(\Illuminate\Support\Facades\Request::route('gradeIdEdit') == $g->grade_id || \Illuminate\Support\Facades\Request::route('gradeIdView') == $g->grade_id) class="text-white" @endif>
                <td>{{$i++}}</td>
                <td>{{$g->grade_title}}</td>
                <td> {{$g->grade_basic}}</td>
                <td>
                    @if($g->grade_status<=0)
                        <label class="text-danger">Inactive</label>
                    @else
                        <label class="text-success">Active</label>
                    @endif
                </td>
                <td class="text-center">
{{--                 View--}}
                    <a href="{{url("admin/grade/salary/view-grade/{$g->grade_id}")}}" class="text-warning" title="Full view of Salary Grade"> <i class="mdi mdi-eye"></i></a>
{{--                Edit--}}
                    <a href="{{url("admin/grade/salary/edit-grade/{$g->grade_id}")}}" class="text-info"><i class="mdi mdi-table-edit" title="Edit Salary Grade"></i></a>
{{--                 Delete--}}
                    <a href="{{url("admin/grade/salary/delete-grade/{$g->grade_id}")}}" class="text-danger" title="Delete Salary Grade" onclick="return confirm('Are you sure delete this Position?')"><i class="mdi mdi-delete"></i></a>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="5" class="text-center">Not Found!</td>
        </tr>
    @endif
    </tbody>
</table>
