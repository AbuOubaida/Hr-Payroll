@extends('layouts.admin.main')
@section('content')
    {{--Employee List--}}
    <div class="row">
        @include('layouts.admin.employee.employee-list')
    </div>
@stop
