@extends('layouts.project-manager.main')
@section('content')

<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="card-title">Team Member list</h4>
                        <p class="text-secondary">Team Member list Without Project Leader</p>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive" id="grade-table">
                                    <table class="table table-sm table-hover">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Member Name</th>
                                            <th>Member Employee ID</th>
                                            <th>Member Email</th>
                                            <th>Member Phone</th>
                                            <th>Member Department</th>
                                            <th>Team Title</th>
                                        </tr>
                                        </thead>
                                        <tbody id="project-sm-list">
                                        <?php $n=1;?>
                                        @if(count(@$teamMembers))
                                            @foreach($teamMembers as $member)
                                                <tr>
                                                    <td>{{$n++}}</td>
                                                    <td>{{$member->name}}</td>
                                                    <td>#{{$member->employee_id}}</td>
                                                    <td>{{$member->email}}</td>
                                                    <td>{{$member->phone_code}}-{{$member->phone}}</td>
                                                    <td>{{$member->dep_name}}</td>
                                                    <td>{{$member->team_title}}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="7" class="text-center text-danger">Not found!</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                    <div class="col-sm-12 position">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
