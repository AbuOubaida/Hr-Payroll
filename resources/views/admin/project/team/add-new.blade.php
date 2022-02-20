@extends('layouts.admin.main')
@section('content')
<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="card-title">Create Team</h4>
                    <p class="card-description">New Team info </p>
                    <form class="form-sample" method="post" action="{{route('add.team')}}">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for="title">Team title</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="title" id="title" required placeholder="Enter team title" value="{{old('title')}}">
                                        <small class="float-right text-success">Required</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label" for="leader">Team Leader</label>
                                    <div class="col-sm-12">
                                        <select name="leader" id="leader" class="form-control">
                                            <option></option>
                                            @if(count($project_managers))
                                                @foreach($project_managers as $p)
                                                    <option value="{{$p->user_id}}" @if($p->user_id == old('leader'))selected @endif>{{$p->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <small class="float-right text-success">Required</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label" for="details">Team Details</label>
                                    <textarea name="details" class="form-control" id="details" rows="5" spellcheck="false" placeholder="Enter Team Details">{{old('details')}}</textarea>
                                    <small class="float-right text-primary">Optional</small>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group float-right mt-2">
                                    <input type="submit" class="btn btn-success">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-sm-6">
                    <h4 class="card-title">Project list</h4>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend input-group-sm">
                                        <span class="input-group-text"><i class="mdi mdi-account-search"></i></span>
                                    </div>
                                    <input type="text" class="form-control " placeholder="Search by team title or team leader name" onkeyup="return searchSmTeam(this)">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="table-responsive" id="grade-table">
                                <table class="table table-sm table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Team Leader</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="project-sm-list">
                                    @include('layouts.admin.project.team._sm_list')
                                    </tbody>
                                </table>
                                <div class="col-sm-12 position">
                                    @if($teams->links())
                                        {{$teams->links()}}
                                    @endif
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
