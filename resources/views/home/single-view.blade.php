@extends('layouts/home/main')
@section('home')
<body>
<!--Main Wrapper Start-->
<div class="as-mainwrapper">
    <!--Bg White Start-->
    <div class="bg-dark">
        @include('layouts.home.navbar')
        <div class="breadcrumb-banner-area pt-94 pb-85 bg-3 bg-opacity-dark-blue-90">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="breadcrumb-text">
                            <h2 class="text-center text-white uppercase mb-17">Job Details</h2>
                            <div class="breadcrumb-bar">
                                <ul class="breadcrumb text-center m-0">
                                    <li class="text-white uppercase ml-15 mr-15"><a href="{{url('/')}}">Home</a></li>
                                    <li class="text-white uppercase ml-15 mr-15"><a href="#">{{$singleData->r_title}}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="single-job-post-area pt-70">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        @if ($errors->any())
                            <div class="col-12">
                                <div class="alert alert-danger alert-dismissible show z-index-1 position-absolute w-auto error-alert" role="alert">
                                    @foreach ($errors->all() as $error)
                                        <div>{{$error}}</div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        {{--                For Insert message Showing--}}
                        @if (session('success'))
                            <div class="col-12">
                                <div class="alert alert-success alert-dismissible show z-index-1 position-absolute w-auto error-alert" role="alert">
                                    <div>{{session('success')}}</div>
                                </div>
                            </div>
                        @endif
                        {{--                For Insert message Showing--}}
                        @if (session('error'))
                            <div class="col-12">
                                <div class="alert alert-danger alert-dismissible show z-index-1 position-absolute w-auto error-alert" role="alert">
                                    <div>{{session('error')}}</div>
                                </div>
                            </div>
                        @endif
                        @if (session('warning'))
                            <div class="col-12">
                                <div class="alert alert-warning alert-dismissible show z-index-1 position-absolute w-auto error-alert" role="alert">
                                    <div>{{session('warning')}}</div>
                                </div>
                            </div>
                        @endif

                        @yield('content')
                    </div>
                    <div class="col-md-10 col-md-offset-1 table-responsive">
                        <table class="table table-borderless">

                            <tr>
                                <th>Job Title</th>

                                <td>{{$singleData->r_title}}</td>
                            </tr>
                            <tr>
                                <th>Job Vacancies</th>
                                <td>{{$singleData->r_vacancies}}</td>
                            </tr>
                            <tr>
                                <th>Apply Start Date</th>
                                <td>{{date('d F Y',strtotime($singleData->r_start_at))}}</td>
                            </tr>
                            <tr>
                                <th>Apply End Date</th>
                                <td>{{date('d F Y',strtotime($singleData->r_end_at))}}</td>
                            </tr>

                            <tr>
                                <th>Contact Email</th>
                                <td>{{$singleData->r_c_email}}</td>
                            </tr>
                            <tr>
                                <th>Contact Phone</th>
                                <td>({{$singleData->r_c_phone_code}}) {{$singleData->r_c_phone}}</td>
                            </tr>
                            <tr>
                                <th>Jod Department</th>
                                <td>{{$singleData->dep_name}}</td>
                            </tr>
                            <tr>
                                <th>Jod Document</th>
                                <td><a href="{{url('file/admin/recruitments/'.$singleData->r_doc)}}" class="label label-primary">Click to Download</a></td>
                            </tr>
                            <tr>
                                <th>Jod Description</th>
                                <td class="text-justify">{{$singleData->r_details}}</td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="single-job-post-area mb-120">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 table-responsive">
                        <form action="{{route('job.apply')}}" method="post" enctype="multipart/form-data">
                            <div class="col-5 pr-6 mb-15">
                                <label for="name" class="block ml-20">Name <span style="color: red">*</span></label>
                                <input type="text" name="name" id="name" class="pl-20" placeholder="Please enter your name" required value="{{old('name')}}">
                            </div>
                            <div class="col-5 pl-6 mb-15">
                                <label for="email" class="block ml-20">Email <span style="color: red">*</span></label>
                                <input type="email" name="email" id="email" class="pl-20" placeholder="Please enter your email" required value="{{old('email')}}">
                            </div>
                            <div class="col-5 pr-6 mb-15">
                                <input type="hidden" value="{{$singleData->r_id}}" name="id">
                                <label for="phone" class="block ml-20">Phone <span style="color: red">*</span></label>
                                <input type="number" name="phone" id="phone" class="pl-20" placeholder="Please enter your phone number" required value="{{old('phone')}}">
                            </div>
                            <div class="col-5 pl-6 mb-15">
                                <label for="cv" class="block ml-20">CV <span style="color: red">*</span> [.pdf only]</label>
                                <input type="file" name="cv" id="cv" class="pl-20" placeholder="Please Upload your CV" required>
                            </div>
                            <div class="col-10">
                                <label for="details" class="block ml-20">Details</label>
                                <textarea name="details" id="details" cols="30" rows="10" placeholder="Please enter details" class="mb-10"></textarea>
                            </div>
                            <div class="col-10 fix">
                                <button type="submit" class="button submit-btn">APPLY</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @include('layouts.home.footer')
@stop
