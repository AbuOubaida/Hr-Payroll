@if(count($recruitments)>0)
    @foreach($recruitments as $rec)
        <tr class="">
            <td>{{$rec->r_title}}</td>
            <td>{{$rec->r_vacancies}}</td>
            <td>{{$rec->r_start_at}}</td>
            <td>{{$rec->r_end_at}}</td>
            <td>{{$rec->r_c_email}}</td>
{{--            <td>({{$rec->r_c_phone_code}}) {{$rec->r_c_phone}}</td>--}}
            <td>{{$rec->dep_name}}</td>
{{--            <td>@if($rec->r_details){{substr($rec->r_details,0,20)}}......@endif</td>--}}
            <td class="text-center">
                <a href="{{url("admin/recruitment/view-recruitment/{$rec->r_id}")}}" class="text-warning" title="View Recruitment"> <i class="mdi mdi-eye"></i></a>

                <a href="{{url("admin/recruitment/edit-recruitment/{$rec->r_id}")}}" class="text-info"><i class="mdi mdi-table-edit" title="Edit Recruitment"></i></a>

                <a href="{{url("admin/recruitment/delete-recruitment/{$rec->r_id}")}}" class="text-danger" title="Delete Recruitment" onclick="return confirm('Are you sure delete this Recruitment?')"><i class="mdi mdi-delete"></i></a>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="9" class="text-center text-danger">Not Found</td>
    </tr>
@endif
