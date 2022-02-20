@extends('layouts.admin.main')
@section('content')
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="">
                            <h4 class="card-title">CV List</h4>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend input-group-sm">
                                    <span class="input-group-text">Department</span>
                                </div>
                                <select class="form-control text-white" id="dep" name="" onchange="return searchCV(this)">
                                    <option value="">All</option>
                                    @if($departments)
                                        @foreach($departments as $dep)
                                            <option value="{{$dep->d_id}}">{{$dep->d_name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend input-group-sm">
                                    <span class="input-group-text">Job Title</span>
                                </div>
                                <select class="form-control text-white" id="title" name="" onchange="return searchCV(this)">
                                    <option value="">All</option>
                                    @if($recruitments)
                                        @foreach($recruitments as $rec)
                                            <option value="{{$rec->r_title}}">{{$rec->r_title}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group form-group-sm">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Search</span>
                                </div>
                                <input id="name" type="text" class="form-control form-control-sm" placeholder="Search by name or email or phone" aria-label="" aria-describedby="basic-addon1" onkeyup="return searchCV(this)">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <br>
                    <div class="col-sm-12">
                        <div class="table-responsive" id="emp-table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Title</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Department</th>
                                        <th class="text-center">Seen Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="cv-data">
                                @include('layouts.admin.recruitment._cv_list')
                                </tbody>
                            </table>
                            <div class="col-sm-12 position">
                                @if($cvList->links())
                                    {{$cvList->links()}}
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop

