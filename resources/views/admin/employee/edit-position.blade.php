@extends('layouts.admin.main')
@section('content')
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <h4 class="card-title">Edit Position</h4>
                        <p class="card-description"> Position info </p>
                    </div>
                    <div class="col-sm-6">
                        <h4 class="card-title">List of Position</h4>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend input-group-sm">
                                            <span class="input-group-text"><i class="mdi mdi-account-search"></i></span>
                                        </div>
                                        <input type="text" class="form-control " placeholder="Search by Position Title" onkeyup="return searchPosition(this)">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form class="form-sample" method="post" action="{{route("update.position",['id'=>$position->position_id])}}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Title</label>
                                <div class="col-sm-9">
                                    <input name="positionTitle" type="text" class="form-control" required value="{{$position->position_name}}">
                                    <small class="">e.g. CEO or Developer etc.</small>
                                    <small class="text-success float-right">Required</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Status</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="" name="positionStatus" required>
                                        <option value="1" class="text-success" @if($position->position_status >= 1){{'selected'}}@endif>Active</option>
                                        <option value="0" class="text-danger" @if($position->position_status <= 0){{'selected'}}@endif>Inactive</option>
                                    </select>
                                    <small class="">e.g. CEO or Developer etc.</small>
                                    <small class="text-success float-right">Required</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Details</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control text-justify" name="positionDescription" id="" rows="10">{{$position->position_details}}</textarea>
                                    <small class="text-primary float-right">Optional</small>
                                </div>
                            </div>
                            <div class="form-group float-right">
                                <input class="btn btn-success" type="submit" value="Update">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="table-responsive" id="position-table">
                                @include('layouts.admin.employee._position-table')
                                <div class="col-sm-12 position">
                                    @if($positions->links())
                                        {{$positions->links()}}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
