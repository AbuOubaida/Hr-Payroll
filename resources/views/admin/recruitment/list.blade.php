@extends('layouts.admin.main')
@section('content')
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="">
                            <h4 class="card-title">Recruitment List</h4>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend input-group-sm">
                                    <span class="input-group-text">Department</span>
                                </div>
                                <select class="form-control text-white" id="dep" name="order" onchange="return recruitmentSearch(this)">
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
                    <div class="col-sm-2"></div>
                    <div class="col-sm-7">
                        <div class="form-group form-group-sm">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Search</span>
                                </div>
                                <input id="title" type="text" class="form-control form-control-sm" placeholder="Search by recruitment title" aria-label="" aria-describedby="basic-addon1" onkeyup="return recruitmentSearch(this)">
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
                                    <th>Title</th>
                                    <th>Vacancies</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Email</th>
                                    <th>Department</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody id="recr-data">
                                @include('layouts.admin.recruitment._list')
                                </tbody>
                            </table>
                            <div class="col-sm-12 position">
                                @if($recruitments->links())
                                    {{$recruitments->links()}}
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop

