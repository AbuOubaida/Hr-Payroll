@extends('layouts.admin.main')
@section('content')
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="">
                            <h4 class="card-title">List of Position</h4>
                        </div>
                    </div>

                    <div class="col-sm-6">
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
                <div class="col-md-12">
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
        </div>
    </div>
@stop
