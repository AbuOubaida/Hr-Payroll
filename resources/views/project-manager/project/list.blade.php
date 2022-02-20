@extends('layouts.project-manager.main')
@section('content')
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h4 class="card-title">All Project List</h4>
                                </div>
                                <div class="col-sm-6">

                                </div>
                                <div class="col-sm-12">
                                    <div class="table-responsive" id="grade-table">
                                        <table class="table table-sm table-hover">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Project Title</th>
                                                <th>Project Duration</th>
                                                <th>Project Start Date</th>
                                                <th>Project End Date</th>
                                                <th>Team Title</th>
                                                <th>Team Leader</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody id="project-sm-list">
                                            @include('layouts.project-manager.project._project_sm_list')
                                            </tbody>
                                        </table>
                                        <div class="col-sm-12 position">
                                            {{--                                    @if($projects->links())--}}
                                            {{--                                        {{$projects->links()}}--}}
                                            {{--                                    @endif--}}
                                        </div>
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
