@if(count($cvList)>0)
    <?php $i=1;?>
    @foreach($cvList as $cv)
        <tr class="">
            <td>{{$i++}}</td>
            <td>{{$cv->cv_name}}</td>
            <td><a href="{{url("admin/recruitment/view-recruitment/{$cv->cv_r_id}")}}" target="_blank">{{$cv->r_title}}</a></td>
            <td>{{$cv->cv_email}}</td>
            <td>{{$cv->cv_phone}}</td>
            <td><a href="{{url("admin/view-department/{$cv->dep_id}")}}" target="_blank"> {{$cv->dep_name}}</a></td>
            <td class="text-center">@if($cv->seen_status == 1) <span class="text-warning">Seen</span> @else <span class="text-danger">Unseen</span> @endif</td>
{{--            <td>@if($cv->r_details){{substr($cv->r_details,0,20)}}......@endif</td>--}}
            <td class="text-center">
                <a href="{{url("admin/recruitment/view-cv/{$cv->cv_id}")}}" class="text-warning" title="View CV"> <i class="mdi mdi-eye"></i></a>

                <a href="{{url("admin/recruitment/delete-cv/{$cv->cv_id}")}}" class="text-danger" title="Delete Recruitment" onclick="return confirm('Are you sure delete this CV?')"><i class="mdi mdi-delete"></i></a>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="9" class="text-center text-danger">Not Found</td>
    </tr>
@endif
