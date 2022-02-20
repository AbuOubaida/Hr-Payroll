@extends('layouts.project-manager.main')
@section('content')
    <div class="col-12 grid-margin">
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center d-block text-light">Change Password Here</h3>
                <br>
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <form action="{{route('change.password')}}" method="post">
                    <div class="form-group row">
                        <label class="col-sm-12 col-form-label" for="old">Old Password</label>
                        <div class="col-sm-12">
                            <input id="old" name="old" type="password" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-form-label" for="new">New Password</label>
                        <div class="col-sm-12">
                            <input id="new" name="new" type="password" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-form-label" for="conform">Conform New Password</label>
                        <div class="col-sm-12">
                            <input id="conform" name="conform" type="password" class="form-control" required>
                        </div>
                    </div>
                    <br>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <input type="submit" class="form-control bg-success" value="Submit">
                        </div>
                    </div>
                </form>
        </div>
            <div class="col-md-4"></div>
    </div>
@stop
